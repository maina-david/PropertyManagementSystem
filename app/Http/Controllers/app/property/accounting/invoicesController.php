<?php
namespace App\Http\Controllers\app\property\accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\property\invoice\invoices;
use App\Models\wingu\business;
use App\Models\property\invoice\invoice_products;
use App\Models\property\payments\payments;
use App\Models\finance\payments\payment_type; 
use App\Models\property\invoice\invoice_settings;
use App\Models\property\creditnote\creditnote_settings;
use App\Models\property\creditnote\creditnote;
use App\Models\property\creditnote\creditnote_products;
use App\Models\property\lease;
use App\Models\property\tenants\tenants;
use App\Models\finance\accounts; 
use App\Models\finance\income\category;
use App\Models\finance\tax;
use PDF;
use Auth;
use Session;
use DB;
use Helper;
use Wingu;
use Property as Prop;

class invoicesController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response 
	 */
	public function index($propertyID)
	{
      $property = property::join('business','business.id','=','property.businessID')
									->join('currency','currency.id','=','business.base_currency')
									->where('property.businessID',Auth::user()->businessID)
									->where('property.id',$propertyID)
									->select('code','property.id as propertyID','property_type','title')
									->first();
		   
      return view('app.property.accounting.invoices.index', compact('property','propertyID'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($propertyID)
	{
		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      //check if property has settings 
      $check = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->count();
      if($check != 1){
         Prop::make_invoice_settings($propertyID);
		}
		
		$tenants = property::join('property_tenants','property_tenants.id','=','property.tenantID')
                  ->join('property_lease','property_lease.id','=','property.leaseID')
                  ->where('property.businessID',Auth::user()->businessID)
                  ->where('property.parentID',$propertyID)
						->where('property.tenantID','!=', '')
						->where('property_lease.statusID',15)
                  ->orderby('property.id','desc')
                  ->select('property_tenants.id as tenantID','property_tenants.tenant_name as tenant_name')
						->pluck('tenant_name','tenantID')
						->prepend('Choose tenant','');

		$taxes = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$incomes = category::where('businessID',0)->where('section','property')->get();
		$settings = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();
      return view('app.property.accounting.invoices.create', compact('property','tenants','taxes','incomes','propertyID','settings'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request,$propertyID)
	{	
		$this->validate($request, array(
			'tenant'    	  => 'required',
			'category'    	  => 'required',
			'tax_rate'    	  => 'required',
			'invoice_date'  => 'required',
			'invoice_due'	  => 'required',
		));

		$leaseInfo = lease::where('property_lease.propertyID',$propertyID)
								->where('property_lease.businessID',Auth::user()->businessID)  
								->where('id',$request->leaseID)
								->first();

		$code = Helper::generateRandomString(16);

		//store invoice
		$store					   = new invoices;
		$store->created_by	   = Auth::user()->id;
		$store->tenantID	   	= $request->tenant;
		$store->invoice_title	= $request->invoice_title;
		$store->income_category = $request->category; 
		$store->leaseID         = $leaseInfo->id;
		$store->unitID          = $leaseInfo->unitID;
		$store->invoice_number  = $request->invoice_number;
		$store->invoice_prefix  = $request->invoice_prefix;
		$store->invoice_date	   = $request->invoice_date;
		$store->invoice_due	   = $request->invoice_due;
		$store->customer_note	= $request->customer_note;
		$store->terms			   = $request->terms;
		$store->propertyID      = $propertyID;
		$store->invoice_type		= 'Rent';
		$store->statusID		   = 2;
		$store->invoice_code 	= $code;
		$store->businessID 		= Auth::user()->businessID;
		$store->save();

		//rent billing
		if($request->category == 35){			
			if($leaseInfo->rent_amount != 0 || $leaseInfo->rent_amount != ""){
				$mainAmount = $leaseInfo->rent_amount;
				if($request->tax_rate != "" || $request->tax_rate > 0 ){
					$compound =  $request->tax_rate/100;
					$taxvalue = $mainAmount * $compound;
					$totalAmount = $mainAmount + $taxvalue;
				}else{
					$taxvalue = 0;
					$totalAmount = $mainAmount + $taxvalue;
				}

				$rent 					= new invoice_products;
				$rent->invoiceID		= $store->id;
				$rent->propertyID		= $propertyID;
				$rent->item_name		= 'Rent';
				$rent->quantity		= 1;
				$rent->taxrate			= $request->tax_rate;
				$rent->taxvalue		= $taxvalue; 
				$rent->total_amount  = $totalAmount;
				$rent->main_amount   = $mainAmount;
				$rent->sub_total  	= $mainAmount;
				$rent->businessID  	= Auth::user()->businessID;
				$rent->price         = $mainAmount;
				$rent->category      = 'Rent';
				$rent->save();
			}
		}

		//parking billing
		if($request->category == 39){			
			if($leaseInfo->parking_price != 0 || $leaseInfo->parking_price != ""){
				if($leaseInfo->parking_price != "" && $leaseInfo->parking_spaces != ""){
					//store parking
					$mainAmount = $leaseInfo->parking_price * $leaseInfo->parking_spaces;

					if($request->tax_rate != "" || $request->tax_rate > 0 ){
						$compound =  $request->tax_rate/100;
						$taxvalue = $mainAmount * $compound;
						$totalAmount = $mainAmount + $taxvalue;
					}else{
						$taxvalue = 0;
						$totalAmount = $mainAmount + $taxvalue;
					}

					$parking 				   = new invoice_products;
					$parking->invoiceID	   = $store->id;
					$parking->propertyID		= $propertyID;
					$parking->item_name		= 'Parking';
					$parking->quantity		= $leaseInfo->parking_spaces;
					$parking->taxrate			= $request->tax_rate;
					$parking->taxvalue		= $taxvalue; 
					$parking->total_amount  = $totalAmount;
					$parking->main_amount   = $mainAmount;
					$parking->sub_total  	= $mainAmount;
					$parking->businessID  	= Auth::user()->businessID;
					$parking->price         = $leaseInfo->parking_price;
					$parking->category      = 'Parking';
					$parking->save();
				}
			}
		}

		//service charge billing
		if($request->category == 37){			
			if($leaseInfo->service_charge != "" | $leaseInfo->service_charge != 0){

				$mainAmount = $leaseInfo->service_charge;
				if($request->tax_rate != "" || $request->tax_rate > 0 ){
					$compound =  $request->tax_rate/100;
					$taxvalue = $mainAmount * $compound;
					$totalAmount = $mainAmount + $taxvalue;
				}else{
					$taxvalue = 0;
					$totalAmount = $mainAmount + $taxvalue;
				}


				$service 					= new invoice_products;
				$service->invoiceID		= $store->id;
				$service->propertyID		= $propertyID;
				$service->item_name		= 'Service charge';
				$service->quantity		= 1;
				$service->taxrate			= $request->tax_rate;;
				$service->taxvalue		= $taxvalue; 
				$service->total_amount  = $totalAmount;
				$service->main_amount   = $mainAmount;
				$service->sub_total  	= $mainAmount;
				$service->businessID  	= Auth::user()->businessID;
				$service->price         = $leaseInfo->service_charge;
				$service->category      = 'Service charge';
				$service->save();
			}
		}

		//Rent,Service charge & Parking
		if($request->category == 38){	
			if($request->apply_tax_to == 'All'){
				//rent billing
				if($leaseInfo->rent_amount != 0 || $leaseInfo->rent_amount != ""){
					$mainAmount = $leaseInfo->rent_amount;
					if($request->tax_rate != ""){
						$compound =  $request->tax_rate/100;
						$taxvalue = $mainAmount * $compound;
						$totalAmount = $mainAmount + $taxvalue;
					}else{
						$taxvalue = 0;
						$totalAmount = $mainAmount + $taxvalue;
					}

					$rent 					= new invoice_products;
					$rent->invoiceID		= $store->id;
					$rent->propertyID		= $propertyID;
					$rent->item_name		= 'Rent';
					$rent->quantity		= 1;
					$rent->taxrate			= $request->tax_rate;
					$rent->taxvalue		= $taxvalue; 
					$rent->total_amount  = $totalAmount;
					$rent->main_amount   = $mainAmount;
					$rent->sub_total  	= $mainAmount;
					$rent->businessID  	= Auth::user()->businessID;
					$rent->price         = $mainAmount;
					$rent->category      = 'Rent';
					$rent->save();
				}

				//parking billing
				if($request->category == 5){			
					if($leaseInfo->parking_price != 0 || $leaseInfo->parking_price != ""){
						if($leaseInfo->parking_price != "" && $leaseInfo->parking_spaces != ""){
							//store parking
							$mainAmount = $leaseInfo->parking_price * $leaseInfo->parking_spaces;
	
							if($request->tax_rate != "" || $request->tax_rate > 0 ){
								$compound =  $request->tax_rate/100;
								$taxvalue = $mainAmount * $compound;
								$totalAmount = $mainAmount + $taxvalue;
							}else{
								$taxvalue = 0;
								$totalAmount = $mainAmount + $taxvalue;
							}
	
							$parking 				   = new invoice_products;
							$parking->invoiceID	   = $store->id;
							$parking->propertyID		= $propertyID;
							$parking->item_name		= 'Parking';
							$parking->quantity		= $leaseInfo->parking_spaces;
							$parking->taxrate			= $request->tax_rate;
							$parking->taxvalue		= $taxvalue; 
							$parking->total_amount  = $totalAmount;
							$parking->main_amount   = $mainAmount;
							$parking->sub_total  	= $mainAmount;
							$parking->businessID  	= Auth::user()->businessID;
							$parking->price         = $leaseInfo->parking_price;
							$parking->category      = 'Parking';
							$parking->save();
						}
					}
				}

				//service charge billing
				if($leaseInfo->service_charge != "" | $leaseInfo->service_charge != 0){

					$mainAmount = $leaseInfo->service_charge;
					if($request->tax_rate != "" || $request->tax_rate > 0 ){
						$compound =  $request->tax_rate/100;
						$taxvalue = $mainAmount * $compound;
						$totalAmount = $mainAmount + $taxvalue;
					}else{
						$taxvalue = 0;
						$totalAmount = $mainAmount + $taxvalue;
					}

					$service 					= new invoice_products;
					$service->invoiceID		= $store->id;
					$service->propertyID		= $propertyID;
					$service->item_name		= 'Service charge';
					$service->quantity		= 1;
					$service->taxrate			= $request->tax_rate;;
					$service->taxvalue		= $taxvalue; 
					$service->total_amount  = $totalAmount;
					$service->main_amount   = $mainAmount;
					$service->sub_total  	= $mainAmount;
					$service->businessID  	= Auth::user()->businessID;
					$service->price         = $leaseInfo->service_charge;
					$service->category      = 'Service charge';
					$service->save();
				}
			}else{
				//apply tax to rent alone
				
				//rent billing
				if($leaseInfo->rent_amount != 0 || $leaseInfo->rent_amount != ""){
					$mainAmount = $leaseInfo->rent_amount;
					if($request->tax_rate != ""){
						$compound =  $request->tax_rate/100;
						$taxvalue = $mainAmount * $compound;
						$totalAmount = $mainAmount + $taxvalue;
					}else{
						$taxvalue = 0;
						$totalAmount = $mainAmount + $taxvalue;
					}

					$rent 					= new invoice_products;
					$rent->invoiceID		= $store->id;
					$rent->propertyID		= $propertyID;
					$rent->item_name		= 'Rent';
					$rent->quantity		= 1;
					$rent->taxrate			= $request->tax_rate;
					$rent->taxvalue		= $taxvalue; 
					$rent->total_amount  = $totalAmount;
					$rent->main_amount   = $mainAmount;
					$rent->sub_total  	= $mainAmount;
					$rent->businessID  	= Auth::user()->businessID;
					$rent->price         = $mainAmount;
					$rent->category      = 'Rent';
					$rent->save();
				}

				//parking billing
				if($request->category == 5){			
					if($leaseInfo->parking_price != 0 || $leaseInfo->parking_price != ""){
						if($leaseInfo->parking_price != "" && $leaseInfo->parking_spaces != ""){
							//store parking
							$mainAmount = $leaseInfo->parking_price * $leaseInfo->parking_spaces;		
							$taxvalue = 0;
							$totalAmount = $mainAmount + $taxvalue;
	
							$parking 				   = new invoice_products;
							$parking->invoiceID	   = $store->id;
							$parking->propertyID		= $propertyID;
							$parking->item_name		= 'Parking';
							$parking->quantity		= $leaseInfo->parking_spaces;
							$parking->taxrate			= 0;
							$parking->taxvalue		= $taxvalue; 
							$parking->total_amount  = $totalAmount;
							$parking->main_amount   = $mainAmount;
							$parking->sub_total  	= $mainAmount;
							$parking->businessID  	= Auth::user()->businessID;
							$parking->price         = $leaseInfo->parking_price;
							$parking->category      = 'Parking';
							$parking->save();
						}
					}
				}

				//service charge billing
				if($leaseInfo->service_charge != "" | $leaseInfo->service_charge != 0){

					$mainAmount = $leaseInfo->service_charge;
					$taxvalue = 0;
					$totalAmount = $mainAmount + $taxvalue;

					$service 					= new invoice_products;
					$service->invoiceID		= $store->id;
					$service->propertyID		= $propertyID;
					$service->item_name		= 'Service charge';
					$service->quantity		= 1;
					$service->taxrate			= 0;
					$service->taxvalue		= $taxvalue; 
					$service->total_amount  = $totalAmount;
					$service->main_amount   = $mainAmount;
					$service->sub_total  	= $mainAmount;
					$service->businessID  	= Auth::user()->businessID;
					$service->price         = $leaseInfo->service_charge;
					$service->category      = 'Service charge';
					$service->save();
				}
			}
		}

		//get invoice products
		$invoiceProducts = invoice_products::where('invoiceID',$store->id)
								->select(DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update invoice 
		$invoice = invoices::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
		$invoice->main_amount = $invoiceProducts->mainAmount;
		$invoice->total		 = $invoiceProducts->total;
		$invoice->balance		 = $invoiceProducts->total;
		$invoice->sub_total	 = $invoiceProducts->sub_total; 
		$invoice->taxvalue	 = $invoiceProducts->taxvalue; 
		$invoice->save();
		
		//invoice setting	
		$invoiceSetting = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();		
		$invoiceSetting->number = $invoiceSetting->number + 1;
		$invoiceSetting->save();

		//update lease information 
		$leaseInfo->next_invoice = $request->invoice_due;
		$leaseInfo->last_invoiced = $request->invoice_date;
		$leaseInfo->save();			

		//recored activity
		$activities = 'Property Invoice #'.$store->invoice_prefix.$store->invoice_number.' has been created by '.Auth::user()->name;
		$section = 'Invoice';
		$type = 'Create';
		$adminID = Auth::user()->id;
		$activityID = $store->id;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Invoice has been successfully created');

		return redirect()->route('property.invoice.index',$propertyID);
	}

	/**
	* Create bulk invoices
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function create_bulk($propertyID){
		//check if property has settings 
      $check = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->count();
      if($check != 1){
         Prop::make_invoice_settings($propertyID);
		}
		$category = category::where('businessID',0)->where('section','property')->get();
		$invoiceSetting = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();
		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
		$taxes = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		return view('app.property.property.show', compact('property','taxes','propertyID','invoiceSetting','category'));
	}

	/**
	* Store bulk invoices
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function store_bulk(Request $request ,$propertyID){
		$this->validate($request,[
			'lease_type'     => 'required',
			'invoice_due'    => 'required',
			'invoice_date'   => 'required',
			'tax_rate'    	  => 'required',
			'invoice_number' => 'required',
			'invoice_prefix' => 'required',
			'category'     => 'required',
			'billing_schedule'     => 'required'
		]);

		//validate the parent property to avoid users changing value via browser
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');
         return redirect()->back();
		}
		
		//get all the units
		$unitquery = lease::where('propertyID',$propertyID)
							->where('lease_type','Like',"%{$request->lease_type}%")
							->where('billing_schedule',$request->billing_schedule)
							->where('statusID',15)
							->where('businessID',Auth::user()->businessID)
							->select('id');

		$units = $unitquery->get();

		$unitCount = $unitquery->count();

		if($unitCount == 0){
			Session::flash('warning','please check it the units have active leases');
			
			return redirect()->back();
		}

		$invoiceSettings = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();

		foreach($units as $unit){
			$leaseInfo = lease::where('property_lease.propertyID',$propertyID)
									->where('property_lease.businessID',Auth::user()->businessID)  
									->where('id',$unit->id)
									->first();

			$code = Helper::generateRandomString(16);

			//store invoice
			$store					   = new invoices;
			$store->created_by	   = Auth::user()->id;
			$store->tenantID	   	= $leaseInfo->tenantID;
			$store->invoice_title	= $request->invoice_title;
			$store->income_category = $request->category; 
			$store->leaseID         = $unit->id;
			$store->unitID          = $leaseInfo->unitID;
			$store->invoice_number  = $invoiceSettings->number + 1;
			$store->invoice_prefix  = $request->invoice_prefix;
			$store->invoice_date	   = $request->invoice_date;
			$store->invoice_due	   = $request->invoice_due;
			$store->propertyID      = $propertyID;
			$store->invoice_type		= 'Rent';
			$store->statusID		   = 2;
			$store->invoice_code 	= $code;
			$store->businessID 		= Auth::user()->businessID;
			$store->save();

			//rent billing
			if($request->category == 35){			
				if($leaseInfo->rent_amount != 0 || $leaseInfo->rent_amount != ""){
					$mainAmount = $leaseInfo->rent_amount;
					if($request->tax_rate != "" || $request->tax_rate > 0 ){
						$compound =  $request->tax_rate/100;
						$taxvalue = $mainAmount * $compound;
						$totalAmount = $mainAmount + $taxvalue;
					}else{
						$taxvalue = 0;
						$totalAmount = $mainAmount + $taxvalue;
					}

					$rent 					= new invoice_products;
					$rent->invoiceID		= $store->id;
					$rent->propertyID		= $propertyID;
					$rent->item_name		= 'Rent';
					$rent->quantity		= 1;
					$rent->taxrate			= $request->tax_rate;
					$rent->taxvalue		= $taxvalue; 
					$rent->total_amount  = $totalAmount;
					$rent->main_amount   = $mainAmount;
					$rent->sub_total  	= $mainAmount;
					$rent->businessID  	= Auth::user()->businessID;
					$rent->price         = $mainAmount;
					$rent->category      = 'Rent';
					$rent->save();
				}
			}

			//parking billing
			if($request->category == 39){			
				if($leaseInfo->parking_price != 0 || $leaseInfo->parking_price != ""){
					if($leaseInfo->parking_price != "" && $leaseInfo->parking_spaces != ""){
						//store parking
						$mainAmount = $leaseInfo->parking_price * $leaseInfo->parking_spaces;

						if($request->tax_rate != "" || $request->tax_rate > 0 ){
							$compound =  $request->tax_rate/100;
							$taxvalue = $mainAmount * $compound;
							$totalAmount = $mainAmount + $taxvalue;
						}else{
							$taxvalue = 0;
							$totalAmount = $mainAmount + $taxvalue;
						}

						$parking 				   = new invoice_products;
						$parking->invoiceID	   = $store->id;
						$parking->propertyID		= $propertyID;
						$parking->item_name		= 'Parking';
						$parking->quantity		= $leaseInfo->parking_spaces;
						$parking->taxrate			= $request->tax_rate;
						$parking->taxvalue		= $taxvalue; 
						$parking->total_amount  = $totalAmount;
						$parking->main_amount   = $mainAmount;
						$parking->sub_total  	= $mainAmount;
						$parking->businessID  	= Auth::user()->businessID;
						$parking->price         = $leaseInfo->parking_price;
						$parking->category      = 'Parking';
						$parking->save();
					}
				}
			}

			//service charge billing
			if($request->category == 37){			
				if($leaseInfo->service_charge != "" | $leaseInfo->service_charge != 0){

					$mainAmount = $leaseInfo->service_charge;
					if($request->tax_rate != "" || $request->tax_rate > 0 ){
						$compound =  $request->tax_rate/100;
						$taxvalue = $mainAmount * $compound;
						$totalAmount = $mainAmount + $taxvalue;
					}else{
						$taxvalue = 0;
						$totalAmount = $mainAmount + $taxvalue;
					}


					$service 					= new invoice_products;
					$service->invoiceID		= $store->id;
					$service->propertyID		= $propertyID;
					$service->item_name		= 'Service charge';
					$service->quantity		= 1;
					$service->taxrate			= $request->tax_rate;;
					$service->taxvalue		= $taxvalue; 
					$service->total_amount  = $totalAmount;
					$service->main_amount   = $mainAmount;
					$service->sub_total  	= $mainAmount;
					$service->businessID  	= Auth::user()->businessID;
					$service->price         = $leaseInfo->service_charge;
					$service->category      = 'Service charge';
					$service->save();
				}
			}

			//Rent,Service charge & Parking
			if($request->category == 38){	
				if($request->apply_tax_to == 'All'){
					//rent billing
					if($leaseInfo->rent_amount != 0 || $leaseInfo->rent_amount != ""){
						$mainAmount = $leaseInfo->rent_amount;
						if($request->tax_rate != ""){
							$compound =  $request->tax_rate/100;
							$taxvalue = $mainAmount * $compound;
							$totalAmount = $mainAmount + $taxvalue;
						}else{
							$taxvalue = 0;
							$totalAmount = $mainAmount + $taxvalue;
						}

						$rent 					= new invoice_products;
						$rent->invoiceID		= $store->id;
						$rent->propertyID		= $propertyID;
						$rent->item_name		= 'Rent';
						$rent->quantity		= 1;
						$rent->taxrate			= $request->tax_rate;
						$rent->taxvalue		= $taxvalue; 
						$rent->total_amount  = $totalAmount;
						$rent->main_amount   = $mainAmount;
						$rent->sub_total  	= $mainAmount;
						$rent->businessID  	= Auth::user()->businessID;
						$rent->price         = $mainAmount;
						$rent->category      = 'Rent';
						$rent->save();
					}

					//parking billing
					if($request->category == 5){			
						if($leaseInfo->parking_price != 0 || $leaseInfo->parking_price != ""){
							if($leaseInfo->parking_price != "" && $leaseInfo->parking_spaces != ""){
								//store parking
								$mainAmount = $leaseInfo->parking_price * $leaseInfo->parking_spaces;
		
								if($request->tax_rate != "" || $request->tax_rate > 0 ){
									$compound =  $request->tax_rate/100;
									$taxvalue = $mainAmount * $compound;
									$totalAmount = $mainAmount + $taxvalue;
								}else{
									$taxvalue = 0;
									$totalAmount = $mainAmount + $taxvalue;
								}
		
								$parking 				   = new invoice_products;
								$parking->invoiceID	   = $store->id;
								$parking->propertyID		= $propertyID;
								$parking->item_name		= 'Parking';
								$parking->quantity		= $leaseInfo->parking_spaces;
								$parking->taxrate			= $request->tax_rate;
								$parking->taxvalue		= $taxvalue; 
								$parking->total_amount  = $totalAmount;
								$parking->main_amount   = $mainAmount;
								$parking->sub_total  	= $mainAmount;
								$parking->businessID  	= Auth::user()->businessID;
								$parking->price         = $leaseInfo->parking_price;
								$parking->category      = 'Parking';
								$parking->save();
							}
						}
					}

					//service charge billing
					if($leaseInfo->service_charge != "" | $leaseInfo->service_charge != 0){

						$mainAmount = $leaseInfo->service_charge;
						if($request->tax_rate != "" || $request->tax_rate > 0 ){
							$compound =  $request->tax_rate/100;
							$taxvalue = $mainAmount * $compound;
							$totalAmount = $mainAmount + $taxvalue;
						}else{
							$taxvalue = 0;
							$totalAmount = $mainAmount + $taxvalue;
						}

						$service 					= new invoice_products;
						$service->invoiceID		= $store->id;
						$service->propertyID		= $propertyID;
						$service->item_name		= 'Service charge';
						$service->quantity		= 1;
						$service->taxrate			= $request->tax_rate;;
						$service->taxvalue		= $taxvalue; 
						$service->total_amount  = $totalAmount;
						$service->main_amount   = $mainAmount;
						$service->sub_total  	= $mainAmount;
						$service->businessID  	= Auth::user()->businessID;
						$service->price         = $leaseInfo->service_charge;
						$service->category      = 'Service charge';
						$service->save();
					}
				}else{
					//apply tax to rent alone

					//rent billing
					if($leaseInfo->rent_amount != 0 || $leaseInfo->rent_amount != ""){
						$mainAmount = $leaseInfo->rent_amount;
						if($request->tax_rate != ""){
							$compound =  $request->tax_rate/100;
							$taxvalue = $mainAmount * $compound;
							$totalAmount = $mainAmount + $taxvalue;
						}else{
							$taxvalue = 0;
							$totalAmount = $mainAmount + $taxvalue;
						}

						$rent 					= new invoice_products;
						$rent->invoiceID		= $store->id;
						$rent->propertyID		= $propertyID;
						$rent->item_name		= 'Rent';
						$rent->quantity		= 1;
						$rent->taxrate			= $request->tax_rate;
						$rent->taxvalue		= $taxvalue; 
						$rent->total_amount  = $totalAmount;
						$rent->main_amount   = $mainAmount;
						$rent->sub_total  	= $mainAmount;
						$rent->businessID  	= Auth::user()->businessID;
						$rent->price         = $mainAmount;
						$rent->category      = 'Rent';
						$rent->save();
					}

					//parking billing
					if($request->category == 5){			
						if($leaseInfo->parking_price != 0 || $leaseInfo->parking_price != ""){
							if($leaseInfo->parking_price != "" && $leaseInfo->parking_spaces != ""){
								//store parking
								$mainAmount = $leaseInfo->parking_price * $leaseInfo->parking_spaces;		
								$taxvalue = 0;
								$totalAmount = $mainAmount + $taxvalue;
		
								$parking 				   = new invoice_products;
								$parking->invoiceID	   = $store->id;
								$parking->propertyID		= $propertyID;
								$parking->item_name		= 'Parking';
								$parking->quantity		= $leaseInfo->parking_spaces;
								$parking->taxrate			= 0;
								$parking->taxvalue		= $taxvalue; 
								$parking->total_amount  = $totalAmount;
								$parking->main_amount   = $mainAmount;
								$parking->sub_total  	= $mainAmount;
								$parking->businessID  	= Auth::user()->businessID;
								$parking->price         = $leaseInfo->parking_price;
								$parking->category      = 'Parking';
								$parking->save();
							}
						}
					}

					//service charge billing
					if($leaseInfo->service_charge != "" | $leaseInfo->service_charge != 0){

						$mainAmount = $leaseInfo->service_charge;
						$taxvalue = 0;
						$totalAmount = $mainAmount + $taxvalue;

						$service 					= new invoice_products;
						$service->invoiceID		= $store->id;
						$service->propertyID		= $propertyID;
						$service->item_name		= 'Service charge';
						$service->quantity		= 1;
						$service->taxrate			= 0;
						$service->taxvalue		= $taxvalue; 
						$service->total_amount  = $totalAmount;
						$service->main_amount   = $mainAmount;
						$service->sub_total  	= $mainAmount;
						$service->businessID  	= Auth::user()->businessID;
						$service->price         = $leaseInfo->service_charge;
						$service->category      = 'Service charge';
						$service->save();
					}
				}
			}

			//get invoice products
			$invoiceProducts = invoice_products::where('invoiceID',$store->id)
															->select(DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
															->first();

			//update invoice 
			$invoice = invoices::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
			$invoice->main_amount = $invoiceProducts->mainAmount;
			$invoice->total		 = $invoiceProducts->total;
			$invoice->balance		 = $invoiceProducts->total;
			$invoice->sub_total	 = $invoiceProducts->sub_total; 
			$invoice->taxvalue	 = $invoiceProducts->taxvalue; 
			$invoice->save();
			
			//invoice setting			
			$invoiceSettings->number = $invoiceSettings->number + 1;
			$invoiceSettings->save();

			//update lease information 
			$leaseInfo->next_invoice = $request->invoice_due;
			$leaseInfo->last_invoiced = $request->invoice_date;
			$leaseInfo->save();		
		}
		
		//recored activity
		$activities = 'Billing Invoice #'.$invoiceSettings->invoice_prefix.$store->invoice_number.' has been created by '.Auth::user()->name;
		$section = 'Invoice';
		$type = 'Create';
		$adminID = Auth::user()->id;
		$activityID = $store->id;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success', 'Invoices processed successfully !!!');
		

      return redirect()->route('property.invoice.index',$propertyID);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id 
	 * @return \Illuminate\Http\Response
	 */
	public function show($propertyID,$invoiceID)
	{
		$business = business::join('template','template.id','=','business.templateID')
									->join('currency','currency.id','=','business.base_currency')
									->where('business.id',Auth::user()->businessID)
									->where('businessID',Auth::user()->code)
									->first();

		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

		$invoice = invoices::join('status','status.id','=','property_invoices.statusID')
								->where('property_invoices.id',$invoiceID)
								->where('propertyID',$propertyID)
								->where('businessID',Auth::user()->businessID)
								->select('*','property_invoices.id as invoiceID')
								->first();

		$products = invoice_products::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->get();
		$payments = payments::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->get();
		
		$mainMethods =  payment_type::where('businessID',0)->get();
      $paymentmethod = payment_type::where('businessID',Auth::user()->businessID)->get();

		$tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
								->where('businessID',Auth::user()->businessID)
								->where('property_tenants.id',$invoice->tenantID)
								->select('*','property_tenants.id as tenantID')
								->first();

		$taxes = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$incomes = category::where('businessID',Auth::user()->businessID)->get();
		$OriginalIncomes = category::where('businessID',0)->get();
		$accounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose deposit account','');

		if($invoice->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $invoice->sub_total * ($invoice->tax / 100);
		}

		$count = 1;

		return view('app.property.accounting.invoices.show', compact('property','invoiceID','invoice','products','tenant','taxes','taxed','incomes','OriginalIncomes','business','mainMethods','paymentmethod','payments','count','propertyID','accounts'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($propertyID,$invoiceID)
	{
		$invoiceSetting = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();
		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
		$invoice = invoices::where('id',$invoiceID)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();
		$products = invoice_products::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->get();
		$tenants = property::join('property_tenants','property_tenants.id','=','property.tenantID')
								->join('property_lease','property_lease.id','=','property.leaseID')
								->where('property.businessID',Auth::user()->businessID)
								->where('property.parentID',$propertyID)
								->where('property.tenantID','!=', '')
								->orderby('property.id','desc')
								->select('*', 'property.id as propID','property_tenants.id as tenantID')
								->get();

		$tenant = tenants::join('property_lease','property_lease.tenantID','=','property_tenants.id')
								->join('property','property.leaseID','=','property_lease.id')
								->where('property_tenants.businessID',Auth::user()->businessID)
								->where('property_tenants.id',$invoice->tenantID)
								->select('property.serial as serial','tenant_name as tenant_name')
								->first();

		//check income category
		if($invoice->income_category != ""){
			$checkifOriginal = category::where('id',$invoice->income_category)->where('businessID',0)->count();
			if($checkifOriginal == 1){
				$incomeType = 'original';				
			}else{
				$incomeType = 'business';
			}
		}

		$taxes = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$incomes = category::where('businessID',0)->where('section','property')->get();
		if($invoice->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $invoice->sub_total * ($invoice->tax / 100);
		}

		return view('app.property.accounting.invoices.edit', compact('property','invoice','products','tenants','tenant','taxes','taxed','incomes','propertyID','incomeType','invoiceSetting'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id, $propertyID)
	{

		$this->validate($request, array(
			'tenant'    	  => 'required',
			'invoice_date'  => 'required',
			'invoice_due'	  => 'required',
		));

		$leaseInfo = lease::where('property_lease.propertyID',$propertyID)
								->where('property_lease.businessID',Auth::user()->businessID)  
								->where('property_lease.tenantID',$request->tenant) 
								->where('id',$request->leaseID)
								->first();

		$update	= invoices::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		$invoiceSetting = invoice_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();

		//delete old product
		$delete = invoice_products::where('invoiceID', $id);
		$delete->delete();

		//add new products
		$products	= $request->product_name;
		foreach ($products as $k => $v){
			
			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k]);

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;
			
			$totalAmount = $amount + $taxvalue;

			$product 					= new invoice_products;
			$product->invoiceID		= $update->id;
			$product->item_name		= $request->product_name[$k];
			$product->quantity		= $request->qty[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue; 
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->businessID  	= Auth::user()->businessID;
			$product->price         = $request->price[$k];
			$product->propertyID    = $update->propertyID;
			$product->save();
		}
			
		//get invoice products
		$invoiceProducts = invoice_products::where('invoiceID',$id)
								->select(DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update invoice 
		if($update->invoice_code == "") {
			$code = Helper::generateRandomString(16);
			$update->invoice_code = $code;
		}
		$update->main_amount   =  $invoiceProducts->mainAmount;
		$update->total		     = $invoiceProducts->total;
		$update->balance		  = $invoiceProducts->total - $update->paid;
		$update->sub_total	  = $invoiceProducts->sub_total; 
		$update->taxvalue	     = $invoiceProducts->taxvalue;  
		$update->updated_by	  = Auth::user()->id;
		$update->invoice_title = $request->invoice_title;
		if($update->invoice_prefix == ""){
			$update->invoice_prefix = $invoiceSetting->prefix;
		}
		$update->tenantID	     = $request->tenant;
		$update->income_category = $request->income_category;
		$update->invoice_date  = $request->invoice_date;
		$update->invoice_due	  = $request->invoice_due;
		$update->customer_note = $request->customer_note;
		$update->terms			  = $request->terms;
		$update->invoice_type  = 'Rent';
		$update->leaseID       = $request->leaseID;
		$update->unitID        = $leaseInfo->unitID;
		$update->businessID 	  = Auth::user()->businessID;
		$update->save();

      //recored activity
      $activities = 'Invoice has been updated by '.Auth::user()->name;
      $section = 'Invoice';
      $type = 'update';
      $adminID = Auth::user()->id;
      $activityID = $id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Invoice has been successfully updated');

    	return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete($propertyID,$invoiceID)
	{
		$checkPayment = payments::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->count();
		if($checkPayment == 0){
			//invoice details
			$invoice = invoices::where('id',$invoiceID)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();

			//delete invoice products
			$products = invoice_products::where('invoiceID',$invoice->id)->where('businessID',Auth::user()->businessID)->get();
			foreach($products as $product){
				invoice_products::where('id',$product->id)->where('invoiceID',$invoice->id)->where('businessID',Auth::user()->businessID)->delete();
			}

			//delete invoice
			$invoice->delete();

			Session::flash('success','Invoice Successfully deleted');

			return redirect()->back();		
		}

		Session::flash('warning','This invoice has a transaction linked to it, we can not delete it !!');

		return redirect()->back();
	}

	/**
 	* get lesases
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function get_leases($propertyID,$tenantID){
		$leases =  lease::join('property_tenants','property_tenants.id','=','property_lease.tenantID')
								->join('property','property.id','=','property_lease.unitID')
								->where('property_lease.statusID',15)
								->where('property_lease.propertyID',$propertyID)
								->where('property_lease.businessID',Auth::user()->businessID)  
								->where('property_lease.tenantID',$tenantID)                   
								->orderby('property_lease.id','desc')
								->select('*','property_lease.id as leaseID','property_lease.unitID as unitID')
								->get();

		return \Response::json($leases);
	}

	/**
	 * Invoice printing and pdf generation
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	*/
	public function print($propertyID,$invoiceID){
		$business = business::join('template','template.id','=','business.templateID')
									->join('currency','currency.id','=','business.base_currency')
									->where('business.id',Auth::user()->businessID)
									->where('businessID',Auth::user()->code)
									->first();

		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

		$invoice = invoices::join('status','status.id','=','property_invoices.statusID')
								->where('property_invoices.id',$invoiceID)
								->where('propertyID',$propertyID)
								->where('businessID',Auth::user()->businessID)
								->select('*','property_invoices.id as invoiceID','property_invoices.statusID as invoiceStatusID')
								->first();

		$products = invoice_products::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->get();
		$payments = payments::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->get();
		$paymenttypes = payment_type::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose payment method','');
		$tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
								->where('businessID',Auth::user()->businessID)
								->where('property_tenants.id',$invoice->tenantID)
								->first();

		$taxes = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$accounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose deposit account','');

		if($invoice->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $invoice->sub_total * ($invoice->tax / 100);
		}

		$count = 1;

		$pdf = PDF::loadView('templates/'.$business->template_name.'/invoice/property/invoice', compact('property','invoiceID','invoice','products','tenant','taxes','taxed','business','paymenttypes','payments','count','propertyID','accounts'));

		return $pdf->stream($invoice->invoice_prefix.$invoice->invoice_number.'.pdf');
	}

	/**
	 * Invoice payments
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	*/
	public function payments(Request $request,$propertyID,$invoiceID){
		$this->validate($request, [
			'amount' => 'required',
			'tenantID' => 'required',
		]);

		//update invoice payment & status
		$invoice = invoices::where('id',$invoiceID)->where('businessID',Auth::user()->businessID)->where('propertyID',$propertyID)->first(); 

		//update payment
		$oldPaid = $invoice->paid;
		$newPaid = $oldPaid + $request->amount;
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
		$pay = new payments;
		$pay->amount            = $request->amount;
		$pay->balance           = $invoice->total - $newPaid;
		$pay->reference_number  = $request->transactionID;
		$pay->payment_method    = $request->payment_method;
		$pay->payment_date      = $request->payment_date;
		$pay->invoiceID         = $request->invoiceID;
		$pay->created_by        = Auth::user()->id;
		$pay->businessID        = Auth::user()->businessID;
		$pay->note              = $request->note;
		$pay->tenantID          = $request->tenantID;
		$pay->incomeID          = $request->incomeID;
		$pay->accountID         = $request->accountID;
		$pay->payment_category  = 'Received';
		$pay->save();

	   //tenant Credit
		if($invoice->paid > $invoice->total){
			$check = creditnote_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->count();
			if($check != 1){
				Prop::make_creditnote_settings($propertyID);
			}

			//update creditnote number
			$setting = creditnote_settings::where('businessID',Auth::user()->businessID)->first();

			$creditAmount = $invoice->paid - $invoice->total;

			$credit					      = new creditnote;
			$total                     = $creditAmount;
			$credit->created_by		   = Auth::user()->id;
			$credit->tenantID	 	      = $request->tenantID;
			$credit->creditnote_number = $setting->number+1;
			$credit->creditnote_prefix  = $setting->prefix;
			$credit->leaseID           = $invoice->leaseID;
			$credit->total		         = $total;
			$credit->main_amount		   = $total;
			$credit->balance		      = $total;
			$credit->credit_code 	   = Helper::generateRandomString(16);
			$credit->taxvalue		      = 0;
			$credit->title             = 'Payment credit for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number;
			$credit->sub_total		   = $total;
			$credit->creditnote_date   = date('Y-m-d');
			$credit->statusID		      = 21;
			$credit->propertyID        = $request->propertyID;
			$credit->paymentID         = $pay->id;
			$credit->businessID 	      = Auth::user()->businessID;
			$credit->save();
			
			//products
			$product 					= new creditnote_products;
			$product->creditnoteID  = $credit->id;
			$product->item_name	   = 'Payment credit for invoice #'.$invoice->invoice_number;
			$product->quantity		= 1;
			$product->businessID  	= Auth::user()->businessID;
			$product->propertyID		= $propertyID;
			$product->price    		= $total;
			$product->main_amount   = $total;
			$product->sub_total    	= $total;
			$product->total_amount  = $total;
			$product->save();

			$setting->number = $setting->number + 1;
			$setting->save();

			//update payment
			$updateCredit = payments::find($pay->id);
			$updateCredit->credited = 'yes';
			$updateCredit->creditID = $credit->id;
			$updateCredit->save();
		}

		//Send payment acknowledgment message to client
		if($request->send_email == 'yes'){

			$clientName = Finance::client($invoice->customerID)->customer_name;

			$subject = 'Payment acknowledgment for #'.$invoice->invoice_prefix.$invoice->invoice_number;
			$to = Finance::client($invoice->customerID)->email;
			$content = '<span style="font-size: 12pt;">Hello '.$clientName.'</span><br/><br/>
			Thank you for the payment. Find the payment details below:<br/><br/>
			-------------------------------------------------
			<br/><br/>
			Amount:&nbsp;<strong>'. number_format($request->amount).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
			Balance:&nbsp;<strong>'. number_format($invoice->total - $invoice->paid).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
			Date:&nbsp;<strong>'.date('jS F, Y', strtotime($request->payment_date)).'</strong><br/>
			Invoice number:&nbsp;<span style="font-size: 12pt;"><strong>#'.$invoice->invoice_prefix.$invoice->invoice_number.'</strong><br/><br/></span>
			-------------------------------------------------
			<br/><br/>
			We are looking forward working with you.<br/>';

			Mail::to($to)->send(new sendMessage($content,$subject));

			//save email
			$emails = new emails;
			$emails->message   = $content;
			$emails->clientID  = $invoice->customerID;
			$emails->subject   = $subject;
			$emails->mail_from = 'message-noreply@Winguerp.com';
			$emails->category  = 'Invoice Payment acknowledgment';
			$emails->status    = 'Sent';
			$emails->ip 		 = Helper::get_client_ip();
			$emails->type      = 'Outgoing';
			$emails->section   = 'invoices';
			$emails->mail_to   = $to;
			$emails->userID   = Auth::user()->id;
			$emails->businessID   = Auth::user()->businessID;
			$emails->save();

		}

		//record activity
		$activities = 'Payment has been recorded for Invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.' by '.Auth::user()->name;
		$section = 'Invoice';
		$type = 'Payment';
		$adminID = Auth::user()->id;
		$activityID = $request->invoiceID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Payment successfully recorded');

		return redirect()->back();

	}	
}
