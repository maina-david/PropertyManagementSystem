<?php

namespace App\Http\Controllers\app\wingu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\control\invoices;
use App\Models\wingu\control\invoice_settings; 
use App\Models\wingu\control\invoice_products;
use App\Models\wingu\control\invoice_payments;  
use App\Models\wingu\control\creditnote_settings;
use App\Models\wingu\control\creditnote;
use App\Model\limitless\plan;  
use App\Models\wingu\control\creditnote_products;
use App\Model\limitless\business;
use Session;
use Helper;
use Auth;

class paypalController extends Controller
{
   // amt=35.00
   // cc=USD
   // item_name=Starter
   // item_number=3
   // st=Pending  or Completed;
   // tx=1U957726F1273742P
   // cm=paypal

   public function callback(Request $request){
      if($request->st == 'Completed'){
         //get plan infonrmation
         $plan = plan::find($request->item_number);
         $code = Helper::generateRandomString(16);

         $planDays = 30;
         $invoiceDate = date('Y-m-d');
         $invoiceDue = date('Y-m-d', strtotime($invoiceDate. ' + '.$planDays.' days'));

         //invoice setting
         $invoiceSettings = invoice_settings::find(1);  

         $store = new invoices;     

         //store invoice
         $store					   = new invoices;
         $store->businessID	 	= $request->cm;
         $store->invoice_title	= 'Plan payment';
         $store->invoice_number  = $invoiceSettings->number + 1;
         $store->invoice_date	   = $invoiceDate;
         $store->invoice_due	   = $invoiceDue;
         $store->customer_note	= $invoiceSettings->default_customer_notes;
         $store->terms				= $invoiceSettings->default_terms_conditions;
         $store->statusID		   = 2;
         $store->invoice_code 	= $code;
         $store->main_amount     = $plan->usd;
         $store->total		      = $plan->usd;
         $store->balance		   = $plan->usd;
         $store->sub_total	      = $plan->usd;
         $store->created_by      = Auth::user()->id;
         $store->save();

         //products
         $product 					= new invoice_products;
         $product->invoiceID		= $store->id;
         $product->productID		= $request->item_number;
         $product->quantity		= 1;
         $product->taxrate			= 0;
         $product->total_amount  = $plan->price;
         $product->main_amount   = $plan->price;
         $product->sub_total  	= $plan->price;
         $product->selling_price = $plan->price;
         $product->category      = 'Product';
         $product->save();
         
         //invoice settings
         $invoiceNumber 	        = $invoiceSettings->number + 1;
         $invoiceSettings->number  = $invoiceNumber;
         $invoiceSettings->save();

         //update invoice payment & status
         $invoice =  invoices::where('id',$store->id)->where('invoice_code',$store->invoice_code)->first();

         //update payment
         $oldPaid = $invoice->paid;
         $newPaid = $oldPaid + $request->amt;
         $invoice->balance = $invoice->total - $newPaid;
         $invoice->paid = $newPaid;

         //update status
         if($newPaid == $invoice->total || $newPaid > $invoice->total){
            $invoice->statusID = 1;
         }elseif($newPaid < $invoice->total && $newPaid != 0 ){
            $invoice->statusID = 3;
         }

         $invoice->save();

         //record payment
         $pay = new invoice_payments;
         $pay->amount = $request->amt;
         $pay->balance = $invoice->total - $newPaid;
         $pay->reference_number = $request->tx;
         $pay->payment_method = 'Paypal';
         $pay->payment_date = date('Y-m-d H:i:s');
         $pay->invoiceID = $store->id;
         $pay->customerID = $request->cm;
         $pay->save();

         //update account
         // $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$request->accountID)->first();
         // $account->initial_balance = $account->initial_balance + $request->mc;
         // $account->save();

         //Client Credit
         if($invoice->paid > $invoice->total) {
            //update creditnote number
            $setting = creditnote_settings::find(2);

            $creditAmount = $invoice->paid - $invoice->total;

            $credit					      = new creditnote;
            $total                     = $creditAmount;
            $credit->customerID	 	   = $request->cm;
            $credit->creditnote_number = $setting->number+1;
            $credit->total		         = $total;
            $credit->balance		      = $total;
            $credit->title             = 'Payment credit for invoice #'.$invoice->invoice_number;
            $credit->sub_total		   = $total;
            $credit->creditnote_date   = date('Y-m-d');
            $credit->statusID		      = 21;
            $credit->paymentID         = $pay->id;
            $credit->businessID 	      = Auth::user()->businessID;
            $credit->save();

            //products
            $product 					= new creditnote_products;
            $product->creditnoteID  = $credit->id;
            $product->product_name	= 'Payment credit for invoice #'.$invoice->invoice_number;
            $product->quantity		= 1;
            $product->price    		= $total;
            $product->save();


            $setting->number = $setting->number + 1;
            $setting->save();

            //update payment
            $updateCredit = invoice_payments::find($pay->id);
            $updateCredit->credited = 'yes';
            $updateCredit->creditID = $credit->id;
            $updateCredit->save();
         }

         //update account
         $business = business::where('id',$request->cm)->first();
         $business->due_date  = $invoiceDue;
         $business->plan = $request->item_number;
         $business->ip = request()->ip();
         $business->save();

         Session::flash('success','Your account has been updated');

         return redirect()->route('wingu.dashboard');
      }else{
         Session::flash('success','Your transaction was not successfull');

         return redirect()->back();
      }

      //http://localhost/winguplus/cloud.winguplus.com/subscriptions/paypal/callback?amt=25.00&cc=USD&cm=1&item_name=Growth&item_number=1&st=Pending&tx=6P1805366J4855446
   }

   public function cancel(){
      return view('fontend.plan.cancel');
   }
}
