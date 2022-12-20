<?php

namespace App\Http\Controllers\app\property\landlords;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\estimate\estimates;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\salesorder\salesorders;
use App\Models\finance\customer\comments;
use App\Models\finance\customer\address;
use App\Models\property\property;
use App\Models\wingu\country;
use App\Models\project\tasks;
use App\Models\project\project; 
use App\Models\finance\invoice\invoices;
use App\Models\finance\quotes\quotes;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\customer\groups;
use App\Models\finance\customer\customer_group; 
use App\Models\wingu\file_manager as documents; 
use App\Models\subscriptions\subscriptions;
use App\Models\asset\assets\assets;
use App\Models\finance\customer\events;
use App\Models\finance\customer\notes;
use App\Models\crm\sms;
use App\Models\crm\emails;
use File; 
use Helper;
use Session;
use Wingu;
use Auth;

class landlordController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
      $landlords = customers::join('customer_group','customer_group.customerID','=','customers.id')
						->where('customers.businessID',Auth::user()->businessID)
						->where('customer_group.groupID',1)
						->select('*','customers.id as propertyID','customers.created_at as date_added')
						->OrderBy('customers.id','DESC')
						->get();
		$count = 1;

		return view('app.property.landlord.index', compact('landlords','count'));
	}

	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		return view('app.property.landlord.create', compact('country'));
	}

	public function store(Request $request){
		$this->validate($request, [
			'primary_phone_number' => 'required',
			'contact_type' => 'required',
			'customer_name' => 'required',
		]);

 		$primary = new customers;
		$code = Helper::generateRandomString(10);
		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$code.'/images/';

			if (!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			$file = $request->image;

			// GET THE FILE EXTENSION
			$extension = $file->getClientOriginalExtension();
			// RENAME THE UPLOAD WITH RANDOM NUMBER
			$fileName = Helper::generateRandomString(). '.' . $extension;
			// MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
			$file->move($path, $fileName);

			$primary->image = $fileName;
		}

 		$primary->contact_type = $request->contact_type;
		$primary->salutation = $request->salutation;
		$primary->email = $request->email;
 		$primary->customer_name = $request->customer_name;
		$primary->email_cc = $request->email_cc;
 		$primary->primary_phone_number = $request->primary_phone_number;
 		$primary->other_phone_number = $request->other_phone_number;
 		$primary->currency = $request->currency;
 		$primary->payment_terms = $request->payment_terms;
 		$primary->portal = $request->portal;
		$primary->customer_code = $code;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->skypeID = $request->skypeID;
 		$primary->website = $request->website;
		$primary->remarks = $request->remarks;
		$primary->tax_pin = $request->tax_pin;
		$primary->gender = $request->gender;
		$primary->identification_type = $request->identification_type;
		$primary->identification_number = $request->identification_number;
		$primary->dob = $request->dob;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
		$primary->businessID = Auth::user()->businessID;
		$primary->created_by = Auth::user()->id;
 		$primary->save();

 		//address
 		$address = new address;
		$address->customerID = $primary->id;
		$address->bill_attention = $request->bill_attention;
 		$address->bill_street = $request->bill_street;
 		$address->bill_city = $request->bill_city;
 		$address->bill_state = $request->bill_state;
 		$address->bill_zip_code = $request->bill_zip_code;
 		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;

 		$address->ship_attention = $request->ship_attention;
 		$address->ship_street = $request->ship_street;
 		$address->ship_city = $request->ship_city;
 		$address->ship_state = $request->ship_state;
 		$address->ship_zip_code = $request->ship_zip_code;
		$address->ship_country = $request->ship_country;
		$address->ship_fax = $request->ship_fax;
		$address->ship_postal_address = $request->ship_postal_address;
 		$address->save();

		$contacts = count(collect($request->cn_names));

 		//contact persons
		if($contacts > 0){
	  		if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {

					$contact_persons = new contact_persons;
					$contact_persons->customerID = $primary->id;
					$contact_persons->salutation = $request->cn_salutation[$i];
					$contact_persons->names = $request->cn_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->designation = $request->cn_desgination[$i];
					$contact_persons->businessID = Auth::user()->businessID;
					$contact_persons->save();
				}
	 		}
		}

		//customer group
		$group = new customer_group;
		$group->customerID = $primary->id;
		$group->groupID = 1;
		$group->save();

		if($request->hasFile('documents')){

         //directory
			$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$code.'/documents/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('documents');

         foreach($files as $file) {
            $size =  $file->getSize();
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(15).'.'.$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new documents;
            $upload->fileID      = $primary->id;
            $upload->folder 	   = 'customer/'.$code;
            $upload->section 	   = 'customer';
            $upload->name 		   = $request->tenant_name;
            $upload->file_name   = $fileName;
            $upload->file_size   = $size;
            $upload->file_mime   = $file->getClientMimeType();
            $upload->created_by  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->save();
         }
		}

	   Session::flash('success','Contact has been successfully Added');

	   //recorord activity
		$activities = Auth::user()->name.' Has added a Landlord #'.$request->customer_name;
		$section = 'Property';
		$type = 'Landlords';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
		$activityID = $primary->id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Landlord has been successfully Added');

		return redirect()->route('landlord.index');
 	}

 	public function edit($id){
 		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
 		$landlord = customers::where('customers.id',$id)
						->join('customer_address','customer_address.customerID','=','customers.id')
						->where('businessID',Auth::user()->businessID)
						->select('*','customers.id as customerID')
						->first();

 		$persons = contact_persons::where('customerID',$id)->get();
 		$count = 1;

 		return view('app.property.landlord.edit', compact('landlord','persons','count','country'));
 	}

 	public function update(Request $request, $id){
		$this->validate($request, [
			'primary_phone_number' => 'required',
			'contact_type' => 'required',
			'customer_name' => 'required',
		]);

		$primary = customers::where('id',$id)->where('businessID',Auth::user()->businessID)->first();


		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$primary->customer_code.'/images/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         $check = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();

         if ($check > 0){
				$oldimagename = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image')->first();
				$delete = $path.$oldimagename->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
         }

         $file = $request->file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $primary->image = $fileName;
      }

		$primary->contact_type = $request->contact_type;
		$primary->salutation = $request->salutation;
		$primary->email = $request->email;
 		$primary->customer_name = $request->customer_name;
		$primary->email_cc = $request->email_cc;
 		$primary->primary_phone_number = $request->primary_phone_number;
 		$primary->other_phone_number = $request->other_phone_number;
 		$primary->currency = $request->currency;
 		$primary->payment_terms = $request->payment_terms;
 		$primary->portal = $request->portal;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->skypeID = $request->skypeID;
 		$primary->website = $request->website;
		$primary->remarks = $request->remarks;
		$primary->tax_pin = $request->tax_pin;
		$primary->gender = $request->gender;
		$primary->identification_type = $request->identification_type;
		$primary->identification_number = $request->identification_number;
		$primary->dob = $request->dob;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
		$primary->businessID = Auth::user()->businessID;
		$primary->created_by = Auth::user()->id;
 		$primary->save();

 		//address
 		$address = address::where('customerID',$id)->first();
 		$address->bill_attention = $request->bill_attention;
 		$address->bill_street = $request->bill_street;
 		$address->bill_city = $request->bill_city;
 		$address->bill_state = $request->bill_state;
 		$address->bill_zip_code = $request->bill_zip_code;
 		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;

 		$address->ship_attention = $request->ship_attention;
 		$address->ship_street = $request->ship_street;
 		$address->ship_city = $request->ship_city;
 		$address->ship_state = $request->ship_state;
 		$address->ship_zip_code = $request->ship_zip_code;
		$address->ship_country = $request->ship_country;
		$address->ship_postal_address = $request->ship_postal_address;
 		$address->ship_fax = $request->ship_fax;
 		$address->save();


		$contacts = count(collect($request->cn_names));

 		//contact persons
		if($contacts > 0){
			if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {
					$contact_persons = new contact_persons;
					$contact_persons->customerID = $id;
					$contact_persons->salutation = $request->cn_salutation[$i];
					$contact_persons->names = $request->cn_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->designation = $request->cn_desgination[$i];
					$contact_persons->businessID = Auth::user()->businessID;
					$contact_persons->save();
				}
			}
		}

 		Session::flash('success','Landlord has been successfully updated');

	   return redirect()->back();
 	}

 	public function show($id){
		$customerID = $id;
 		$count = 1;
		$client = customers::join('customer_address','customer_address.customerID','=','customers.id')
					->join('business','business.id','=','customers.businessID')
					->join('currency','currency.id','=','business.base_currency')
					->where('customers.id',$id)
					->where('customers.businessID',Auth::user()->businessID)
					->select('*','customers.id as cid')
					->first();

		//contacts
		$contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

		//project
		$projectCount = project::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->count();
		$projects = project::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

		//invoices
		$invoices = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
		$paymentsCount = invoice_payments::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->count();
		$outstanding = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->sum('balance');
		$totalIncome = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->sum('paid');
		$invoiceCount = invoices::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->count();

		//quotes
		$quotesCount = quotes::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->count();
		$quotes = quotes::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

		//creditnote
		$unusedCredits = creditnote::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->sum('balance');
		$creditnotes = creditnote::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get(); 

		//sms count
		$smsCount = sms::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->count();

		//mail count
		$mailCount = emails::where('clientID',$customerID)->where('businessID',Auth::user()->businessID)->count();

		//task count
		$taskCount = tasks::join('project','project.id','=','project_tasks.projectID')
								  ->where('project.customerID',$customerID)
								  ->where('project.businessID',Auth::user()->businessID)
								  ->count();

		//subscription
		$subscriptionsCount = subscriptions::where('businessID',Auth::user()->businessID)
									->where('customer',$customerID)
									->count();
									
		//assets
		$assetsCount = assets::where('businessID',Auth::user()->businessID)->where('customer',$customerID)->where('category','Asset')->count();

		//meeting
		$eventsCount = events::where('businessID', Auth::user()->businessID)->where('customerID',$customerID)->count();

		//notes
		$countNotes = notes::where('businessID',Auth::user()->businessID)->where('customerID',$customerID)->count(); 

		//documents
		$folder = 'customer/'.$client->reference_number;
		$documentsCount = documents::where('fileID',$customerID)
									->where('businessID',Auth::user()->businessID)
									->where('folder',$folder)
									->where('section','customer')
									->count();

		//documents
		$salesOrderCount = salesorders::where('businessID',Auth::user()->businessID)->where('customerID',$customerID)->count();	

		//comments
		$commentCount = comments::where('businessID',Auth::user()->businessID)->where('customerID',$customerID)->count();	
		
		//subscription
		$subscriptions = subscriptions::join('business','business.id','=','subscriptions.businessID')
									->join('subscription_settings','subscription_settings.businessID','=','business.id')
									->join('product_information','product_information.id','=','subscriptions.plan')
									->join('product_price','product_price.productID','=','product_information.id')
									->join('status','status.id','=','subscriptions.status')
									->where('subscriptions.businessID',Auth::user()->businessID)
									->where('subscriptions.customer',$customerID)
									->orderby('subscriptions.id','desc')
									->select('*','status.name as statusName','subscriptions.id as subscriptionID')
									->get();

		$count = 1;
				
      return view('app.finance.contacts.view', compact('client','customerID','totalIncome','unusedCredits','contacts','outstanding','projectCount','invoiceCount','quotesCount','paymentsCount','smsCount','mailCount','taskCount','subscriptionsCount','assetsCount','eventsCount','countNotes','documentsCount','salesOrderCount','commentCount','invoices','quotes','creditnotes','projects','subscriptions','count'));
 	}

	public function comment_post(Request $request){
		$this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
		$comment->comment = $request->comment;
		$comment->userID = Auth::user()->id;
		$comment->customerID = $request->customerID;
		$comment->businessID = Auth::user()->businessID;
		$comment->save();

		Session::flash('success', 'comment added');

		return redirect()->back();
	}

	public function comment_delete($id){

		$delete = comments::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();

		Session::flash('success', 'comment deleted');

		return redirect()->back();
	}

 	public function delete_contact_person($id){

		contact_persons::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();
		
		Session::flash('success','Contact person successfully deleted');

 		return redirect()->back();
 	}

 	public function update_quick_edit(){

 		$primary = customers::where('id',$id)->first();
 		$primary->company_name = $request->company_name;
 		$primary->salutation = $request->salutation;
 		$primary->first_name = $request->first_name;
 		$primary->last_name = $request->last_name;
 		$primary->contact_display_name = $request->contact_display_name;
 		$primary->contact_email = $request->contact_email;
 		$primary->work_phone = $request->work_phone;
 		$primary->mobile_phone = $request->mobile_phone;
 		$primary->currency = $request->currency;
 		$primary->payment_terms = $request->payment_terms;
 		$primary->portal = $request->portal;
 		$primary->language = $request->language;
 		$primary->facebook = $request->facebook;
 		$primary->twitter = $request->twitter;
 		$primary->website = $request->website;
 		$primary->remarks = $request->remarks;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
 		$primary->save();

 		return responce()->json($primary);

	}


	 //delete permanently
	public function delete($id){

		//check if user is linked to any module
		//invoice
		$invoice = invoices::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//credit note
		$creditnote = creditnote::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//credit note
		$property = property::where('businessID',Auth::user()->businessID)->where('landlordID',$id)->count();

		if($invoice == 0 && $creditnote == 0 && $property == 0){

			//client info
			$check = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image','customer_code')->first();

				$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/clients/'.$deleteinfo->customer_code.'/images/';

				$delete = $path.$deleteinfo->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			$persons = contact_persons::where('customerID',$id)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			$deleteclient = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->first();
			$deleteclient->delete();

			//delete address
			$address = address::where('customerID',$id)->first();
			$address->delete();

			//delete company group
			$check_group = customer_group::where('customerID',$id)->count();
			if($check_group > 0){
				$groups = customer_group::where('customerID',$id)->get();
				foreach($groups as $group){
					$deleteGroup = customer_group::find($group->id);
					$deleteGroup->delete();
				}
			}

			Session::flash('success','Landlord was successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}


   public function express_store(Request $request){
      $primary = new customers;
		$primary->customer_name = $request->customer_name;
      $primary->businessID = Auth::user()->businessID;
      $primary->created_by = Auth::user()->id;
		$primary->save();

		$address = new address;
		$address->customerID = $primary->id;
		$address->save();

   }

   public function express_list(Request $request)
   {
      $accounts = customers::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get(['id', 'customer_name as text']);
      return ['results' => $accounts];
	}
}
