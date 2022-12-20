<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_payment_integrations;
use App\Models\hr\payroll_people;
use Carbon\Carbon;
use Helper;
use Auth;
use Session;
use Wingu;

class mpesaPaymentController extends Controller
{

   /**
   * Lipa na M-PESA password
   * */
   public function password($businessID)
   {
      $daraja = business_payment_integrations::where('business_code',$businessID)->where('integrationID',3)->first();
      $data = json_decode($daraja,true);
      $lipa_time = Carbon::rawParse('now')->format('YmdHms');
      $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
      $BusinessShortCode = $data['paybill_number'];
      $timestamp =$lipa_time;
      $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
      return $lipa_na_mpesa_password;
   }


   /**
   * Payment request
   * */
   public function process_payment(Request $request)
   {
      $businessID = $request->businessID;
      $daraja = business_payment_integrations::where('business_code',$businessID)->where('integrationID',3)->first();
     

      if($daraja->live_or_sandbox == 'sandbox'){
         $url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
      }

      if($daraja->live_or_sandbox == 'live'){
         $url = 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest'; 
      }

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken($businessID)));
      $curl_post_data = [
         'InitiatorName' => $daraja->title,
         'SecurityCredential' => $this->password($businessID),
         'CommandID' => 'SalaryPayment',
         'Amount' => $request->amount, //amount sent
         'PartyA' => $daraja->paybill_number, //paybill number
         'PartyB' => $request->phone_number, //receiver
         'Remarks' => 'winguplus payroll payments',
         'QueueTimeOutURL' => $daraja->callback_url,
         'ResultURL' => $daraja->callback_url,
         'Occasion' => $daraja->payrollID, //Optional user system transactionID
      ];
      $data_string = json_encode($curl_post_data);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
      $curl_response = curl_exec($curl);
      $data = json_decode($curl_response,true);

      if(isset($data['ResponseCode'])){
         if($data['ResponseCode'] == 0){
            // "ConversationID": "AG_20210310_000079f7bee02e49a0e2",
            // "OriginatorConversationID": "2424-20917958-1",
            $update = payroll_people::where('id',$request->payrollID)->where('businessID',Auth::user()->businessID)->where('payroll_id',$request->payroll_code)->first();
            $update->transactionID = $data['ConversationID'];
            $update->status = 7;
            $update->updated_by = Auth::user()->id;
            $update->save();

            Session::flash('success','Payment is being processed');

            return redirect()->back();
         }else{
            Session::flash('warning','Their is an issue with the urls please contact winguplus support for more information, thank you');

            return redirect()->back();
         }
      }
      
      if(isset($data['errorMessage'])){         
         Session::flash('warning','Their is an issue with the urls please contact winguplus support for more information, thank you');
         return redirect()->back();
      }else{
         Session::flash('warning','Their is an issue with the urls please contact winguplus support for more information, thank you');

         return redirect()->back();
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