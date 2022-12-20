<?php
namespace App\Http\Controllers\app\finance\contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business_telephony;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\wingu\business;
use App\Models\crm\sms;
use Twilio\Rest\Client;
use Validator;
use Session;
use Auth;

class smsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

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

      $smses = sms::where('customerID',$id)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

      return view('app.finance.contacts.view', compact('client','customerID','smses','contacts','smses'));
   }

   //send sms
   public function send(Request $request){
      $this->validate($request, [
         'message' => 'required',
         'to' => 'required',
         'customerID' => 'required',
      ]);

      //get default channel
      $business = business::where('businessID',Auth::user()->code)->where('id',Auth::user()->businessID)->first();
   
      $sms = new sms;
      $sms->sms_to = $request->to;
      $sms->message = $request->message;
      $sms->businessID = Auth::user()->businessID;
      $sms->created_by = Auth::user()->id;
      $sms->channelID = $business->telephonyID;
      $sms->status = 10;
      $sms->sent_mode = 'single';
      $sms->section = 'Customer';
      $sms->customerID = $request->customerID;
      $sms->save();   

      //twilio
      if($business->telephonyID == 1){
         $twilio = business_telephony::where('businessID',Auth::user()->businessID)->where('telephonyID',1)->first();

         // Your Account SID and Auth Token from twilio.com/console
         $sid    = $twilio->tw_sid;
         $token  = $twilio->tw_token;
         $client = new Client($sid, $token );

         $validator = Validator::make($request->all(), [
            'to' => 'required',
            'message' => 'required'
         ]);

         if ($validator->passes() ) {
            $numbers_in_arrays = explode( ',' , $request->input( 'to' ) );
            $message = $request->input( 'message' );
            $count = 0;
            foreach( $numbers_in_arrays as $number ){
               $count++;
               $client->messages->create(
                  $number,
                  [
                     'from' => $twilio->sms_from,
                     'body' => $message,
                  ]
               );
            }

            Session::flash('success',$count .' Sms has been saved and sent');

            //update sms status
            $update = sms::where('businessID',Auth::user()->businessID)->where('id', $sms->id)->first();
            $update->status = 6;
            $update->sms_from = $twilio->sms_from;
            $update->save();

            return redirect()->back();
                  
         } else {
            Session::flash('error','Sms has not been sent');

            return redirect()->back();
         }
      }
      
      //africas talking
      if($business->telephonyID == 2){
         $africa = business_telephony::where('businessID',Auth::user()->businessID)->where('telephonyID',2)->first();

         // Set your app credentials
         $username   = $africa->at_username;
         $apiKey     = $africa->at_apikey;

         // Initialize the SDK
         $AT         = new AfricasTalking($username, $apiKey);

         // Get the SMS service
         $sendSms        = $AT->sms();

         // Set the numbers you want to send to in international format
         $recipients = $request->to;

         // Set your message
         $message    = $request->message;

         // Set your shortCode or senderId
         //$from       = $africa->sms_from;

         try {
            // Thats it, hit send and we'll take care of the rest
            $result = $sendSms->send([
               'to'      => $recipients,
               'message' => $message,
               'from'    => $africa->sms_from,
            ]);

            Session::flash('success','Sms has been saved and sent');

            //update sms status
            $update = sms::where('businessID',Auth::user()->businessID)->where('id', $sms->id)->first();
            $update->status = 6;
            $update->sms_from = $africa->sms_from;
            $update->save();

            return redirect()->back();

         } catch (Exception $e) {

            Session::flash('error','Sms has not been sent');

            return redirect()->back();
         }
      }
   }
}
