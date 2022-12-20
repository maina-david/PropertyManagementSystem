<?php

namespace App\Http\Controllers\app\property\property\tenants;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\tenants\clients;
use App\Models\property\lease;
use App\Models\property\tenants\tenants;
use App\Models\property\tenants\contact_persons;
use App\Models\property\tenants\comments;
use App\Models\property\tenants\tenant_address;
use App\Models\wingu\country;
use App\Models\property\tenants\tenant_group;
use App\Models\property\property;
use App\Models\wingu\file_manager as documents;
use File;
use Input;
use Helper;
use Session;
use Wingu;
use Auth;

class tenantsController extends Controller{

	public function __construct(){
		$this->middleware('auth'); 
	}

	public function index($propertyID){
		//check if user is linked to a business and allow access
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first(); 
		$tenants = lease::join('property_tenants','property_tenants.id','=','property_lease.tenantID')
								->where('property_lease.propertyID',$propertyID)
								->where('property_lease.statusID',15)		
								->where('property_lease.businessID',Auth::user()->businessID)
								->groupby('property_lease.tenantID')						
								->orderby('property_tenants.id','desc')
								->select('*','property_tenants.id as tenantID')								
								->get();
								
		$count = 1;

		return view('app.property.property.tenants.index', compact('tenants','count','property','propertyID'));
 	} 

	//add tenant 
	public function create($id){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		return view('app.property.property.tenants.show', compact('property','country'));
	}

	public function store(Request $request, $id){
		$this->validate($request, [
			'primary_phone_number' => 'required',
			'tenant_type' => 'required',
			'tenant_name' => 'required',
		]);

		$property = property::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$primary = new tenants;

		$code = Helper::generateRandomString(10);

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/tenant/'.$code.'/images/';

			if (!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			$file = $request->image;

			// GET THE FILE EXTENSION
			$extension = $file->getClientOriginalExtension();
			// RENAME THE UPLOAD WITH RANDOM NUMBER
			$fileName = Helper::generateRandomString(). '.' . $extension;
			// MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
			$upload_success = $file->move($path, $fileName);

			$primary->image = $fileName;
		}

		$primary->tenant_type = $request->tenant_type;
		$primary->referral = $request->referral;
		$primary->tenant_name = $request->tenant_name;
		$primary->salutation = $request->salutation;
		$primary->contact_email = $request->contact_email;
		$primary->email_cc = $request->email_cc;
		$primary->primary_phone_number = $request->primary_phone_number;
		$primary->other_phone_number = $request->other_phone_number;
		$primary->portal = $request->portal;
		$primary->tenant_code = $code;
		$primary->language = $request->language;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->website = $request->website;
		$primary->tax_pin = $request->tax_pin;
		$primary->gender = $request->gender;
		$primary->dob = $request->dob;
		$primary->remarks = $request->remarks; 
		$primary->identification_type = $request->identification_type;
		$primary->identification_number = $request->identification_number;
		$primary->businessID = Auth::user()->businessID;
		$primary->created_by = Auth::user()->id;

		$primary->save();


		//address
		$address = new tenant_address;
		$address->tenantID = $primary->id;
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

		$contacts = count(collect($request->contact_names));

		//contact persons
		if($contacts > 0){
			if(isset($_POST['contact_names'])){
				for($i=0; $i < count($request->contact_names); $i++ ) {

					$contact_persons = new contact_persons;
					$contact_persons->tenantID = $primary->id;
					$contact_persons->salutation = $request->tenant_salutation[$i];
					$contact_persons->names = $request->contact_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->designation = $request->tenant_desgination[$i];
					$contact_persons->save();
				}
			}
		}

		//documents
		//upload images
		if($request->hasFile('files')){

         //directory
			$directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/tenant/'.$code.'/documents/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

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
            $upload->folder 	   = 'Property';
            $upload->section 	   = 'Property/tenant/documents';
            $upload->name 		   = $request->tenant_name;
            $upload->file_name   = $fileName;
            $upload->file_size   = $size;
            $upload->file_mime   = $file->getClientMimeType();
            $upload->created_by  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->save();
         }
		}
		
		//recorord activity
		$activities = Auth::user()->name.' Has added a tenant to property'.$property->title.'-'.$property->serials;
		$section = 'Property';
		$type = 'Tenant';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
		$activityID = $primary->id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Tenant has been successfully Added');

		return redirect()->route('property.tenants',$id);
	}

	public function edit($id){
		$currency = currency::OrderBy('id','DESC')->pluck('currency_name','id')->prepend('Choose currency','');
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$tenant = tenants::where('tenants.id',$id)
						->join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
						->where('businessID',Auth::user()->businessID)
						->select('*','property_tenants.id as tenantID')
						->first();
		$contact_person = contact_persons::where('tenantID',$id)->get();
		$count = 1;


		//category
		$category = groups::where('businessID',Auth::user()->businessID)->get();
		$joincat = array();
		foreach ($category as $joint) {
			$joincat[$joint->id] = $joint->name;
		}

		//join category
		$getjoint = tenant_group::join('tenant_groups','tenant_groups.id', '=' ,'tenant_group.groupID')
						->where('tenantID',$id)
						->select('tenant_groups.id as catid')
						->get();
		$jointcategories = array();
		foreach($getjoint as $cj){
			$jointcategories[] = $cj->catid;
		}

		return view('app.property.tenants.edit', compact('tenant','joincat','jointcategories'))
				->withCurrency($currency)
				->withPersons($contact_person)
				->withCount($count)
				->withCountry($country);
	}

	/**
	* Show tenant details
	**/
	public function show($propertyID,$tenantID){
		$count = 1;
		$tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
								->where('property_tenants.id',$tenantID)
								->select('*','property_tenants.id as tenantID')
								->first();
								
		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

		return view('app.property.property.tenants.overview', compact('tenant','tenantID','property','propertyID'));
	}

	public function comment_post(Request $request){
		$this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
		$comment->comment = $request->comment;
		$comment->userID = Auth::user()->id;
		$comment->tenantID = $request->tenantID;
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

		$contact_person = contact_persons::where('id',$id)->first();

		$contact_person->delete();

		Session::flash('success','contact person successfully deleted');

		return redirect()->back();
	}
	
	//delete permanently	
	public function delete($id){
		//check if linked to lease
		$lease = lease::where('tenantID',$id)->where('businessID',Auth::user()->businessID)->count();
		
		//check if linked to invoice
		$invoices = invoices::where('tenantID',$id)->where('businessID',Auth::user()->businessID)->count();

		if($lease == 0 && $invoices == 0){
			//client info
			$check = tenants::where('id','=',$id)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = tenants::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image','tenant_email')->first();

				$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/tenant/'.$deleteinfo->tenant_code.'/images/';

				$delete = $path.$deleteinfo->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete images

			//delete documents

			//delete contact person
			$persons = contact_persons::where('tenantID',$id)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			$deleteclient = tenants::where('id','=',$id)->where('businessID',Auth::user()->businessID)->first();
			$deleteclient->delete();

			//delete address
			$address = tenant_address::where('tenantID',$id)->first();
			$address->delete();

			Session::flash('success','Tenant was successfully deleted');
			
		}else{
			Session::flash('error','This Tenant is linked to several transaction,you can not delete the tenant');
		}

		return redirect()->back();
	}
}
