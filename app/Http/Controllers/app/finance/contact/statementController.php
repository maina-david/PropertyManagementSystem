<?php
namespace App\Http\Controllers\app\finance\contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_settings;
use App\Models\crm\emails; 
use App\Mail\sendStatement;
use Session;
use Helper;
use Wingu;
use Auth;
use PDF;
use Mail;
use Finance;

class statementController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   //index
   public function index($id){
      $customerID = $id;
      $year = date('Y');
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->join('business','business.id','=','customers.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->where('customers.id',$id)
					->where('customers.businessID',Auth::user()->businessID)
					->select('*','customers.id as cid','business.businessID as business_code')
               ->first();

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

      //invoices
      $invoicesBalance = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('balance');
      $invoicedAmount = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('main_amount');
      $amountReceived = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('paid');
      $invoices = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('businessID',Auth::user()->businessID)->first();
				
      return view('app.finance.contacts.view', compact('client','customerID','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));
   }

   //pdf
   public function pdf($id){
      $year = date('Y');
      $customerID = $id;
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->join('business','business.id','=','customers.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->where('customers.id',$id)
					->where('customers.businessID',Auth::user()->businessID)
					->select('*','customers.id as cid','business.businessID as business_code')
               ->first();

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

      //invoices
      $invoicesBalance = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('balance');
      $invoicedAmount = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('main_amount');
      $amountReceived = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('paid');
      $invoices = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('businessID',Auth::user()->businessID)->first();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/statement/statement', compact('client','customerID','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));

		return $pdf->download('statement.pdf');
   }

   //print
   public function print($id){
      $year = date('Y');
      $customerID = $id;
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->join('business','business.id','=','customers.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->where('customers.id',$id)
					->where('customers.businessID',Auth::user()->businessID)
					->select('*','customers.id as cid','business.businessID as business_code')
               ->first();

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

      //invoices
      $invoicesBalance = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('balance');
      $invoicedAmount = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('main_amount');
      $amountReceived = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('paid');
      $invoices = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('businessID',Auth::user()->businessID)->first();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/statement/statement', compact('client','customerID','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));

		return $pdf->stream('statement.pdf');
   }

   //mail
   public function mail($id){
      $year = date('Y');
      $customerID = $id;
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->join('business','business.id','=','customers.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->where('customers.id',$id)
					->where('customers.businessID',Auth::user()->businessID)
					->select('*','customers.id as cid','business.businessID as business_code')
               ->first();

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

      //invoices
      $invoicesBalance = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('balance');
      $invoicedAmount = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('main_amount');
      $amountReceived = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->sum('paid');
      $invoices = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->whereYear('invoice_date', '=', $year)->orderby('id','asc')->get();
      $invoiceSettings = invoice_settings::where('businessID',Auth::user()->businessID)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/statement/';
      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/statement/statement', compact('client','customerID','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));

      $pdf->save($directory.$client->reference_number.'-2020.pdf');
      
      return view('app.finance.contacts.view', compact('client','customerID','contacts','invoicesBalance','invoicedAmount','amountReceived','invoices','invoiceSettings'));
   }

   //send 
   public function send(Request $request){
      $this->validate($request,[
			'send_to' 	 => 'required',
			'subject'    => 'required',
			'message'	 => 'required',
      ]);
      
      //check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
      $trackCode = Helper::generateRandomString(9);
      
      $client = customers::where('id',$request->customerID)->where('customers.businessID',Auth::user()->businessID)->first();

		$emails = new emails;
		$emails->message   = $request->message;
		$emails->clientID  = $request->customerID;
      $emails->subject   = $request->subject;
      $emails->names     = $client->customer_name;
		$emails->tracking_code  = $trackCode;
		$emails->mail_from = Wingu::business()->primary_email;
		$emails->category  = 'Customer statement';
		$emails->status    = 'Sent';
		$emails->ip 		 = Helper::get_client_ip();
		$emails->type      = 'Outgoing';
		$emails->section   = 'Statement';
		$emails->mail_to   = $request->send_to;
		$emails->userID   = Auth::user()->id;
		$emails->businessID   = Auth::user()->businessID;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
      $emails->save();
      
		//send email
		$subject = $request->subject;
		$content = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->businessID.'/'.$emails->id.'" width="1" height="1" />';

		$from = $request->email_from;
		$to = $request->send_to;
      $mailID = $emails->id;

      $year = date('Y');
		
		$attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/statement/'.$client->reference_number.'-'.$year.'.pdf';

		Mail::to($to)->send(new sendStatement($content,$subject,$from,$mailID,$attachment));

		//recorord activity
		$activities = Auth::user()->name.' has email statement of account to '.$client->customer_name;
		$section    = 'Statement of account';
		$type       = 'Sent';
		$adminID    = Auth::user()->id;
		$activityID = $emails->id;
		$businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','statement of account successfully sent');
      
      return redirect()->route('finance.customer.mail',$request->customerID);
   }
}
