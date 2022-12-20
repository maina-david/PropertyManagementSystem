<?php

namespace App\Http\Controllers\app\crm\leads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\limitless\business_telephony;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\finance\customer\customers;
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
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$id)->where('category','Lead')->first();
      $smses = sms::where('customerID',$id)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $customerID = $id;

      return view('app.crm.leads.show', compact('lead','customerID','smses'));
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


      //get default telephony 

      // //twilio
      // if($business->telephonyID == 1){
      //    $twilio = business_telephony::where('businessID',Auth::user()->businessID)->where('telephonyID',1)->first();

      //    // Your Account SID and Auth Token from twilio.com/console
      //    $sid    = $twilio->tw_sid;
      //    $token  = $twilio->tw_token;
      //    $client = new Client($sid, $token );

      //    $validator = Validator::make($request->all(), [
      //       'to' => 'required',
      //       'message' => 'required'
      //    ]);

      //    if ($validator->passes() ) {
      //       $numbers_in_arrays = explode( ',' , $request->input( 'to' ) );
      //       $message = $request->input( 'message' );
      //       $count = 0;
      //       foreach( $numbers_in_arrays as $number ){
      //          $count++;
      //          $client->messages->create(
      //             $number,
      //             [
      //                'from' => $twilio->sms_from,
      //                'body' => $message,
      //             ]
      //          );
      //       }

      //       Session::flash('success',$count .' Sms has been saved and sent');

      //       //update sms status
      //       $update = sms::where('businessID',Auth::user()->businessID)->where('id', $sms->id)->first();
      //       $update->status = 6;
      //       $update->sms_from = $twilio->sms_from;
      //       $update->save();

      //       return redirect()->back();
                  
      //    } else {
      //       Session::flash('error','Sms has not been sent');

      //       return redirect()->back();
      //    }
      // }
      
      // //africas talking
      // if($business->telephonyID == 2){
      //    $africa = business_telephony::where('businessID',Auth::user()->businessID)->where('telephonyID',2)->first();

      //    // Set your app credentials
      //    $username   = $africa->at_username;
      //    $apiKey     = $africa->at_apikey;

      //    // Initialize the SDK
      //    $AT         = new AfricasTalking($username, $apiKey);

      //    // Get the SMS service
      //    $sendSms        = $AT->sms();

      //    // Set the numbers you want to send to in international format
      //    $recipients = $request->to;

      //    // Set your message
      //    $message    = $request->message;

      //    // Set your shortCode or senderId
      //    //$from       = $africa->sms_from;

      //    try {
      //       // Thats it, hit send and we'll take care of the rest
      //       $result = $sendSms->send([
      //          'to'      => $recipients,
      //          'message' => $message,
      //          'from'    => $africa->sms_from,
      //       ]);

      //       Session::flash('success','Sms has been saved and sent');

      //       //update sms status
      //       $update = sms::where('businessID',Auth::user()->businessID)->where('id', $sms->id)->first();
      //       $update->status = 6;
      //       $update->sms_from = $africa->sms_from;
      //       $update->save();

      //       return redirect()->back();

      //    } catch (Exception $e) {

      //       Session::flash('error','Sms has not been sent');

      //       return redirect()->back();
      //    }
      // }

       
       


      //vaspro
      // Account details
      $apiKey = 'dd73f2295847b1d5112aaa867766de58';
      
      // Message details
      $numbers = array('0700928867', '0700928867');
      $message = 'This is your message';
      $shortCode = "VasPro";
      $origin = "API_INTERFACE";
      $enqueue = 1;
      $numbers = implode(',', $numbers);
      $isScheduled = "2";
      $scheduleDate = "";
      $scheduleTime = "";
      $uniqueId = "12347";
      $callbackURL = "http://vaspro.co.ke/dlr";
   
      // Prepare data for POST request
      $data = array(
         "apikey"       => $apiKey, 
         "shortCode"    => $shortCode,
         "origin"       => $origin,
         "isScheduled"  => $isScheduled,
         "scheduleDate" => $scheduleDate,
         "scheduleTime" => $scheduleTime,
         "callbackURL"  => $callbackURL,
         "contacts"     => $numbers,
         "enqueue"      => $enqueue,
         "message"      => $message,
         "uniqueId"     => $uniqueId,
      );

      //return $data;
   
      // Send the POST request with cURL
      $ch = curl_init('https://api.vaspro.co.ke/v3/BulkSMS/bulk/create');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      $response = curl_exec($ch);
      curl_close($ch);
      
      // Process your response here
      echo $response;
   }
}