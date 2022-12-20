<?php

namespace App\Http\Controllers\app\crm\customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\wingu\file_manager as docs; 
use App\Models\crm\emails;
use App\Mail\sendCrm;
use Mail;
use Session;
use Auth;
use Helper;
use Wingu;

class mailController extends Controller
{
   public function index($id){
      $customerID = $id;
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->join('business','business.id','=','customers.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->where('customers.id',$id)
					->where('customers.businessID',Auth::user()->businessID)
					->select('*','customers.id as cid')
               ->first();

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

      $mails = emails::where('clientID',$id)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->paginate(11);
				
      return view('app.crm.customers.view', compact('client','customerID','contacts','mails'));
   }

   //compose mail
   public function send($id){
      $customerID = $id;
      $client = customers::join('customer_address','customer_address.customerID','=','customers.id')
               ->join('business','business.id','=','customers.businessID')
               ->join('currency','currency.id','=','business.base_currency')
               ->where('customers.id',$id)
               ->where('customers.businessID',Auth::user()->businessID)
               ->select('*','customers.id as cid')
               ->first();

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();
      $folder = 'customer/'.$client->reference_number;
      $files = docs::where('fileID',$id)
                     ->where('businessID',Auth::user()->businessID)
                     ->where('folder',$folder)
                     ->where('section','customer')
                     ->orderby('id','desc')
                     ->get();

      return view('app.crm.customers.view', compact('client','customerID','files','contacts'));
   }

   //send mail
   public function store(Request $request){
      $this->validate($request, [
         'email' => 'required',
         'message' => 'required',
         'leadID' => 'required',
         'subject' => 'required',
      ]);

      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$request->leadID)->first();

      $checkatt = count(collect($request->attach_files));

		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('section','customer')->where('fileID',$request->leadID)->where('businessID',Auth::user()->businessID)->get();
			foreach ($filechange as $fc) {
				$null = docs::where('id',$fc->id)->where('businessID',Auth::user()->businessID)->first();
				$null->attach = "No";
				$null->save();
			}

			for($i=0; $i < count($request->attach_files); $i++ ) {

				$sendfile = docs::where('id',$request->attach_files[$i])->where('businessID',Auth::user()->businessID)->first();
				$sendfile->attach = "Yes";
				$sendfile->save();
			}
		}else{
			$chage = docs::where('section','customer')->where('fileID',$request->leadID)->where('businessID',Auth::user()->businessID)->get();
			foreach ($chage as $cs) {
				$null = docs::where('id',$cs->id)->where('businessID',Auth::user()->businessID)->first();
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
      $checkcc = count(collect($request->email_cc));
      
      //save email
		$trackCode          = Helper::generateRandomString(9);   
      $emails             = new emails;
      $emails->message    = $request->message;
      $emails->names      = $lead->customer_name;
      $emails->clientID   = $request->leadID;
      $emails->subject    = $request->subject;
      $emails->mail_from  = Wingu::business()->primary_email;
      $emails->category   = 'customer';
      $emails->ip 		  = Helper::get_client_ip();
      $emails->type       = 'Outgoing';
      $emails->section    = 'customer';
      $emails->mail_to    = $request->email;
      $emails->tracking_code = $trackCode;
      $emails->userID     = Auth::user()->id;
      $emails->businessID = Auth::user()->businessID;
      if($checkcc > 0){
			$emails->cc  = json_encode($request->get('email_cc'));
		}
      $emails->save();
      
		//send email      
      $mailID   = $emails->id;
      $parentID = $request->leadID;  
		$folder   = 'customer/'.$lead->reference_number;
      $subject  = $request->subject;
      $to       = $request->email; 
      $from     = Wingu::business()->primary_email;
      $content  = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->businessID.'/'.$emails->id.'" width="1" height="1" />';

      Mail::to($to)->send(new sendCrm($content,$subject,$from,$mailID,$parentID,$folder));

      $updateEmails = emails::where('id',$emails->id)->where('businessID',Auth::user()->businessID)->first();
      $updateEmails->status = 'Sent';
      $updateEmails->save();

      //record activity
		$activities = Auth::user()->name.' has sent an email to '.$lead->customer_name;
		$section = 'crm';
		$type = 'customer';
		$adminID = Auth::user()->id;
		$activityID = $request->leadID;
		$businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);
      
      Session::flash('success','Email successfully sent');

      return redirect()->route('crm.customer.mail',$request->leadID);
   }

   //mail details
   public function details($id,$customerID){
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->join('business','business.id','=','customers.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->where('customers.id',$customerID)
					->where('customers.businessID',Auth::user()->businessID)
					->select('*','customers.id as cid')
               ->first();

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

      $mail = emails::where('clientID',$customerID)->where('businessID',Auth::user()->businessID)->where('id',$id)->first();
				
      return view('app.crm.customers.mail.show', compact('client','customerID','contacts','mail'));
   }
}
