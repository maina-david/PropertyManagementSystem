<?php

namespace App\Http\Controllers\app\property\property\tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\property\tenants\tenants;
use App\Models\property\lease;
use App\Models\wingu\business;
use App\Models\property\utilities;
use App\Models\property\lease_utility;
use App\Models\property\invoice\invoice_products;
use App\Models\property\invoice\invoices;
use App\Models\finance\tax;
use Helper;
use Auth;
use Session;
use Response; 

class leasesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($propertyID,$tenantID)
   { 
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
      $leases = lease::join('property_tenants','property_tenants.id','=','property_lease.tenantID')
                     ->join('property','property.id','=','property_lease.propertyID')
                     ->where('property_lease.propertyID',$propertyID)
                     ->where('property_lease.tenantID',$tenantID)   
                     ->where('property_lease.businessID',Auth::user()->businessID)  
                     ->select('property.id as propertyID','property_lease.id as leaseID','property_tenants.id as tenantID','property_lease.lease_code as code','property_lease.lease_type as type','property_tenants.tenant_name as tenant_name','next_invoice','last_invoiced','billing_schedule','lease_end_date','lease_start_date','property_lease.statusID as status')
                     ->orderby('property_lease.id','desc')
                     ->get(); 

      $tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
								->where('property_tenants.id',$tenantID)
								->select('*','property_tenants.id as tenantID')
								->first();
      $count = 1;

      return view('app.property.property.tenants.leases.index', compact('property','leases','count','propertyID','tenantID','tenant'));
   }

   
   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($propertyID,$tenantID,$leasID)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('businessID',Auth::user()->code)
                           ->where('business.id',Auth::user()->businessID)
                           ->first();
                           
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      if($property->property_type == 1 or $property->property_type == 3){
         $lease = lease::join('property_tenants','property_tenants.id','=','property_lease.tenantID')
                        ->join('property','property.id','=','property_lease.propertyID')
                        ->where('property_lease.propertyID',$propertyID)
                        ->where('property_lease.id',$leasID)
                        ->where('property.id',$propertyID)
                        ->where('property_lease.businessID',Auth::user()->businessID)  
                        ->where('property_lease.tenantID',$tenantID)                   
                        ->orderby('property_lease.id','desc')
                        ->select('*','property_lease.id as leaseID','property_lease.unitID as unitID','property.title as propertyName','property_lease.statusID as status')
                        ->first();

      }else{
         $lease = lease::join('property_tenants','property_tenants.id','=','property_lease.tenantID')
                        ->join('property','property.id','=','property_lease.unitID')
                        ->where('property_lease.propertyID',$propertyID)
                        ->where('property_lease.id',$leasID)
                        ->where('property_lease.businessID',Auth::user()->businessID)  
                        ->where('property_lease.tenantID',$tenantID)                   
                        ->orderby('property_lease.id','desc')
                        ->select('*','property_lease.id as leaseID','property_lease.unitID as unitID','property.title as propertyName')
                        ->first();
      }

      $tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
								->where('property_tenants.id',$tenantID)
								->select('*','property_tenants.id as tenantID')
								->first();
      $count = 1;

      return view('app.property.property.tenants.leases.show', compact('property','lease','count','propertyID','tenantID','tenant','business'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($propertyID,$tenantID,$leasID)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('businessID',Auth::user()->code)
                           ->where('business.id',Auth::user()->businessID)
                           ->first();

      if($property->property_type == 1 or $property->property_type == 3){
         $lease = lease::join('property','property.id','=','property_lease.propertyID')
                  ->where('property_lease.id',$leasID)
                  ->where('property_lease.businessID',Auth::user()->businessID)
                  ->select('*','property_lease.id as leaseID','property_lease.service_charge as serviceCharge')
                  ->first();
         $currentUnit = [];
      }else{
         $lease = lease::join('property','property.id','=','property_lease.unitID')
                  ->where('property_lease.id',$leasID)
                  ->where('property_lease.businessID',Auth::user()->businessID)
                  ->select('*','property_lease.id as leaseID','property_lease.service_charge as serviceCharge','property_lease.unitID as unit')
                  ->first();

         $currentUnit = property::where('id',$lease->unit)->where('businessID',Auth::user()->businessID)->first();
        
      }


      $tenants = tenants::where('businessID',Auth::user()->businessID)->orderby('id','Desc')->get();
      $tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
                        ->where('property_tenants.id',$tenantID)
                        ->where('property_tenants.businessID',Auth::user()->businessID)
                        ->select('*','property_tenants.id as tenantID')
                        ->first();
                        
      $units = property::where('businessID',Auth::user()->businessID)
               ->where('parentID',$propertyID)
               ->whereNull('tenantID')
               ->orderby('id','desc')
               ->get();

      $utilities = utilities::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $selected_utility = lease_utility::join('property_utilities','property_utilities.id','=','property_lease_utility.utilityID')
                        ->where('property_lease_utility.businessID',Auth::user()->businessID)
                        ->where('property_lease_utility.leaseID',$leasID)
                        ->select('*','property_lease_utility.id as leaseUtilityID')
                        ->get();

      $taxes = tax::where('businessID',Auth::user()->businessID)->get();

      $count = 1;

      return view('app.property.property.tenants.leases.edit', compact('property','lease','count','propertyID','tenantID','tenant','taxes','tenants','tenant','utilities','selected_utility','business','units','currentUnit'));
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   function update(Request $request,$id){
      $this->validate($request, [
         'propertyID' => 'required',
         'unitID' => 'required',
         'lease_type' => 'required',
         'lease_start_date' => 'required',
         'tenant' => 'required',
         'rent_amount' => 'required',
         'billing_schedule' => 'required',
         'first_invoice_date' => 'required',
         'due_day' => 'required',
      ]);

      $lease = lease::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $lease->propertyID = $request->propertyID;
      $lease->unitID = $request->unitID;
      $lease->lease_type = $request->lease_type;
      $lease->lease_start_date = $request->lease_start_date;
      $lease->lease_end_date = $request->lease_end_date;
      $lease->tenantID = $request->tenant;
      $lease->deposit = $request->deposit;
      $lease->rent_amount = $request->rent_amount;
      $lease->billing_schedule = $request->billing_schedule;
      $lease->first_invoice_date = $request->first_invoice_date;
      $lease->due_day = $request->due_day;
      $lease->escalation_rate = $request->escalation_rate;
      $lease->escalation_period = $request->escalation_period;
      $lease->service_charge = $request->service_charge;
      $lease->define_service_charge = $request->define_service_charge;
      $lease->parking_price = $request->parking_price;
      $lease->parking_spaces = $request->parking_spaces;
      $lease->tax_rate = $request->tax_rate;
      $lease->include_utility = $request->include_utility;
      $lease->agreement = $request->agreement;
      $lease->updated_by = Auth::user()->id;
      $lease->businessID = Auth::user()->businessID;
      if($request->escalating_items != ""){
         $items = $request->escalating_items;
         $Itemimpload = implode(", ", $items);
         $lease->escalating_items = substr($Itemimpload, 0);
      }
      $lease->save();


      $propertyCheck = property::where('businessID',Auth::user()->businessID)->where('id',$request->propertyID)->first();
      if($propertyCheck->property_type == 1 or $propertyCheck->property_type == 3){
         //update for single unit property
         $property = property::where('businessID',Auth::user()->businessID)->where('id',$request->propertyID)->first();
         $property->tenantID = $request->tenant;
         $property->leaseID = $lease->id;
         $property->save();
      }else{
         //update for multi unit property
         $property = property::where('businessID',Auth::user()->businessID)->where('id',$request->unitID)->first();
         $property->tenantID = $request->tenant;
         $property->leaseID = $lease->id;
         $property->save();
      }

      Session::flash('success', 'Lease successfully Updated');

      return redirect()->route('property.tenant.lease.edit',[$request->propertyID,$request->tenant,$id]);
   }

   /**
   * Add utility 
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function add_utility(Request $request){
      $this->validate($request,[
         'utility' => 'required',
         'last_reading' => 'required',
         'unit_price' => 'required',
         'leaseID' => 'required',
      ]);

      //check if utility is allocated
      $check = lease_utility::where('businessID',Auth::user()->businessID)->where('leaseID',$request->leaseID)->where('utilityID',$request->utility)->count();
      if($check != 0){
         Session::flash('warning','The Utility is already linked to the lease');

         return redirect()->back();
      }

      $util = new lease_utility;
      $util->businessID	 = Auth::user()->businessID;
      $util->created_by  = Auth::user()->id;
      $util->leaseID = $request->leaseID;
      $util->utilityID = $request->utility;
      $util->utility_No = $request->utility_No;
      $util->last_reading = $request->last_reading;
      $util->initial_price = $request->unit_price;
      $util->save();

      Session::flash('success','Utility successfully added');

      return redirect()->back();
   }

   /**
   * Update utility 
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update_utility(Request $request){
   $this->validate($request,[
      'utility' => 'required',
      'initial_readings' => 'required',
      'initial_price' => 'required',
      'leaseID' => 'required',
   ]);

   //check if utility is allocated
   $util = lease_utility::where('id',$request->utilityID)->where('leaseID',$request->leaseID)->where('businessID',Auth::user()->businessID)->first();

   return $util;

   $util->businessID	 = Auth::user()->businessID;
   $util->created_by  = Auth::user()->id;
   $util->leaseID = $request->leaseID;
   $util->utilityID = $request->utility;
   $util->utility_No = $request->utility_No;
   $util->initial_reading = $request->initial_readings;
   $util->previous_reading = $request->initial_readings;
   $util->initial_price = $request->initial_price;
   $util->save();

   Session::flash('success','Utility successfully updated');

   return redirect()->back();
}
 
   /**
   * delete utility 
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete_utility($leaseID,$utilityID){
      //check if utility is linked to any billing 
      $check = invoices::where('leaseUtilityID',$utilityID)->where('businessID',Auth::user()->businessID)->where('leaseID',$leaseID)->count();

      if($check != 0){
         Session::flash('warning','This utility is linked to a billing transaction it can not be deleted');
         
         return redirect()->back();
      }

      lease_utility::where('businessID',Auth::user()->businessID)->where('leaseID',$leaseID)->where('id',$utilityID)->delete();

      Session::flash('success','Utility successfully deleted');

      return redirect()->back();
   }

   /**
   * Terminate lease 
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function lease_termination(Request $request){
      $lease = lease::where('businessID',Auth::user()->businessID)->where('id',$request->leaseID)->first();

      $lease->statusID = 26;
      $lease->lease_end_date = $request->lease_termination_date;
      $lease->lease_termination_note = $request->lease_termination_note;
      $lease->save();
      
      //property
      $property = property::where('businessID',Auth::user()->businessID)->where('leaseID',$request->leaseID)->first();
      $property->leaseID = Null;
      $property->tenantID = Null;
      $property->status = 47;
      $property->save();

      Session::flash('success','Lease successfully terminated');

      return redirect()->back();
   }

   /**
   * Delete lease
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete_lease($leaseID){
      //check if lease is linked to a bill
      $check = invoices::where('businessID',Auth::user()->businessID)->where('leaseID',$leaseID)->count();

      //check if lease is linkes to a maintainance request

      if($check != 0){
         Session::flash('warning','This utility is linked to a billing transaction it can not be deleted');         
         return redirect()->back();
      }
      
      //delete utilities linked 
      lease_utility::where('businessID',Auth::user()->businessID)->where('leaseID',$leaseID)->delete();
      
      //delete lease
      lease::where('businessID',Auth::user()->businessID)->where('id',$leaseID)->delete();

      Session::flash('success','Lease successfully deleted');

      return redirect()->back();
   }
}
