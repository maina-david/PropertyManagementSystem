<?php

namespace App\Http\Controllers\app\crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use App\Models\finance\quotes\quotes;
use App\Models\finance\salesorder\salesorders;
class trackController extends Controller
{
   public function invoice($trackCode,$businessID,$invoiceID){
      $track = invoices::where('id',$invoiceID)
                     ->where('invoice_code',$trackCode)
                     ->where('businessID',$businessID)
                     ->first();
      $count = $track->view_count;

      if($track->sent_status == "" || $track->sent_status == "Sent" ){
         $track->sent_status = 'Sent & Read';
         $track->view_date = date("Y-m-d H:i:s");
         $track->view_count = $count + 1;
      }else{
         $track->view_count = $count + 1;
      }

      $track->save();
   }

   public function quote($trackCode,$businessID,$quoteID){
      $track = quotes::where('id',$quoteID)
                     ->where('quote_code',$trackCode)
                     ->where('businessID',$businessID)
                     ->first();
      $count = $track->view_count;

      if($track->sent_status == "" || $track->sent_status == "Sent" ){
         $track->sent_status = 'Sent & Read';
         $track->view_date = date("Y-m-d H:i:s");
         $track->view_count = $count + 1;
      }else{
         $track->view_count = $count + 1;
      }


      $track->save();
   }

   public function salesorder($trackCode,$businessID,$salesID){
      $track = salesorders::where('id',$salesID)
                     ->where('salesorder_code',$trackCode)
                     ->where('businessID',$businessID)
                     ->first();
                     
      $count = $track->view_count;

      if($track->sent_status == "" || $track->sent_status == "Sent" ){
         $track->sent_status = 'Sent & Read';
         $track->view_date = date("Y-m-d H:i:s");
         $track->view_count = $count + 1;
      }else{
         $track->view_count = $count + 1;
      }

      $track->save();
   }
}
