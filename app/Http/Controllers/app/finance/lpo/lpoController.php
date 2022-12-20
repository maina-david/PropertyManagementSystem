<?php

namespace App\Http\Controllers\app\finance\lpo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\suppliers\contact_persons;
use App\Models\finance\lpo\lpo;
use App\Models\finance\lpo\lpo_products;
use App\Models\finance\lpo\lpo_settings as settings;
use App\Models\finance\products\product_information;
use App\Models\finance\expense\expense;
use App\Models\wingu\status; 
use App\Models\wingu\file_manager as docs;
use App\Models\finance\tax;
use App\Models\finance\currency;
use App\Models\crm\emails;
use App\Mail\sendLpo;
use Session;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF; 
use Mail;
use DB;

class lpoController extends Controller
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
		$lpos	= lpo::join('suppliers','suppliers.id','=','purchaseorders.supplierID')
							->join('purchaseorder_settings','purchaseorder_settings.businessID','=','purchaseorders.businessID')
							->join('business','business.id','=','purchaseorders.businessID')
							->join('currency','currency.id','=','business.base_currency')
							->join('status','status.id','=','purchaseorders.statusID')
							->where('purchaseorders.businessID',Auth::user()->businessID)
							->orderby('purchaseorders.id','desc')
							->select('*','purchaseorders.id as lpoID','status.name as statusName','purchaseorders.title as lpo_title')
							->get();
			$count = 1;
			return view('app.finance.purchaseorders.index', compact('lpos','count'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
   {
		$check = settings::where('businessID',Auth::user()->businessID)->count();
			if($check != 1){
			Finance::lpo_setting_setup();
		}
		
		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$suppliers = suppliers::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
												->where('product_information.businessID',Auth::user()->businessID)
												->where('product_information.type','product')
												->where('default_inventory','Yes')
												->orwhere('product_information.type','service')
												->OrderBy('product_information.id','DESC')
												->select('*','product_information.id as productID')
												->get();
      $status	= status::all();

		return view('app.finance.purchaseorders.create', compact('suppliers','products','status','taxs'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request, array(
			'supplier'	=> 'required',
			'lpo_number'	=> 'required',
			'lpo_date'	=> 'required',
			'lpo_due'	=> 'required', 
		));

		//store purches order
		$code = Helper::generateRandomString(16);

		$store					      = new lpo;
		$store->created_by		   = Auth::user()->id;
		$store->supplierID	 	   = $request->supplier;
		$store->lpo_number         = $request->lpo_number;
		$store->reference_number   = $request->reference_number;
		$store->title				   = $request->title; 
		$store->expense_category  = $request->expense_category;
		$store->lpo_date	         = $request->lpo_date;
		$store->lpo_due	         = $request->lpo_due;
		$store->customer_note	   = $request->customer_note;
		$store->terms				   = $request->terms;
		$store->statusID		      = 10;
		$store->purchesorder_code 	= $code;
		$store->businessID 		   = Auth::user()->businessID;
		$store->save();

		//products
		$products				= $request->productID;

		foreach ($products as $k => $v){

			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;			
			$totalAmount = $amount + $taxvalue;

			$product 					= new lpo_products;
			$product->lpoID   		= $store->id;
			$product->productID		= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue; 
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;			
			$product->price         = $request->price[$k];
			$product->businessID  	= Auth::user()->businessID;
			$product->save();
		}

		//get invoice products
		$lpoProducts = lpo_products::where('lpoID',$store->id)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update invoice 
		$lpo = lpo::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
		$lpo->main_amount =  $lpoProducts->mainAmount;
		$lpo->discount    = $lpoProducts->discount;
		$lpo->total		   = $lpoProducts->total;
		$lpo->sub_total	= $lpoProducts->sub_total; 
		$lpo->taxvalue	   = $lpoProducts->taxvalue; 
		$lpo->save();
		
		//lpo setting
		$settings  = settings::where('businessID',Auth::user()->businessID)->first();
		$lpoNumber 	= $settings->number + 1;
		$settings->number	= $lpoNumber;
		$settings->save();

		//recored activity
		$activities = 'Purchase Order #'.Finance::lpo()->prefix.$store->lpo_number.' has been created by '.Auth::user()->name;
		$section = 'Purchase Order';
		$type = 'Create';
		$adminID = Auth::user()->id;
		$activityID = $store->id;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Purchase Order has been successfully created');

		return redirect()->route('finance.lpo.index');

   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   { 

		$lpo = lpo::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$suppliers = suppliers::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$supplier = suppliers::where('id',$lpo->supplierID)->where('businessID',Auth::user()->businessID)->first();

		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$currency = currency::find($lpo->currency_id);
		$lpoproducts = lpo_products::where('lpoID',$id)->get();

		$products = product_information::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();

		$count = 1;

		if($lpo->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $lpo->sub_total * ($lpo->tax / 100);
		} 

		return view('app.finance.purchaseorders.edit', compact('suppliers','supplier','taxed','count','lpo','products','lpoproducts','taxs'));
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
      $this->validate($request, array(
			'supplier'	=> 'required',
			'lpo_number'	=> 'required',
			'lpo_date'	=> 'required',
			'lpo_due'	=> 'required',
		));

		$update					 	  = lpo::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$update->updated_by		  = Auth::user()->id;
		$update->supplierID	 	  = $request->supplier;
		$update->lpo_number       = $request->lpo_number;
		$update->expense_category = $request->expense_category;
		$update->reference_number = $request->reference_number;
		$update->title				  = $request->title; 
		$update->lpo_date	        = $request->lpo_date;
		$update->lpo_due	        = $request->lpo_due;
		$update->customer_note	  = $request->customer_note;
		$update->terms				  = $request->terms;
		$update->businessID 		  = Auth::user()->businessID;
		$update->save(); 


		//delete product
		$delete = lpo_products::where('lpoID', $id);
		$delete->delete();

		//new products
		$products				      = $request->productID;
		foreach ($products as $k => $v){

			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;			
			$totalAmount = $amount + $taxvalue;

			$product 					= new lpo_products;
			$product->lpoID   		= $id;
			$product->productID		= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue; 
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;			
			$product->price         = $request->price[$k];
			$product->businessID  	= Auth::user()->businessID;
			$product->save();
		}

		//get invoice products
		$lpoProducts = lpo_products::where('lpoID',$id)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update invoice 
		$lpo = lpo::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$lpo->main_amount  =  $lpoProducts->mainAmount;
		$lpo->discount     = $lpoProducts->discount;
		$lpo->total		    = $lpoProducts->total;
		$lpo->sub_total	 = $lpoProducts->sub_total; 
		$lpo->taxvalue	    = $lpoProducts->taxvalue; 
		$lpo->save();
		

		//recored activity
		$activities = 'Purchase Order #'.Finance::invoice_settings()->prefix.$update->lpo_number.' has been updated by '.Auth::user()->name;
		$section = 'Purchase Order';
		$type = 'Update';
		$adminID = Auth::user()->id;
		$activityID = $id;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Purchase Order has been successfully created');

		return redirect()->back();
	}

	/**
   * show lpo
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($id){
		$count = 1;
		$filec = 1;
		$lpo = lpo::join('business','business.id','=','purchaseorders.businessID')
						->join('currency','currency.id','=','business.base_currency')
						->join('purchaseorder_settings','purchaseorder_settings.businessID','=','business.id')
						->join('status','status.id','=','purchaseorders.statusID')
						->where('purchaseorders.id',$id)
						->where('purchaseorders.businessID',Auth::user()->businessID)
						->select('*','purchaseorders.id as lpoID','business.name as businessName','business.businessID as business_code')
						->first();

		$products = lpo_products::where('lpoID',$lpo->lpoID)->get();

		$supplier = suppliers::join('supplier_address','supplier_address.supplierID','=','suppliers.id')
						->where('suppliers.businessID',Auth::user()->businessID)
						->where('suppliers.id',$lpo->supplierID)
						->select('*','suppliers.id as supplierID')
						->first();

		$files = docs::where('fileID',$id)->where('folder','Purchase orders')->where('businessID',Auth::user()->businessID)->get();

		$persons = contact_persons::where('supplierID',$supplier->supplierID)->get();

		$template = Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name;

		return view('app.finance.purchaseorders.show', compact('supplier','lpo','products','count','filec','files','persons','template'));
	}


	/**
   * generate lpo pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function pdf($id){
		$count = 1;
		$details = lpo::join('vendors','vendors.id','=','purchaseorders.vendorID')
						->join('business','business.id','=','purchaseorders.businessID')
						->join('currency','currency.id','=','business.base_currency')
						->join('purchaseorder_settings','purchaseorder_settings.businessID','=','purchaseorders.businessID')
						->join('status','status.id','=','purchaseorders.statusID')
						->where('purchaseorders.id',$id)
						->where('purchaseorders.businessID',Auth::user()->businessID)
						->select('*','purchaseorders.id as lpoID','business.name as businessName','business.businessID as business_code')
						->first();

		$products = lpo_products::where('lpoID',$details->lpoID)->get();

		$vendor = vendors::join('vendor_address','vendor_address.vendorID','=','vendors.id')
							->where('vendors.id',$details->vendorID)
							->where('businessID',Auth::user()->businessID)
							->select('*','vendors.id as vendorID')
							->first();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/lpo', compact('products','details','vendor','taxed','count'));

		return $pdf->download(Finance::lpo()->prefix.$details->lpo_number.'.pdf');
	}

	/**
	* print lpo
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function print($id){
		$count = 1;
		$details = lpo::join('business','business.id','=','purchaseorders.businessID')
						->join('currency','currency.id','=','business.base_currency')
						->join('purchaseorder_settings','purchaseorder_settings.businessID','=','business.id')
						->join('status','status.id','=','purchaseorders.statusID')
						->where('purchaseorders.id',$id)
						->where('purchaseorders.businessID',Auth::user()->businessID)
						->select('*','purchaseorders.id as lpoID','business.name as businessName','business.businessID as business_code')
						->first();

		$supplier = suppliers::join('supplier_address','supplier_address.supplierID','=','suppliers.id')
						->where('suppliers.businessID',Auth::user()->businessID)
						->where('suppliers.id',$details->supplierID)
						->select('*','suppliers.id as supplierID')
						->first();

		$products = lpo_products::where('lpoID',$details->lpoID)->get();

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/lpo/lpo', compact('products','details','supplier','count'));

		return $pdf->stream(Finance::lpo()->prefix.$details->lpo_number.'.pdf');
	}

	/**
	* attachment lpo
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$lpo = lpo::where('id',$request->lpoID)->where('businessID',Auth::user()->businessID)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/lpo/';

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

      $upload->fileID      = $request->lpoID;
		$upload->folder 	   = 'Finance';
		$upload->section 	   = 'Purchase orders';
		$upload->name 		   = Finance::lpo()->prefix.$lpo->lpo_number;
		$upload->file_name   = $filename;
      $upload->file_size   = $size;
		$upload->attach 	   = 'No';
      $upload->file_mime   = $file->getClientMimeType();
		$upload->created_by  = Auth::user()->id;
		$upload->businessID  = Auth::user()->businessID;
      $upload->save();
	}


	/**
	* update file status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/

	public function update_file_status($status,$file){
		$file = docs::find($file);
		$file->status = $status;
		$file->save();
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
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/lpo/';

		$delete = $directory.$file->file_name;
		if (File::exists($delete)) {
			unlink($delete);
		}

		$file->delete();

		Session::flash('success','File Deleted');

		return redirect()->back();
	}


	/**
	* 	show mailing section
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function mail($id){
		$lpo = lpo::join('vendors','vendors.id','=','purchaseorders.vendorID')
						->join('business','business.id','=','purchaseorders.businessID')
						->join('currency','currency.id','=','business.base_currency')
						->join('purchaseorder_settings','purchaseorder_settings.businessID','=','purchaseorders.businessID')
						->join('status','status.id','=','purchaseorders.statusID')
						->where('purchaseorders.id',$id)
						->where('purchaseorders.businessID',Auth::user()->businessID)
						->select('*','purchaseorders.id as lpoID','business.name as businessName')
						->first();

		$vendor = vendors::join('vendor_address','vendor_address.vendorID','=','vendors.id')
							->where('vendors.id',$lpo->vendorID)
							->where('vendors.businessID',Auth::user()->businessID)
							->select('*','vendors.id as vendorID')
							->first();

		$files = docs::where('parentid',$id)->where('section','Purchase orders')->get();

		$contacts = contact_persons::where('vendorID',$vendor->vendorID)->get();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/lpo/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		} 

		$count = 1;
		$details = lpo::where('id',$id)->where('businessID',Auth::user()->businessID)->select('*','lpo_number as number')->first();
		$products = lpo_products::where('lpoID',$details->id)->get();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/lpo', compact('products','details','vendor','taxed','count'));

		$pdf->save($directory.Finance::lpo()->prefix.$details->lpo_number.'.pdf');

		return view('app.finance.purchaseorders.mail', compact('lpo','files','contacts','vendor'));
	}

	/**
	* 	send lpo via email
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

		//lpo information
		$lpo = lpo::find($request->lpoID);

		//client info
		$client = vendors::join('vendor_address','vendor_address.vendorID','=','vendors.id')
							->where('vendors.id',$lpo->vendorID)
							->select('*','vendors.id as vendorID')
							->first();

		$checkatt = count(collect($request->attach_files));
		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('section','Purchase orders')->where('parentid',$lpo->id)->where('businessID',Auth::user()->businessID)->get();
			foreach ($filechange as $fc) {
				$null = docs::find($fc->id);
				$null->status = "No";
				$null->save();
			}

			for($i=0; $i < count($request->attach_files); $i++ ) {

				$sendfile = docs::find($request->attach_files[$i]);
				$sendfile->status = "Yes";
				$sendfile->save();
			}
		}else{
			$chage = docs::where('section','Purchase orders')->where('parentid',$lpo->id)->where('businessID',Auth::user()->businessID)->get();
			foreach ($chage as $cs) {
				$null = docs::find($cs->id);
				$null->status = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
		$emails = new emails;
		$emails->message   = $request->message;
		$emails->clientID  = $client->vendorID;
		$emails->subject   = $request->subject;
		$emails->mail_from = $request->email_from;
		if($checkatt > 0){
			$emails->attachment = json_encode($request->get('files'));
		}
		$emails->category  = 'Purchase orders Document';
		$emails->status    = 'Sent';
		$emails->ip 		 = Helper::get_client_ip();
		$emails->type      = 'Outgoing';
		$emails->section   = 'Purchase orders';
		$emails->mail_to   = $request->send_to;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
		$emails->save();

		//update lpo
		$lpo->statusID = 6;
		$lpo->save();

		//send email
		$subject = $request->subject;
		$content = $request->message;
		$from = $request->email_from;
		$to = $request->send_to;
		$mailID = $emails->id;
		$doctype = 'Purchase orders';
		$docID = $lpo->id; //lpo ID

		if($request->attaches == 'Yes'){
			$attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/lpo/'.Finance::lpo()->prefix.$lpo->lpo_number.'.pdf';
		}else{
			$attachment = 'No';
		}


		Mail::to($to)->send(new sendLpo($content,$subject,$from,$mailID,$docID,$doctype,$attachment));

		//recorord activity
		$activities = 'Purchase orders #'.Finance::lpo()->prefix.$lpo->lpo_number.' has been sent to the client by '.Auth::user()->name;
		$section = 'Purchase orders';
		$type = 'Sent';
		$adminID = Auth::user()->id;
		$activityID = $request->lpoID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Purchase orders Sent to client successfully');

		return redirect()->back();


	}

	/**
	* 	change lpo status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function change_status($lpoID,$status){
		$lpo = lpo::where('id',$lpoID)->where('businessID',Auth::user()->businessID)->first();
		$lpo->statusID = $status; 
		$lpo->save();

		//recorord activity
		$activities = 'lpo #'.Finance::lpo()->prefix.$lpo->lpo_number.' status has been updated by '.Auth::user()->name;
		$section = 'lpo';
		$type = 'update';
		$adminID = Auth::user()->id;
		$activityID = $lpoID; 
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','lpo status successfully changed');
		return redirect()->back();
	}

	/**
	* 	change lpo status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function convert_to_invoice($lpoID){
		$lpo = lpo::find($lpoID);

		//create invoice
		$invoice = new lpo;
		$invoice->admin_id = $lpo->admin_id;
		$invoice->vendorID = $lpo->vendorID;
		$invoice->currencyID = $lpo->currencyID;
		$invoice->invoice_number = Finance::invoice_settings()->invoice_number + 1;
		$invoice->sub_total = $lpo->sub_total;
		$invoice->total = $lpo->total;
		$invoice->discount = $lpo->discount;
		$invoice->discount_type = $lpo->discount_type;
		$invoice->invoice_date = $lpo->lpo_date;
		$invoice->invoice_due = $lpo->lpo_due;
		$invoice->tax = $lpo->tax;
		$invoice->statusID = 2;
		$invoice->businessID = $lpo->businessID;
		$invoice->invoice_type = 'Random';
		$invoice->save();


		//create products
		$estprod = lpo_products::where('lpoID',$lpoID)->get();
		foreach($estprod as $product){
			$invoprod = new lpo_products;
			$invoprod->invoiceID = $invoice->id;
			$invoprod->product_name = $product->product_name;
			$invoprod->quantity = $product->quantity;
			$invoprod->price = $product->price;
			$invoprod->save();
		}

		//link lpo to invoice
		$lpo->invoice_link = $invoice->id;
		$lpo->statusID = 13;
		$lpo->save();

		//update invoice number settings
		$invoice_settings = settings::where('businessID',Auth::user()->businessID)->first();
		$invoice_settings->invoice_number = $invoice_settings->invoice_number + 1;
		$invoice_settings->save();


		//recorord activity
		$activities = 'Purchase orders #'.Finance::lpo()->prefix.$lpo->lpo_number.' had been converted to a bill by '.Auth::user()->name;
		$section = 'Purchase orders';
		$type = 'Convert';
		$adminID = Auth::user()->id;
		$activityID = $lpoID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','lpo has been successfully converted');

		return redirect()->back();
	}

	/**
	* 	delete lpo permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_lpo($lpoID){
		$lpo = lpo::where('id',$lpoID)->where('businessID',Auth::user()->businessID)->first();
		if($lpo->expenseID == ""){
			//delete all files linked to the lpo
			$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/lpo/';

			$check_files = docs::where('parentid',$lpoID)->where('section','lpo')->count();

			if($check_files > 0){
				$files = docs::where('fileID',$lpoID)->where('section','lpo')->where('businessID',Auth::user()->businessID)->get();
				foreach($files as $file){
					$doc = docs::where('id',$file->id)->where('section','lpo')->where('businessID',Auth::user()->businessID)->first();

					//create directory if it doesn't exists
					$delete = $directory.$doc->file_name;
					if (File::exists($delete)) {
						unlink($delete);
					}

					$doc->delete();
				}
			}

			//delete lpo products
			lpo_products::where('lpoID',$lpoID)->delete();

			//delete lpo plus attachment
			
			if($lpo->attachment != ""){
				$delete = $directory.$lpo->attachment;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}
			$lpo->delete();

			//recorord activity
			$activities = 'lpo #'.Finance::lpo()->prefix.$lpo->lpo_number.' had been deleted by '.Auth::user()->name;
			$section = 'lpo';
			$type = 'Delete';
			$adminID = Auth::user()->id;
			$activityID = $lpoID;
			$businessID = Auth::user()->businessID;

			Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

			Session::flash('success','lpo has been successfully deleted');

			return redirect()->route('finance.lpo.index');
		}else{
			Session::flash('warning','This purchase order has been linked to an expense, you will have to unlink it first then delete the purchase order');

			return redirect()->back();
		}
		
	}

	public function convert($id){
		$lpo = lpo::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		
		$expense = new expense;
      $expense->date              =  date('Y-m-d');
      $expense->expense_name      =  'Purchase order converted to expense';
      $expense->expense_category  =  $lpo->expense_category;
      $expense->amount            =  $lpo->main_amount;
		$expense->supplierID        =  $lpo->supplierID; 
		$expense->statusID          =  2;
      $expense->expence_type      =  'expense';
      $expense->created_by        =  Auth::user()->id;
      $expense->businessID        =  Auth::user()->businessID;
		$expense->save();
		
		//update po
		$lpo->expenseID = $expense->id;
		$lpo->save();

		//record activity
		$activities = 'Purchase order converted to expense by'.Auth::user()->name;
		$section = 'Expense';
		$type = 'expense';
		$adminID = Auth::user()->id;
		$activityID = $expense->id;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','expense added successfully');

		return redirect()->route('finance.expense.index');
	}
}
