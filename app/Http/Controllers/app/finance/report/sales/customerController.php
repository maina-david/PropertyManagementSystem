<?php
namespace App\Http\Controllers\app\finance\report\sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class customerController extends Controller
{ 
   public function __construct(){
      $this->middleware('auth');
   }
   
   //customer sales
   public function salesbycustomer(Request $request){
      $to = $request->to;
      $from = $request->from;
      $sales = invoices::join('customers','customers.id','=','invoices.customerID')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.customerID')
										->select('customer_name as customerName','customers.id as customerID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();

      $countInvoice = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoices.invoice_date',[$from, $to ])->count();

      return view('app.finance.reports.sales.customer', compact('to','from','sales','countInvoice'));
   }

   public function print($to,$from){
      $sales = invoices::join('customers','customers.id','=','invoices.customerID')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.customerID')
										->select('customer_name as customerName','customers.id as customerID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();

      $countInvoice = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoices.invoice_date',[$from, $to ])->count();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/sales/customer', compact('to','from','sales','countInvoice'));

		return $pdf->stream('customer.pdf');
   }

   public function pdf($to,$from){
      $sales = invoices::join('customers','customers.id','=','invoices.customerID')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.customerID')
										->select('customer_name as customerName','customers.id as customerID','currency.code as code',DB::raw('sum(total) total'))
										->orderby('invoices.invoice_date','desc')
                              ->get();

      $countInvoice = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoices.invoice_date',[$from, $to ])->count();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/sales/customer', compact('to','from','sales','countInvoice'));

      return $pdf->download('customer.pdf');
   }
}
