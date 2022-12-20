<?php

namespace App\Http\Controllers\app\property\property\tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\property\tenants\tenants;
use App\Models\property\lease;
use App\Models\property\utilities;
use App\Models\property\lease_utility;
use App\Models\wingu\business;
use App\Models\finance\tax;
use Helper;
use Auth;
use Session;
use Response;

class unitsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   //unit list
   public function index($propertyID,$tenantID){
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->first();

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
                        ->where('property_tenants.id',$tenantID)
                        ->where('property_tenants.businessID',Auth::user()->businessID)  
								->select('*','property_tenants.id as tenantID')
                        ->first();
                        
      $units = lease::join('property_tenants','property_tenants.id','=','property_lease.tenantID')
                        ->join('property','property.id','=','property_lease.unitID')
                        ->where('property_lease.propertyID',$propertyID)
                        ->where('property_lease.businessID',Auth::user()->businessID)  
                        ->where('property_lease.tenantID',$tenantID)                   
                        ->orderby('property_lease.id','desc')
                        ->select('*','property.id as unitID')
                        ->get();
      
      $count = 1;


      return view('app.property.property.tenants.units', compact('property','count','propertyID','tenantID','tenant','units','business'));
   }
}
