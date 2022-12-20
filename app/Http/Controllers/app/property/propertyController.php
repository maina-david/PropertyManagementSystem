<?php
namespace App\Http\Controllers\app\property;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\type;
use App\Models\wingu\business;
use App\Models\property\property;
use App\Models\wingu\country;
use App\Models\wingu\documents;
use App\Models\property\lease;
use App\Models\property\listings;
use App\Models\finance\customer\customers;
use App\Models\property\invoice\invoices;
use App\Models\property\tenants\tenants;
use App\Models\property\invoice\invoice_settings;
use Auth;
use Session;
use Wingu; 
use Helper;
use File;
use Property as prop;

class propertyController extends Controller
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
      $properties = property::where('parentID',0)
                            ->where('businessID', Auth::user()->businessID)
                            ->orderby('id','Desc')
                            ->get();
      $count = 1;

      return view('app.property.property.index', compact('properties','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
       $landlords = customers::join('business','business.id','=','customers.businessID')
                     ->where('customers.businessID',Auth::user()->businessID)
                     ->whereNull('category')
                     ->select('*','customers.id as customerID','customers.created_at as date_added')
                     ->OrderBy('customers.id','DESC')
                     ->get();
       $country = country::pluck('name','id')->prepend('Choose county','');
       $types = type::where('status',15)->get();
 
       return view('app.property.property.create', compact('landlords','country','types'));
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
         'property_type' => 'required',
         'title' => 'required',
         'street_address' => 'required',
         'city' => 'required',
         'state' => 'required',
         'country' => 'required',
      ]);
      $code = Helper::generateRandomString(12);
      $property = new property;
      $property->businessID = Auth::user()->businessID;
      $property->created_by = Auth::user()->id;
      $property->title = $request->title;
      $property->parentID = 0;
      $property->serial = Helper::generateRandomString(9);
      $property->property_code = $code;
      $property->landlordID = $request->landlord;
      $property->year_built = $request->year_built; 
      $property->property_type = $request->property_type;
      $property->city = $request->city;
      $property->street_address = $request->street_address;
      $property->state = $request->state;
      $property->zip_code = $request->zip_code;
      $property->countryID = $request->country;
      $property->bedrooms = $request->bedrooms;
      $property->bathrooms = $request->bathrooms;
      $property->size = $request->size;
      $property->geolocation = $request->geolocation;
      $property->latitude = $request->lat;
      $property->longitude = $request->lng;
      $property->price = $request->price;
      $property->land_size = $request->land_size;
      $property->parking_size = $request->parking_size;
      $property->management_name = $request->management_name;
      $property->management_email = $request->management_email;
      $property->management_phonenumber = $request->management_phonenumber;
      $property->management_postaladdress = $request->management_postaladdress;

      if($request->features != ""){
         $features = $request->features;
         $featimpload = implode(", ", $features);

         $property->features = substr($featimpload, 1);
      }

      if($request->amenities != ""){
         $amenities = $request->amenities;
         $amenimpload = implode(", ", $amenities);

         $property->amenities = substr($amenimpload, 1);
      }

      $property->smoking = $request->smoking;
      $property->laundry = $request->laundry;
      $property->furnished = $request->furnished;
      $property->description = $request->description;
      $property->status = $request->status;

      if(!empty($request->image)){
			$path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$code.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

			$file = $request->file('image');

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();
         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(). '.' . $extension;
         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $property->image = $fileName;
      }

      $property->save();

      //check if property has settings 
      $check = invoice_settings::where('propertyID',$property->id)->where('businessID',Auth::user()->businessID)->count();
      if($check != 1){
         prop::make_invoice_settings($property->id);
		}

      Session::flash('success','Property added successfully');

      return redirect()->route('property.index'); 
   }
 
   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
      if($check == 1 ){ 
         $year = date('Y');
         $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
         $business = business::join('currency','currency.id','=','business.base_currency')
                              ->where('business.id',Auth::user()->businessID)
                              ->where('businessID',Auth::user()->code)
                              ->first();
                              
         $outstandingInvoices = invoices::where('propertyID',$id)->where('businessID',Auth::user()->businessID)->where('invoice_type','Rent')->sum('balance');
         $outstandingUtility= invoices::where('propertyID',$id)->where('businessID',Auth::user()->businessID)->where('invoice_type','Utility')->sum('balance');
         $payed = invoices::where('propertyID',$id)
                           ->whereYear('invoice_date', '=', $year)
                           ->where('businessID',Auth::user()->businessID)
                           ->where('invoice_type','Rent')
                           ->sum('balance');

         $tenants = lease::where('businessID',Auth::user()->businessID)
                           ->where('propertyID',$id)
                           ->where('statusID',15)
                           ->groupby('tenantID')
                           ->get(); 

         $activeLease = lease::where('businessID',Auth::user()->businessID)
                           ->where('propertyID',$id)
                           ->where('statusID',15)
                           ->count(); 

         $vacant = property::where('businessID',Auth::user()->businessID)->whereNull('tenantID')->where('parentID',$id)->count();

         $occupied = property::where('businessID',Auth::user()->businessID)->where('tenantID','!=',"")->where('parentID',$id)->count();

         $owner = property::where('businessID',Auth::user()->businessID)
                           ->where('landlordID','!=',"")
                           ->where('parentID',$id)
                           ->groupby('landlordID')
                           ->get();

         $units = property::where('businessID',Auth::user()->businessID)->where('parentID',$id)->count();

         $propertyID = $id;

         return view('app.property.property.details', compact('property','outstandingInvoices','business','outstandingUtility','payed','units','tenants','owner','vacant','occupied','activeLease','propertyID'));
      }else{
         return view('errors.403');
      }
   }
  
   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $landlords = customers::where('businessID',Auth::user()->businessID)->orderby('id','Desc')->get();
      $tenants = tenants::where('businessID',Auth::user()->businessID)->orderby('id','Desc')->get();
      $country = country::pluck('name','id')->prepend('Choose county','');
      $type = type::pluck('name','id')->prepend('Choose type','');
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $propertyID = $id;

      return view('app.property.property.edit', compact('landlords','tenants','country','type','property','propertyID'));
   }
 
   /**
   * Display all vacant units
   *
   */
   public function vacant($id)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->where('businessID',Auth::user()->code)
                           ->first();

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $units = property::where('businessID',Auth::user()->businessID)
                     ->where('parentID',$id)
                     ->whereNull('tenantID')
                     ->orderby('property.id','desc')
                     ->select('*', 'property.id as propID','property.property_type as typeID')
                     ->get();
      $count = 1;
      $propertyID = $id;

      return view('app.property.property.units.vacant', compact('property','units','count','business','propertyID'));
   }
 
   /**
   * Display all occupied units
   *
   */
   public function occupied($id)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->where('businessID',Auth::user()->code)
                           ->first();

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $units = property::join('property_tenants','property_tenants.id','=','property.tenantID')
               ->join('property_lease','property_lease.id','=','property.leaseID')
               ->where('property.businessID',Auth::user()->businessID)
               ->where('property.parentID',$id)
               ->where('property.tenantID','!=', '')
               ->orderby('property.id','desc')
               ->select('*', 'property.id as propID')
               ->get();
      $count = 1;
      $propertyID = $id;

      return view('app.property.property.units.occupied', compact('property','units','count','business','propertyID'));
   }
 
   /**
   * Display all occupied units
   *
   */
   public function tenants($id)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $tenants = property::join('tenants','property_tenants.id','=','property.tenantID')
                  ->join('property_lease','property_lease.unitID','=','property.id')
                  ->where('property.parentID',$id)
                  ->whereNull('property_lease.statusID')
                  ->orderby('property_tenants.id','desc')
                  ->select('*','property_tenants.id as tenantID')
                  ->get();
      $count = 1;
      
      return view('app.property.property.tenants.index', compact('property','tenants','count'));
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
            'property_type' => 'required',
            'title' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'countryID' => 'required',
      ]);
      $code = Helper::generateRandomString(12);
      $property = property::find($id);
      $property->businessID = Auth::user()->businessID;
      $property->updated_by = Auth::user()->id;
      $property->title = $request->title;
      $property->serial = Helper::generateRandomString(9);
      $property->landlordID = $request->landlord;
      if($property->property_code == ""){
         $property->property_code = $code;
      }
      $property->year_built = $request->year_built;
      $property->property_type = $request->property_type;
      $property->city = $request->city;
      $property->street_address = $request->street_address;
      $property->state = $request->state;
      $property->zip_code = $request->zip_code;
      $property->countryID = $request->countryID;
      $property->bedrooms = $request->bedrooms;
      $property->bathrooms = $request->bathrooms;
      $property->size = $request->size;
      $property->geolocation = $request->geolocation;
      $property->latitude = $request->lat;
      $property->longitude = $request->lng;
      $property->land_size = $request->land_size;
      $property->parking_size = $request->parking_size;
      $property->price = $request->price;
      $property->management_name = $request->management_name;
      $property->management_email = $request->management_email;
      $property->management_phonenumber = $request->management_phonenumber;
      $property->management_postaladdress = $request->management_postaladdress;

      if($request->features != ""){
         $features = $request->features;
         $featimpload = implode(", ", $features);

         $property->features = substr($featimpload, 0);
      }

      if($request->amenities != ""){
            $amenities = $request->amenities;
            $amenimpload = implode(", ", $amenities);

            $property->amenities = substr($amenimpload, 0);
      }

      $property->smoking = $request->smoking;
      $property->laundry = $request->laundry;
      $property->furnished = $request->furnished;
      $property->description = $request->description;
      $property->status = $request->status;

      if(!empty($request->image)){
         $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/';

         if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         $check = property::where('id','=',$id)->where('businessID',Auth::user()->businessID)->where('image','!=', "")->count();

         if ($check > 0){
            $oldimagename = property::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image')->first();
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

         $property->image = $fileName;
      }

      $property->save();

      Session::flash('success','Property updated successfully');

      return redirect()->back();
   }
 
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function information($id)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      return view('app.property.property.information', compact('property'));
   }
 
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update_information(Request $request, $id)
   {
      $this->validate($request, [
            'management_name' => 'required',
            'management_email' => 'required',
            'management_phonenumber' => 'required',
            'management_postaladdress' => 'required',
      ]);

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $property->businessID = Auth::user()->businessID;
      $property->userID = Auth::user()->id;
      $property->management_name = $request->management_name;
      $property->management_email = $request->management_email;
      $property->management_phonenumber = $request->management_phonenumber;
      $property->management_postaladdress = $request->management_postaladdress;
      $property->bank_name = $request->bank_name;
      $property->bank_branch = $request->bank_branch;
      $property->bank_account_number = $request->bank_account_number;
      $property->bank_account_name = $request->bank_account_name;
      $property->paybill_number = $request->paybill_number;
      $property->paybill_name = $request->paybill_name;
      $property->invoice_number = $request->invoice_number;
      $property->invoice_prefix = $request->invoice_prefix;
      $property->credit_note_number = $request->credit_note_number;
      $property->credit_note_prefix = $request->credit_note_prefix;        
      $property->save();

      Session::flash('success','Information successfully updated');

      return redirect()->back();
   }

   //remove property image
   public function remove_image($id){
      $property = property::where('id','=',$id)->where('businessID',Auth::user()->businessID)->first();
      $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/';

      //delete image from folder
      $oldimagename = property::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image')->first();
      $delete = $path.$oldimagename->image;
      if (File::exists($delete)) {
         unlink($delete);
      }

      //update image        
      $property ->image = NULL;
      $property->save();

      Session::flash('success','Image successfully removed');

      return redirect()->back();
   }

   /**
    * Delete Property
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function delete($id){
      //check if property is listed
      $checkListing = listings::where('propertyID',$id)->where('businessID',Auth::user()->businessID)->count();

      //check if has leases
      $checkLease = lease::where('propertyID',$id)->where('businessID',Auth::user()->businessID)->count();

      if($checkListing == 0 && $checkLease == 0){
         $property = property::where('id','=',$id)->where('businessID',Auth::user()->businessID)->first();
         $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/';

         //delete image from folder
         $oldimagename = property::where('id','=',$id)->where('businessID',Auth::user()->businessID)->select('image')->first();
         $delete = $path.$oldimagename->image;
         if (File::exists($delete)) {
            unlink($delete);
         }

         //update image        
         $property->delete();

         Session::flash('success','Property successfully deleted');

         return redirect()->route('property.index');
      }

      Session::flash('warning','Make sure their no Leases linked to the property and the property is not listed in the marketing section');

      return redirect()->back();
   }

}
