<?php
namespace App\Http\Controllers\app\property\accounting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\creditnote\creditnote_settings;
use App\Models\property\creditnote\creditnote;
use App\Models\property\creditnote\creditnote_products;
use App\Models\property\invoice\invoices;
use App\Models\property\lease;
use App\Models\property\tenants\tenants;
use App\Models\wingu\business;
use App\Models\property\property;
use App\Models\wingu\status;
use App\Models\finance\tax;
use App\Models\crm\emails;
use App\Mail\sendLpo;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Property as prop;
use Auth;
use PDF;
use Mail;
use DB;

class creditnoteController extends Controller
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
		$creditnotes	= creditnote::join('business','business.id','=','property_creditnote.businessID')
								->join('currency','currency.id','business.base_currency')
								->join('status','status.id','=','property_creditnote.statusID')
								->join('property_tenants','property_tenants.id','=','property_creditnote.tenantID')
								->where('property_creditnote.businessID',Auth::user()->businessID)
								->where('property_creditnote.propertyID',$propertyID)
								->select('*','property_creditnote.id as creditnoteID','status.name as statusName')
								->orderby('property_creditnote.id','desc')
								->get();

			$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

			$count = 1;

			return view('app.property.accounting.creditnote.index', compact('creditnotes','property','propertyID'));
	}

   /**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
   public function create($propertyID)
   {
		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

		$check = creditnote_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->count();
		if($check != 1){
			Prop::make_creditnote_settings($propertyID);
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

		$settings = creditnote_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();
		$taxes = tax::where('businessID',Auth::user()->businessID)->get();

		return view('app.property.accounting.creditnote.create', compact('tenants','taxes','property','settings','propertyID'));
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
			'creditnote_date'  => 'required',
			'leaseID'  => 'required',
			'creditnote_date'  => 'required',
		));

		$leaseInfo = lease::where('property_lease.propertyID',$propertyID)
								->where('property_lease.businessID',Auth::user()->businessID)  
								->where('property_lease.tenantID',$request->tenant) 
								->where('id',$request->leaseID)
								->first();

		$code = Helper::generateRandomString(16);

		//store invoice
		$store					     = new creditnote;
		$store->created_by	     = Auth::user()->id;
		$store->tenantID	   	  = $request->tenant;
		$store->title	           = $request->title;
		$store->leaseID           = $request->leaseID;
		$store->unitID            = $leaseInfo->unitID;
		$store->creditnote_number = $request->creditnote_number;
		$store->creditnote_prefix = $request->creditnote_prefix;
		$store->creditnote_date	  = $request->creditnote_date;
		$store->customer_note	  = $request->customer_note;
		$store->terms				  = $request->terms;
		$store->propertyID        = $propertyID;
		$store->statusID		     = 21;
		$store->credit_code 	     = $code;
		$store->businessID 		  = Auth::user()->businessID;
		$store->save();

		//products
		$products				= $request->product_name;

		foreach($products as $k => $v){
			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k]);

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;
			
			$totalAmount = $amount + $taxvalue;

			$product 					= new creditnote_products;
			$product->creditnoteID		= $store->id;
			$product->propertyID		= $propertyID;
			$product->item_name		= $request->product_name[$k];
			$product->quantity		= $request->qty[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue; 
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->businessID  	= Auth::user()->businessID; 
			$product->price         = $request->price[$k];
			$product->save();
		}

		//get invoice products
		$creditnoteProducts = creditnote_products::where('creditnoteID',$store->id)
								->select(DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update creditnote 
		$creditnote = creditnote::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
		$creditnote->main_amount = $creditnoteProducts->mainAmount;
		$creditnote->total		 = $creditnoteProducts->total;
		$creditnote->balance		 = $creditnoteProducts->total;
		$creditnote->sub_total   = $creditnoteProducts->sub_total; 
		$creditnote->taxvalue	 = $creditnoteProducts->taxvalue; 
		$creditnote->save();
		
		//invoice setting
		$crednoteSettings  = creditnote_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();
		$crednoteSettings->number	=  $crednoteSettings->number + 1;
		$crednoteSettings->save();

		Session::flash('success','creditnote has been successfully created');

		return redirect()->route('property.creditnote.index',$propertyID);

   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($propertyID,$id)
   {
		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

		$creditnote = creditnote::where('id',$id)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();


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

		$tenant = tenants::join('property_lease','property_lease.tenantID','=','property_tenants.id')
						->join('property','property.leaseID','=','property_lease.id')
						->where('property_tenants.businessID',Auth::user()->businessID)
						->where('property_tenants.id',$creditnote->tenantID)
						->select('property.serial as serial','tenant_name as tenant_name')
						->first();

		$taxes = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();

      $creditProducts = creditnote_products::where('creditnoteID',$id)->where('businessID',Auth::user()->businessID)->get();
		$count = 1;

		if($creditnote->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $creditnote->sub_total * ($creditnote->tax / 100);
		}

		return view('app.property.accounting.creditnote.edit', compact('property','tenants','taxed','count','taxes','creditnote','creditProducts','tenant','propertyID'));
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request,$propertyID,$id)
   {
		$this->validate($request, array(
			'tenantID'    	  => 'required',
			'leaseID'  => 'required',
			'creditnote_date'  => 'required',
		));

		$update	= creditnote::where('id',$id)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();

		$creditnoteSetting = creditnote_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();

		//delete old product
		creditnote_products::where('creditnoteID',$id)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->delete();

		//add new products
		$products	= $request->product_name;
		foreach ($products as $k => $v){
			
			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k]);

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;
			
			$totalAmount = $amount + $taxvalue;

			$product 					= new creditnote_products;
			$product->creditnoteID	= $update->id;
			$product->item_name		= $request->product_name[$k];
			$product->quantity		= $request->qty[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue; 
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->businessID  	= Auth::user()->businessID;
			$product->price         = $request->price[$k];
			$product->propertyID    = $propertyID;
			$product->save();
		}
			
		//get invoice products
		$creditProducts = creditnote_products::where('creditnoteID',$id)
								->select(DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update invoice 
		if($update->credit_code == "") {
			$code = Helper::generateRandomString(16);
			$update->credit_code = $code;
		}
		$update->main_amount   = $creditProducts->mainAmount;
		$update->total		     = $creditProducts->total;
		$update->balance		  = $creditProducts->total - $update->paid;
		$update->sub_total	  = $creditProducts->sub_total; 
		$update->taxvalue	     = $creditProducts->taxvalue;  
		$update->updated_by	  = Auth::user()->id;
		$update->title = $request->title;
		if($update->creditnote_prefix == ""){
			$update->creditnote_prefix = $creditnoteSetting->prefix;
		}
		$update->tenantID	     = $request->tenantID;
		$update->creditnote_date  = $request->creditnote_date;
		$update->customer_note = $request->customer_note;
		$update->terms			  = $request->terms;
		$update->leaseID       = $request->leaseID;
		$update->propertyID    = $propertyID;
		$update->businessID 	  = Auth::user()->businessID;
		$update->save();

      //recored activity
      $activities = 'Credit note has been updated by '.Auth::user()->name;
      $section = 'Property Credit note';
      $type = 'update';
      $adminID = Auth::user()->id;
      $activityID = $id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Credit note has been successfully updated');

    	return redirect()->back();
	}

	/**
   * show creditnote
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($propertyID,$id){
		$count = 1;

		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

		$show = creditnote::join('business','business.id','=','property_creditnote.businessID')
								->join('property_tenants','property_tenants.id','=','property_creditnote.tenantID')
								->join('property_tenant_address','property_tenant_address.tenantID','=','property_creditnote.tenantID')
								->join('currency','currency.id','business.base_currency')
								->join('status','status.id','=','property_creditnote.statusID')
								->where('property_creditnote.businessID',Auth::user()->businessID)
								->where('property_creditnote.id',$id)
								->where('property_creditnote.propertyID',$propertyID)
								->select('*','property_creditnote.id as creditnoteID','status.name as statusName','business.name as businessName','business.website as business_website','business.businessID as business_code')
								->first();

		$products = creditnote_products::where('creditnoteID',$id)->where('businessID',Auth::user()->businessID)->get();

		if($show->paymentID != ""){
			$products = creditnote_products::where('creditnoteID',$show->creditnoteID)->where('businessID',Auth::user()->businessID)->get();
		}
						

		if($show->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $show->sub_total * ($show->tax / 100);
		}

		//check if user has pending invoice
		$checkOpenInvoices = invoices::where('statusID','!=',1)
									->where('tenantID',$show->tenantID)
									->whereNull('credited')
									->where('businessID',Auth::user()->businessID)
									->count();

		$invoices = invoices::join('property_invoice_settings','property_invoice_settings.businessID','=','property_invoices.businessID')
					->join('business','business.id','=','property_invoices.businessID')
					->join('currency','currency.id','business.base_currency')
					->where('statusID','!=',1)
					->where('tenantID',$show->tenantID)
					->whereNull('credited')
					->where('property_invoices.businessID',Auth::user()->businessID)
					->select('*','property_invoices.id as invoID')
					->get();

		$template = Wingu::template($show->templateID)->template_name;

		return view('app.property.accounting.creditnote.show', compact('show','products','taxed','checkOpenInvoices','invoices','template','property','count','propertyID'));
	}


	/**
   * generate creditnote pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function pdf($id){
		$count = 1;
		$details = creditnote::join('business','business.id','=','creditnote.businessID')
						->join('currency','currency.id','business.base_currency')
						->join('property_creditnote_settings','creditnote_settings.businessID','=','business.id')
						->join('status','status.id','=','creditnote.statusID')
						->where('creditnote.businessID',Auth::user()->businessID)
						->where('creditnote.id',$id)
						->select('*','creditnote.id as creditnoteID','status.name as statusName','creditnote_number as number','business.name as businessName','business.businessID as business_code')
						->first();

		$products = creditnote_products::where('creditnoteID',$details->creditnoteID)->get();
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$details->customerID)
							->where('businessID',Auth::user()->businessID)
							->select('*','customers.id as clientID')
							->first();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/creditnote/creditnote', compact('products','details','client','taxed','count'));

		return $pdf->download(Finance::creditnote()->prefix.$details->creditnote_number.'.pdf');

	}

	/**
	* print creditnote
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function print($id){
		$count = 1;
		$details = creditnote::join('business','business.id','=','creditnote.businessID')
						->join('currency','currency.id','business.base_currency')
						->join('property_creditnote_settings','creditnote_settings.businessID','=','business.id')
						->join('status','status.id','=','creditnote.statusID')
						->where('creditnote.businessID',Auth::user()->businessID)
						->where('creditnote.id',$id)
						->select('*','creditnote.id as creditnoteID','status.name as statusName','creditnote_number as number','business.name as businessName','business.businessID as business_code')
						->first(); 

		$products = creditnote_products::where('creditnoteID',$details->creditnoteID)->get();

		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$details->customerID)
							->where('businessID',Auth::user()->businessID)
							->select('*','customers.id as clientID')
							->first();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/creditnote/creditnote', compact('products','details','client','taxed','count'));

		return $pdf->stream(Finance::creditnote()->prefix.$details->creditnote_number.'.pdf');
	}

	/**
	* attachment creditnote
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$creditnote = creditnote::where('id',$request->creditnoteID)->where('businessID',Auth::user()->businessID)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/creditnote/';

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
      $upload->fileID      = $request->creditnoteID;
		$upload->folder 	   = 'Property';
		$upload->section 	   = 'creditnote';
		$upload->name 		   = Finance::creditnote()->prefix.$creditnote->creditnote_number;
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
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/creditnote/';

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
		$details = creditnote::join('business','business.id','=','creditnote.businessID')
						->join('currency','currency.id','business.base_currency')
						->join('property_creditnote_settings','creditnote_settings.businessID','=','business.id')
						->join('status','status.id','=','creditnote.statusID')
						->where('creditnote.businessID',Auth::user()->businessID)
						->where('creditnote.id',$id)
						->select('*','creditnote.id as creditnoteID','status.name as statusName','creditnote_number as number','business.name as businessName')
						->first();

		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$details->customerID)
							->where('customers.businessID',Auth::user()->businessID)
							->select('*','customers.id as clientID')
							->first();

		$files = docs::where('fileID',$id)->where('section','creditnote')->where('businessID',Auth::user()->buinessID)->get();
		$contacts = contact_persons::where('customerID',$client->clientID)->get();

		$count = 1;
		
		$products = creditnote_products::where('creditnoteID',$details->creditnoteID)->get();

		if($details->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $details->sub_total * ($details->tax / 100);
		}

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/creditnote/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/creditnote/creditnote', compact('products','details','client','taxed','count'));

		$pdf->save($directory.Finance::creditnote()->prefix.$details->creditnote_number.'.pdf');

		return view('app.property.accounting.creditnote.mail', compact('details','files','contacts','client'));
	}

	/**
	* 	send creditnote via email
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

		//creditnote information
		$creditnote = creditnote::where('id',$request->creditnoteID)->where('businessID',Auth::user()->businessID)->first();

		//client info
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$creditnote->customerID)
							->select('*','customers.id as clientID')
							->first();

		$checkatt = count(collect($request->attach_files));
		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('section','creditnote')->where('fileID',$creditnote->id)->where('businessID',Auth::user()->businessID)->get();
			foreach ($filechange as $fc) {
				$null = docs::where('id',$fc->id)->where('businessID',Auth::user()->businessID)->first();
				$null->attach = "No";
				$null->save();
			}

			for($i=0; $i < count($request->attach_files); $i++ ) {

				$sendfile = docs::where('id',$request->attach_files[$i])->where('businessID',Auth::user()->businessID)->first();
				$sendfile->attach = "Yes";
				$sendfile->save();
			}
		}else{
			$chage = docs::where('section','creditnote')->where('fileID',$creditnote->id)->where('businessID',Auth::user()->businessID)->get();
			foreach ($chage as $cs) {
				$null = docs::where('id',$cs->id)->where('businessID',Auth::user()->businessID)->first();;
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
		$emails = new emails;
		$emails->message   = $request->message;
		$emails->clientID  = $client->clientID;
		$emails->subject   = $request->subject;
		$emails->mail_from = $request->email_from;
		if($checkatt > 0){
			$emails->attachment = json_encode($request->get('files'));
		}
		$emails->category  = 'creditnote Document';
		$emails->status    = 'Sent';
		$emails->ip 		 = Helper::get_client_ip();
		$emails->type      = 'Outgoing';
		$emails->section   = 'creditnote';
		$emails->mail_to   = $request->send_to;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
		$emails->save();

		$creditnote->save();

		//send email
		$subject = $request->subject;
		$content = $request->message;
		$from = $request->email_from;
		$to = $request->send_to;
		$mailID = $emails->id;
		$doctype = 'creditnote';
		$docID = $creditnote->id; //creditnote ID

		if($request->attaches == 'Yes'){
			$attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/creditnote/'.Finance::creditnote()->prefix.$creditnote->creditnote_number.'.pdf';
		}else{
			$attachment = 'No';
		}


		Mail::to($to)->send(new sendLpo($content,$subject,$from,$mailID,$docID,$doctype,$attachment));

		//recorord activity
		$activities = 'creditnote #'.Finance::creditnote()->prefix.$creditnote->creditnote_number.' has been sent to the client by '.Auth::user()->name;
		$section = 'creditnote';
		$type = 'Sent';
		$adminID = Auth::user()->id;
		$activityID = $request->creditnoteID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','creditnote Sent to client successfully');

		return redirect()->back();


	}

	/**
	* 	change creditnote status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function change_status($creditnoteID,$status){
		$creditnote = creditnote::where('id',$creditnoteID)->where('businessID',Auth::user()->businessID)->first();
		$creditnote->statusID = $status;
		$creditnote->save();

		//recorord activity
		$activities = 'creditnote #'.Finance::creditnote()->prefix.$creditnote->creditnote_number.' status has been updated by '.Auth::user()->name;
		$section = 'creditnote';
		$type = 'update';
		$adminID = Auth::user()->id;
		$activityID = $creditnoteID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','creditnote status successfully changed');
		return redirect()->back();
	}


	/**
	* 	apply credit to invoice
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function apply_credit(Request $request){

		$credits = count(collect($request->invoiceID));
		$date = date("Y-m-d");

 		//contact persons
		if($credits > 0){
			if(isset($_POST['invoiceID'])){
				for($i=0; $i < count($request->invoiceID); $i++ ) {
					//credit note
					$creditnote = creditnote::where('businessID',Auth::user()->businessID)->where('id',$request->creditnoteID[$i])->first();					

					if($creditnote->balance != 0){
						//update invoice
						$invoice = creditnote::where('businessID',Auth::user()->businessID)->where('id',$request->invoiceID[$i])->first();

						//check if credited amount is greater than available amount
						if($request->credit[$i] >= $creditnote->balance){
							$newPayment = $invoice->paid + $creditnote->balance;
							$invoice->balance = $invoice->total - $newPayment;
							$invoice->paid = $newPayment;
							//update status
							if($newPayment == $invoice->total || $newPayment > $invoice->total){
								$invoice->statusID = 1;
							}elseif($newPayment < $invoice->total && $newPayment != 0 ){
								$invoice->statusID = 3;
							}
							
							$invoice->credited = 'Yes';
							$invoice->save();
						}elseif($request->credit[$i] < $creditnote->balance){
							
							$newPayment = $invoice->paid + $request->credit[$i];
							$invoice->balance = $invoice->total - $newPayment;
							$invoice->paid = $newPayment;
							//update status
							if($newPayment == $invoice->total || $newPayment > $invoice->total){
								$invoice->statusID = 1;
							}elseif($newPayment < $invoice->total && $newPayment != 0 ){
								$invoice->statusID = 3;
							}
							
							$invoice->credited = 'Yes';
							$invoice->save();
						}					

						//record payment
						$pay = new invoice_payments;
						$pay->amount = $request->credit[$i];
						$pay->balance = $invoice->total - $invoice->paid;
						$pay->payment_category = 'Credited'; 
						$pay->payment_date = $date;
						$pay->invoiceID = $request->invoiceID[$i];
						$pay->created_by = Auth::user()->id;
						$pay->businessID = Auth::user()->businessID;
						$pay->customerID = $creditnote->customerID;
						$pay->save();

						$creditnote->balance = $creditnote->balance - $request->credit[$i];
						if($pay->balance == 0){
							$creditnote->statusID = 22;
						}
						$creditnote->save();

						Finance::flow($request->invoiceID[$i],$pay->id,'Credit');
					}
				}
			}else{
				return redirect()->back();
			}
		}

		Session::flash('success','Credit note applied');

		return redirect()->back();
	}


	/**
	* 	delete creditnote permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_creditnote($creditnoteID){
		$creditnote = creditnote::where('id',$creditnoteID)->where('businessID',Auth::user()->businessID)->first();

		$invoiceCredit = invoice_creditnote::where('creditID',$creditnoteID)
                                 ->where('businessID',Auth::user()->businessID)
											->count();
											
      if($creditnote->statusID != 22 && $invoiceCredit == 0){
			//delete all files linked to the creditnote
			$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/creditnote/';

			$check_files = docs::where('fileID',$creditnoteID)->where('section','creditnote')->where('businessID',Auth::user()->businessID)->count();

			if($check_files > 0){
				$files = docs::where('fileID',$creditnoteID)->where('section','creditnote')->get();
				foreach($files as $file){
					$doc = docs::where('id',$file->id)->where('businessID',Auth::user()->businessID)->first();

					//create directory if it doesn't exists
					$delete = $directory.$doc->file_name;
					if (File::exists($delete)) {
						unlink($delete);
					}

					$doc->delete();
				}
			}

			//delete creditnote products
			$delete_products = creditnote_products::where('creditnoteID',$creditnoteID)->delete();

			//delete creditnote plus attachment
			$creditnote = creditnote::where('id',$creditnoteID)->where('businessID',Auth::user()->businessID)->first();
			if($creditnote->attachment != ""){
				$delete = $directory.$creditnote->attachment;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}
			$creditnote->delete();

			//recorord activity
			$activities = 'creditnote #'.Finance::creditnote()->prefix.$creditnote->creditnote_number.' had been deleted by '.Auth::user()->name;
			$section = 'creditnote';
			$type = 'Delete';
			$adminID = Auth::user()->id;
			$activityID = $creditnoteID;
			$businessID = Auth::user()->businessID;

			Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

			Session::flash('success','creditnote has been successfully deleted');

			return redirect()->route('finance.creditnote.index');
		}else{
         Session::flash('error','You have recorded transactions for this credit note. Hence, this credit note cannot be deleted.');

			return redirect()->back();
      }
	}
}
 