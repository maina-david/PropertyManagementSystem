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
class c2bController extends Controller
{
   /**
   * Lipa na M-PESA password
   * */
   public function lipaNaMpesaPassword($businessID)
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
   public function customerMpesaSTKPush($businessID)
   {
      if (!is_numeric($amount) || $amount < 1 || !is_numeric($phone)) {
         throw new Exception("Invalid amount and/or phone number. Amount should be 10 or more, phone number should be in the format 254xxxxxxxx");
         return false;
     }

      $daraja = business_payment_integrations::where('business_code',$businessID)->where('integrationID',3)->first();
      $data = json_decode($daraja,true);

      if($data['live_or_sandbox'] == 'sandbox'){
         $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
         
      }

      if($data['live_or_sandbox'] == 'live'){
         $url = 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query'; 
      }

      
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken($businessID)));
      $curl_post_data = [
         'BusinessShortCode' => $this->lipa_na_mpesa,
            'Password' => $passwd,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkoutRequestID
      ];
      $data_string = json_encode($curl_post_data);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
      $curl_response = curl_exec($curl);

      return $curl_response;
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

   /**
    * J-son Response to M-pesa API feedback - Success or Failure
    */
   public function createValidationResponse($result_code, $result_description){
      $result=json_encode(["ResultCode"=>$result_code, "ResultDesc"=>$result_description]);
      $response = new Response();
      $response->headers->set("Content-Type","application/json; charset=utf-8");
      $response->setContent($result);
      return $response;
   }

   /**
   *  M-pesa Validation Method
   * Safaricom will only call your validation if you have requested by writing an official letter to them
   */
   public function mpesaValidation(Request $request)
   {
      $result_code = "0";
      $result_description = "Accepted validation request.";
      return $this->createValidationResponse($result_code, $result_description);
   }
  
}
