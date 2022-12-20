<?php

namespace App\Http\Controllers\app\property\property;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\property;
use App\Models\finance\customer\customers as landlords;
use App\Models\property\tenants\tenants;
use App\Models\property\type;  
use App\Models\property\lease; 
use Auth;
use Session;
use Helper;
class unitsController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($id)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $units = property::where('businessID',Auth::user()->businessID)
               ->where('parentID',$id)
               ->orderby('property.id','desc')
               ->select('*', 'property.id as propID')
               ->get();
               
      $count = 1;
      $propertyID = $id;
      return view('app.property.property.units.index', compact('property','units','count','propertyID'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create($id)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $landlords = landlords::join('customer_group','customer_group.customerID','=','customers.id')
							->where('customers.businessID',Auth::user()->businessID)
							->where('customer_group.groupID',1)
							->select('*','customers.id as customerID','customers.created_at as date_added')
							->OrderBy('customers.id','DESC')
							->get();
      $tenants = tenants::where('businessID',Auth::user()->businessID)->orderby('id','Desc')->get();
      $type = type::pluck('name','id')->prepend('choose property type');
      $propertyID = $id;

      return view('app.property.property.units.create', compact('property','landlords','tenants','type','propertyID'));
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
         'parentID' => 'required'
      ]);

      //validate the parent property to avoid users changing value via browser
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$request->parentID)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');

         return redirect()->back();
      }

      $property = new property;
      $property->businessID = Auth::user()->businessID;
      $property->created_by = Auth::user()->id;
      $property->property_code = Helper::generateRandomString(16);
      $property->parentID = $request->parentID;
      $property->serial = $request->serial;
      $property->property_type = $request->property_type;
      $property->ownwership_type = $request->ownwership_type;
      $property->landlordID = $request->landlord;
      $property->year_built = $request->year_built;
      $property->bedrooms = $request->bedrooms;
      $property->bathrooms = $request->bathrooms;
      $property->size = $request->size;
      $property->price = $request->price;
      if($request->features != ""){
         $features = $request->features;
         $featimpload = implode(", ", $features);

         $property->features = substr($featimpload, 0);
      }
      $property->smoking = $request->smoking;
      $property->laundry = $request->laundry;
      $property->furnished = $request->furnished;
      $property->description = $request->description;
      $property->save();

      Session::flash('success','The unit have been successfully added');

      return redirect()->route('property.units',$request->parentID);

   }

   /**
 * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function bulk($id)
   {
      //check if user is linked to a business and allow access
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
      if($check == 1 ){

         $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
         $landlords = landlords::where('businessID',Auth::user()->businessID)->orderby('id','Desc')->get();
         $tenants = tenants::where('businessID',Auth::user()->businessID)->orderby('id','Desc')->get();
         $type = type::pluck('name','id')->prepend('choose unite type');
         $propertyID = $id;
         return view('app.property.property.units.bulk', compact('property','landlords','tenants','type','propertyID'));

      }else{
         return view('errors.403');
      }
   }


   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store_bulk(Request $request)
   {
      $this->validate($request, [
         'total_units' => 'required',
         'parentID' => 'required'
      ]);

      //validate the parent property to avoid users changing value via browser
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$request->parentID)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');

         return redirect()->back();
      }

      $range = $request->total_units;
      $start = 1;

      for ($i = $start; $i <= $range; $i++) {
         $property = new property;
         $property->businessID = Auth::user()->businessID;
         $property->updated_by = Auth::user()->id;
         $property->parentID = $request->parentID;
         if($request->prefix != ""){
            $property->serial = $request->prefix.$i;
         }else{
            $property->serial = Helper::generateRandomString(9);
         }
         $property->landlordID = $request->landlord;
         $property->property_type = $request->property_type;
         $property->year_built = $request->year_built;
         $property->bedrooms   = $request->bedrooms;
         $property->bathrooms  = $request->bathrooms;
         $property->ownwership_type = $request->ownwership_type;
         $property->size = $request->size;
         $property->price = $request->price;
         if($request->features != ""){
            $features = $request->features;
            $featimpload = implode(", ", $features);
            $property->features = substr($featimpload, 0);
         }
         $property->smoking = $request->smoking;
         $property->laundry = $request->laundry;
         $property->furnished = $request->furnished;
         $property->description = $request->description;
         $property->save();
      }

      Session::flash('success','The '.$range.' units have been successfully added');

      return redirect()->route('property.units',$request->parentID);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($pid,$uid)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$pid)->first();
      $landlords = landlords::where('businessID',Auth::user()->businessID)->orderby('id','Desc')
                              ->select('customers.id as landlordID','customers.customer_name as landlord')
                              ->pluck('landlord','landlordID')
                              ->prepend('choose landlord','');
                     
      $unit = property::where('businessID',Auth::user()->businessID)->where('id',$uid)->first();

      $type = type::pluck('name','id')->prepend('choose unite type');
      $propertyID = $pid;
      
      return view('app.property.property.units.edit', compact('property','landlords','unit','type','propertyID'));
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
         'parentID' => 'required',
         'serial' => 'required'
      ]);

      //validate the parent property to avoid users changing value via browser
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');

         return redirect()->back();
      }

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $property->businessID = Auth::user()->businessID;
      $property->updated_by = Auth::user()->id;
      $property->parentID = $request->parentID;
      $property->serial = $request->serial;
      $property->property_type = $request->property_type; 
      $property->landlordID = $request->landlordID;
      $property->year_built = $request->year_built;
      $property->bedrooms = $request->bedrooms;
      $property->ownwership_type = $request->ownwership_type;
      $property->bathrooms = $request->bathrooms;
      $property->size = $request->size;
      $property->price = $request->price;
      if($request->features != ""){
         $features = $request->features;
         $featimpload = implode(", ", $features);

         $property->features = substr($featimpload, 0);
      }
      $property->smoking = $request->smoking;
      $property->laundry = $request->laundry;
      $property->furnished = $request->furnished;
      $property->description = $request->description;
      $property->save();

      Session::flash('success','The unit has been successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($pid,$uid)
   {
      //check if unit is linked to a lease
      $check = lease::where('unitID',$uid)->where('propertyID',$pid)->where('businessID',Auth::user()->businessID)->count();

      if($check != 0){
         Session::flash('warning','This unit is linked to a lease and you can not delete it');

         return redirect()->route('property.units',$pid);
      }

      property::where('businessID',Auth::user()->businessID)->where('parentID',$pid)->where('id',$uid)->delete();

      Session::flash('success','Unit successfully deleted');

      return redirect()->route('property.units',$pid);
   }
}
