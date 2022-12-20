<?php

namespace App\Http\Controllers\app\crm\customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\salesorder\salesorders;
use App\Models\finance\customer\comments;
use App\Models\finance\customer\address;
use App\Models\wingu\country;
use App\Models\project\tasks;
use App\Models\finance\invoice\invoices;
use App\Models\finance\quotes\quotes;
use App\Models\finance\invoice\invoice_payments;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\customer\groups;
use App\Models\finance\customer\customer_group;
use App\Models\wingu\file_manager as documents;
use App\Models\subscriptions\subscriptions;
use App\Models\asset\assets;
use App\Models\finance\customer\events;
use App\Models\finance\customer\notes;
use App\Models\crm\sms;
use App\Models\crm\emails;
use Session;
use Helper;
use Wingu;
use Auth;
use File;
use DB;

class customersController extends Controller
{
   /**
   * Show the application dashboard.   *
   * @return \Illuminate\Http\Response
   */
   public function index(){
      $customers = customers::join('business','business.id','=','customers.businessID')
						->where('customers.businessID',Auth::user()->businessID)
                  ->whereNull('category')
						->select('*','customers.id as customerID','customers.created_at as date_added')
						->OrderBy('customers.id','DESC')
						->get();
		$count = 1;

      return view('app.crm.customers.index', compact('customers','count'));
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

      return view('app.crm.customers.view', compact('client','customerID','totalIncome','unusedCredits','contacts','outstanding','invoiceCount','quotesCount','paymentsCount','smsCount','mailCount','taskCount','subscriptionsCount','assetsCount','eventsCount','countNotes','documentsCount','salesOrderCount','commentCount','invoices','quotes','creditnotes','subscriptions','count'));
   }

   public function note_store(Request $request){

      $note = new note;

      $note->note = $request->note;
      $note->customerID = $request->customerID;
      $note->user_id = Auth::user()->id;
      $note->save();

      session::flash('Success','Note Successfully added');

      return redirect()->back();
   }

