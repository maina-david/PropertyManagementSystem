<?php

namespace App\Http\Controllers\app\crm\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\leads\status;
use App\Models\finance\customer\customers;
use App\Exports\leadstatusreport;
use Excel;
use Auth;
use Session;

class leadsByStatusController extends Controller
{
   //filter status
   public function filter(Request $request){
      $start = $request->start;
      $end   = $request->end;
      $count = 1;
      $statusValue = $request->status;
      $status = status::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose status', '');
      $checkStatus = status::where('id',$request->status)->where('businessID',Auth::user()->businessID)->count();
      
      if($checkStatus == 0){
         $statusRequest = 'All';
         $statusResults = [];
         $leads = customers::join('customer_address','customer_address.customerID','=','customers.id')
                        ->where('customers.businessID',Auth::user()->businessID)
                        ->where('customers.category','Lead')
                        ->select('*','customers.id as leadID','customers.created_at as date')
                        ->whereBetween('customers.created_at', [$start, $end])
                        ->OrderBy('customers.id','DESC')
                        ->get();

      }else{
         
         $statusResults = status::where('id',$request->status)->where('businessID',Auth::user()->businessID)->first();
         $statusRequest = $statusResults->name;
         $leads = customers::join('customer_address','customer_address.customerID','=','customers.id')
                        ->where('customers.businessID',Auth::user()->businessID)
                        ->where('customers.category','Lead')
                        ->whereBetween('customers.created_at', [$start, $end])
                        ->where('customers.statusID',$request->status)
                        ->select('*','customers.id as leadID','customers.created_at as date')
                        ->OrderBy('customers.id','DESC')
                        ->get();
      } 

      return view('app.crm.reports.leads.status', compact('status','leads','count','statusRequest','start','end','statusValue'));
   }

   //export
   public function export($status,$start,$end){
      return Excel::download(new leadstatusreport($status,$start,$end), 'statusReport.xlsx');
   }
}
