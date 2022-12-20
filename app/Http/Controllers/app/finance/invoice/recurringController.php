<?php

namespace App\Http\Controllers\app\finance\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\payments\payments;
use App\Models\finance\clients\clients;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoice_received;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\payments\payment_type;
use App\Models\finance\products\product_information;
use App\Models\wingu\status;
use App\Models\general\settings;
use App\Models\finance\tax;
use App\Models\finance\currency;
use App\Models\finance\products\product_price;
use DB;
use Input;
use Session;
use Finance;
use Limitless;
use Auth;
use PDF;
use Helper;


class recurringController extends Controller
{
	public function __construct(){
      $this->middleware('auth');
	}

   public function create(){
		//check if user is linked to a business and allow access
      $check = Limitless::user_business_link(Auth::user()->id,Auth::user()->businessID);

      if($check == 1 ){

			$clients = clients::where('businessID',Auth::user()->businessID)->where('status',0)->OrderBy('id','DESC')->get();
			$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
			$currencies = currency::OrderBy('id','DESC')->get();
			$paymenttypes = payment_type::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
			$status	= status::all();
			$products = product_information::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();


			return view('app.finance.invoices.recurring.create', compact('clients','status','currencies','taxs','paymenttypes','products'));

		}else{
			return view('errors.403');
		}
   }

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
  	public function store(Request $request){
		$this->validate($request, array(
			'client'    	  => 'required',
			'currency'	     => 'required',
			'currency'	     => 'required',
			'invoice_date'  => 'required',
			'invoice_due'	  => 'required',
			'cycles_option'	  => 'required',
			'frequency_count'	  => 'required',
			'frequency_duration'	  => 'required',
		));

		//store invoice
		$code = Helper::generateRandomString(16);
		$store					   = new invoices;
		$store->userID		   = Auth::user()->id;
		$store->client_id	 	   = $request->client;
		$store->currencyID	   = $request->currency;
		$store->lpo_number      = $request->lpo_number;
		$store->invoice_number  = $request->invoice_number;
		$store->discount      	= $request->discount;
		$store->discount_type 	= $request->discount_type;
		$store->total		      = $store->total(
										  $request->qty,
										  $request->price,
										  $request->discount,
										  $request->discount_type,
										  $request->tax
									  );
		$store->sub_total		   = $store->amount($request->qty, $request->price);
		$store->tax				   = $request->tax;
		$store->invoice_date	   = $request->invoice_date;
		$store->invoice_due	   = $request->invoice_due;
		$store->customer_note	= $request->customer_note;
		$store->terms				= $request->terms;
		$store->invoice_code 	= $code;
		$store->invoice_type		= 'Recurring';
		$store->transaction_type = 'Credit';
		$store->businessID 		= Auth::user()->businessID;

		$store->cycles_option	 = $request->cycles_option;
		$store->cycles_count		 = $request->cycles_count;
		$store->frequency_count	 = $request->frequency_count;
		$store->frequency_duration	= $request->frequency_duration;
		$store->send_remainder	 = $request->send_remainder;
		$store->save();

		//products
		$products				= Input::get('productID');

		foreach ($products as $k => $v){
			$product 					= new invoice_products;
			$product->invoiceID		= $store->id;
			$product->productID		= Input::get('productID')[$k];
			$product->quantity		= Input::get('qty')[$k];
			$product->total_amount   = Input::get('price')[$k] * Input::get('qty')[$k];
			$product->selling_price  = Input::get('price')[$k];
			$product->category      = 'Product'; 
			$product->save();
		}

	   if (Input::get('paymentAmount') && Input::get('paymentDate') && Input::get('paymentMethod'))
	   {
			$payment 					 = new invoice_payments;
			$payment->userID		    = Auth::user()->id;
			$payment->invoiceID		 = $store->id;
			$payment->customerID	    = $request->client;
			$payment->payment_method = Input::get('paymentMethod');
			$payment->payment_date	 = Input::get('paymentDate');
			$payment->amount	       = Input::get('paymentAmount');
			$payment->businessID	    = Auth::user()->businessID;
			$payment->payment_category = 'Received';
			$payment->save();

			//paid
			$paid = invoices::find($store->id);
			$paid->paid = Input::get('paymentAmount');
			if($paid->paid > $paid->total || $paid->paid == $paid->total){
				$paid->statusID = 1;
			}else{
				$paid->statusID = 3;
			}
			$paid->save();
		}else{
			$payment = invoices::find($store->id);
			$payment->statusID = 2;
			$payment->save();
		}

		//update status
		$status = invoices::find($store->id);
		$status->invoiceStatus($store->id);

		//invoice setting
		$invoiceSettings = invoice_settings::where('businessID',Auth::user()->businessID)->first();
		$invoiceNumber 	= $invoiceSettings->number + 1;
		$invoiceSettings->number	= $invoiceNumber;
		$invoiceSettings->save();

		//recored activity
		$activities = 'Invoices #'.Finance::invoice_settings()->prefix.$store->invoice_number.' has been created by '.Auth::user()->name;
		$section = 'Invoice';
		$type = 'Create';
		$adminID = Auth::user()->id;
		$activityID = $store->id;
		$businessID = Auth::user()->businessID;

		Limitless::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Invoice has been successfully created');

		return redirect()->route('finance.invoice.index');

   }

