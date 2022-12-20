<?php
namespace App\Http\Controllers\app\property;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\expense\expense;
use App\Models\finance\suppliers\contact_persons;
use App\Models\finance\products\product_information;
use App\Models\finance\suppliers\comments;
use App\Models\finance\suppliers\supplier_address;
use App\Models\finance\suppliers\category;
use App\Models\finance\suppliers\suppliers_categories;
use App\Models\wingu\country;
use App\Models\finance\lpo\lpo;
use App\Models\finance\invoice\invoices;
use File;
use Input;
use Helper;
use Session;
use Wingu;
use Auth;

class supplierController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$suppliers = suppliers::join('business','business.id','=','suppliers.businessID')
							->where('suppliers.businessID',Auth::user()->businessID)
							->select('*','suppliers.id as supplierID','contactType as contact_type','primaryPhoneNumber as primary_phone_number','otherPhoneNumber as other_phone_number','emailCC as email_cc','paymentTerms as payment_terms','suppliers.businessID as business_code')
							->OrderBy('suppliers.id','DESC')
							->get();
      $count = 1;

      return view('app.property.suppliers.index', compact('suppliers','count'));
	}

	public function create(){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
      $groups = category::OrderBy('id','DESC')->pluck('name','id');
      
		return view('app.property.suppliers.create', compact('country','groups'));
	}

	public function store(Request $request){
		$this->validate($request, [
			'email' => 'required',
			'primary_phone_number' => 'required',
		]);

		$primary = new suppliers;

		$code =  Helper::generateRandomString(10);

		$primary->contactType = $request->contact_type;
      $primary->referral = $request->referral;
      $primary->supplierCode = $code;
		$primary->salutation = $request->salutation;
		$primary->email = $request->email;
		$primary->supplierName = $request->supplierName;
		$primary->emailCC = $request->email_cc;
		$primary->primaryPhoneNumber = $request->primary_phone_number;
		$primary->otherPhoneNumber = $request->other_phone_number;
		$primary->currency = $request->currency;
		$primary->paymentTerms = $request->payment_terms;
		$primary->portal = $request->portal;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->website = $request->website;
		$primary->remarks = $request->remarks;
		$primary->position = $request->position;
		$primary->department = $request->department;
		$primary->businessID = Auth::user()->businessID;
      $primary->created_by = Auth::user()->id;

      if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/suppliers/'.$code.'/images/';

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
		$primary->save();


		//address
		$address = new supplier_address;
		$address->supplierID = $primary->id;
		$address->bill_attention = $request->bill_attention;
		$address->bill_street = $request->bill_street;
		$address->bill_city = $request->bill_city;
		$address->bill_state = $request->bill_state;
		$address->bill_zip_code = $request->bill_zip_code;
		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;
		$address->businessID = Auth::user()->businessID;
		$address->save();

		$contacts = count(collect($request->cn_names));

		//contact persons
		if($contacts > 0){
			if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {
					$contact_persons = new contact_persons;
					$contact_persons->supplierID = $id;
					$contact_persons->salutation = $request->cn_salutation[$i];
					$contact_persons->names = $request->cn_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->position = $request->cn_desgination[$i];
					$contact_persons->businessID = Auth::user()->businessID;
					$contact_persons->save();
				}
			}
		}

		//supplier group
		$category = count(collect($request->categories));
		if($category > 0){
	  		if(isset($_POST['categories'])){
				for($i=0; $i < count($request->categories); $i++ ) {
					$group = new suppliers_categories;
					$group->supplierID = $primary->id;
					$group->categoryID = $request->categories[$i];
					$group->businessID = Auth::user()->businessID;
					$group->save();
				}
	 		}
		}

		Session::flash('success','Supplier has been successfully Added');

		return redirect()->route('property.supplier'); 
	}

	public function edit($id){
		$country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose Country','');
		$suppliers = suppliers::join('supplier_address','supplier_address.supplierID','=','suppliers.id')
						->where('suppliers.businessID',Auth::user()->businessID)
						->where('suppliers.id',$id)
						->select('*','suppliers.id as supplierID','contactType as contact_type','primaryPhoneNumber as primary_phone_number','otherPhoneNumber as other_phone_number','emailCC as email_cc','paymentTerms as payment_terms')
						->first();

		$persons = contact_persons::where('supplierID',$id)->get();
		$count = 1;

		//category
      $category = category::where('businessID',Auth::user()->businessID)->get();
      $joincat = array();
      foreach ($category as $joint) {
         $joincat[$joint->id] = $joint->name;
      }

      //join category
      $getjoint = suppliers_categories::join('supplier_category','supplier_category.id', '=' ,'suppliers_categories.categoryID')
                  ->where('supplierID',$id)
                  ->select('supplier_category.id as catid')
                  ->get();
      $jointcategories = array();
      foreach($getjoint as $cj){
         $jointcategories[] = $cj->catid;
      }

		return view('app.property.suppliers.edit', compact('joincat','jointcategories','suppliers','count','country','persons'));
	}

	public function update(Request $request, $id){
		$this->validate($request, [
			'email' => 'required',
			'primary_phone_number' => 'required',
		]);

		$primary = suppliers::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/suppliers/'.$primary->reference_number.'/images/';

			if (!file_exists($path)) {
				mkdir($path, 0777,true);
			}

			$check = suppliers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();

			if ($check > 0){
				$oldimagename = suppliers::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image')->first();
				$delete = $path.$oldimagename->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
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

		$primary->contactType = $request->contact_type;
		$primary->referral = $request->referral;
		$primary->salutation = $request->salutation;
		$primary->supplierName = $request->supplierName;
		$primary->email = $request->email;
		$primary->emailCC = $request->email_cc;
		$primary->primaryPhoneNumber = $request->primary_phone_number;
		$primary->otherPhoneNumber = $request->other_phone_number;
		$primary->currency = $request->currency;
		$primary->paymentTerms = $request->payment_terms;
		$primary->portal = $request->portal;
		$primary->facebook = $request->facebook;
		$primary->twitter = $request->twitter;
		$primary->website = $request->website;
		$primary->remarks = $request->remarks;
		$primary->position = $request->position;
		$primary->department = $request->department;
		$primary->updated_by = Auth::user()->id;
		$primary->save();

		//address
		$address = supplier_address::where('supplierID',$id)->first();
		$address->bill_attention = $request->bill_attention;
		$address->bill_street = $request->bill_street;
		$address->bill_city = $request->bill_city;
		$address->bill_state = $request->bill_state;
		$address->bill_zip_code = $request->bill_zip_code;
		$address->bill_country = $request->bill_country;
		$address->bill_fax = $request->bill_fax;
		$address->bill_postal_address = $request->bill_postal_address;
		$address->save();


		$contacts = count(collect($request->cn_names));

		//contact persons
		if($contacts > 0){
			if(isset($_POST['cn_names'])){
				for($i=0; $i < count($request->cn_names); $i++ ) {
					$contact_persons = new contact_persons;
					$contact_persons->supplierID = $id;
					$contact_persons->salutation = $request->cn_salutation[$i];
					$contact_persons->names = $request->cn_names[$i];
					$contact_persons->contact_email = $request->email_address[$i];
					$contact_persons->phone_number = $request->phone_number[$i];
					$contact_persons->position = $request->cn_desgination[$i];
					$contact_persons->businessID = Auth::user()->businessID;
					$contact_persons->save();
				}
			}
		}


		//category
		$category = count(collect($request->categories));
		//delete existing category
		suppliers_categories::where('supplierID',$id)->delete();


		//add supplier
		$category = count(collect($request->categories));
		if($category > 0){
	  		if(isset($_POST['categories'])){
				for($i=0; $i < count($request->categories); $i++ ) {
					$group = new suppliers_categories;
					$group->supplierID = $primary->id;
					$group->categoryID = $request->categories[$i];
					$group->save();
				}
	 		}
		}

		Session::flash('success','Supplier has been successfully updated');

		return redirect()->back();
	}

	public function show($id){
		$clientID = $id;
		$count = 1;
		$client = suppliers::join('supplier_address','supplier_address.supplierID','=','suppliers.id')->where('suppliers.id',$id)->select('*','suppliers.id as cid')->first();

		//comments
		$comments = comments::where('clientID',$id)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

		//invoices
		$invoices = invoices::where('client_id',$clientID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

		return view('backend.property.suppliers.view', compact('client','clientID','comments','invoices'));
	}

	public function comment_post(Request $request){
		$this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
		$comment->comment = $request->comment;
		$comment->userID = Auth::user()->id;
		$comment->clientID = $request->clientID;
		$comment->businessID = Auth::user()->businessID;
		$comment->save();

		Session::flash('success', 'comment added');

		return redirect()->back();
	}

	public function comment_delete($id){

		comments::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();

		Session::flash('success', 'comment deleted');

		return redirect()->back();
	}

	public function delete_contact_person($id){

		$contact_person = contact_persons::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		$contact_person->delete();

		Session::flash('success','Contact person deleted');

		return redirect()->back();
	}

	//delete permanently
	public function delete($id){

		//check if linked to lpo
		$lpo = lpo::where('supplierID',$id)->where('businessID',Auth::user()->businessID)->count();

		//check if linked to products
		$products = product_information::where('supplierID',$id)->where('businessID',Auth::user()->businessID)->count();

		//check if linked to products
		$expense = expense::where('supplierID',$id)->where('businessID',Auth::user()->businessID)->count();

		if($lpo == 0 && $products == 0 && $expense == 0){

			$supplier = suppliers::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

			//delete image
			$check = suppliers::where('id',$id)->where('image','!=', "")->where('businessID',Auth::user()->businessID)->count();

			if ($check > 0){
				$oldimagename = suppliers::where('id',$id)->where('businessID',Auth::user()->businessID)->select('image')->first();

				$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/suppliers/'.$supplier->reference_number.'/images/';

				$delete = $path.$oldimagename->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			$persons = contact_persons::where('supplierID',$id)->where('businessID',Auth::user()->businessID)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			$supplier->delete();

			//delete address
			$address = supplier_address::where('supplierID',$id)->first();
			$address->delete();

			Session::flash('success','supplier was successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this supplier. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}

	public function express_save(Request $request){
      $suppliers = new suppliers;
      $suppliers->supplierName = $request->name;
      $suppliers->created_by = Auth::user()->id;
      $suppliers->businessID = Auth::user()->businessID;
		$suppliers->save();
		
		$address = new supplier_address;
		$address->supplierID = $suppliers->id;
		$address->save();

      //records activity
      $activities = Auth::user()->name.' Has added an expense suppliers';
      $section = 'Finance';
      $type = 'Suppliers';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
      $activityID = $suppliers->id;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);
   }

   public function express_list(Request $request)
   {
      $accounts = suppliers::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get(['id', 'supplierName as text']);
      return ['results' => $accounts];
   }
}