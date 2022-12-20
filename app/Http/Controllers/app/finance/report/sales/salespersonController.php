<?php

namespace App\Http\Controllers\app\finance\report\sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\invoice\invoices;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class salespersonController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   //customer sales
   public function salesbysalesperson(Request $request){
      $to = $request->to;
      $from = $request->from;
      $sales = invoices::join('hr_employees','hr_employees.id','=','invoices.salesperson')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.salesperson')
										->select('hr_employees.names as salesperson','invoices.salesperson as salespersonID','hr_employees.id as employeeID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();
      $countInvoice = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoices.invoice_date',[$from, $to ])->count();

      $others = invoices::join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->whereNull('invoices.salesperson')
                              ->groupby('invoices.salesperson')
										->select('invoices.salesperson as salespersonID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();

      $otherCounts = invoices::whereBetween('invoice_date',[$from, $to ])
                              ->whereNull('salesperson')
                              ->where('businessID',Auth::user()->businessID)
                              ->count();

      $total  = invoices::where('businessID',Auth::user()->businessID)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->get();

      $totalCount = invoices::where('businessID',Auth::user()->businessID)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->count();

      return view('app.finance.reports.sales.salesperson', compact('to','from','sales','countInvoice','others','otherCounts','total','totalCount'));
   }

   public function print($to,$from){
      $sales = invoices::join('hr_employees','hr_employees.id','=','invoices.salesperson')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.salesperson')
										->select('hr_employees.names as salesperson','invoices.salesperson as salespersonID','hr_employees.id as employeeID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();
      $countInvoice = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoices.invoice_date',[$from, $to ])->count();

      $others = invoices::join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->whereNull('invoices.salesperson')
                              ->groupby('invoices.salesperson')
										->select('invoices.salesperson as salespersonID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();

      $otherCounts = invoices::whereBetween('invoice_date',[$from, $to ])
                              ->whereNull('salesperson')
                              ->where('businessID',Auth::user()->businessID)
                              ->count();

      $total  = invoices::where('businessID',Auth::user()->businessID)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->get();

      $totalCount = invoices::where('businessID',Auth::user()->businessID)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->count();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/sales/salesperson', compact('to','from','sales','countInvoice','others','otherCounts','total','totalCount'));

		return $pdf->stream('salesperson.pdf');
   }

   public function pdf($to,$from){
      $sales = invoices::join('hr_employees','hr_employees.id','=','invoices.salesperson')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.salesperson')
										->select('hr_employees.names as salesperson','invoices.salesperson as salespersonID','hr_employees.id as employeeID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();
      $countInvoice = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoices.invoice_date',[$from, $to ])->count();

      $others = invoices::join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->whereNull('invoices.salesperson')
                              ->groupby('invoices.salesperson')
										->select('invoices.salesperson as salespersonID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();

      $otherCounts = invoices::whereBetween('invoice_date',[$from, $to ])
                              ->whereNull('salesperson')
                              ->where('businessID',Auth::user()->businessID)
                              ->count();

      $total  = invoices::where('businessID',Auth::user()->businessID)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->get();

      $totalCount = invoices::where('businessID',Auth::user()->businessID)
                                 ->whereBetween('invoice_date',[$from, $to ])
                                 ->count();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/sales/salesperson', compact('to','from','sales','countInvoice','others','otherCounts','total','totalCount'));

      return $pdf->download('salesperson.pdf');
   }
}
