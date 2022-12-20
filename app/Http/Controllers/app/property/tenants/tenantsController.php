<?php
namespace App\Http\Controllers\app\property\tenants;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\tenants\tenants;
use App\Models\property\tenants\contact_persons;
use App\Models\property\tenants\tenant_address;
use App\Models\property\invoice\invoices;
use App\Models\wingu\country;
use App\Models\property\tenants\tenant_group;
use App\Models\wingu\file_manager as documents;
use File;
use Helper;
use Session;
use Wingu;
use Auth;


class tenantsController extends Controller
{
   public function __construct(){ 
		$this->middleware('auth'); 
	}

	public function index(){
		return view('app.property.tenants.index');
 	} 

	//add tenant 
	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		return view('app.property.tenants.create', compact('country'));
	}


	/**
	* Tenant store
	* */ 
	public function store(Request $request){
		$this->validate($request, [
			'phone_number' => 'required',
			'tenant_type' => 'required',
			'tenant_name' => 'required',
		]);

		$code = Helper::generateRandomString(10);
		$primary = new tenants;
		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/tenant/'.$code.'/images/';

			if (!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			$file = $request->image;

			// GET THE FILE EXTENSION
			$extension = $file->getClientOriginalExtension();
			// RENAME THE UPLOAD WITH RANDOM NUMBER
			$fileName = Helper::generateRandomString(16). '.' . $extension;
			// MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
			$file->move($path, $fileName);

			$primary->image = $fileName;
		}
		$primary->tenant_type = $request->tenant_type;
		$primary->referral = $request->referral;
		$primary->tenant_name = $request->tenant_name;
		$primary->salutation = $request->salutation;
		$primary->contact_email = $request->contact_email;
		$primary->email_cc = $request->email_cc;
		$primary->primary_phone_number = $request->phone_number;
		$primary->other_phone_number = $request->other_phone_number;
		$primary->portal = $request->portal;
		$primary->tenant_code = $code;
		$primary->language = $request->language;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->website = $request->website;
		$primary->tax_pin = $request->tax_pin;
		$primary->gender = $request->gender;
		$primary->linkedin = $request->linkedin;
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

		$contacts = count(collect($request->cn_names));

		//contact persons
		if($contacts > 0){
			if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {
					$contact_persons = new contact_persons;
					$contact_persons->tenantID = $primary->id;
					$contact_persons->salutation = $request->cn_salutation[$i];
					$contact_persons->names = $request->cn_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->designation = $request->cn_desgination[$i];
					$contact_persons->save();
				}
			}
		}

		//documents
		//upload images
		if($request->hasFile('documents')){

         //directory
			$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/tenant/'.$code.'/documents/';

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
            $upload->folder 	   = 'tenant/'.$code;
            $upload->section 	   = 'tenant';
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
		$activities = Auth::user()->name.' Has added a tenant';
		$section = 'Property';
		$type = 'Tenant';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
		$activityID = $primary->id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Tenant has been successfully Added');

		return redirect()->route('tenants.index');
	}


	/**
	* Tenant edit
	* */ 
	public function edit($id){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
								->where('businessID',Auth::user()->businessID)
								->where('property_tenants.id',$id)
								->select('*','property_tenants.id as tenantID','property_tenants.primary_phone_number as phone_number')
								->first(); 

		$persons = contact_persons::where('tenantID',$id)->get();
		$count = 1;

		return view('app.property.tenants.edit', compact('country','tenant','persons','count'));
	}


	/**
	* Tenant update
	* */
	public function update(Request $request, $id){
		$this->validate($request, [
			'phone_number' => 'required',
			'tenant_type' => 'required',
			'tenant_name' => 'required',
		]);

		$primary = tenants::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/tenant/'.$primary->tenant_code.'/images/';

			if (!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			$check = tenants::where('id','=',$id)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();

			if ($check > 0){
				$oldimagename = tenants::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image')->first();
				$delete = $path.$oldimagename->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			$file = $request->image;

			// GET THE FILE EXTENSION
			$extension = $file->getClientOriginalExtension();
			// RENAME THE UPLOAD WITH RANDOM NUMBER
			$fileName = Helper::generateRandomString(16). '.' . $extension;
			// MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
			$file->move($path, $fileName);

			$primary->image = $fileName;
		}

		$primary->tenant_type = $request->tenant_type;
		$primary->referral = $request->referral;
		$primary->tenant_name = $request->tenant_name;
		$primary->salutation = $request->salutation;
		$primary->contact_email = $request->contact_email;
		$primary->email_cc = $request->email_cc;
		$primary->primary_phone_number = $request->phone_number;
		$primary->other_phone_number = $request->other_phone_number;
		$primary->portal = $request->portal;
		$primary->language = $request->language;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->linkedin = $request->linkedin;
		$primary->website = $request->website;
		$primary->tax_pin = $request->tax_pin;
		$primary->gender = $request->gender;
		$primary->dob = $request->dob;
		$primary->remarks = $request->remarks; 
		$primary->identification_type = $request->identification_type;
		$primary->identification_number = $request->identification_number;
		$primary->businessID = Auth::user()->businessID;
		$primary->updated_by = Auth::user()->id;
		$primary->save();

		//address
		$address = tenant_address::where('tenantID',$id)->first();
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

					$contact_persons->tenantID = $id;
					$contact_persons->salutation = $request->cn_salutation[$i];
					$contact_persons->names = $request->cn_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->designation = $request->cn_desgination[$i];

					$contact_persons->save();
				}
			}
		}

		Session::flash('success','Tenant has been successfully updated');

		return redirect()->back();
	}


   /**
	* Tenant show
	* */
   public function show($id)
   {
      //
   }

   /**
	* Tenant destroy
	* */
   public function delete($code)
   {
		//tenant details
		$tenant = tenants::where('tenant_code',$code)->where('businessID',Auth::user()->businessID)->first();

		//check if has invoice
		$checkInvoice = invoices::where('tenantID',$tenant->id)->where('businessID',Auth::user()->businessID)->count();
		if($checkInvoice != 0){
			Session::flash('warning','This tenant has bills linked to the account, please delete them first');

			return redirect()->back();
		}
		
		//delete tenant image
		if(!empty($tenant->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/tenant/'.$code.'/images/';

			$check = tenants::where('tenant_code',$code)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();

			if ($check > 0){
				$oldimagename = tenants::where('id','=',$tenant->id)->where('businessID',Auth::user()->businessID)->select('image')->first();
				$delete = $path.$oldimagename->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}
		}

		//recored activity
      $activities = Auth::user()->name.' Has deleted '.$tenant->tenant_name;
      $section = 'Property Management';
      $type = 'Delete';
      $adminID = Auth::user()->id;
      $activityID = $code;
      $businessID = Auth::user()->businessID;

		//delete tenanat
		$tenant->delete();

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Tenant successfully deleted');

		return redirect()->route('tenants.index');
   }
}
