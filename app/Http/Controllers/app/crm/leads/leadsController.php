<?php
namespace App\Http\Controllers\app\crm\leads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\address;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\customer\customer_group;
use App\Models\crm\leads\status;
use App\Models\crm\leads\sources;
use App\Models\crm\leads\notes;
use App\Models\wingu\User;
use App\Models\wingu\languages;
use App\Models\wingu\country;
use App\Models\wingu\industry;
use App\Models\finance\invoice\invoices;
use App\Models\finance\estimate\estimates;
use App\Models\finance\creditnote\creditnote;
use App\Models\finance\quotes\quotes;
use App\Models\finance\customer\groups;
use Auth;
use Wingu;
use Session;
use Helper;

class leadsController extends Controller
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
      //check if user is linked to a business and allow access
      $leads = customers::where('customers.businessID',Auth::user()->businessID)
                        ->where('category','Lead')
                        ->select('*','customers.id as leadID')
                        ->OrderBy('customers.id','DESC')
                        ->get();
      $count = 1;
      return view('app.crm.leads.index', compact('leads','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(){
      $country = country::pluck('name','id')->prepend('Choose country', '');
      $languages = languages::pluck('name','id')->prepend('Choose language', '');
      $employees = User::where('businessID',Auth::user()->businessID)->select('name as names','id')->pluck('names','id')->prepend('Choose users');
      $status = status::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose status', '');
      $sources = sources::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose source', '');
      $industry = industry::pluck('name','id')->prepend('Choose industry');

      return view('app.crm.leads.create', compact('country','languages','employees','status','sources','industry'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'phone_number' => 'required',
         'leads_name' => 'required',
      ]);

      $code = Helper::generateRandomString(10);
      $leads = new customers;
      $leads->title = $request->title;
      $leads->contact_type = $request->lead_type;
      $leads->reference_number = $code;
      $leads->category = 'Lead';
      $leads->salutation = $request->salutation;
      $leads->customer_name = $request->leads_name;
      $leads->email = $request->email;
      $leads->primary_phone_number = $request->phone_number;
      $leads->designation = $request->position;
      $leads->website = $request->website;
      $leads->statusID = $request->status;
      $leads->sourceID = $request->sourceID;
      $leads->remarks = $request->description;
      $leads->created_by = Auth::user()->id;
      $leads->assignedID = $request->assignedID;
      $leads->businessID = Auth::user()->businessID;
      $leads->industryID = $request->industry;
      $leads->save();

      //billing
      $address = new address;
      $address->customerID = $leads->id;
      $address->bill_attention = $request->leads_name;
      $address->bill_city = $request->city;
      $address->bill_country  = $request->country;
      $address->bill_postal_address = $request->postal_address;
      $address->bill_state = $request->state;
      $address->bill_street = $request->location;
      $address->bill_zip_code = $request->zip_code;

      //shipping
      $address->ship_attention = $request->leads_name;
      $address->ship_street = $request->location;
      $address->ship_city = $request->city;
      $address->ship_state = $request->state;
      $address->ship_zip_code = $request->zip_code;
      $address->ship_country = $request->country;
      $address->save();

      $contacts = count(collect($request->cn_names));
      //contact persons
		if($contacts > 0){
         if(isset($_POST['cn_names'])){
            for($i=0; $i < count($request->cn_names); $i++ ) {
               $contact_persons = new contact_persons;
               $contact_persons->customerID = $leads->id;
               $contact_persons->salutation = $request->cn_salutation[$i];
               $contact_persons->names = $request->cn_names[$i];
               $contact_persons->contact_email = $request->email_address[$i];
               $contact_persons->phone_number = $request->cp_phone_number[$i];
               $contact_persons->designation = $request->cn_desgination[$i];
               $contact_persons->businessID = Auth::user()->businessID;
               $contact_persons->save();
            }
         }
      }

      Session::flash('success','Lead added successfully');

      return redirect()->route('crm.leads.index');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      $country = country::pluck('name','id')->prepend('Choose country', '');
      $languages = languages::pluck('name','id')->prepend('Choose language', '');
      $employees = User::where('businessID',Auth::user()->businessID)->select('name as names','id')->pluck('names','id')->prepend('Choose users');
      $status = status::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose status', '');
      $sources = sources::where('businessID',0)->pluck('name','id')->prepend('Choose source', '');
      $industry = industry::pluck('name','id')->prepend('Choose industry');
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $address = address::where('customerID',$id)->first();
      $persons = contact_persons::where('customerID',$id)->where('businessID',Auth::user()->businessID)->get();
      $customerID = $id;
      $count = 1;

      return view('app.crm.leads.show', compact('lead','customerID','country','languages','employees','status','sources','industry','persons','count','address'));
   }

   /**
    * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $edit = customers::join('customer_address','customer_address.customerID','=','customers.id')
                  ->where('customers.businessID',Auth::user()->businessID)
                  ->where('customers.id',$id)
                  ->select('*','customers.id as leadID','bill_country as country','statusID as status','industryID as industry','primary_phone_number as phone_number','bill_postal_address as postal_address','bill_city as city'
                  ,'bill_state as state','bill_zip_code as zip_code','bill_street as location','contact_type as lead_type','customer_name as leads_name','designation as position','remarks as description')
                  ->first();

      $phoneCode = country::pluck('phonecode','id')->prepend('Choose phone code', '');
      $country = country::pluck('name','id')->prepend('Choose country', '');
      $languages = languages::pluck('name','id')->prepend('Choose language', '');
      $employees = User::where('businessID',Auth::user()->businessID)->select('name as names','id')->pluck('names','id')->prepend('Choose users','');

      $status = status::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose status', '');
      $sources = sources::where('businessID',0)->pluck('name','id')->prepend('Choose source', '');
      $industry = industry::pluck('name','id')->prepend('Choose industry');
      $persons = contact_persons::where('customerID',$id)->where('businessID',Auth::user()->businessID)->get();
      $count = 1;

      return $sources;

      return view('app.crm.leads.edit', compact('country','languages','employees','status','sources','industry','edit','persons','count'));
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
      $this->validate($request, [
         'phone_number' => 'required',
         'leads_name' => 'required',
      ]);

      $leads = customers::where('businessID',Auth::user()->businessID)->where('category','Lead')->where('id',$id)->first();
      $leads->title = $request->title;
      $leads->contact_type = $request->lead_type;
      $leads->salutation = $request->salutation;
      $leads->customer_name = $request->leads_name;
      $leads->email = $request->email;
      $leads->primary_phone_number = $request->phone_number;
      $leads->designation = $request->position;
      $leads->website = $request->website;
      $leads->statusID = $request->status;
      $leads->sourceID = $request->sourceID;
      $leads->remarks = $request->description;
      $leads->updated_by = Auth::user()->id;
      $leads->assignedID = $request->assignedID;
      $leads->businessID = Auth::user()->businessID;
      $leads->industryID = $request->industry;
      $leads->save();

      //billing
      $address = address::where('customerID',$leads->id)->first();
      $address->bill_attention = $request->leads_name;
      $address->bill_city = $request->city;
      $address->bill_country  = $request->country;
      $address->bill_postal_address = $request->postal_address;
      $address->bill_state = $request->state;
      $address->bill_street = $request->location;
      $address->bill_zip_code = $request->zip_code;

      //shipping
      $address->ship_attention = $request->leads_name;
      $address->ship_street = $request->location;
      $address->ship_city = $request->city;
      $address->ship_state = $request->state;
      $address->ship_zip_code = $request->zip_code;
      $address->ship_country = $request->country;
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
               $contact_persons->phone_number = $request->cp_phone_number[$i];
               $contact_persons->designation = $request->cn_desgination[$i];
               $contact_persons->businessID = Auth::user()->businessID;
               $contact_persons->save();
            }
         }
      }

      Session::flash('success','Lead update successfully');

      return redirect()->back();
   }

   public function delete_contact_person($id){

      $contact_person = contact_persons::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $contact_person->delete();

      return redirect()->back();
   }

   public function convert($id){
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $lead->category = NULL;
      $lead->updated_by = Auth::user()->id;
      $lead->save();

      Session::flash('success','Lead successfully converted');

      return redirect()->route('crm.customers.index');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($id){

		//check if user is linked to any module
		//invoice
		$invoice = invoices::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//credit note
		$creditnote = creditnote::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		//quotes
		$quotes = quotes::where('businessID',Auth::user()->businessID)->where('customerID',$id)->count();

		if($invoice == 0 && $creditnote == 0 &&  $quotes == 0){

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

			Session::flash('success','Contact was successfully deleted');

			return redirect()->back();
		}else{
			Session::flash('error','You have recorded transactions for this contact. Hence, this contact cannot be deleted.');

			return redirect()->back();
		}
	}
}
