<?php

namespace App\Http\Controllers\app\finance\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\invoice\invoices;
use App\Models\finance\customer\customers;
use App\Models\finance\payments\payment_type;
use App\Models\finance\creditnote\creditnote_products;
use App\Models\finance\creditnote\creditnote_settings;
use App\Models\finance\creditnote\invoice_creditnote;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\creditnote\creditnote;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\accounts;
use App\Models\finance\income\category;
use App\Models\crm\emails;
use App\Mail\sendPayment;
use App\Mail\sendMessage;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;

class paymentsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $payments = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
                     ->join('business','business.id','=','invoice_payments.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->join('invoice_settings','invoice_settings.businessID','=','business.id')
                     ->join('invoices','invoices.id','=','invoice_payments.invoiceID')
                     ->where('invoice_payments.businessID',Auth::user()->businessID)
                     ->select('*','invoice_payments.id as paymentID','invoice_payments.reference_number as transactionID')
                     ->orderby('invoice_payments.id','desc')
                     ->get();

         $count = 1;
         return view('app.finance.payments.index',compact('payments','count'));
   }

   public function create(){
      $contacts = customers::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();

      $paymentmethod = payment_type::where('businessID',Auth::user()->businessID)->get();
      $defaultPaymentMethod = payment_type::where('businessID',0)->get();

      $settings = invoice_settings::join('business','business.id','=','invoice_settings.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->where('invoice_settings.businessID',Auth::user()->businessID)
                  ->first();

      $accounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose deposit account','');

      $categories = category::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose income category','');

      return view('app.finance.payments.create', compact('contacts','paymentmethod','settings','accounts','categories','defaultPaymentMethod'));
   }

   public function store(request $request){
      $this->validate($request, array(
         'customer'=>'required',
         'amount'=>'required',
         'invoice'=>'required',
      ));

      //update invoice payment & status
      $invoice =  invoices::where('id',$request->invoice)->where('businessID',Auth::user()->businessID)->first();
      $newBalance = $invoice->balance - $request->amount;
      if($newBalance < 0){
         $newBalance = 0;
      }
      $payment = new invoice_payments;
      $payment->amount = $request->amount;
      $payment->balance = $newBalance;
      $payment->bank_charges = $request->bank_charges;
      $payment->payment_date = $request->payment_date;
      $payment->payment_method = $request->payment_method;
      $payment->reference_number = $request->reference_number;
      $payment->invoiceID = $request->invoice;
      $payment->note = $request->note;
      $payment->display_in_portal = $request->display_in_portal;
      $payment->customerID = $request->customer;
      $payment->accountID = $request->accountID;
      $payment->incomeID = $request->incomeID;
      $payment->created_by = Auth::user()->id;
      $payment->businessID = Auth::user()->businessID;
      $payment->payment_category = 'Received';

      $payment->save();


      //update payment
      $oldPaid = $invoice->paid;
      $newPaid = $oldPaid + $request->amount;
      $invoice->balance = $invoice->total - $newPaid;
      $invoice->paid = $newPaid;
         //update status
         if($newPaid == $invoice->total || $newPaid > $invoice->total){
               $invoice->statusID = 1;
         }elseif($newPaid < $invoice->total && $newPaid != 0 ){
               $invoice->statusID = 3;
      }

      $invoice->save();


      //Client Credit
      if($invoice->paid > $invoice->total) { 
         $paidAmount = round($invoice->paid);
			if( $paidAmount > 0){
            $check = creditnote_settings::where('businessID',Auth::user()->businessID)->count();
               if($check != 1){
               Finance::creditnote_setting_setup();
            }

            //update creditnote number
            $setting = creditnote_settings::where('businessID',Auth::user()->businessID)->first();

            $creditAmount = $invoice->paid - $invoice->total;

            $credit					      = new creditnote;
            $total                     = $creditAmount;
            $credit->created_by		   = Auth::user()->id;
            $credit->customerID	 	   = $request->customer;
            $credit->creditnote_number = $setting->number;
            $credit->total		         = $total;
            $credit->title             = 'Payment credit for invoice '.$invoice->invoice_number;
            $credit->balance			   = $total;
            $credit->sub_total			= $total;
            $credit->creditnote_date	= date('Y-m-d');
            $credit->statusID			   = 21;
            $credit->paymentID         = $payment->id;
            $credit->businessID 		   = Auth::user()->businessID;
            $credit->save();

            //credit note product
            $product 					= new creditnote_products;
            $product->creditnoteID  = $credit->id;
            $product->product_name	= 'Payment credit '.$invoice->invoice_number;
            $product->quantity		= 1;
            $product->price    		= $total;
            $product->save();


            $setting->number = $setting->number + 1;
            $setting->save();

            //update payment
            $updateCredit = invoice_payments::find($payment->id);
            $updateCredit->credited = 'yes';
            $updateCredit->creditID = $credit->id;
            $updateCredit->save();
         }
      }

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            $size =  $file->getSize();
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Finance::invoice_settings()->perfix.Helper::seoUrl($invoice->invoice_number).'-'.Helper::generateRandomString(3). '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new docs;
            $upload->fileID      = $payment->id;
            $upload->folder 	   = 'Finance';
            $upload->section 	   = 'payments';
            $upload->name 		   = 'Payment for invoice # 0'.$invoice->number;
            $upload->file_name   = $fileName;
            $upload->file_size   = $size;
            $upload->file_mime   = $file->getClientMimeType();
            $upload->created_by  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->save();
         }
      }

      //Send payment acknowledgment message to client
      if($request->send_email == 'yes'){

         $clientName = Finance::client($request->customer)->customer_name;

         $subject = 'Payment acknowledgment for #'.Finance::invoice_settings()->prefix.$invoice->invoice_number;
         $to = Finance::client($request->customer)->email;
         $content = '<span style="font-size: 12pt;">Hello '.$clientName.'</span><br/><br/>
         Thank you for the payment. Find the payment details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         Amount:&nbsp;<strong>'. number_format($request->amount).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
         Balance:&nbsp;<strong>'. number_format($invoice->total - $invoice->paid).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
         Date:&nbsp;<strong>'.date('jS F, Y', strtotime($request->payment_date)).'</strong><br/>
         Invoice number:&nbsp;<span style="font-size: 12pt;"><strong>#'.Finance::invoice_settings()->prefix.$invoice->invoice_number.'</strong><br/><br/></span>
         -------------------------------------------------
         <br/><br/>
         We are looking forward working with you.<br/>';

         Mail::to($to)->send(new sendMessage($content,$subject));

         //save email
         $emails = new emails;
         $emails->message   = $content;
         $emails->clientID  = $request->customer;
         $emails->subject   = $subject;
         $emails->mail_from = Wingu::business(Auth::user()->businessID)->businessID;
         $emails->category  = 'Invoice Payment acknowledgment';
         $emails->status    = 'Sent';
         $emails->ip 		 = Helper::get_client_ip();
         $emails->type      = 'Outgoing';
         $emails->section   = 'invoices';
         $emails->mail_to   = $to;
         $emails->view_count = 0;
         $emails->userID   = Auth::user()->id;
         $emails->businessID   = Auth::user()->businessID;
         $emails->save();

      }

      Session::flash('success','The payments have been added');

      //record activity
      $activities = 'A payment has been made for invoice #'.Finance::invoice_settings()->prefix.$invoice->invoice_number.',recorded by '.Auth::user()->name;
      $section = 'Invoice';
      $type = 'Payment';
      $adminID = Auth::user()->id;
      $activityID = $payment->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      return redirect()->route('finance.payments.edit',$payment->id);
   }

   public function edit($id){
      $contacts = customers::where('businessID',Auth::user()->businessID)->get();
      $paymentmethod = payment_type::where('businessID',Auth::user()->businessID)->get();
      $defaultPaymentMethod = payment_type::where('businessID',0)->get();

      $payment = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
               ->join('business','business.id','=','invoice_payments.businessID')
               ->join('currency','currency.id','=','business.base_currency')
               ->where('invoice_payments.id',$id)
               ->select('*','invoice_payments.id as paymentID','invoice_payments.reference_number as reference_number')
               ->first();

      $invoice = invoices::where('id',$payment->invoiceID)->where('businessID',Auth::user()->businessID)->first();
      $files = docs::where('fileID',$id)
               ->where('folder','=','Finance')
               ->where('section','=','Payments')
               ->where('businessID',Auth::user()->businessID)
               ->get();

      $settings = invoice_settings::join('business','business.id','=','invoice_settings.businessID')
               ->join('currency','currency.id','=','business.base_currency')
               ->where('invoice_settings.businessID',Auth::user()->businessID)
               ->first();

      $accounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose deposit account','');

      $categories = category::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose income category','');

      return view('app.finance.payments.edit',  compact('contacts','payment','invoice','files','settings','accounts','categories','paymentmethod','defaultPaymentMethod'));
   }

   public function update(Request $request, $id){
      $this->validate($request, array(
         'customer'=>'required',
         'amount'=>'required',
         'invoice'=>'required',
      ));

      $payment = invoice_payments::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      $invoice =  invoices::where('id',$request->invoice)->where('businessID',Auth::user()->businessID)->first();

      //check if amount has changed
      if($payment->amount != $request->amount){

         //subtract the initial edited payment and replace with new
         $remove = invoices::where('id',$request->invoice)->where('businessID',Auth::user()->businessID)->first();
         $remove->paid = $remove->paid - $payment->amount;
         $remove->save();

         $newInvoice =  invoices::where('id',$request->invoice)->where('businessID',Auth::user()->businessID)->first();
         //update invoice payment & status
         //update payment
         $currentPayment = $newInvoice->paid;
         $newPayment = $currentPayment + $request->amount;
         $newInvoice->paid = $newPayment;
         $newInvoice->balance = $newInvoice->total - $newPayment;

         //update status
         if($newPayment == $newInvoice->total || $newPayment > $newInvoice->total){
               $newInvoice->statusID = 1;
         }elseif($newPayment < $newInvoice->total && $newPayment != 0 ){
               $newInvoice->statusID = 3;
         }

         $newInvoice->save();

         //credit customer
         if($payment->amount != $request->amount && $payment->credit == 'yes' && $invoice->paid != $invoice->total) {
               //delete credit note
               //credit note
               $creditnote = creditnote::where('id',$payment->creditID)->where('businessID',Auth::user()->businessID)->first();

               if($creditenote->statusID != 22){
               //check if linked to invoice
               $invoiceCredit = invoice_creditnote::where('creditID',$payment->creditID)
                                 ->where('businessID',Auth::user()->businessID)
                                 ->count();

               if($invoiceCredit == 0){
                  $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/creditnote/';

                  $check_files = docs::where('fileID',$payment->creditID)->where('section','creditnote')->count();

                  if($check_files > 0){
                     $files = docs::where('fileID',$payment->creditID)->where('section','creditnote')->get();
                     foreach($files as $file){
                           $doc = docs::find($file->id);

                           //create directory if it doesn't exists
                           $delete = $directory.$doc->file_name;
                           if (File::exists($delete)) {
                           unlink($delete);
                           }

                           $doc->delete();
                     }
                  }

                  //delete creditnote products
                  $delete_products = creditnote_products::where('creditnoteID',$payment->creditID)->delete();

                  //delete creditnote plus attachment

                  $creditnote->delete();

                  //recorord activity
                  $activities = 'creditnote #'.Finance::creditnote()->prefix.$creditnote->creditnote_number.' had been deleted by '.Auth::user()->name;
                  $section = 'creditnote';
                  $type = 'Delete';
                  $adminID = Auth::user()->id;
                  $activityID = $payment->creditID;
                  $businessID = Auth::user()->businessID;

                  Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);
               }
               }

         }

         if($payment->amount != $request->amount && $payment->credit == 'yes' && $invoice->paid > $invoice->total) {
               //update credit note
               $update = creditnote::where('businessID',Auth::user()->businessID)->where('id',$payment->creditID)->first();
               $update->customerID	 	  = $request->customer;
               $update->total		        = $request->amount;
               $update->sub_total		  = $request->amount;
               $update->businessID 		  = Auth::user()->businessID;
               $update->save();


               //delete product
               $delete = creditnote_products::where('creditnoteID', $payment->creditID);
               $delete->delete();

               //new products
               $product 					= new creditnote_products;
               $product->creditnoteID  = $update->id;
               $product->product_name	= 'Payment credit';
               $product->quantity		= 1;
               $product->price    		= $request->amount;
               $product->save();
         }

         if($payment->amount != $request->amount && $payment->credit == "" && $invoice->paid > $invoice->total) {
               //create a new credit note
               //update creditnote number
               $setting = creditnote_settings::where('businessID',Auth::user()->businessID)->first();

               $creditAmount = $invoice->paid - $invoice->total;

               $credit					     = new creditnote;
               $total                    = $creditAmount;
               $credit->userID		        = Auth::user()->id;
               $credit->customerID	 	  = $request->customer;
               $credit->creditnote_number = $setting->number;
               $credit->total		         = $total;
               $credit->balance			   = $total;
               $credit->sub_total			 = $total;
               $credit->creditnote_date	 = date('Y-m-d');
               $credit->statusID			 = 21;
               $credit->paymentID       = $payment->id;
               $credit->businessID 		 = Auth::user()->businessID;
               $credit->save();

               //products
               $product 					= new creditnote_products;
               $product->creditnoteID  = $credit->id;
               $product->product_name	= 'Payment credit';
               $product->quantity		= 1;
               $product->price    		= $total;
               $product->save();


               $setting->number = $setting->number + 1;
               $setting->save();

               //update payment
               $updateCredit = invoice_payments::where('id',$payment->id)->where('businessID',Auth::user()->businessID)->first();
               $updateCredit->credited = 'yes';
               $updateCredit->creditID = $credit->id;
               $updateCredit->save();
         }
      }

      // if($request->accountID != $payment->accountID){

      //    //remove from account
      //    $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$payment->accountID)->first();
      //    $account->initial_balance = $account->initial_balance - $payment->amount;
      //    $account->save();

      //    //add to new account
      //    $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$request->accountID)->first();
      //    $account->initial_balance = $account->initial_balance + $request->amount;
      //    $account->save();

      //    Session::flash('success','Account successfully changed');
      // }

      // edit payment info
      if($payment->amount != $request->amount){
         $payBalance =  invoices::where('id',$request->invoice)->where('businessID',Auth::user()->businessID)->first();
         $payment->amount = $request->amount;
         $payment->balance = $payBalance->total - $payBalance->paid;
      }

      $payment->bank_charges = $request->bank_charges;
      $payment->payment_date = $request->payment_date;
      $payment->payment_method = $request->payment_method;
      $payment->reference_number = $request->reference_number;
      $payment->invoiceID = $request->invoice;
      $payment->note = $request->note;
      $payment->accountID = $request->accountID;
      $payment->incomeID = $request->incomeID;
      $payment->display_in_portal = $request->display_in_portal;
      $payment->customerID = $request->customer;
      $payment->updated_by = Auth::user()->id;
      $payment->businessID = Auth::user()->businessID;
      $payment->payment_category = 'Received';

      $payment->save();

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/';

         if (!file_exists($directory)) {
               mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
               // GET THE FILE EXTENSION
               $extension = $file->getClientOriginalExtension();

               // RENAME THE UPLOAD WITH RANDOM NUMBER
               $fileName = Finance::invoice_settings()->perfix.'00'.Helper::seoUrl($invoice->invoice_number).'-'.Helper::generateRandomString(3). '.' . $extension;

               // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
               $upload_success = $file->move($directory, $fileName);

               $upload = new docs;
               $upload->fileID      = $payment->id;
               $upload->folder 	   = 'Finance';
               $upload->section 	   = 'payments';
               $upload->name 		   = 'Payment for invoice # 0'.$invoice->number;
               $upload->file_name   = $fileName;
               $upload->file_size   = $size;
               $upload->file_mime   = $file->getClientMimeType();
               $upload->created_by  = Auth::user()->id;
               $upload->businessID  = Auth::user()->businessID;
               $upload->save();
         }
      }

      Session::flash('success','The payment has been updated');

      //record activity
      $activities = 'A payment update has been made for invoice #'.Finance::invoice_settings()->prefix.$invoice->invoice_number.',recorded by '.Auth::user()->name;
      $section = 'Invoice';
      $type = 'Payment';
      $adminID = Auth::user()->id;
      $activityID = $payment->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      return redirect()->back();
   }

   public function files($id){
      $files = docs::where('fileID',$id)
               ->where('folder','=','Finance')
               ->where('section','=','Payments')
               ->where('businessID',Auth::user()->businessID)
               ->OrderBy('id','DESC')
               ->get();
      $file_count = docs::where('fileID',$id)->where('folder','Finance')->count();

      return view('app.finance.payments.file')->withPaymentid($id)->withFiles($files)->withCount($file_count);
   }

   public function retrive_client($id){
      $invoices = invoices::where('customerID',$id)->where('statusID','!=',1)->where('businessID',Auth::user()->businessID)->get();
      return \Response::json($invoices);
   }

   public function file_delete($id){
      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/';

      $delete = docs::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      $file = $directory.$delete->file_name;

      if(File::exists($file)) {
         unlink($file);
      }

      $delete->delete();

      //record activity
      $activities = 'payment file has been deleted by '.Auth::user()->name;
      $section = 'Invoice';
      $type = 'Payment';
      $adminID = Auth::user()->id;
      $activityID = $id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','File deleted successfully');

      return redirect()->back();
   }

   public function download($id) {
      $file = docs::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/'.$file->file_name;
      return response()->download($path);
   }

   public function show($id){
      $details = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
                  ->join('business','business.id','=','invoice_payments.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->join('customer_address','customer_address.customerID','=','invoice_payments.customerID')
                  ->join('invoices','invoices.id','=','invoice_payments.invoiceID')
                  ->join('invoice_settings','invoice_settings.businessID','=','business.id')
                  ->where('invoice_payments.id',$id)
                  ->where('invoice_payments.businessID',Auth::user()->businessID)
                  ->select('*','invoice_payments.reference_number as transactionID','invoice_payments.balance as paymentBalance','invoice_payments.id as invoicePaymentID','business.name as businessName')
                  ->first();
      
      return view('app.finance.payments.show', compact('details'));
   }

   public function print($id){

      $payments = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
                  ->join('business','business.id','=','invoice_payments.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->join('invoice_settings','invoice_settings.businessID','=','business.id')
                  ->join('invoices','invoices.id','=','invoice_payments.invoiceID')
                  ->join('users','users.id','=','invoice_payments.created_by')
                  ->where('invoice_payments.businessID',Auth::user()->businessID)
                  ->select('*','invoice_payments.id as paymentID','invoice_payments.created_at as payment_date','invoice_payments.reference_number as transactionID','users.name as username')
                  ->orderby('invoice_payments.id','desc')
                  ->get();

      $details = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
                  ->join('business','business.id','=','invoice_payments.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->join('customer_address','customer_address.customerID','=','invoice_payments.customerID')
                  ->join('invoices','invoices.id','=','invoice_payments.invoiceID')
                  ->join('invoice_settings','invoice_settings.businessID','=','business.id')
                  ->where('invoice_payments.id',$id)
                  ->where('invoice_payments.businessID',Auth::user()->businessID)
                  ->select('*','invoice_payments.reference_number as transactionID','invoice_payments.balance as paymentBalance','invoice_payments.id as invoicePaymentID','business.name as businessName')
                  ->first();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/receipt', compact('payments','details'));

      return $pdf->stream($details->transactionID.'.pdf');
   }

   public function pdf($id){

      $payments = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
                  ->join('business','business.id','=','invoice_payments.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->join('invoice_settings','invoice_settings.businessID','=','business.id')
                  ->join('invoices','invoices.id','=','invoice_payments.invoiceID')
                  ->join('users','users.id','=','invoice_payments.created_by')
                  ->where('invoice_payments.businessID',Auth::user()->businessID)
                  ->select('*','invoice_payments.id as paymentID','invoice_payments.created_at as payment_date','invoice_payments.reference_number as transactionID','users.name as username')
                  ->orderby('invoice_payments.id','desc')
                  ->get();

      $details = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
                  ->join('business','business.id','=','invoice_payments.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->join('customer_address','customer_address.customerID','=','invoice_payments.customerID')
                  ->join('invoices','invoices.id','=','invoice_payments.invoiceID')
                  ->join('invoice_settings','invoice_settings.businessID','=','business.id')
                  ->where('invoice_payments.id',$id)
                  ->where('invoice_payments.businessID',Auth::user()->businessID)
                  ->select('*','invoice_payments.reference_number as transactionID','invoice_payments.balance as paymentBalance','invoice_payments.id as invoicePaymentID','business.name as businessName')
                  ->first();  

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/receipt', compact('payments','details'));

      return $pdf->download($details->invoicePaymentID.'payment.pdf');
   }

   public function mail($id){
      $details = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
                  ->join('business','business.id','=','invoice_payments.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->join('customer_address','customer_address.customerID','=','invoice_payments.customerID')
                  ->join('invoices','invoices.id','=','invoice_payments.invoiceID')
                  ->join('invoice_settings','invoice_settings.businessID','=','business.id')
                  ->where('invoice_payments.id',$id)
                  ->where('invoice_payments.businessID',Auth::user()->businessID)
                  ->select('*','invoice_payments.reference_number as transactionID','invoice_payments.balance as paymentBalance','invoice_payments.id as invoicePaymentID','business.name as businessName')
                  ->first();

      $contacts = contact_persons::where('customerID',$details->customerID)->get();

      //directory
      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/';
      

      //create directory if it doesn't exists
      if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
      }

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/receipt', compact('details'));

      $pdf->save($directory.$details->invoicePaymentID.'payment.pdf');

      return view('app.finance.payments.mail', compact('details','contacts'));
   }

   public function send(Request $request){
      $this->validate($request,[
            'email_from' => 'required|email',
            'send_to' 	 => 'required',
            'subject'    => 'required',
            'message'	 => 'required',
      ]);

         //creditnote information
      $payment = invoice_payments::join('customers','customers.id','=','invoice_payments.customerID')
               ->join('business','business.id','=','invoice_payments.businessID')
               ->where('invoice_payments.id',$request->paymentID)
               ->where('invoice_payments.businessID',Auth::user()->businessID)
               ->select('*','invoice_payments.reference_number as transactionID','invoice_payments.balance as paymentBalance','invoice_payments.id as invoicePaymentID','business.name as businessName','customers.id as customerID')
                  ->first();

         //check for email CC
         $checkcc = count(collect($request->email_cc));

         //save email
         $emails = new emails;
         $emails->message   = $request->message;
         $emails->clientID  = $payment->customerID;
         $emails->subject   = $request->subject;
         $emails->mail_from = $request->email_from;
         $emails->category  = 'Payment Document';
         $emails->status    = 'Sent';
         $emails->ip 		 = Helper::get_client_ip();
         $emails->type      = 'Outgoing';
         $emails->section   = 'payments';
         $emails->mail_to   = $request->send_to;
         if($checkcc > 0){
               $emails->cc   	= json_encode($request->get('email_cc'));
         }
         $emails->save();

         //send email
         $subject = $request->subject;
         $content = $request->message;
         $from = $request->email_from;
         $to = $request->send_to;
         $mailID = $emails->id;
         $doctype = 'payments';
         $docID = $payment->invoicePaymentID;

         if($request->attaches == 'Yes'){
            $attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/'.$payment->invoicePaymentID.'payment.pdf';
         }else{
               $attachment = 'No';
         }


         Mail::to($to)->send(new sendPayment($content,$subject,$from,$mailID,$docID,$doctype,$attachment));

         //recorord activity
         $activities = 'Payment #'.Finance::creditnote()->prefix.$payment->creditnote_number.' has been sent to the client by '.Auth::user()->name;
         $section = 'payment';
         $type = 'Sent';
         $adminID = Auth::user()->id;
         $activityID = $request->paymentID;
         $businessID = Auth::user()->businessID;

         Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

         Session::flash('success','Payment Sent to client successfully');

         return redirect()->back();
   }

   public function delete($id){
      //delete payments
      $payment = invoice_payments::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      //reduce payment amount
      $invoice =  invoices::where('id',$payment->invoiceID)->where('businessID',Auth::user()->businessID)->first();
      $balance = $invoice->paid - $payment->amount;
      $invoice->paid = $balance;
      $invoice->balance = $invoice->paid + $payment->amount;

      //update status
         if($balance == $invoice->total || $balance > $invoice->total){
               $invoice->statusID = 1;
         }elseif($balance < $invoice->total && $balance != 0 ){
               $invoice->statusID = 3;
      }

      $invoice->save();


      $payment->delete();

      //delete files
      $check = docs::where('fileID',$id)->where('folder','Finance')->where('section','Payments')->count();

      if($check > 0){
         $files = docs::where('fileID',$id)->where('folder','Finance')->where('section','Payments')->get();
         foreach ($files as $file) {
               $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/';
               $delete = $directory.$file->file_name;
               if (File::exists($delete)) {
               unlink($delete);
               }
               $file->delete();
         }
      }

      //record activity
         $activities = 'payment has been deleted by '.Auth::user()->name;
         $section = 'Invoice';
         $type = 'Payment';
         $adminID = Auth::user()->id;
         $activityID = $payment->id;
         $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Payment successfully deleted and invoice adjusted');

      return redirect()->back();
   }
}
