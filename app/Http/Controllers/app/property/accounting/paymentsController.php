<?php

namespace App\Http\Controllers\app\property\accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\wingu\business;
use App\Models\property\invoice\invoices;
use App\Models\property\invoice\invoice_settings;
use App\Models\property\payments\payments;
use App\Models\property\tenants\tenants;
use App\Models\property\lease;
use App\Models\finance\accounts;
use App\Models\finance\income\category;
use App\Models\finance\payments\payment_type; 
use App\Models\property\creditnote\creditnote_settings;
use App\Models\property\creditnote\creditnote;
use App\Models\property\creditnote\creditnote_products;
use App\Models\wingu\file_manager as documents; 
use Property as Prop;
use Auth;
use Session;
use Helper;
use Wingu;
use File;

class paymentsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($propertyID)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->first();
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
      $payments = payments::join('property_invoices','property_invoices.id','=','property_invoice_payments.invoiceID')
                           ->join('property_tenants','property_tenants.id','=','property_invoice_payments.tenantID')
                           ->join('property_lease','property_lease.id','=','property_invoices.leaseID')
                           ->where('property_invoice_payments.businessID',Auth::user()->businessID)
                           ->where('property_invoices.propertyID',$propertyID)
                           ->orderby('property_invoice_payments.id','desc')
                           ->select('*','property_invoice_payments.reference_number as reference_number','property_lease.unitID as unit','property_invoice_payments.id as paymentID')
                           ->get();

      $count = 1;

      return view('app.property.accounting.payments.index', compact('property','count','propertyID','business','payments'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create($propertyID)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->first(); 

      $tenants = lease::join('property_tenants','property_tenants.id','=','property_lease.tenantID')
									->where('property_lease.propertyID',$propertyID)
									->where('property_lease.statusID',15)		
									->where('property_lease.businessID',Auth::user()->businessID)
									->groupby('property_lease.tenantID')						
									->orderby('property_tenants.id','desc')
									->select('*','property_tenants.id as tenantID')								
									->get();
      
      $accounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose deposit account','');

      $mainMethods =  payment_type::where('businessID',0)->get();
      $paymentmethod = payment_type::where('businessID',Auth::user()->businessID)->get();

      $invoiceSetting = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
         
      $count = 1;

      return view('app.property.accounting.payments.create', compact('property','tenants','accounts','paymentmethod','mainMethods','invoiceSetting','business','propertyID'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(request $request){
      $this->validate($request, array(
         'tenant'=>'required',
         'amount'=>'required',
         'invoice'=>'required',
      ));

      //update invoice payment & status
      $invoice =  invoices::where('id',$request->invoice)->where('propertyID',$request->propertyID)->where('businessID',Auth::user()->businessID)->first();
      $payment = new payments;
      $payment->amount = $request->amount;
      $payment->balance = $invoice->balance - $request->amount;
      $payment->bank_charges = $request->bank_charges;
      $payment->payment_date = $request->payment_date;
      $payment->payment_method = $request->payment_method;
      $payment->reference_number = $request->reference_number;
      $payment->invoiceID = $request->invoice;
      $payment->note = $request->note;
      $payment->display_in_portal = $request->display_in_portal;
      $payment->tenantID = $request->tenant;
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


      //tenant Credit
      if($invoice->paid > $invoice->total) {
         $check = creditnote_settings::where('propertyID',$request->propertyID)->where('businessID',Auth::user()->businessID)->count();
			if($check != 1){
				Prop::make_creditnote_settings($request->propertyID);
			}

         //update creditnote number
         $setting = creditnote_settings::where('propertyID',$request->propertyID)->where('businessID',Auth::user()->businessID)->first();

         $creditAmount = $invoice->paid - $invoice->total;

         $credit					      = new creditnote;
         $total                     = $creditAmount;
         $credit->created_by		   = Auth::user()->id;
         $credit->tenantID	 	      = $request->customer;
         $credit->creditnote_number = $setting->number;
         $credit->creditnote_prefix = $setting->prefix;
         $credit->total		         = $total;
         $credit->title             = 'Payment credit for invoice '.$invoice->invoice_prefix.$invoice->invoice_number;
         $credit->balance			   = $total;
         $credit->sub_total			= $total;
         $credit->creditnote_date	= date('Y-m-d');
         $credit->statusID			   = 21;
         $credit->propertyID        = $request->propertyID;
         $credit->paymentID         = $payment->id;
         $credit->businessID 		   = Auth::user()->businessID;
         $credit->save();

         //credit note product
         $product 					= new creditnote_products;
         $product->creditnoteID  = $credit->id;
         $product->product_name	= 'Payment credit '.$invoice->invoice_prefix.$invoice->invoice_number;
         $product->quantity		= 1;
         $product->price    		= $total;
         $product->save();

         $setting->number = $setting->number + 1;
         $setting->save();

         //update payment
         $updateCredit = payments::where('id',$payment->id)->where('businessID',Auth::user()->businessID)->first();
         $updateCredit->credited = 'yes';
         $updateCredit->creditID = $credit->id;
         $updateCredit->save();
      }

      //upload images
      if($request->hasFile('files')){
         $property = property::where('id',$request->propertyID)->where('businessID',Auth::user()->businessID)->first();

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/payments/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            $size =  $file->getSize();
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(20).'.'.$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new documents;
            $upload->fileID      = $payment->id;
            $upload->folder 	   =  $property->property_code;
            $upload->section 	   = 'property/payments';
            $upload->name 		   = 'Payment for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number;
            $upload->file_name   = $fileName;
            $upload->file_size   = $size;
            $upload->file_mime   = $file->getClientMimeType();
            $upload->created_by  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->save();
         }
      }

      //Send payment acknowledgment message to client
      // if($request->send_email == 'yes'){

      //    $clientName = Finance::client($request->customer)->customer_name;

      //    $subject = 'Payment acknowledgment for #'.Finance::invoice_settings()->prefix.$invoice->invoice_number;
      //    $to = Finance::client($request->customer)->email;
      //    $content = '<span style="font-size: 12pt;">Hello '.$clientName.'</span><br/><br/>
      //    Thank you for the payment. Find the payment details below:<br/><br/>
      //    -------------------------------------------------
      //    <br/><br/>
      //    Amount:&nbsp;<strong>'. number_format($request->amount).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
      //    Balance:&nbsp;<strong>'. number_format($invoice->total - $invoice->paid).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
      //    Date:&nbsp;<strong>'.date('jS F, Y', strtotime($request->payment_date)).'</strong><br/>
      //    Invoice number:&nbsp;<span style="font-size: 12pt;"><strong>#'.Finance::invoice_settings()->prefix.$invoice->invoice_number.'</strong><br/><br/></span>
      //    -------------------------------------------------
      //    <br/><br/>
      //    We are looking forward working with you.<br/>';

      //    Mail::to($to)->send(new sendMessage($content,$subject));

      //    //save email
      //    $emails = new emails;
      //    $emails->message   = $content;
      //    $emails->clientID  = $request->customer;
      //    $emails->subject   = $subject;
      //    $emails->mail_from = Wingu::business(Auth::user()->businessID)->businessID;
      //    $emails->category  = 'Invoice Payment acknowledgment';
      //    $emails->status    = 'Sent';
      //    $emails->ip 		 = Helper::get_client_ip();
      //    $emails->type      = 'Outgoing';
      //    $emails->section   = 'invoices';
      //    $emails->mail_to   = $to;
      //    $emails->userID   = Auth::user()->id;
      //    $emails->businessID   = Auth::user()->businessID;
      //    $emails->save();
      // }

      Session::flash('success','The payments have been added');

      //record activity
      $activities = 'A payment has been made for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.',recorded by '.Auth::user()->name;
      $section = 'Property';
      $type = 'Payment';
      $adminID = Auth::user()->id;
      $activityID = $payment->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      return redirect()->route('property.payments',$request->propertyID);
   }

   /**
   * Edit payment
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($propertyID,$paymentID){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $business = business::join('currency','currency.id','=','business.base_currency')
                        ->where('business.id',Auth::user()->businessID)
                        ->first();

      $tenants = tenants::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
     
      $mainMethods =  payment_type::where('businessID',0)->get();
      $paymentmethod = payment_type::where('businessID',Auth::user()->businessID)->get();

      $payment = payments::join('property_invoices','property_invoices.id','=','property_invoice_payments.invoiceID')
                  ->join('property_tenants','property_tenants.id','=','property_invoice_payments.tenantID')                 
                  ->where('property_invoice_payments.businessID',Auth::user()->businessID)
                  ->where('propertyID',$propertyID)
                  ->where('property_invoice_payments.id',$paymentID)
                  ->select('*','property_invoice_payments.id as paymentID','property_invoice_payments.tenantID as tenantID','property_invoice_payments.payment_date as payment_date','property_invoice_payments.reference_number as reference_number')
                  ->first();

      $invoice = invoices::where('id',$payment->invoiceID)->where('businessID',Auth::user()->businessID)->first();

      $files = documents::where('fileID',$paymentID)
                        ->where('folder','=',$property->property_code)
                        ->where('section','=','property/payments')
                        ->where('businessID',Auth::user()->businessID)
                        ->get();

      $invoiceSetting = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();


      return view('app.property.accounting.payments.edit',  compact('tenants','business','paymentmethod','mainMethods','payment','invoice','files','invoiceSetting','property','propertyID'));
   }

   /**
    * update payment
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $propertyID, $paymentID){
      $this->validate($request, array(
         'amount'=>'required',
      ));

      //get the payment information
      $payment = payments::where('id',$paymentID)->where('businessID',Auth::user()->businessID)->first();

      //get invoice information
      $invoice =  invoices::where('id',$payment->invoiceID)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();   
      //check if amount has changed
      if($payment->amount != $request->amount){

         //if the old payment was credited
         if($payment->credited == 'yes') {
            //delete credit note
            //credit note
            $creditnote = creditnote::where('id',$payment->creditID)->where('paymentID',$paymentID)->where('businessID',Auth::user()->businessID)->first();

            //check if credit note is not used up
            if($creditnote->statusID != 22){
               //delete creditnote products
               creditnote_products::where('creditnoteID',$creditnote->id)->delete();

               //delete creditnote plus attachment
               $creditnote->delete();

               $paymentCreditUpdate = payments::where('id',$paymentID)->where('businessID',Auth::user()->businessID)->first();
               $paymentCreditUpdate->credited = Null;
               $paymentCreditUpdate->save();

               //recorord activity
               $activities = 'creditnote #'.$creditnote->creditnote_number.' had been deleted by '.Auth::user()->name;
               $section = 'creditnote';
               $type = 'Delete';
               $adminID = Auth::user()->id;
               $activityID = $payment->creditID;
               $businessID = Auth::user()->businessID;

               Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);
            }
         }

         //subtract the initial payment and replace with new
         $remove = invoices::where('id',$invoice->id)->where('businessID',Auth::user()->businessID)->where('propertyID',$propertyID)->first();
         $remove->paid = $remove->paid - $payment->amount;
         $remove->save();

         //update the invoice with the new payment amount
         $newInvoice =  invoices::where('id',$invoice->id)->where('businessID',Auth::user()->businessID)->where('propertyID',$propertyID)->first();
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

         //create new credit note
         if($newPayment > $newInvoice->total) {
            //create settings if not exsisting
            $check = creditnote_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->count();
            if($check != 1){
               Prop::make_creditnote_settings($propertyID);
            }
            
            //get creditnote settings
            $setting = creditnote_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();
   
            $creditAmount = $newInvoice->paid - $newInvoice->total;
   
            $credit					      = new creditnote;
            $total                     = $creditAmount;
            $credit->created_by		   = Auth::user()->id;
            $credit->tenantID	 	      = $payment->tenantID;
            $credit->creditnote_number = $setting->number;
            $credit->creditnote_prefix = $setting->prefix;
            $credit->total		         = $total;
            $credit->title             = 'Payment credit for invoice '.$newInvoice->invoice_prefix.$newInvoice->invoice_number;
            $credit->balance			   = $total;
            $credit->sub_total			= $total;
            $credit->creditnote_date	= date('Y-m-d');
            $credit->statusID			   = 21;
            $credit->propertyID        = $request->propertyID;
            $credit->paymentID         = $payment->id;
            $credit->businessID 		   = Auth::user()->businessID;
            $credit->save();

            //credit note product
            $product 					= new creditnote_products;
            $product->creditnoteID  = $credit->id;
            $product->product_name	= 'Payment credit '.$newInvoice->invoice_prefix.$newInvoice->invoice_number;
            $product->quantity		= 1;
            $product->price    		= $total;
            $product->save();
   
            $setting->number = $setting->number + 1;
            $setting->save();
   
            //update payment with credit amount
            $payment->credited = 'yes';
            $payment->creditID = $credit->id;
         }

         //update the payment with the new payment details
         $payment->amount = $request->amount;         
         $payment->balance = $newInvoice->total - $newInvoice->paid;
      }

      $payment->bank_charges = $request->bank_charges;
      $payment->payment_date = $request->payment_date;
      $payment->payment_method = $request->payment_method;
      $payment->reference_number = $request->reference_number;
      $payment->note = $request->note;
      $payment->updated_by = Auth::user()->id;
      $payment->businessID = Auth::user()->businessID;
      $payment->payment_category = 'Received';
      $payment->save();

      //get the invoice details again with the updates 
      $invoice =  invoices::where('id',$payment->invoiceID)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();

      if($request->hasFile('files')){
         $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->first();

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/payments/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            $size =  $file->getSize();
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(20).'.'.$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new documents;
            $upload->fileID      = $payment->id;
            $upload->folder 	   =  $property->property_code;
            $upload->section 	   = 'property/payments';
            $upload->name 		   = 'Payment for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number;
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
      $activities = 'A payment update has been made for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.',recorded by '.Auth::user()->name;
      $section = 'Invoice';
      $type = 'Payment';
      $adminID = Auth::user()->id;
      $activityID = $payment->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      return redirect()->back();
   }

   /**
    * show payment
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function show($propertyID,$paymentID){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $business = business::join('currency','currency.id','=','business.base_currency')
                        ->where('business.id',Auth::user()->businessID)
                        ->first();

      $payment = payments::join('property_invoices','property_invoices.id','=','property_invoice_payments.invoiceID')
                  ->join('property_tenants','property_tenants.id','=','property_invoice_payments.tenantID')                 
                  ->where('property_invoice_payments.businessID',Auth::user()->businessID)
                  ->where('propertyID',$propertyID)
                  ->where('property_invoice_payments.id',$paymentID)
                  ->select('*','property_invoice_payments.id as paymentID','property_invoice_payments.tenantID as tenantID','property_invoice_payments.payment_date as payment_date','property_invoice_payments.reference_number as reference_number','property_invoice_payments.balance as paymentBalance')
                  ->first();

      $tenant = tenants::where('businessID',Auth::user()->businessID)->where('id',$payment->tenantID)->first();

      $invoice = invoices::where('id',$payment->invoiceID)->where('businessID',Auth::user()->businessID)->first();

      $files = documents::where('fileID',$paymentID)
               ->where('folder','=',$property->property_code)
               ->where('section','=','property/documents')
               ->where('businessID',Auth::user()->businessID)
               ->get();

      $invoiceSetting = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();


      return view('app.property.accounting.payments.show',  compact('tenant','business','payment','invoice','files','invoiceSetting','property','propertyID'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function destroy($propertyID,$paymentID)
   {
      $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->first();

      //get payment
      //get the payment information
      $payment = payments::where('id',$paymentID)->where('businessID',Auth::user()->businessID)->first();

      //get invoice information
      $invoice = invoices::where('id',$payment->invoiceID)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();  
      
      //delete credit not
      if($payment->credited == 'yes') {
         //delete credit note
         //credit note
         $creditnote = creditnote::where('id',$payment->creditID)->where('paymentID',$paymentID)->where('businessID',Auth::user()->businessID)->first();
         //check if credit note is not used up
         if($creditnote->statusID != 22){
            //delete creditnote products
            creditnote_products::where('creditnoteID',$creditnote->id)->delete();

            //delete creditnote plus attachment
            $creditnote->delete();
         }
      }

      //remove payment from invoice
      $remove = invoices::where('id',$invoice->id)->where('businessID',Auth::user()->businessID)->where('propertyID',$propertyID)->first();
      $newPaid = $remove->paid - $payment->amount;
      $remove->paid = $newPaid;
      $remove->balance = $remove->total - $newPaid;
      $remove->updated_by = Auth::user()->id;

      //update status
      if($newPaid == $remove->total || $newPaid > $remove->total){
         $remove->statusID = 1;
      }elseif($newPaid < $remove->total && $newPaid != 0 ){
         $remove->statusID = 3;
      }
      $remove->save();



      //delete files
      $checkFiles = documents::where('fileID',$paymentID)->where('businessID',Auth::user()->businessID) ->where('folder','=',$property->property_code)->count();
      if($checkFiles > 0){
         $deleteFiles = documents::where('fileID',$paymentID)->where('businessID',Auth::user()->businessID) ->where('folder','=',$property->property_code)->get();
         foreach($deleteFiles as $df){
            $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/payments/';
      
            $delete = documents::where('id',$df->id)
                              ->where('fileID',$paymentID)
                              ->where('businessID',Auth::user()->businessID)
                              ->where('folder','=',$property->property_code)
                              ->where('section','=','property/documents')
                              ->first();
   
            $file = $directory.$delete->file_name;
            if(File::exists($file)) {
               unlink($file);
            }
            $delete->delete();
         }        
      }

      //delete payment
      $payment->delete();

      Session::flash('success','Payment successfully deleted');

      return redirect()->route('property.payments',$propertyID);
   }
   
   /**
    * delete payment files
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function delete_file($propertyID,$fileID,$parentID){
      $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/payments/';
      
      $delete = documents::where('id',$fileID)
                        ->where('fileID',$parentID)
                        ->where('businessID',Auth::user()->businessID)
                        ->where('folder','=',$property->property_code)
                        ->where('section','=','property/payments')
                        ->first();

      $file = $directory.$delete->file_name;
      if(File::exists($file)) {
         unlink($file);
      }
      $delete->delete();

      //record activity
      $activities = 'payment file has been deleted by '.Auth::user()->name;
      $section = 'Property';
      $type = 'Payment';
      $adminID = Auth::user()->id;
      $activityID = $parentID;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','File deleted successfully');

      return redirect()->back();
   }

   /**
    * Retrive tenant invoices
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function retrive_tenant_invoice($propertyID,$tenantID){
      $invoices = invoices::where('tenantID',$tenantID)
                        ->where('propertyID',$propertyID)
                        ->where('statusID','!=',1)
                        ->where('businessID',Auth::user()->businessID)
                        ->orderby('id','desc')
                        ->get();
      return \Response::json($invoices);
   }
}
