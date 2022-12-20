<?php

namespace App\Http\Controllers\app\settings\integrations\payments\mpesa\daraja;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_payment_integrations;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
use Session;
use Wingu;
use Helper;
class stkpushController extends Controller
{
   /**
   * password
   * */
   public function password($businessID)
   {
      $daraja = business_payment_integrations::where('business_code',$businessID)->where('integrationID',3)->first();
      $data = json_decode($daraja,true);
      $lipa_time = Carbon::rawParse('now')->format('YmdHms');
      $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
      $BusinessShortCode = $data['till_number'];
      $timestamp =$lipa_time;
      $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
      return $lipa_na_mpesa_password;
   }


   /**
   * Lipa na M-PESA STK Push method
   * */
   public function stkpush(Request $request,$businessID)
   {
      $amount = $request->amount;
      $phone = $request->phone_number;
      $ref = $request->invoice_code;
      $desc = "Invoice Payment";

      if(!is_numeric($amount) || $amount < 1 || !is_numeric($phone)) {

         Session::flash('warning','Invalid amount and/or phone number. Amount should be 10 or more, phone number should be in the format 254xxxxxxxx');

         return redirect()->back();
      }

      $daraja = business_payment_integrations::where('business_code',$businessID)->where('integrationID',3)->first();
      $data = json_decode($daraja,true);

      if($data['live_or_sandbox'] == 'sandbox'){
         $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
      }

      if($data['live_or_sandbox'] == 'live'){
         $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest'; 
      }

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken($businessID)));
      $curl_post_data = [
         'BusinessShortCode' => $data['till_number'],
         'Password' => $this->password($businessID),
         'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
         'TransactionType' => 'CustomerPayBillOnline',
         'Amount' => $amount,
         'PartyA' => $phone, // replace this with your phone number
         'PartyB' => $data['till_number'],
         'PhoneNumber' => $phone, // replace this with your phone number
         'CallBackURL' => $data['callback_url'],
         'AccountReference' => $ref,
         'TransactionDesc' => $desc
      ];

      return $curl_post_data;
      
      $data_string = json_encode($curl_post_data);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
      $curl_response = curl_exec($curl);
      $data = json_decode($curl_response,true);

      if(isset($data['errorMessage'])){         
         Session::flash('error',$data['errorMessage']);

         return redirect()->back();
      }

      if(isset($data['ResponseCode'])){      
         if($data['ResponseCode'] == 0){
            Session::flash('success','Amount has been sent to '.$phone);
            return redirect()->back();
         } 
      }
   }

   /**
   * Show the form for editing the specified resource.
   **/
   public function generateAccessToken($businessID)
   {  
      $daraja = business_payment_integrations::where('business_code',$businessID)->where('integrationID',3)->first();
      $data = json_decode($daraja,true);

      $consumer_key= $data['merchant_consumer_key'];
      $consumer_secret= $data['merchant_consumer_secret'];

      $credentials = base64_encode($consumer_key.":".$consumer_secret);
      
      if($data['live_or_sandbox'] == 'sandbox'){
         $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
      }

      if($data['live_or_sandbox'] == 'live'){
         $url = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
      }
      

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
      curl_setopt($curl, CURLOPT_HEADER,false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $curl_response = curl_exec($curl);
      $access_token=json_decode($curl_response);
      
      return $access_token->access_token;
   }
}
