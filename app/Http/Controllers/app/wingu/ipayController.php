<?php

namespace App\Http\Controllers\app\wingu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\control\invoice_settings; 
use App\Models\wingu\control\invoice_products;
use App\Models\wingu\control\invoice_payments;  
use App\Models\wingu\control\creditnote_settings;
use App\Models\wingu\control\creditnote_products; 
use App\Models\wingu\control\creditnote;
use App\Models\wingu\control\invoices;
use App\Models\wingu\business;
use App\Models\wingu\business_modules;
use Session;
use Helper;
use Auth;
use Wingu;

class ipayController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
 
   public function callback(Request $request){
		//create invoice 
		
		//get plan infonrmation
		$application = business_modules::join('modules','modules.id','=','business_modules.moduleID')
													->where('business_modules.id',$request->id)
													->where('businessID',$request->p2)
													->select('*','modules.id as module_id')
													->first();

		if($request->p3 == 'KES'){
			$amount = $request->mc * 100;
		}else{
			$amount = $request->mc;
		}

      $code = Helper::generateRandomString(16);

      $planDays = 31;
      $invoiceDate = date('Y-m-d');
      $invoiceDue = date('Y-m-d', strtotime($invoiceDate. ' + '.$planDays.' days'));

      //invoice setting
		$invoiceSettings = invoice_settings::find(1);  

      $store = new invoices;     

		//store invoice
		$store					   = new invoices;
		$store->businessID	 	= Wingu::business()->businessID;
		$store->invoice_title	= $application->name .'Application';
		$store->invoice_number  = $invoiceSettings->number + 1;
		$store->invoice_date	   = $invoiceDate;
		$store->module_id	      = $application->module_id;
		$store->invoice_due	   = $invoiceDue;
		$store->customer_note	= $invoiceSettings->default_customer_notes;
		$store->terms				= $invoiceSettings->default_terms_conditions;
		$store->statusID		   = 2;
      $store->invoice_code 	= $code;
		$store->main_amount     = $application->price;
		$store->total		      = $application->price;
		$store->balance		   = $application->price;
		$store->sub_total	      = $application->price;
		$store->created_by      = Auth::user()->id;
		$store->save();
		
		//invoice settings
		$invoiceNumber 				= $invoiceSettings->number + 1;
		$invoiceSettings->number	= $invoiceNumber;
		$invoiceSettings->save();

      //update invoice payment & status
		$invoice =  invoices::where('id',$store->id)->where('invoice_code',$store->invoice_code)->first();

		//update payment
		$oldPaid = $invoice->paid;
		$newPaid = $oldPaid + $amount;
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
		$pay->amount = $amount;
		$pay->balance = $invoice->total - $newPaid;
		$pay->reference_number = $request->txncd;
		$pay->payment_method = $request->channel;
		$pay->payment_date = date('Y-m-d H:i:s');
		$pay->invoiceID = $store->id;
		$pay->customerID = $request->p2;
		$pay->save();

	   //Client Credit
		if($invoice->paid > $invoice->total) {
			//update creditnote number
			$setting = creditnote_settings::find(1);

			$creditAmount = $invoice->paid - $invoice->total;

			$credit					      = new creditnote;
			$total                     = $creditAmount;
			$credit->customerID	 	   = $request->p2;
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

      //update accout
		if($invoice->statusID == 1 || $invoice->statusID == 3){
			$applicationUpdate = business_modules::where('id',$request->id)->where('businessID',$request->p2)->first();
			$applicationUpdate->payment_status  = 1;
			$applicationUpdate->start_date = $invoiceDate ;
			$applicationUpdate->end_date = $invoiceDue; 
			$applicationUpdate->module_status = 15;
			$applicationUpdate->save();
		}

      Session::flash('success','Payment successful');

      return redirect()->route('wingu.dashboard');
   }
}