	public function edit($id){

		$invoice = invoices::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$clients = clients::where('businessID',Auth::user()->businessID)->where('status',0)->OrderBy('id','DESC')->get();
		$client = clients::where('id',$invoice->client_id)->where('businessID',Auth::user()->businessID)->first();

		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$products = product_information::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$currencies = currency::OrderBy('id','DESC')->get();
		$currency = currency::find($invoice->currencyID);
      $invoiceProducts = invoice_products::where('category','Product')->where('invoiceID',$id)->get();
		$count = 1;

		if($invoice->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $invoice->sub_total * ($invoice->tax / 100);
		}

		return view('app.finance.invoices.recurring.edit', compact('client','clients','currency','taxed','count','invoice','products','currencies','taxs','invoiceProducts'));
	}

	public function update(request $request,$id){
		$this->validate($request, array(
			'client'    	  => 'required',
			'currency'	     => 'required',
			'invoice_date'  => 'required',
			'invoice_due'	  => 'required',
		));

		$update					 	 = invoices::find($id);
		$update->userID		    = Auth::user()->id;
		$update->client_id	 	 = $request->client;
		$update->currencyID	    = $request->currency;
		$update->lpo_number      = $request->lpo_number;
		$update->discount      	 = $request->discount;
		$update->discount_type 	 = $request->discount_type;
		$update->total		       = $update->total(
											$request->qty,
											$request->price,
											$request->discount,
											$request->discount_type,
											$request->tax
										);
		$update->sub_total		= $update->amount($request->qty, $request->price);
		$update->tax				= $request->tax;
		$update->invoice_date	= $request->invoice_date;
		$update->invoice_due	   = $request->invoice_due;
		$update->customer_note	= $request->customer_note;
		$update->terms				= $request->terms;
		$update->businessID 		= Auth::user()->businessID;

		if($update->invoice_code == "") {
			$code = Helper::generateRandomString(16);
			$update->invoice_code = $code;
		}

		$update->cycles_option	 = $request->cycles_option;
		$update->cycles_count	 = $request->cycles_count;
		$update->frequency_count  = $request->frequency_count;
		$update->frequency_duration = $request->frequency_duration;
		$update->send_remainder	 = $request->send_remainder;
		$update->save();


		//delete product
		$delete = invoice_products::where('invoiceID', $id);
		$delete->delete();

		//new products
		$products				= Input::get('productID');
		foreach ($products as $k => $v)
		{
			$product 						= new invoice_products;
			$product->invoiceID			= $update->id;
			$product->productID			= Input::get('productID')[$k];
			$product->quantity			= Input::get('qty')[$k];
			$product->total_amount   = Input::get('price')[$k] * Input::get('qty')[$k];
			$product->selling_price  = Input::get('price')[$k];
			$product->category       = 'Product';
			$product->save();
		}

      //recored activity
      $activities = 'Invoices #'.Finance::invoice_settings()->prefix.$update->invoice_number.' has been updated by '.Auth::user()->name;
      $section = 'Invoice';
      $type = 'update';
      $adminID = Auth::user()->id;
      $activityID = $id;
      $businessID = Auth::user()->businessID;

      Limitless::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Invoice has been successfully updated');

    	return redirect()->back();
	}
}
