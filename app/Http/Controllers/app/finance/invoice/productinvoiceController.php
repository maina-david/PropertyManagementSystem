<?php

namespace App\Http\Controllers\app\finance\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoices;
use App\Models\hr\employees;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\payments\payment_type;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_price;
use App\Models\finance\income\category;
use App\Models\wingu\status;
use App\Models\finance\tax; 
use App\Models\finance\currency;
use App\Mail\systemMail;
use DB;
use Session;
use Finance;
use Wingu;
use Auth;
use Helper;
use Mail;
class productinvoiceController extends Controller
{
	public function __construct(){
      $this->middleware('auth');
	}

   public function create(){
		//check if account has settings
		$check = invoice_settings::where('businessID',Auth::user()->businessID)->count();
		if($check != 1){
			Finance::invoice_setting_setup();
		} 

		$clients = customers::where('businessID',Auth::user()->businessID)
									->where('category', '=', 'Subscriber')
									->whereNull('category')
									->OrderBy('id','DESC')
									->get();

		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$currencies = currency::OrderBy('id','DESC')->get();
		$paymenttypes = payment_type::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
		$status	= status::all();
		$Itemproducts = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
											->where('product_information.type','product')
											->where('product_information.businessID',Auth::user()->businessID)
											->where('default_inventory','Yes')
											->OrderBy('product_information.id','DESC')
											->select('*','product_information.id as productID')
											->get();
		$Itemservice = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
										->where('product_information.type','service')
										->where('default_inventory','Yes')
										->where('product_information.businessID',Auth::user()->businessID)
										->OrderBy('product_information.id','DESC')
										->select('*','product_information.id as productID')
										->get();

		$salespersons = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose salse person','');

		return view('app.finance.invoices.product.create', compact('clients','status','currencies','taxs','paymenttypes','salespersons','Itemproducts','Itemservice'));		
   }

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
  	public function store(Request $request){
		$this->validate($request, array(
			'customer'    	  => 'required',
			'invoice_date'  => 'required',
			'invoice_due'	  => 'required',
		));

		$invoiceSettings = invoice_settings::where('businessID',Auth::user()->businessID)->first();

		$code = Helper::generateRandomString(16);

		//store invoice
		$store					   = new invoices;
		$store->created_by		= Auth::user()->id;
		$store->customerID	 	= $request->customer;
		$store->invoice_title	= $request->invoice_title;
		$store->lpo_number      = $request->lpo_number;
		$store->income_category = $request->income_category;
		$store->invoice_number  = $request->invoice_number;
		$store->invoice_prefix  = $invoiceSettings->prefix;
		$store->invoice_date	   = $request->invoice_date;
		$store->invoice_due	   = $request->invoice_due;
		$store->customer_note	= $request->customer_note;
		$store->terms				= $request->terms;
		$store->salesperson   	= $request->salesperson;
		$store->taxconfig			= $request->taxconfig;
		$store->invoice_type		= 'Product';
		$store->statusID		   = 2;
		$store->invoice_code 	= $code;
		$store->branch_id 		= Auth::user()->branch_id;
		$store->businessID 		= Auth::user()->businessID;
		$store->save();

		//products
		$products				= $request->productID;

		foreach ($products as $k => $v){
			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;

			$totalAmount = $amount + $taxvalue;

			$product 					= new invoice_products;
			$product->invoiceID		= $store->id;
			$product->productID		= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue;
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->businessID  	= Auth::user()->businessID;
			$product->selling_price = $request->price[$k];
			$product->category      = 'Product';
			$product->save();

			//product information
			$productInfo = product_information::where('id',$request->productID[$k])->where('businessID',Auth::user()->businessID)->first();

			//reduce quantity
			if($productInfo->track_inventory == 'Yes'){
				$inventory = product_inventory::where('businessID',Auth::user()->businessID)->where('default_inventory','Yes')->where('productID',$request->productID[$k])->first();
				if($inventory->current_stock > $request->qty[$k]){
					$inventory->current_stock = $inventory->current_stock - $request->qty[$k];

					//send inventory notification if below reorder point
					if($inventory->current_stock < $inventory->reorder_point){
						if($inventory->notification < 2){
							//send email
							$subject = 'winguPlus Stock Level Notification';
							$to = Wingu::business()->primary_email;
							$content = '<p>The following product needs to be restocked<br><b>Product:</b> '.$productInfo->product_name.'<br><b>Current Stock</b> '.$inventory->current_stock.'<br> <b>Reorder Quantity</b> '.$inventory->reorder_qty.'</p>';
							Mail::to($to)->send(new systemMail($content,$subject));

							$inventroyNotification = product_inventory::where('businessID',Auth::user()->businessID)
																					->where('default_inventory','Yes')
																					->where('productID',$request->productID[$k])
																					->first();
							$inventroyNotification->notification = $inventroyNotification->notification + 1;
							$inventroyNotification->save();	
						}										
					}
				}else {
					$inventory->current_stock = 0;
				}
				$inventory->save();	
			}
		}

		//get invoice products
		$invoiceProducts = invoice_products::where('invoiceID',$store->id)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update invoice
		$invoice = invoices::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
		$invoice->main_amount =  $invoiceProducts->mainAmount;
		$invoice->discount   = $invoiceProducts->discount;
		$invoice->total		= $invoiceProducts->total;
		$invoice->balance		= $invoiceProducts->total;
		$invoice->sub_total	= $invoiceProducts->sub_total;
		$invoice->taxvalue	= $invoiceProducts->taxvalue;
		$invoice->save();

		//invoice setting
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

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Invoice has been successfully created');

		return redirect()->route('finance.invoice.index');

   }

