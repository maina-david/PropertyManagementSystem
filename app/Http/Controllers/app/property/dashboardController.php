<?php

namespace App\Http\Controllers\app\property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business;
use App\Models\property\property;
use App\Models\property\lease;
use App\Models\finance\customer\customers;
use App\Models\property\tenants\tenants;
use App\Models\crm\emails;
use Auth;
class dashboardController extends Controller
{
   public function dashboard(){
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->where('businessID',Auth::user()->code)
                           ->first();

      $tenants = tenants::where('businessID',Auth::user()->businessID)->count();

      $vacant = property::where('businessID',Auth::user()->businessID)->whereNull('tenantID')->count();

      $occupied = property::where('businessID',Auth::user()->businessID)->where('tenantID','!=',"")->count();

      $owners = customers::join('customer_group','customer_group.customerID','=','customers.id')
                        ->where('customers.businessID',Auth::user()->businessID)
                        ->where('customer_group.groupID',1)
                        ->count();

      $inquiries = emails::where('businessID',Auth::user()->businessID)
                           ->where('property_code','!=',NULL)
                           ->where('section','Property Inquiry')
                           ->orderby('id','desc')
                           ->limit(7)
                           ->get();
      $count = 1;
      return view('app.property.dashboard.dashboard', compact('tenants','vacant','occupied','owners','inquiries','count'));
   }
}
