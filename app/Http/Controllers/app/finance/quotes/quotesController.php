<?php

namespace App\Http\Controllers\app\finance\quotes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\quotes\quotes;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\quotes\quote_products;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\quotes\quote_settings as settings;
use App\Models\finance\products\product_information;
use App\Models\wingu\file_manager as docs;
use App\Models\finance\tax;
use App\Models\finance\currency;
use App\Models\crm\emails;
use App\Mail\sendQuotes;
use Session;
use File;
use Helper;
use Finance;
use DB;
use Wingu;
use Auth;
use PDF;
use Mail;

class quotesController extends Controller
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
		$quotes	= quotes::join('business','business.id','=','quotes.businessID')
						->join('currency','currency.id','=','business.base_currency')
						->join('quote_settings','quote_settings.businessID','=','business.id')
						->join('customers','customers.id','=','quotes.customerID')
						->join('status','status.id','=','quotes.statusID')
						->where('quotes.businessID',Auth::user()->businessID)
						->select('*','quotes.id as quotesID','quotes.created_at as quote_date','quotes.reference_number as reff','quotes.statusID as qstatus')
						->orderby('quotes.id','desc')
						->get();
			return view('app.finance.quotes.index', compact('quotes'));
	}

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
   {
		//check if account has settings
		$check = settings::where('businessID',Auth::user()->businessID)->count();
		if($check != 1){
			Finance::quote_setting_setup();
		}

      $customers = customers::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
      $products = product_information::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
      $taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
      return view('app.finance.quotes.create', compact('customers','taxs','products'));
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
			'customer'	=> 'required',
			'quote_number'	=> 'required',
			'quote_date'	=> 'required',
			'quote_due'	=> 'required',
		));

		//store invoice
		$code = Helper::generateRandomString(16);
		$store					    = new quotes;
		$store->created_by		 = Auth::user()->id;
		$store->customerID	 	 = $request->customer;
		$store->quote_number	    = $request->quote_number;
      $store->subject	    	 = $request->subject;
      $store->quote_code 	    = $code;
		$store->description	    = $request->description;
		$store->reference_number = $request->reference_number;
		$store->quote_date	    = $request->quote_date;
		$store->quote_due			= $request->quote_due;
		$store->customer_note	= $request->customer_note;
		$store->taxconfig			= $request->taxconfig;
		$store->terms				= $request->terms;
		$store->statusID			= 10;
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

			$product 					= new quote_products;
			$product->quoteID		   = $store->id;
			$product->productID		= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue;
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->price         = $request->price[$k];
			$product->save();
		}

		//get invoice products
		$quoteProducts = quote_products::where('quoteID',$store->id)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update invoice
		$quote = quotes::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
		$quote->main_amount =  $quoteProducts->mainAmount;
		$quote->discount    = $quoteProducts->discount;
		$quote->total		  = $quoteProducts->total;
		$quote->sub_total	= $quoteProducts->sub_total;
		$quote->taxvalue	= $quoteProducts->taxvalue;
		$quote->save();

		//update quotes number
		$setting = settings::where('businessID',Auth::user()->businessID)->first();
		$setting->number = $setting->number + 1;
		$setting->save();

		Session::flash('success','quotes has been successfully created');

		return redirect()->route('finance.quotes.index');

   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {

		$quote = quotes::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$customers = customers::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$customer = customers::where('id',$quote->customerID)->where('businessID',Auth::user()->businessID)->first();
		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$currency = currency::find($quote->currency_id);
      $quoteproducts = quote_products::where('quoteID',$id)->get();
      $products = product_information::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$count = 1;

		if($quote->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $quote->sub_total * ($quote->tax / 100);
		}

		return view('app.finance.quotes.edit', compact('customer','customers','taxed','count','quote','products','quoteproducts','taxs'));
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
			'customer'	=> 'required',
			'quote_number'	=> 'required',
			'quote_date'	=> 'required',
			'quote_due'	=> 'required',
		));

		$update	= quotes::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		//delete product
		$delete = quote_products::where('quoteID', $id);
		$delete->delete();

		//new products
		$products				= $request->productID;
		foreach ($products as $k => $v){

			$mainAmount = $request->price[$k] * $request->qty[$k];
			$amount = ($request->price[$k] * $request->qty[$k])-$request->discount[$k];

			$rate = $request->tax[$k]/100;

			$taxvalue = $amount * $rate;

			$totalAmount = $amount + $taxvalue;

			$product 					= new quote_products;
			$product->quoteID		   = $id;
			$product->productID		= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->discount		= $request->discount[$k];
			$product->taxrate			= $request->tax[$k];
			$product->taxvalue		= $taxvalue;
			$product->total_amount  = $totalAmount;
			$product->main_amount   = $mainAmount;
			$product->sub_total  	= $amount;
			$product->price         = $request->price[$k];
			$product->save();
		}

		//get quote products
		$quoteProducts = quote_products::where('quoteID',$id)
								->select(DB::raw('SUM(discount) as discount'),DB::raw('SUM(main_amount) as mainAmount'),DB::raw('SUM(total_amount) as total'),DB::raw('SUM(sub_total) as sub_total'),DB::raw('SUM(taxvalue) as taxvalue'))
								->first();

		//update quoe
		if($update->quote_code == "") {
			$code = Helper::generateRandomString(16);
			$update->quote_code = $code;
		}

		$update->main_amount      =  $quoteProducts->mainAmount;
		$update->discount         = $quoteProducts->discount;
		$update->total		        = $quoteProducts->total;
		$update->sub_total	     = $quoteProducts->sub_total;
		$update->taxvalue	        = $quoteProducts->taxvalue;
		$update->updated_by		  = Auth::user()->id;
		$update->customerID	 	  = $request->customer;
		$update->reference_number = $request->reference_number;
		$update->subject	    	  = $request->subject;
		$update->taxconfig			= $request->taxconfig;
		$update->description	     = $request->description;
		$update->quote_date	     = $request->quote_date;
		$update->quote_due	     = $request->quote_due;
		$update->customer_note	  = $request->customer_note;
		$update->terms				  = $request->terms;
      $update->businessID       = Auth::user()->businessID;
		$update->save();

		Session::flash('success','quotes has been successfully updated');

    	return redirect()->back();
	}

	/**
   * show quotes
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($id){
		$count = 1;
		$filec = 1;
		$quote = quotes::join('business','business.id','=','quotes.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->join('quote_settings','quote_settings.businessID','=','business.id')
					->join('status','status.id','=','quotes.statusID')
					->where('quotes.id',$id)
					->where('quotes.businessID',Auth::user()->businessID)
					->select('*','status.name as statusName','business.name as businessName','quotes.id as quoteID','quotes.reference_number as reff','business.businessID as business_code')
               ->first();

		$products = quote_products::where('quoteID',$quote->quoteID)->get();

		$customer = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$quote->customerID)
							->select('*','customers.id as clientID')
                     ->first();

		if($quote->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $quote->sub_total * ($quote->tax / 100);
		}

		$files = docs::where('fileID',$id)->where('section','quotes')->where('businessID',Auth::user()->businessID)->get();

		$persons = contact_persons::where('customerID',$customer->clientID)->get();

		$template = Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name;

		return view('app.finance.quotes.show', compact('customer','quote','products','count','taxed','filec','files','persons','template'));
	}


	/**
   * generate quotes pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function pdf($id){
		$count = 1;
		$details = quotes::join('business','business.id','=','quotes.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->join('quote_settings','quote_settings.businessID','=','business.id')
					->join('status','status.id','=','quotes.statusID')
					->where('quotes.id',$id)
					->where('quotes.businessID',Auth::user()->businessID)
					->select('*','status.name as statusName','business.name as businessName','quotes.id as quoteID','quotes.reference_number as reff','business.businessID as business_code')
					->first();

		$products = quote_products::where('quoteID',$details->quoteID)->get();
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
		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/quotes/quotes', compact('products','details','client','taxed','count'));

		return $pdf->download(Finance::quote()->prefix.$details->quote_number.'.pdf');

	}

	/**
	* print quotes
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function print($id){
		$count = 1;
		$details = quotes::join('business','business.id','=','quotes.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->join('quote_settings','quote_settings.businessID','=','business.id')
					->join('status','status.id','=','quotes.statusID')
					->where('quotes.id',$id)
					->where('quotes.businessID',Auth::user()->businessID)
					->select('*','status.name as statusName','business.name as businessName','quotes.id as quoteID','quotes.reference_number as reff','business.businessID as business_code')
					->first();

		$products = quote_products::where('quoteID',$details->quoteID)->get();
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

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/quotes/quotes', compact('products','details','client','taxed','count'));

		return $pdf->stream(Finance::quote()->prefix.$details->quote_number.'.pdf');
	}

	/**
	* attachment quotes
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function attachment_files(Request $request){

		$quotes = quotes::where('id',$request->quoteID)->where('businessID',Auth::user()->businessID)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/quotes/';

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
		$upload_success = $file->move($directory, $filename);

      //save the upload details into the database
      $upload = new docs;

      $upload->fileID  = $request->quoteID;
      $upload->folder 	 = 'Finance';
      $upload->section 	 = 'quotes';
		$upload->name 		 = Finance::quote()->prefix.$quotes->quote_number;
		$upload->file_name = $filename;
		$upload->file_size = $size;
		$upload->attach 	 = 'No';
      $upload->file_mime = $file->getClientMimeType();
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
		$file = docs::where('id',$file)->where('businessID',Auth::user()->businessID)->first();
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
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/quotes/';

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
		$quote = quotes::join('business','business.id','=','quotes.businessID')
								->join('currency','currency.id','=','business.base_currency')
								->join('quote_settings','quote_settings.businessID','=','business.id')
								->join('status','status.id','=','quotes.statusID')
								->where('quotes.id',$id)
								->where('quotes.businessID',Auth::user()->businessID)
								->select('*','status.name as statusName','business.name as businessName','quotes.id as quoteID','quotes.reference_number as reff','business.businessID as business_code')
								->first();

		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$quote->customerID)
							->where('customers.businessID',Auth::user()->businessID)
							->select('*','customers.id as clientID')
							->first();
		$files = docs::where('fileID',$id)->where('section','quotes')->where('businessID',Auth::user()->businessID)->get();
		$contacts = contact_persons::where('customerID',$client->clientID)->get();


		$count = 1;
		$details = $quote;
		$products = quote_products::where('quoteID',$details->quoteID)->get();
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

		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/quotes/';
      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		$pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/quotes/quotes', compact('products','details','client','taxed','count'));

		$pdf->save($directory.Finance::quote()->prefix.$details->quote_number.'.pdf');

		return view('app.finance.quotes.mail', compact('quote','files','contacts','client'));
	}

	/**
	* 	send quotes via email
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function send(Request $request){
		$this->validate($request,[
			'email_from' => 'required|email',
			'send_to' 	 => 'required|email',
			'subject'    => 'required',
			'message'	 => 'required',
		]);

		//quotes information
		$quotes = quotes::where('id',$request->quoteID)->where('businessID',Auth::user()->businessID)->first();

		//client info
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
							->where('customers.id',$quotes->customerID)
							->select('*','customers.id as clientID')
							->first();

		$checkatt = count(collect($request->attach_files));
		if($checkatt > 0){
			//change file status to null
			$filechange = docs::where('section','quotes')->where('fileID',$quotes->id)->where('businessID',Auth::user()->businessID)->get();
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
			$chage = docs::where('section','quotes')->where('fileID',$quotes->id)->where('businessID',Auth::user()->businessID)->get();
			foreach ($chage as $cs) {
				$null = docs::where('id',$cs->id)->where('businessID',Auth::user()->businessID)->first();
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
		$trackCode = Helper::generateRandomString(9);
		$emails = new emails;
		$emails->message   = $request->message;
		$emails->clientID  = $client->clientID;
		$emails->subject   = $request->subject;
		$emails->tracking_code  = $trackCode;
		$emails->mail_from = $request->email_from;
		if($checkatt > 0){
			$emails->attachment = json_encode($request->get('files'));
		}
		$emails->category  = 'quotes Document';
		$emails->status    = 'Sent';
		$emails->ip 	    = Helper::get_client_ip();
		$emails->type      = 'Outgoing';
		$emails->section   = 'quotes';
		$emails->businessID  = Auth::user()->businessID;
		$emails->userID    = Auth::user()->id;
		$emails->mail_to   = $request->send_to;
		if($checkcc > 0){
			$emails->cc  = json_encode($request->get('email_cc'));
		}
		$emails->save();

		//update quotes
		$quotes->remainder_count = $quotes->remainder_count + 1;
		$quotes->sent_status 	= 'Sent';
		$quotes->save();

		//send email
		$subject = $request->subject;
        $content = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->businessID.'/'.$emails->id.'" width="1" height="1" /><br><img src="'.url('/').'/track/quote/'.$quotes->quote_code.'/'.Auth::user()->businessID.'/'.$quotes->id.'" width="1" height="1" />';
		$from = $request->email_from;
		$to = $request->send_to;
		$mailID = $emails->id;
		$doctype = 'quotes';
        $docID = $quotes->id;

        //quotes ID

		if($request->attaches == 'Yes'){
			$attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/quotes/'.Finance::quote()->prefix. $quotes->quote_number.'.pdf';
		}else{
			$attachment = 'No';
		}


		Mail::to($to)->send(new sendQuotes($content,$subject,$from,$mailID,$docID,$doctype,$attachment));

		//recorord activity
		$activities = 'quotes #'.Finance::quote()->prefix.$quotes->quote_number.' has been sent to the client by '.Auth::user()->name;
		$section = 'quotes';
		$type = 'Sent';
		$adminID = Auth::user()->id;
		$activityID = $request->quoteID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','quotes Sent to client successfully');

		return redirect()->back();


	}

	/**
	* 	change quotes status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function change_status($quoteID,$status){
		$quotes = quotes::where('id',$quoteID)->where('businessID',Auth::user()->businessID)->first();
		$quotes->statusID = $status;
		$quotes->save();

		//recorord activity
		$activities = 'quotes #'.Finance::quote()->prefix.$quotes->quote_number.' status has been updated by '.Auth::user()->name;
		$section = 'quotes';
		$type = 'update';
		$adminID = Auth::user()->id;
		$activityID = $quoteID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','quotes status successfully changed');
		return redirect()->back();
	}

	/**
	* 	change quotes status
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function convert_to_invoice($quoteID){
		$quotes = quotes::where('id',$quoteID)->where('businessID',Auth::user()->businessID)->first();

		//create invoice
		$invoice = new invoices;
		$invoice->created_by   = $quotes->userID;
		$invoice->customerID   = $quotes->customerID;
		$invoice->invoice_number = Finance::invoice_settings()->number + 1;
		$invoice->invoice_date = $quotes->quote_date;
		$invoice->invoice_due = $quotes->quote_due;
		$invoice->statusID = 2;
		$invoice->businessID =   Auth::user()->businessID;
		$invoice->invoice_type = 'Product';
		$invoice->invoice_title = 'Quote coverted to invoice';
		$invoice->main_amount     =  $quotes->main_amount;
		$invoice->discount        = $quotes->discount;
		$invoice->total		     = $quotes->total;
		$invoice->sub_total	     = $quotes->sub_total;
		$invoice->taxvalue	     = $quotes->taxvalue;
		$invoice->taxconfig		  = $quotes->taxconfig;
		$invoice->save();


		//create products
		$estprod = quote_products::where('quoteID',$quoteID)->get();
		foreach($estprod as $product){
			$invoprod = new invoice_products;
			$invoprod->invoiceID		= $invoice->id;
			$invoprod->productID		= $product->productID;
			$invoprod->quantity		= $product->quantity;
			$invoprod->discount		= $product->discount;
			$invoprod->taxrate		= $product->taxrate;
			$invoprod->taxvalue		= $product->taxvalue;
			$invoprod->total_amount = $product->total_amount;
			$invoprod->main_amount  = $product->main_amount;
			$invoprod->sub_total  	= $product->sub_total;
			$invoprod->selling_price  = $product->price;
			$invoprod->save();
		}

		//link quotes to invoice
		$quotes->invoice_link = $invoice->id;
		$quotes->statusID = 13;
		$quotes->save();

		//update invoice number settings
		$invoice_settings = invoice_settings::where('businessID',Auth::user()->businessID)->first();
		$invoice_settings->number = $invoice_settings->number + 1;
		$invoice_settings->save();


		//recorord activity
		$activities = 'quotes #'.Finance::quote()->prefix.$quotes->quote_number.' had been converted to ana invoice by '.Auth::user()->name;
		$section = 'quotes';
		$type = 'Convert';
		$adminID = Auth::user()->id;
		$activityID = $quoteID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','quotes has been successfully converted');

		return redirect()->back();
	}

	/**
	* 	delete quotes permanently
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete_quotes($quoteID){

		$quotes = quotes::where('id',$quoteID)->where('businessID',Auth::user()->businessID)->first();

		if($quotes->invoice_link == "" && $quotes->statusID == 10){

			//delete all files linked to the quotes
			$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/quotes/';

			$check_files = docs::where('fileID',$quoteID)->where('businessID',Auth::user()->businessID)->where('section','quotes')->count();

			if($check_files > 0){
				$files = docs::where('fileID',$quoteID)->where('businessID',Auth::user()->businessID)->where('section','quotes')->get();
				foreach($files as $file){
					$doc = docs::find($file->id);

					//create directory if it doesn't exists
					$delete = $directory.$doc->file_name;
					if (File::exists($delete)) {
						unlink($delete);
					}

					$doc->delete();
				}
			}

			//delete quotes products
			quote_products::where('quoteID',$quoteID)->delete();

			//delete quotes plus attachment
			if($quotes->attachment != ""){
				$delete = $directory.$quotes->attachment;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}
			$quotes->delete();

			//recorord activity
			$activities = 'quotes #'.Finance::quote()->prefix.$quotes->quote_number.' had been deleted by '.Auth::user()->name;
			$section = 'quotes';
			$type = 'Delete';
			$adminID = Auth::user()->id;
			$activityID = $quoteID;
			$businessID = Auth::user()->businessID;

			Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

			Session::flash('success','quotes has been successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this quote. Hence, this quote cannot be deleted.');

			return redirect()->back();
		}
	}
}
