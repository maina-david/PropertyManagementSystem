<?php

namespace App\Http\Controllers\app\finance\report\receivables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\invoice\invoices;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class customerbalancesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function balance(Request $request){
      $to = $request->to;
      $from = $request->from;
      $balances  = invoices::join('customers','customers.id','=','invoices.customerID')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.customerID')
										->select('customer_name as customerName','customers.id as customerID','currency.code as code',DB::raw('sum(balance) total'))
										->orderby('invoices.id','desc')
                              ->get();
                              

      return view('app.finance.reports.receivables.customer_balances', compact('to','from','balances'));
   }

   public function print($to,$from){
      $balances  = invoices::join('customers','customers.id','=','invoices.customerID')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.customerID')
										->select('customer_name as customerName','customers.id as customerID','currency.code as code',DB::raw('sum(balance) total'))
										->orderby('invoices.id','desc')
                              ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/receivables/balance', compact('to','from','balances'));

		return $pdf->stream('balance.pdf');
   }

   public function pdf($to,$from){
      $balances  = invoices::join('customers','customers.id','=','invoices.customerID')
										->join('business','business.id','=','invoices.businessID')
										->join('currency','currency.id','=','business.base_currency')
                              ->where('invoices.businessID',Auth::user()->businessID)
                              ->whereBetween('invoices.invoice_date',[$from, $to ])
                              ->groupby('invoices.customerID')
										->select('customer_name as customerName','customers.id as customerID','currency.code as code',DB::raw('sum(balance) total'))
										->orderby('invoices.id','desc')
                              ->get();

      $countInvoice = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoices.created_at',[$from, $to ])->count();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/receivables/balance', compact('to','from','balances'));

      return $pdf->download('balance.pdf');
   }
}
