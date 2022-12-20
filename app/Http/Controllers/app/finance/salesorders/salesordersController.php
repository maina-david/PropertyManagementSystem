<?php

namespace App\Http\Controllers\app\finance\salesorders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\salesorder\salesorders;
use App\Models\finance\salesorder\salesorder_products;
use App\Models\finance\salesorder\salesorder_settings;
use App\Models\finance\products\product_information;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\invoice\invoice_settings;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\tax;
use App\Models\crm\emails;
use App\Models\hr\employees;
use App\Models\wingu\status;
use App\Mail\sendSalesorders;
use DB;
use Documents;
use Input;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;

class salesordersController extends Controller
{
	public function __construct(){
      $this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$salesOrders = salesorders::join('customers','customers.id','=','salesorders.customerID')
										->join('business','business.id','=','salesorders.businessID')
										->join('currency','currency.id','=','business.base_currency')
										->join('salesorder_settings','salesorder_settings.businessID','=','salesorders.businessID')
										->join('status','status.id','=','salesorders.statusID')
										->where('salesorders.businessID',Auth::user()->businessID)
										->select('*','salesorders.id as salesID','status.name as statusName','salesorders.created_at as createDate')
										->orderby('salesorders.id','desc')
										->get();

		return view('app.finance.salesorders.index', compact('salesOrders'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
   {
		$check = salesorder_settings::where('businessID',Auth::user()->businessID)->count();
		if($check != 1){
			Finance::salesorder_setting_setup();
		} 

		$clients = customers::where('businessID',Auth::user()->businessID)
				->where('category', '=', 'Subscriber')
				->whereNull('category')
				->OrderBy('id','DESC')
				->get();

		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$status	= status::all();
		$products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
					->where('product_information.businessID',Auth::user()->businessID)
					->where('product_information.type','product')
					->where('default_inventory','Yes')
					->orwhere('product_information.type','service')
					->OrderBy('product_information.id','DESC')
					->select('*','product_information.id as productID')
					->get();

		$salespersons = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose salse person','');

		return view('app.finance.salesorders.create', compact('clients','taxs','products','salespersons','status'));
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
			'salesorder_date'  => 'required',
			'salesorder_due_date'	  => 'required',
		)); 

		//store invoice
		$store					       = new salesorders;
		$store->created_by		    = Auth::user()->id;
		$store->customerID	 	    = $request->customer;
		$store->subject			    = $request->subject;
		$store->reference           = $request->reference;
		$store->salesorder_number   = $request->salesorder_number;
		$store->salesorder_date	    = $request->salesorder_date;
		$store->salesorder_due_date = $request->salesorder_due_date;
		$store->customer_note		 = $request->customer_note;
		$store->terms_conditions	 = $request->terms_conditions;
		$store->salesperson   		 = $request->salesperson;
		$store->taxconfig				 = $request->taxconfig;
		$store->statusID		   	 = 10;
		$store->businessID 			 = Auth::user()->businessID;
		$store->save();

		//products
		$products				= $request->productID;

		foreach ($products as $k => $v){

			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;
			$taxvalue = $amount * $rate;			
			$totalAmount = $amount + $taxvalue;

			$product 					  = new salesorder_products;
			$product->salesorderID	  = $store->id;
			$product->productID		  = $request->productID[$k];
			$product->quantity		  = $request->qty[$k];
			$product->discount		  = $request->discount[$k];
			$product->taxrate			  = $request->tax[$k];
			$product->taxvalue		  = $taxvalue; 
			$product->total_amount    = $totalAmount;
			$product->main_amount     = $mainAmount;
			$product->sub_total  	  = $amount;
			$product->businessID  	  = Auth::user()->businessID;
			$product->selling_price   = $request->price[$k];
			$product->save();
		}

		//get invoice products
		$salesordersProducts = salesorder_products::where('salesorderID',$store->id)
										->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
										->first();

		//update invoice 
		$salesorders = salesorders::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
		$salesorders->main_amount = $salesordersProducts->mainAmount;
		$salesorders->discount    = $salesordersProducts->discount;
		$salesorders->total		  = $salesordersProducts->total;
		$salesorders->balance	  = $salesordersProducts->total;
		$salesorders->sub_total	  = $salesordersProducts->sub_total; 
		$salesorders->taxvalue	  = $salesordersProducts->taxvalue; 
		$salesorders->save();
		
		//sales order setting
		$salesorderSettings = salesorder_settings::where('businessID',Auth::user()->businessID)->first();
		$salesNumber 	= $salesorderSettings->number + 1;
		$salesorderSettings->number = $salesNumber;
		$salesorderSettings->save();

		//recored activity
		$activities = 'Sales order #'.Finance::salesorder_setting()->prefix.$store->salesorder_number.' has been created by '.Auth::user()->name;
		$section = 'Sales order';
		$type = 'Create';
		$adminID = Auth::user()->id;
		$activityID = $store->id;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Sales order has been successfully created');

		return redirect()->route('finance.salesorders.index');

   }

	/**
	*  Sales order edit
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function edit($id){

		$salesorder = salesorders::join('business','business.id','=','salesorders.businessID')
									->join('currency','currency.id','=','business.base_currency')
									->join('status','status.id','=','salesorders.statusID')
									->join('salesorder_settings','salesorder_settings.businessID','=','salesorders.businessID')
									->join('customers','customers.id','=','salesorders.customerID')
									->where('salesorders.id',$id)
									->where('salesorders.businessID',Auth::user()->businessID)
									->select('*','salesorders.id as salesorderID','business.name as businessName')
									->first();

		$clients = customers::where('businessID',Auth::user()->businessID)
                            ->where('category', '=', 'Subscriber')
                            ->orWhereNull('category')
                            ->OrderBy('id','DESC')
                            ->get();
		$client = customers::where('id',$salesorder->customerID)->where('businessID',Auth::user()->businessID)->first();

		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		
		$products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
											->where('product_information.businessID',Auth::user()->businessID)
											->where('product_information.type','product')
											->where('default_inventory','Yes')
											->orwhere('product_information.type','service')
											->OrderBy('product_information.id','DESC')
											->select('*','product_information.id as productID')
											->get();

		$salespersons = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose salse person','');
      $salesorderProducts = salesorder_products::where('salesorderID',$id)->get();
		$count = 1;

		if($salesorder->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $salesorder->sub_total * ($salesorder->tax / 100);
		}

		return view('app.finance.salesorders.edit', compact('client','clients','taxed','count','salesorder','products','taxs','salesorderProducts','salespersons'));
	}

	/**
	*  Sales order update
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function update(request $request,$id){
		$this->validate($request, array(
			'customer'    	  => 'required',
			'salesorder_date'  => 'required',
			'salesorder_due_date'	  => 'required',
		));

		//delete old product
		$delete = salesorder_products::where('salesorderID', $id);
		$delete->delete();

		$update	= salesorders::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		//add new products
		$products				= $request->productID;
		foreach ($products as $k => $v){
			
			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;
			
			$totalAmount = $amount + $taxvalue;

			$product 					= new salesorder_products;
			$product->salesorderID	= $update->id;
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
			$product->save();
		}
			

		//get invoice products
		$salesordersProducts = salesorder_products::where('salesorderID',$id)
																->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
																->first();

		$update->main_amount         = $salesordersProducts->mainAmount;
		$update->discount            = $salesordersProducts->discount;
		$update->total		           = $salesordersProducts->total;
		$update->balance		        = $salesordersProducts->total - $update->paid;
		$update->sub_total	        = $salesordersProducts->sub_total; 
		$update->taxvalue	           = $salesordersProducts->taxvalue;  
		$update->updated_by	        = Auth::user()->id;
		$update->subject  		     = $request->subject;
		$update->customerID	        = $request->customer;
		$update->salesperson    	  = $request->salesperson;
		$update->reference           = $request->reference;
		$update->salesorder_date	  = $request->salesorder_date;
		$update->salesorder_due_date = $request->salesorder_due_date;
		$update->customer_note		  = $request->customer_note;
		$update->terms_conditions	  = $request->terms_conditions;
		$update->taxconfig	        = $request->taxconfig;
		$update->businessID 	        = Auth::user()->businessID;
		$update->save();

      //recored activity
      $activities = 'Sales order #'.Finance::salesorder_setting()->prefix.$update->salesorder_number.' has been updated by '.Auth::user()->name;
      $section = 'Sales order';
      $type = 'update';
      $adminID = Auth::user()->id;
      $activityID = $id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Sales order has been successfully updated');

    	return redirect()->back();
	}

	/**
	*  Sales order show
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function show($id){
		$count = 1;
		$filec = 1;

		$salesorder = salesorders::join('business','business.id','=','salesorders.businessID')
									->join('currency','currency.id','=','business.base_currency')
									->join('status','status.id','=','salesorders.statusID')
									->join('salesorder_settings','salesorder_settings.businessID','=','salesorders.businessID')
									->join('customers','customers.id','=','salesorders.customerID')
									->where('salesorders.id',$id)
									->where('salesorders.businessID',Auth::user()->businessID)
									->select('*','salesorders.id as salesorderID','business.name as businessName','salesorders.statusID as statusID','business.businessID as business_code')
									->first();

		$products = salesorder_products::where('salesorderID',$salesorder->salesorderID)->get();

		if($salesorder->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $salesorder->sub_total * ($salesorder->tax / 100);
		}

		$files = docs::where('fileID',$id)->where('section','sales order')->where('businessID',Auth::user()->businessID)->get();

		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
									->where('customers.id',$salesorder->customerID)
									->where('businessID',Auth::user()->businessID)
									->select('*','customers.id as clientID','bill_country as countryID')
									->first();

		$persons = contact_persons::where('customerID',$client->clientID)->get();

		$template = Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name;

		return view('app.finance.salesorders.show', compact('client','salesorder','products','count','taxed','filec','files','persons','template'));
	}

	/**
	* 	send invoice via mail
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function mail($id){
		$salesorder = salesorders::join('business','business.id','=','salesorders.businessID')
								->join('currency','currency.id','=','business.base_currency')
								->join('status','status.id','=','salesorders.statusID')
								->join('salesorder_settings','salesorder_settings.businessID','=','salesorders.businessID')
								->join('customers','customers.id','=','salesorders.customerID')
								->where('salesorders.id',$id)
								->where('salesorders.businessID',Auth::user()->businessID)
								->select('*','salesorders.id as salesorderID','business.name as businessName')
								->first();

		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$salesorder->customerID)
							->where('customers.businessID',Auth::user()->businessID)
							->select('*','customers.id as clientID')
							->first();

		$files = docs::where('fileID',$id)->where('section', 'like', '%sales order%')->where('businessID',Auth::user()->businessID)->get();
		$contacts = contact_persons::where('customerID',$client->clientID)->get();

		$count = 1;

		$details = salesorders::join('business','business.id','=','salesorders.businessID')
						->join('currency','currency.id','=','business.base_currency')
						->join('status','status.id','=','salesorders.statusID')
						->join('salesorder_settings','salesorder_settings.businessID','=','salesorders.businessID')
						->join('customers','customers.id','=','salesorders.customerID')
						->where('salesorders.id',$id)
						->where('salesorders.businessID',Auth::user()->businessID)
						->select('*','salesorders.id as salesorderID','business.name as businessName')
						->first();

		$products = salesorder_products::where('salesorderID',$details->salesorderID)->where('businessID',Auth::user()->businessID)->get();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/salesorder/';
      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/salesorder/salesorder', compact('products','details','client','taxed','count'));

		$pdf->save($directory.Finance::salesorder_setting()->prefix.$details->salesorder_number.'.pdf');

		return view('app.finance.salesorders.mail', compact('salesorder','files','contacts','client'));
	}

	/**
	* 	send invoice via email
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function send(Request $request){
		$this->validate($request,[
			'email_from' => 'required|email',
			'send_to' 	 => 'required',
			'subject'    => 'required',
			'message'	 => 'required',
		]);

		//sales order  information
		$salesorder = salesorders::where('id',$request->salesorderID)->where('businessID',Auth::user()->businessID)->first();

		//client info
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$salesorder->customerID)
							->where('customers.businessID',Auth::user()->businessID)
							->select('*','customers.id as clientID')
							->first();

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
		$trackCode = Helper::generateRandomString(9);

		$emails = new emails;
		$emails->message        = $request->message;
		$emails->clientID       = $client->clientID;
		$emails->subject        = $request->subject;
		$emails->tracking_code  = $trackCode;
		$emails->mail_from      = $request->email_from;
		$emails->category       = 'Sale Order Document';
		$emails->status         = 'Sent';
		$emails->ip 		      = Helper::get_client_ip();
		$emails->type           = 'Outgoing';
		$emails->section        = 'Sales order';
		$emails->mail_to        = $request->send_to;
		$emails->userID         = Auth::user()->id;
		$emails->businessID     = Auth::user()->businessID;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
		$emails->save();

		//update sales order
		$salesorder->remainder_count = $salesorder->remainder_count + 1;
		$salesorder->sent_status 	= 'Sent';
		$salesorder->salesorder_code 	= $trackCode;
		$salesorder->save();

		//send email
		$subject = $request->subject;

		$content = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->businessID.'/'.$emails->id.'" width="1" height="1" /><img src="'.url('/').'/track/salesorder/'.$trackCode.'/'.Auth::user()->businessID.'/'.$salesorder->id.'" width="1" height="1" />';


		$from = $request->email_from;
		$to = $request->send_to;
		$mailID = $emails->id;
		$docID = $salesorder->id; //invoice_settings ID

		if($request->attaches == 'Yes'){
			$attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/salesorder/'.Finance::salesorder_setting()->prefix.$salesorder->salesorder_number.'.pdf';
		}else{
			$attachment = 'No';
		}

		Mail::to($to)->send(new sendSalesorders($content,$subject,$from,$mailID,$attachment));

		//recorord activity
		$activities = 'Sale order #'.Finance::salesorder_setting()->prefix.''.$salesorder->salesorder_number.' has been sent to the client by '.Auth::user()->name;
		$section = 'Sales order';
		$type = 'Sent';
		$adminID = Auth::user()->id;
		$activityID = $request->salesorderID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Invoice Sent to client successfully');

		return redirect()->back();
	}

	/**
	* attachment invoice_settings
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$salesorder = salesorders::where('id',$request->salesorderID)->where('businessID',Auth::user()->businessID)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/salesorders/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		//get file name
		$file = $request->file('file');
		$size =  $file->getSize();

      //change file name
      $filename = Helper::generateRandomString().$file->getClientOriginalName();

      //move file
		$file->move($directory, $filename);

      //save the upload details into the database

		$upload = new docs;

      $upload->fileID      = $request->salesorderID;
		$upload->folder 	   = 'Finance';
		$upload->section 	   = 'sales order';
		$upload->name 		   = Finance::salesorder_setting()->prefix.$salesorder->salesorder_number;
		$upload->file_name   = $filename;
      $upload->file_size   = $size;
		$upload->attach 	   = 'No';
      $upload->file_mime   = $file->getClientMimeType();
		$upload->created_by  = Auth::user()->id;
		$upload->businessID  = Auth::user()->businessID;
      $upload->save();

		//recorord activity
		$activities = Auth::user()->name.' Has attached files to this salse order #'.Finance::salesorder_setting()->prefix.$salesorder->salesorder_number;
		$section = 'invoice';
		$type = 'Attachment';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
		$activityID = $request->salesorderID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);


		Session::flash('success','Invoice has been successfully attached');
	}

	/**
	* 	delete file
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_file($id){

		$file = docs::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/salesorders/';

		$delete = $directory.$file->file_name;
		if(File::exists($delete)) {
			unlink($delete);
		}

		$file->delete();

		Session::flash('success','File Deleted');

		return redirect()->back();
	}

	/**
	* 	delete invoice permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_salesorder($salesorderID){
		//delete all files linked to the invoice_settings
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/salesorders/';
		$check_files = docs::where('fileID',$salesorderID)
							->where('section', 'like', '%sales order%')
							->where('businessID',Auth::user()->businessID)
							->count();

		if($check_files > 0){
			$files = docs::where('fileID',$salesorderID)->where('section', 'like', '%sales order%')->where('businessID',Auth::user()->businessID)->get();
			foreach($files as $file){
				$doc = docs::where('id',$file->id)->where('section', 'like', '%sales order%')->where('businessID',Auth::user()->businessID)->first();

				//create directory if it doesn't exists
				$delete = $directory.$doc->file_name;
				if (File::exists($delete)) {
					unlink($delete);
				}

				$doc->delete();
			}
		}

		//delete sales order products
		salesorder_products::where('salesorderID',$salesorderID)->delete();

		//delete sales orders plus attachment
		$salesorder = salesorders::where('id',$salesorderID)->where('businessID',Auth::user()->businessID)->first();
		if($salesorder->attachment != ""){
			$delete = $directory.$salesorder->attachment;
			if (File::exists($delete)) {
				unlink($delete);
			}
		}
		

		//recorord activity
		$activities = 'Sale order #'.Finance::salesorder_setting()->prefix.$salesorder->salesorder_number.' had been deleted by '.Auth::user()->name;
		$section = 'Sale order';
		$type = 'Delete';
		$adminID = Auth::user()->id;
		$activityID = $salesorderID;
		$businessID = Auth::user()->businessID;

		$salesorder->delete();

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Sales order has been successfully deleted');

		return redirect()->route('finance.salesorders.index');
	}

	/**
   * generate invoice pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function pdf($id){
		$count = 1;
		$details = salesorders::join('business','business.id','=','salesorders.businessID')
						->join('currency','currency.id','=','business.base_currency')
						->join('status','status.id','=','salesorders.statusID')
						->join('salesorder_settings','salesorder_settings.businessID','=','salesorders.businessID')
						->join('customers','customers.id','=','salesorders.customerID')
						->where('salesorders.id',$id)
						->where('salesorders.businessID',Auth::user()->businessID)
						->select('*','salesorders.id as salesorderID','business.name as businessName')
						->first();

		$products = salesorder_products::where('salesorderID',$details->salesorderID)->get();

		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->where('customers.id',$details->customerID)
					->where('businessID',Auth::user()->businessID)
					->select('*','customers.id as clientID','bill_country as countryID')
					->first();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/salesorder/salesorder', compact('products','details','client','taxed','count'));

		return $pdf->download(Finance::salesorder_setting()->prefix.$details->salesorder_number.'.pdf');
	}

	/**
	* print invoice
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function print($id){
		$count = 1;
		$details = salesorders::join('business','business.id','=','salesorders.businessID')
						->join('currency','currency.id','=','business.base_currency')
						->join('status','status.id','=','salesorders.statusID')
						->join('salesorder_settings','salesorder_settings.businessID','=','salesorders.businessID')
						->join('customers','customers.id','=','salesorders.customerID')
						->where('salesorders.id',$id)
						->where('salesorders.businessID',Auth::user()->businessID)
						->select('*','salesorders.id as salesorderID','business.name as businessName')
						->first();

		$products = salesorder_products::where('salesorderID',$details->salesorderID)->get();

		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->where('customers.id',$details->customerID)
					->where('businessID',Auth::user()->businessID)
					->select('*','customers.id as clientID','bill_country as countryID')
					->first();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/salesorder/salesorder', compact('products','details','client','taxed','count'));

		return $pdf->stream(Finance::salesorder_setting()->prefix.$details->salesorder_number.'.pdf');
	}

	/**
	* change sales order status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function change_status($salesorderID,$status){
		$salesOrder = salesorders::where('id',$salesorderID)->where('businessID',Auth::user()->businessID)->first();
		$salesOrder->statusID = $status;
		$salesOrder->save();

		//recorord activity
		$activities = 'Sales order #'.Finance::salesorder_setting()->prefix.$salesOrder->salesorder_number.' had been confirmed by '.Auth::user()->name;
		$section = 'Sales order';
		$type = 'Sale order confirmed';
		$adminID = Auth::user()->id;
		$activityID = $salesorderID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Status successfully changed');

		return redirect()->back();
	}
	
	/**
	* 	change estimate status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function convert_to_invoice($salesorderID){
		$salesorder = salesorders::where('id',$salesorderID)->where('businessID',Auth::user()->businessID)->first();

		$code = Helper::generateRandomString(16);
		//create invoice
		$invoice = new invoices;
		$invoice->created_by = Auth::user()->id;
		$invoice->customerID = $salesorder->customerID;
		$invoice->invoice_number = Finance::invoice_settings()->number + 1;
		$invoice->sub_total = $salesorder->sub_total;
		$invoice->total = $salesorder->total;
		$invoice->discount = $salesorder->discount;
		$invoice->invoice_date = $salesorder->salesorder_date;
		$invoice->invoice_due = $salesorder->salesorder_due_date;
		$invoice->salesperson   	= $salesorder->salesperson;
		$invoice->invoice_code = $code;
		$invoice->statusID = 2;
		$invoice->businessID = $salesorder->businessID;
		$invoice->main_amount =  $salesorder->mainAmount;
		$invoice->discount   = $salesorder->discount;
		$invoice->total		= $salesorder->total;
		$invoice->balance		= $salesorder->total;
		$invoice->sub_total	= $salesorder->sub_total; 
		$invoice->taxvalue	= $salesorder->taxvalue;
		$invoice->invoice_type = 'Product';
		$invoice->save();


		//create products
		$salesproducts = salesorder_products::where('salesorderID',$salesorderID)->where('businessID',Auth::user()->businessID)->get();
		foreach($salesproducts as $product){
			//get individual product 
			$indiprod = salesorder_products::where('id',$product->id)->where('businessID',Auth::user()->businessID)->first();

			//copy them to invoice products
			$product = new invoice_products;
			$product->invoiceID		= $invoice->id;
			$product->productID		= $indiprod->productID;
			$product->quantity		= $indiprod->quantity;
			$product->discount		= $indiprod->discount;
			$product->taxrate			= $indiprod->taxrate;
			$product->taxvalue		= $indiprod->taxvalue;
			$product->total_amount  = $indiprod->total_amount;
			$product->main_amount   = $indiprod->main_amount;
			$product->sub_total  	= $indiprod->sub_total;
			$product->businessID  	= Auth::user()->businessID;
			$product->selling_price = $indiprod->selling_price;
			$product->category      = 'Product';
			$product->save();
		}

		//update sales order
		$salesorder->invoiceID = $invoice->id;
		$salesorder->save();

		//update invoice number settings
		$invoice_settings = invoice_settings::where('businessID',Auth::user()->businessID)->first();
		$invoice_settings->number = $invoice_settings->number + 1;
		$invoice_settings->save();


		//recorord activity
		$activities = 'Sales order #'.Finance::salesorder_setting()->prefix.$salesorder->salesorder_number.' had been converted to an invoice by '.Auth::user()->name;
		$section = 'Sales order';
		$type = 'Convert';
		$adminID = Auth::user()->id;
		$activityID = $salesorderID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Sale order successfully converted');

		return redirect()->back();
	}

}
