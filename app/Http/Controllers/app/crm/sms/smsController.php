<?php

namespace App\Http\Controllers\app\crm\sms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_telephony;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\crm\sms;
use Twilio\Rest\Client;
use Validator;
use Session;
use Auth;

class smsController extends Controller
{
   public function sent(){
      $channel = business_telephony::join('telephony','telephony.id','=','business_telephony.telephonyID')
                  ->where('businessID',Auth::user()->businessID)
                  ->select('*','business_telephony.status as telephonyStatus','telephony.id as telephonyID')
                  ->pluck('name','telephonyID')
                  ->prepend('choose sms channel');
      $smses = sms::join('status','status.id','=','crm_sms.status')
               ->where('businessID',Auth::user()->businessID)
               ->orderby('crm_sms.id','desc')
               ->get();
      $count = 1;
 
      return view('app.crm.sms.sent', compact('channel','smses','count'));
   }

   public function send(Request $request){
      

      $this->validate($request,[
         'to' => 'required',
         'message' => 'required',
      ]);

      $sms = new sms;
      $sms->sms_to = $request->to;
      $sms->message = $request->message;
      $sms->businessID = Auth::user()->businessID;
      $sms->userID = Auth::user()->id;
      $sms->channelID = $request->channel;
      $sms->status = 7;
      $sms->sent_mode = 'single';
      $sms->save();   
      
      //twilio
      if($request->channel == 1){
         $twilio = business_telephony::where('businessID',Auth::user()->businessID)->where('telephonyID',1)->first();

         // Your Account SID and Auth Token from twilio.com/console
         $sid    = $twilio->tw_sid;
         $token  = $twilio->tw_token;
         $client = new Client( $sid, $token );

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
      if($request->channel == 2){
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

   public function retrieve_from($id){
      $from = business_telephony::where('telephonyID',$id)->where('businessID',Auth::user()->businessID)->get();
      return \Response::json($from);
   }
}
