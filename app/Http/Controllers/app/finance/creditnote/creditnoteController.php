<?php

namespace App\Http\Controllers\app\finance\creditnote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\creditnote\creditnote_products;
use App\Models\finance\creditnote\creditnote_settings as settings;
use App\Models\finance\products\product_information;
use App\Models\wingu\status;
use App\Models\wingu\file_manager as docs; 
use App\Models\finance\tax;
use App\Models\finance\currency;
use App\Models\crm\emails;
use App\Mail\sendLpo;
use Session;
use File;
use Helper;
use Finance;
use Wingu;
use Auth;
use PDF;
use Mail;

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
	public function index()
	{
		$creditnotes = creditnote::join('business','business.id','=','creditnote.businessID')
								->join('currency','currency.id','business.base_currency')
								->join('creditnote_settings','creditnote_settings.businessID','=','business.id')
								->join('status','status.id','=','creditnote.statusID')
								->join('customers','customers.id','=','creditnote.customerID')
								->where('creditnote.businessID',Auth::user()->businessID)
								->select('*','creditnote.id as creditnoteID','status.name as statusName')
								->orderby('creditnote.id','desc')
								->get();  

			return view('app.finance.creditnote.index', compact('creditnotes'));
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
			Finance::creditnote_setting_setup();
		}

		$clients = customers::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$currencies = currency::OrderBy('id','DESC')->get();
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
				->where('product_information.businessID',Auth::user()->businessID)
				->where('default_inventory','Yes')
				->OrderBy('product_information.id','DESC')
				->select('*','product_information.id as productID')
				->get();

		return view('app.finance.creditnote.create', compact('clients','status','currencies','taxs','Itemproducts','Itemservice'));
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
			'creditnote_number'	=> 'required',
			'creditnote_date'	=> 'required',
		));

		//check credit products
		$check_product_items = count(collect($request->productID));
		if($check_product_items < 1){
			Session::flash('error','Please select the credited items for this credit note');

			return redirect()->back();
		}

		//store invoice 
		$store					    = new creditnote;
		$total = $store->total($request->qty,$request->price);
		$store->created_by		 = Auth::user()->id;
		$store->customerID	 	 = $request->customer;
      $store->creditnote_number = $request->creditnote_number;
		$store->reference_number = $request->reference_number;
		$store->discount      	 = $request->discount;
		$store->title				 = $request->title;
		$store->discount_type 	 = $request->discount_type;
		$store->total		       = $total;
		$store->balance			 = $total;
		$store->sub_total			 = $store->amount($request->qty,$request->price);
		$store->tax				    = $request->tax;
		$store->creditnote_date	 = $request->creditnote_date;
		$store->customer_note	 = $request->customer_note;
		$store->terms				 = $request->terms;
		$store->statusID			 = 21;
		$store->businessID 		 = Auth::user()->businessID;
		$store->save();


		//products
		$products				    = $request->productID;
		foreach ($products as $k => $v){
			$product 					= new creditnote_products;
			$product->creditnoteID	= $store->id;
			$product->productID	   = $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->price    		= $request->price[$k];
			$product->save();
		}

		//update creditnote number
		$setting = settings::where('businessID',Auth::user()->businessID)->first();
		$setting->number = $setting->number + 1;
		$setting->save();

		Session::flash('success','creditnote has been successfully created');

		return redirect()->route('finance.creditnote.index');

   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {

		$creditnote = creditnote::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		$clients = customers::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$client = customers::where('id',$creditnote->customerID)->where('businessID',Auth::user()->businessID)->first();

		$taxs = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
      $creditProducts = creditnote_products::where('creditnoteID',$id)->get();
		$count = 1;

		if($creditnote->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $creditnote->sub_total * ($creditnote->tax / 100);
		}

      $Itemproducts = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')											
												->where('product_information.type','product')												
												->where('product_information.businessID',Auth::user()->businessID)
												->where('default_inventory','Yes')
												->OrderBy('product_information.id','DESC')
												->select('*','product_information.id as productID')
												->get();
		
		$Itemservice = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')											
												->where('product_information.type','service')												
												->where('product_information.businessID',Auth::user()->businessID)
												->where('default_inventory','Yes')
												->OrderBy('product_information.id','DESC')
												->select('*','product_information.id as productID')
												->get();

		return view('app.finance.creditnote.edit', compact('client','clients','taxed','count','taxs','creditnote','creditProducts','Itemproducts','Itemservice'));
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
			'creditnote_number'	=> 'required',
			'creditnote_date'	=> 'required',
		));

		//check credit products
		$check_product_items = count(collect($request->productID));
		if($check_product_items < 1){
			Session::flash('error','Please select the credited items for this credit note');

			return redirect()->back();
		}

		$update = creditnote::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

		$total = $update->total($request->qty,$request->price);

		//check if credit is linked to any invoice
		$creditLinks = invoice_payments::where('businessID',Auth::user()->businessID)->where('creditID',$id)->count();

		$sum = invoice_payments::where('businessID',Auth::user()->businessID)->where('creditID',$id)->sum('amount');

		if($creditLinks != 0) {
			//check if total is grater that the previous creditations
			if($sum > $total){
				Session::flash('error','Please make sure that the credit notes amount is not lesser than '.$sum.'.00 because as many credits have been applied to invoices.');

				return redirect()->back();
			}
		}

		//update balance
		if($update->total != $total){
			$update->balance = $total - $sum;
		}

		$update->customerID	 	  = $request->customer;
		$update->reference_number = $request->reference_number;
		$update->discount      	  = $request->discount;
		$update->discount_type 	  = $request->discount_type;
		$update->title				  = $request->title;
		$update->total		        = $total;
		$update->sub_total		  = $update->amount($request->qty,$request->price);
		$update->tax				  = $request->tax;
		$update->creditnote_date  = $request->creditnote_date;
		$update->customer_note	  = $request->customer_note;
		$update->terms				  = $request->terms;
		if($creditLinks != 0) {
			if ($total > $update->total) {
				$update->statusID = 21;
			}
		}
		if($update->total > $update->balance){
			$update->statusID = 21;
		}
		$update->updated_by		 = Auth::user()->id;
		$update->businessID 		  = Auth::user()->businessID;
		$update->save();

 
		//delete product
		$delete = creditnote_products::where('creditnoteID', $id);
		$delete->delete();

		//new products
		$products				= $request->productID;
		foreach ($products as $k => $v)
		{
			$product 					= new creditnote_products;
			$product->creditnoteID	= $update->id;
			$product->productID		= $request->productID[$k];
			$product->quantity		= $request->qty[$k];
			$product->price    		= $request->price[$k];
			$product->save();
		}

		Session::flash('success','creditnote has been successfully updated');

    	return redirect()->back();
	}

	/**
   * show creditnote
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($id){
		$count = 1;
		$filec = 1;
		$show = creditnote::join('business','business.id','=','creditnote.businessID')
								->join('customers','customers.id','=','creditnote.customerID')
								->join('customer_address','customer_address.customerID','=','creditnote.customerID')
								->join('currency','currency.id','business.base_currency')
								->join('creditnote_settings','creditnote_settings.businessID','=','business.id')
								->join('status','status.id','=','creditnote.statusID')
								->where('creditnote.businessID',Auth::user()->businessID)
								->where('creditnote.id',$id)
								->select('*','creditnote.id as creditnoteID','status.name as statusName','business.name as businessName','business.website as business_website','business.businessID as business_code')
								->first();

		$products = creditnote_products::where('creditnoteID',$show->creditnoteID)->get();

		if($show->paymentID != ""){
			$products = creditnote_products::where('creditnoteID',$show->creditnoteID)->get();
		}
						

		if($show->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $show->sub_total * ($show->tax / 100);
		}

		//check if user has pending invoice
		$checkOpenInvoices = invoices::where('statusID','!=',1)
									->where('customerID',$show->customerID)
									->whereNull('credited')
									->where('businessID',Auth::user()->businessID)
									->count();

		$invoices = invoices::join('invoice_settings','invoice_settings.businessID','=','invoices.businessID')
					->join('business','business.id','=','invoices.businessID')
					->join('currency','currency.id','business.base_currency')
					->where('statusID','!=',1)
					->where('customerID',$show->customerID)
					->whereNull('credited')
					->where('invoices.businessID',Auth::user()->businessID)
					->select('*','invoices.id as invoID')
					->get();


		$files = docs::where('fileID',$id)->where('section','creditnote')->get();

		//all creditnotes
		$creditnotes	= creditnote::join('business','business.id','=','creditnote.businessID')
								->join('currency','currency.id','business.base_currency')
								->join('creditnote_settings','creditnote_settings.businessID','=','business.id')
								->join('customers','customers.id','=','creditnote.customerID')
								->join('status','status.id','=','creditnote.statusID')
								->where('creditnote.businessID',Auth::user()->businessID)
								->select('*','creditnote.id as creditnoteID','status.name as statusName')
								->orderby('creditnote.id','desc')
								->get();
		
		$template = Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name;

		return view('app.finance.creditnote.show', compact('show','products','count','taxed','filec','files','checkOpenInvoices','invoices','creditnotes','template'));
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
						->join('creditnote_settings','creditnote_settings.businessID','=','business.id')
						->join('status','status.id','=','creditnote.statusID')
						->where('creditnote.businessID',Auth::user()->businessID)
						->where('creditnote.id',$id)
						->select('*','creditnote.id as creditnoteID','status.name as statusName','creditnote_number as number','business.name as businessName')
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
						->join('creditnote_settings','creditnote_settings.businessID','=','business.id')
						->join('status','status.id','=','creditnote.statusID')
						->where('creditnote.businessID',Auth::user()->businessID)
						->where('creditnote.id',$id)
						->select('*','creditnote.id as creditnoteID','status.name as statusName','creditnote_number as number','business.name as businessName')
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
		$upload->folder 	   = 'Finance';
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
						->join('creditnote_settings','creditnote_settings.businessID','=','business.id')
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

		return view('app.finance.creditnote.mail', compact('details','files','contacts','client'));
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
						$invoice = invoices::where('businessID',Auth::user()->businessID)->where('id',$request->invoiceID[$i])->first();

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

		$invoiceCredit = invoice_payments::where('creditID',$creditnoteID)
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
 