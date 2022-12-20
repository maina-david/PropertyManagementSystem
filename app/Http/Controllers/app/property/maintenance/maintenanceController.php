<?php

namespace App\Http\Controllers\app\property\maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\property;
use App\Models\property\lease;
use App\Models\property\tenants\tenants;
use App\Models\property\landlord\landlords;
use App\Models\property\maintenance\category;
use App\Models\property\maintenance\maintenance;; 
use App\Models\finance\suppliers\suppliers;
use Auth;
use Session;
use Helper;
class maintenanceController extends Controller
{
   public function index(){
      $requests = maintenance::join('property','property.id','property_maintenance_request.property')
                              ->join('property_tenants','property_tenants.id','=','property_maintenance_request.tenant')
                              ->where('property_maintenance_request.businessID',Auth::user()->businessID)
                              ->orderby('property_maintenance_request.id','desc')
                              ->select('*','property_maintenance_request.id as reqID')
                              ->get();
                              
      $count = 1;

      return view('app.property.maintenance.index', compact('requests','count'));
   }

   /**
   * create request
   */
   public function create(){
      $properties = property::where('businessID',Auth::user()->businessID)
                  ->where('parentID',0)
                  ->pluck('title','id')
                  ->prepend('choose properties','');

      $category = category::where('parentID',0)
                  ->pluck('name','id')
                  ->prepend('Choose parent category','0');

      $suppliers = suppliers::where('businessID',Auth::user()->businessID)
                  ->pluck('supplierName','id')
                  ->prepend('choose service supplier');

      return view('app.property.maintenance.create', compact('properties','category','suppliers'));
   }

   /**
   * get property units
   */
   public function get_units($propertyID){
      $units = property::where('businessID',Auth::user()->businessID)
                  ->where('parentID',$propertyID)
                  ->where('leaseID','!=','Null')
                  ->get();

                  return \Response::json($units);
   }

   /*
      get tenant
   */
   public function get_tenant($id){
      $unit = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $tenant = tenants::where('id',$unit->tenantID)->where('businessID',Auth::user()->businessID)->get();

      return \Response::json($tenant);
   }

   /*
   `get category
   */ 
   public function get_maintenance_category($id){
      $category = category::where('parentID',$id)->get();

      return \Response::json($category);          
   }

   /*
      store request
   */ 
   public function store(Request $request){
      $this->validate($request, [
         'property' => 'required',
         'unitID' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'tenant' => 'required',
         'available_date' => 'required',
         'available_time' => 'required',
         'authorization_to_enter' => 'required',
         'issue_title' => 'required',
         'category' => 'required',
         'sub_category' => 'required',
         'issue_details' => 'required',
         'service_provider_type' => 'required',
         'initiated_date' => 'required',
         'due_date' => 'required',
      ]);
      
      $maintenance = new maintenance;
      $maintenance->businessID = Auth::user()->businessID;
      $maintenance->userID = Auth::user()->id;
      $maintenance->property = $request->property;
      $maintenance->requestID = Helper::generateRandomString(7);
      $maintenance->unitID = $request->unitID;
      $maintenance->priority = $request->priority;
      $maintenance->status = $request->status;
      $maintenance->tenant = $request->tenant;
      $maintenance->available_date = $request->available_date;
      $maintenance->available_time = $request->available_time;
      $maintenance->authorization_to_enter = $request->authorization_to_enter;
      $maintenance->pet_in_residence = $request->pet_in_residence;
      $maintenance->authorization_type = $request->authorization_type;
      if($request->authorization_type != ""){
         $auth = $request->authorization_type;
         $authImplode = implode(", ", $auth);

         $maintenance->authorization_type = substr($authImplode, 0);
      }
      $maintenance->pet_secured = $request->pet_secured;
      if($request->pet != ""){
         $pet = $request->pet;
         $petImplode = implode(", ", $pet);

         $maintenance->pet = substr($petImplode, 0);
      }
      $maintenance->issue_title = $request->issue_title;
      $maintenance->category = $request->category;
      $maintenance->sub_category = $request->sub_category;
      $maintenance->issue_details = $request->issue_details;
      $maintenance->service_provider_type = $request->service_provider_type;
      $maintenance->initiated_date = $request->initiated_date;
      $maintenance->due_date = $request->due_date;
      $maintenance->started_to_work_date = $request->started_to_work_date; 
      $maintenance->completed_work_date = $request->completed_work_date;
      $maintenance->save();

      Session::flash('success','Request successfully added');

      return redirect()->route('property.maintenance');
   }

   /**
   * Edit Request 
   */
   public function edit($id){
      $category = category::where('parentID',0)
                  ->pluck('name','id')
                  ->prepend('Choose parent category','0');

      $suppliers = suppliers::where('businessID',Auth::user()->businessID)
                  ->pluck('supplierName','id')
                  ->prepend('choose service supplier');

      $properties = property::where('businessID',Auth::user()->businessID)
                  ->where('parentID',0)
                  ->pluck('title','id')
                  ->prepend('choose properties','');
      
      return view('app.property.maintenance.edit', compact('category','suppliers','properties'));
   }
} 