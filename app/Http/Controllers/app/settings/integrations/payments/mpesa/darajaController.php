<?php

namespace App\Http\Controllers\app\settings\integrations\payments\mpesa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Session;
use Wingu;
class darajaController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $edit = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',3)->first();
      
      return view('app.settings.integrations.payment.mpesa.daraja', compact('edit'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      $this->validate($request, [
         'merchant_consumer_key' => 'required',
         'merchant_consumer_secret' => 'required',
         'callback_url' => 'required',         
      ]);

      $edit = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',3)->first();
      if($edit->business_code == ""){
         $edit->business_code = Wingu::business()->businessID;
      }

      if($request->callback_url != $edit->callback_url){
         $edit->daraja_url_registered == NULL;
      }
      $edit->title = $request->title;
      $edit->merchant_consumer_key = $request->merchant_consumer_key;
      $edit->merchant_consumer_secret	 = $request->merchant_consumer_secret;
      $edit->callback_url = $request->callback_url;
      $edit->status = $request->status;
      $edit->live_or_sandbox = $request->live_or_sandbox;
      $edit->paybill_number = $request->paybill_number;
      $edit->till_number = $request->till_number;
      $edit->cancel_url = $request->cancel_url;
      $edit->save();

      Session::flash('success','Mpesa daraja information has been successfully updated');

      return redirect()->back();
   }

   /**
   * Register Validation and Confirmation method
   */
   public function registerUrls($businessID)
   {
      $daraja = business_payment_integrations::where('business_code',$businessID)->where('integrationID',3)->first();

      $validationURL = route('daraja.validation.url',$businessID);

      //http://127.0.0.1:8000/api/daraja/payment/callback/uRMf3K2Vb

      if($daraja->live_or_sandbox == 'sandbox'){
         $url = "https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl";
      }

      if($daraja->live_or_sandbox == 'live'){
         $url = "https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl";
      }

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '. $this->generateAccessToken($businessID)));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
         'ShortCode' => $daraja->paybill_number,
         'ResponseType' => 'Completed', 
         'ConfirmationURL' => $daraja->callback_url,
         'ValidationURL' => $validationURL
      )));

      $curl_response = curl_exec($curl);
      $data = json_decode($curl_response,true);
      
      //return $data;
      if(isset($data['ResponseDescription'])){
         if($data['ResponseDescription'] == 'success'){
            $daraja->daraja_url_registered = 'Yes';
            $daraja->save();
   
            Session::flash('success','URLs have been successfully registered with safaricom');
   
            return redirect()->back();
         }
      }

      if(isset($data['errorMessage'])){         
         Session::flash('warning','Their is an issue with the urls please contact winguplus support for more information, thank you');

         return redirect()->back();
      }
   }

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
