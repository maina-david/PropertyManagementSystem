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

class b2cController extends Controller
{
   /**
   * Lipa na M-PESA password
   * */
   public function MpesaPassword()
   {
      $lipa_time = Carbon::rawParse('now')->format('YmdHms');
      $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
      $BusinessShortCode = 174379;
      $timestamp =$lipa_time;
      $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
      return $lipa_na_mpesa_password;
   }

   /**
   * Payment request
   * */
   public function paymentrequest($businessID)
   {
      $daraja = business_payment_integrations::where('business_code',$businessID)->where('integrationID',3)->first();
      $data = json_decode($daraja,true);

      if($data['live_or_sandbox'] == 'sandbox'){
         $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
      }

      if($data['live_or_sandbox'] == 'live'){
         $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate'; 
      }

      
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken($businessID)));
      $curl_post_data = [
         'ShortCode' => $this->paybill,
         'CommandID' => 'CustomerPayBillOnline',
         'Amount' => $amount,
         'Msisdn' => $msisdn,
         'BillRefNumber' => $ref
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
         $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
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
