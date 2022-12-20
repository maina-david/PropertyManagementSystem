<?php

namespace App\Http\Controllers\app\property\tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\property\tenants\tenants;
use App\Models\wingu\business;
use App\Models\property\invoice\invoices;
use Auth;
use Session;
use Response;

class invoicesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index($propertyID,$tenantID)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->first();

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $tenant = tenants::join('tenant_address','tenant_address.tenantID','=','tenants.id')                       
								->where('tenants.id',$tenantID)
								->select('*','tenants.id as tenantID')
                        ->first();

      $invoices = invoices::join('property','property.id','=','property_invoices.parent_property')
                           ->join('status','status.id','=','property_invoices.statusID')
                           ->where('property_invoices.tenantID',$tenantID)
                           ->select('*','property_invoices.id as invoiceID','status.name as statusName','property_invoices.invoice_number as invoice_number') 
                           ->orderby('property_invoices.id','desc')
                           ->get();

      $count = 1;

      return view('app.property.tenants.view', compact('property','count','propertyID','tenantID','tenant','business','invoices'));
   }
}
