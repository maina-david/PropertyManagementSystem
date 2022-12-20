<?php

namespace App\Http\Controllers\app\settings\integrations\payments\mpesa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Session;
use Wingu;
class callbackController extends Controller
{
 

    /**
   * M-pesa Transaction confirmation method, we save the transaction in our databases
   */
   public function payment_confirmation(Request $request,$businessID)
   {
      $data = file_get_contents('php://input');
      file_put_contents('filename.txt', $data);
      
      // $array_data = json_decode($json_data,true);

      // $content=json_decode($request->getContent());
      // $mpesa_transaction = new MpesaTransaction();
      // $mpesa_transaction->TransactionType = $content->TransactionType;
      // $mpesa_transaction->TransID = $content->TransID;
      // $mpesa_transaction->TransTime = $content->TransTime;
      // $mpesa_transaction->TransAmount = $content->TransAmount;
      // $mpesa_transaction->BusinessShortCode = $content->BusinessShortCode;
      // $mpesa_transaction->BillRefNumber = $content->BillRefNumber;
      // $mpesa_transaction->InvoiceNumber = $content->InvoiceNumber;
      // $mpesa_transaction->OrgAccountBalance = $content->OrgAccountBalance;
      // $mpesa_transaction->ThirdPartyTransID = $content->ThirdPartyTransID;
      // $mpesa_transaction->MSISDN = $content->MSISDN;
      // $mpesa_transaction->FirstName = $content->FirstName;
      // $mpesa_transaction->MiddleName = $content->MiddleName;
      // $mpesa_transaction->LastName = $content->LastName;
      // $mpesa_transaction->save();
      // // Responding to the confirmation request
      // $response = new Response();
      // $response->headers->set("Content-Type","text/xml; charset=utf-8");
      // $response->setContent(json_encode(["C2BPaymentConfirmationResult"=>"Success"]));
      // return $response;
   }

   public function payment_cancel($businessID){
      
   }


   public function url_validation($businessID){
      return 'working';
   }

  

   
}