	public function edit($id){

		$invoice = invoices::join('business','business.id','=','invoices.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->join('status','status.id','=','invoices.statusID')
					->join('invoice_settings','invoice_settings.businessID','=','invoices.businessID')
					->join('customers','customers.id','=','invoices.customerID')
					->where('invoices.id',$id)
					->where('invoices.businessID',Auth::user()->businessID)
					->select('*','invoices.id as invoiceID','business.name as businessName')
					->first();

		$clients = customers::where('businessID',Auth::user()->businessID)
                            ->where('category', '=', 'Subscriber')
                            ->orWhereNull('category')
                            ->OrderBy('id','DESC')
                            ->get();
		$client = customers::where('id',$invoice->customerID)->where('businessID',Auth::user()->businessID)->first();

		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();

		$Itemproducts = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
												->where('product_information.type','product')
												->where('default_inventory','Yes')
												->where('product_information.businessID',Auth::user()->businessID)
												->OrderBy('product_information.id','DESC')
												->select('*','product_information.id as productID')
												->get();

		$Itemservice = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
												->where('product_information.type','service')
												->where('default_inventory','Yes')
												->where('product_information.businessID',Auth::user()->businessID)
												->OrderBy('product_information.id','DESC')
												->select('*','product_information.id as productID')
												->get();

		$salespersons = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose salse person','');
		$currencies = currency::OrderBy('id','DESC')->get();
		$currency = currency::find($invoice->currencyID);
        $invoiceProducts = invoice_products::where('invoiceID',$id)->get();
		$count = 1;

		if($invoice->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $invoice->sub_total * ($invoice->tax / 100);
		}

		return view('app.finance.invoices.product.edit', compact('client','clients','currency','taxed','count','invoice','Itemproducts','currencies','taxs','invoiceProducts','salespersons','Itemservice'));
	}

	public function update(request $request,$id){
		$this->validate($request, array(
			'customer'    	  => 'required',
			'invoice_date'  => 'required',
			'invoice_due'	  => 'required',
		));

		//get the invoice products the update their quantity
		$oldProducts = invoice_products::where('businessID',Auth::user()->businessID)->where('invoiceID',$id)->get();
		foreach($oldProducts as $oldPro){

			//get the invoice product
			$oldInvoiceProduct = invoice_products::where('id',$oldPro->id)->where('businessID',Auth::user()->businessID)->where('invoiceID',$id)->first();

			//get product specification
			$productSpecs = product_information::where('id',$oldPro->productID)->where('businessID',Auth::user()->businessID)->first();

			if($productSpecs->type == 'product' && $productSpecs->track_inventory == 'Yes'){
				//return the quantity
				$returnInventory = product_inventory::where('businessID',Auth::user()->businessID)->where('default_inventory','Yes')->where('productID',$productSpecs->id)->first();
				$returnInventory->current_stock = $returnInventory->current_stock + $oldInvoiceProduct->quantity;
				$returnInventory->save();
			}

			$oldInvoiceProduct->delete();
		}

		//delete old product
		// $delete = invoice_products::where('invoiceID', $id);
		// $delete->delete();
		$invoiceSettings = invoice_settings::where('businessID',Auth::user()->businessID)->first();
		$update	= invoices::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		//add new products
		$products				= $request->productID;
		foreach ($products as $k => $v){

			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;

			$totalAmount = $amount + $taxvalue;

			$product 					= new invoice_products;
			$product->invoiceID		= $update->id;
			$product->productID		= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue;
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->businessID  	= Auth::user()->businessID;
			$product->selling_price = $request->price[$k];
			$product->category      = 'Product';
			$product->save();

			//product information
			$productInfo = product_information::where('id',$request->productID[$k])->where('businessID',Auth::user()->businessID)->first();

			//reduce quantity
			if($productInfo->type == 'product' && $productInfo->track_inventory == 'Yes'){
				$inventory = product_inventory::where('businessID',Auth::user()->businessID)->where('default_inventory','Yes')->where('productID',$request->productID[$k])->first();
				if($inventory->current_stock > $request->qty[$k]){
					$inventory->current_stock = $inventory->current_stock - $request->qty[$k];
				}else {
					$inventory->current_stock = 0;
				}
				$inventory->save();
			}
		}


		//get invoice products
		$invoiceProducts = invoice_products::where('invoiceID',$id)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update invoice
		if($update->invoice_code == "") {
			$code = Helper::generateRandomString(16);
			$update->invoice_code = $code;
		}
		$update->main_amount   =  $invoiceProducts->mainAmount;
		$update->discount      = $invoiceProducts->discount;
		if($invoiceSettings->prefix == ""){
			$update->invoice_prefix  = $invoiceSettings->prefix;
		}
		$update->invoice_number  = $request->invoice_number;
		$update->total		     = $invoiceProducts->total;
		$update->balance		  = $invoiceProducts->total - $update->paid;
		$update->sub_total	  = $invoiceProducts->sub_total;
		$update->taxvalue	     = $invoiceProducts->taxvalue;
		$update->updated_by	  = Auth::user()->id;
		$update->invoice_title = $request->invoice_title;
		$update->customerID	  = $request->customer;
		$update->salesperson   = $request->salesperson;
		$update->income_category = $request->income_category;
		$update->lpo_number    = $request->lpo_number;
		$update->invoice_date  = $request->invoice_date;
		$update->invoice_due	  = $request->invoice_due;
		$update->customer_note = $request->customer_note;
		$update->terms			  = $request->terms;
		$update->taxconfig	  = $request->taxconfig;
		$update->businessID 	  = Auth::user()->businessID;
		$update->save();

      //recored activity
      $activities = 'Invoices #'.Finance::invoice_settings()->prefix.$update->invoice_number.' has been updated by '.Auth::user()->name;
      $section = 'Invoice';
      $type = 'update';
      $adminID = Auth::user()->id;
      $activityID = $id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Invoice has been successfully updated');

    	return redirect()->back();
	}
}
