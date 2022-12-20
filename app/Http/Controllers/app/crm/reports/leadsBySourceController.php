<?php

namespace App\Http\Controllers\app\crm\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\leads\sources;
use App\Models\finance\customer\customers;
use App\Exports\leadsourcereport;
use Excel;
use Auth;
use Session;

class leadsBySourceController extends Controller
{
   //filter status
   public function filter(Request $request){
      $start = $request->start;
      $end   = $request->end;
      $count = 1;
      $sourceValue = $request->source;
      $sources = sources::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose sources', '');
      $checkSource = sources::where('id',$request->source)->where('businessID',Auth::user()->businessID)->count();
      
      if($checkSource == 0){
         $sourceRequest = 'All';
         $statusResults = [];
         $leads = customers::join('customer_address','customer_address.customerID','=','customers.id')
                        ->where('customers.businessID',Auth::user()->businessID)
                        ->where('customers.category','Lead')
                        ->select('*','customers.id as leadID','customers.created_at as date')
                        ->whereBetween('customers.created_at', [$start, $end])
                        ->OrderBy('customers.id','DESC')
                        ->get();

      }else{         
         $sourceResults = sources::where('id',$request->source)->where('businessID',Auth::user()->businessID)->first();
         $sourceRequest = $sourceResults->name;
         $leads = customers::join('customer_address','customer_address.customerID','=','customers.id')
                        ->where('customers.businessID',Auth::user()->businessID)
                        ->where('customers.category','Lead')
                        ->whereBetween('customers.created_at', [$start, $end])
                        ->where('customers.sourceID',$request->source)
                        ->select('*','customers.id as leadID','customers.created_at as date')
                        ->OrderBy('customers.id','DESC')
                        ->get();

      } 

      return view('app.crm.reports.leads.source', compact('sources','leads','count','sourceRequest','start','end','sourceValue'));
   }

   //export
   public function export($source,$start,$end){
      return Excel::download(new leadsourcereport($source,$start,$end), 'sourceReport.xlsx');
   }
}
