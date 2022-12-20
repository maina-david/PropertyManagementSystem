<?php

namespace App\Http\Controllers\app\crm\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\leads\sources;
use App\Models\finance\customer\customers;
use App\Exports\leadindustryreport;
use App\Models\wingu\industry;
use Excel;
use Auth;
use Session;

class leadsByIndustryController extends Controller
{
   //filter status
   public function filter(Request $request){
      $start = $request->start;
      $end   = $request->end;
      $count = 1;
      $industryValue = $request->industry;
      $industies = industry::pluck('name','id')->prepend('Choose industry', '');      
      $checkIndustry = industry::where('id',$request->industry)->count();      
      if($checkIndustry == 0){
         $industryRequest = 'All';
         $industryResults = [];
         $leads = customers::join('customer_address','customer_address.customerID','=','customers.id')
                        ->where('customers.businessID',Auth::user()->businessID)
                        ->where('customers.category','Lead')
                        ->select('*','customers.id as leadID','customers.created_at as date')
                        ->whereBetween('customers.created_at', [$start, $end])
                        ->OrderBy('customers.id','DESC')
                        ->get();

      }else{         
         $industryResults = industry::where('id',$request->industry)->first();
         $industryRequest = $industryResults->name;
         $leads = customers::join('customer_address','customer_address.customerID','=','customers.id')
                        ->where('customers.businessID',Auth::user()->businessID)
                        ->where('customers.category','Lead')
                        ->whereBetween('customers.created_at', [$start, $end])
                        ->where('customers.industryID',$request->industry)
                        ->select('*','customers.id as leadID','customers.created_at as date')
                        ->OrderBy('customers.id','DESC')
                        ->get();
      } 

      return view('app.crm.reports.leads.industry', compact('industies','leads','count','industryResults','start','end','industryValue','industryRequest'));
   }

   //export
   public function export($industry,$start,$end){
      return Excel::download(new leadindustryreport($industry,$start,$end), 'industryReport.xlsx');
   }
}