   public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$groups = groups::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->pluck('name','id');
      return view('app.crm.customers.create', compact('country','groups'));
	}

	public function edit($id){
      $country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
 		$contact = customers::where('customers.id',$id)
						->join('customer_address','customer_address.customerID','=','customers.id')
						->where('businessID',Auth::user()->businessID)
						->select('*','customers.id as customerID')
						->first();
 		$persons = contact_persons::where('customerID',$id)->get();
 		$count = 1;


		//category
      $category = groups::where('businessID',Auth::user()->businessID)->get();
      $joincat = array();
      foreach ($category as $joint) {
         $joincat[$joint->id] = $joint->name;
      }

      //join category
      $getjoint = customer_group::join('customer_groups','customer_groups.id', '=' ,'customer_group.groupID')
                  ->where('customerID',$id)
                  ->select('customer_groups.id as catid')
                  ->get();
      $jointcategories = array();
      foreach($getjoint as $cj){
         $jointcategories[] = $cj->catid;
      }

		return view('app.crm.customers.edit', compact('contact','joincat','jointcategories','country','count','persons'));
	}

	public function contact_store(Request $request){
		$this->validate($request, array(
			'contact_type' => 'required',
         'customer_name' => 'required',
		));

      $code = Helper::generateRandomString(10);

		$contact = new customers;
		$contact->contact_type = $request->contact_type;
		$contact->salutation = $request->salutation;
		$contact->customer_name = $request->customer_name;
		$contact->email = $request->email;
		$contact->website = $request->website;
		$contact->other_phone_number = $request->other_phone_number;
		$contact->primary_phone_number = $request->primary_phone_number;
      $contact->designation = $request->designation;
 		$contact->department = $request->department;
		$contact->remarks = $request->remarks;
      $contact->facebook = $request->facebook;
      $contact->twitter = $request->twitter;
      $contact->linkedin = $request->linkedin;
      $contact->skypeID = $request->skypeID;
		$contact->referral = $request->referral;
      $contact->created_by = Auth::user()->id;
      $contact->businessID = Auth::user()->businessID;
      $contact->reference_number = $code;

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$code.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = $request->file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $upload_success = $file->move($path, $fileName);

         $contact->image = $fileName;
      }
		$contact->save();

		//address
		$address = new address;

		$address->customerID = $contact->id;
		$address->bill_attention = $request->bill_attention;
		$address->bill_street = $request->bill_street;
		$address->bill_city = $request->bill_city;
		$address->bill_state = $request->bill_state;
		$address->bill_zip_code = $request->bill_zip_code;
		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;

		$address->ship_attention = $request->ship_attention;
		$address->ship_street = $request->ship_street;
		$address->ship_city = $request->ship_city;
		$address->ship_state = $request->ship_state;
		$address->ship_zip_code = $request->ship_zip_code;
		$address->ship_country = $request->ship_country;
		$address->ship_fax = $request->ship_fax;
		$address->save();

      $contacts = count(collect($request->cn_names));

 		//contact persons
		if($contacts > 0){
	  		if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {

					$contact_persons = new contact_persons;

					$contact_persons->customerID = $contact->id;
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
		$category = count(collect($request->groups));
		if($category > 0){
	  		if(isset($_POST['groups'])){
				for($i=0; $i < count($request->groups); $i++ ) {
					$group = new customer_group;
					$group->customerID = $contact->id;
					$group->groupID = $request->groups[$i];
					$group->save();
				}
	 		}
		}

		session::flash('Success','Contact Successfully Added');

		return redirect()->route('crm.customers.index');
	}

	public function contact_edit($id){

		$contacts = customers::join('customer_address','customer_address.customerID','=','customers.id')
						->where('customers.id',$id)
						->select('*','customers.id as cid')
						->first();

		$country = country::OrderBy('id','DESC')->pluck('name','id');

		return view('Wingu.Crm.Contacts.edit')->withContact($contacts)->withCountry($country);
	}

	public function contact_update(Request $request,$id){

		$this->validate($request, array(
			'contact_type' => 'required',
         'customer_name' => 'required',
		));

		$primary = customers::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$primary->reference_number.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         $check = customers::where('id','=',$id)->where('image','!=', "")->count();

         if ($check > 0){
				$oldimagename = customers::where('id','=',$id)->select('image')->first();
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
         $upload_success = $file->move($path, $fileName);

         $primary->image = $fileName;
      }

		$primary->contact_type = $request->contact_type;
		$primary->email = $request->email;
		$primary->referral = $request->referral;
 		$primary->salutation = $request->salutation;
		$primary->customer_name = $request->customer_name;
 		$primary->email_cc = $request->email_cc;
 		$primary->primary_phone_number = $request->primary_phone_number;
 		$primary->other_phone_number = $request->other_phone_number;
 		$primary->payment_terms = $request->payment_terms;
 		$primary->portal = $request->portal;
 		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->skypeID = $request->skypeID;
 		$primary->website = $request->website;
 		$primary->remarks = $request->remarks;
 		$primary->designation = $request->designation;
 		$primary->department = $request->department;
		$primary->updated_by = Auth::user()->id;
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

		//category
		$category = count(collect($request->groups));
		//delete existing category
		$deleteCategory = customer_group::where('customerID',$id)->delete();

		if($category > 0){
	  		if(isset($_POST['groups'])){
				for($i=0; $i < count($request->groups); $i++ ) {
					$group = new customer_group;
					$group->customerID = $primary->id;
					$group->groupID = $request->groups[$i];
					$group->save();
				}
	 		}
		}

 		Session::flash('success','Contact has been successfully updated');

	   return redirect()->back();
	}

	public function delete($id){
		//check if user is linked to any module
		//invoice
		$invoice = invoices::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//credit note
		$creditnote = creditnote::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//quotes
		$quotes = quotes::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//project
		$project = project::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//subscription

		if($invoice == 0 && $creditnote == 0 && $quotes == 0 && $project == 0){

			//client info
			$check = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = customers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image','contact_email')->first();

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

			//delete smses
			sms::where('businessID',Auth::user()->businessID)->where('customerID',$id)->delete();

			//delete notes
			notes::where('businessID',Auth::user()->businessID)->where('customerID',$id)->delete();

			//delete  events
			events::where('businessID',Auth::user()->businessID)->where('customerID',$id)->delete();

			//delete comments
			comments::where('businessID',Auth::user()->businessID)->where('customerID',$id)->delete();

			//delete assets
			assets::where('businessID',Auth::user()->businessID)->where('customer',$id)->get();

			Session::flash('success','Contact was successfully deleted');

			return redirect()->route('crm.customers.index');
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}
}
