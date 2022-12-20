<?php

namespace App\Http\Controllers\app\finance\report;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_payments; 
use App\Models\wingu\business;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoice_settings;
use App\Models\finance\creditnote\creditnote_settings;
use Wingu;
use Finance;
use Auth;
use Excel;
use PDF;

class accountStatementController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $clients = customers::where('businessID',Auth::user()->businessID)->get();
      return view('app.finance.reports.account_statement.index', compact('clients'));
   }

   /**
    * process results
    *
    * @return \Illuminate\Http\Response
    */
   public function process(Request $request)
   {
      $this->validate($request,[
         'client' => 'required',
         'from_date' => 'required',
         'to_date' => 'required',
         'transaction_type' => 'required',
      ]);
      return redirect()->route('finance.report.account.statement.results',[$request->client,$request->from_date,$request->to_date,$request->transaction_type]);
   }


   /**
 * results
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function results($clientID,$from,$to,$transaction)
   {
      $invoices = invoices::where('businessID',Auth::user()->businessID)
                  ->where('customerID',$clientID)
                  ->whereBetween('invoice_date', [$from, $to])
                  ->get();
      
      $creditSettings = creditnote_settings::where('businessID',Auth::user()->businessID)->first();

      $invoiceSettings = invoice_settings::where('businessID',Auth::user()->businessID)->first();

      $currency = Finance::currency(Wingu::business()->base_currency);

      $client = customers::where('businessID',Auth::user()->businessID)->where('id',$clientID)->first();

      return view('app.finance.reports.account_statement.results', compact('invoices','clientID','from','to','transaction','client','creditSettings','invoiceSettings','currency'));
   }

   /**
 * export to excel
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function excel($clientID,$from,$to,$transaction){
      if($transaction == 'All'){
         $data = invoices::where('businessID',Auth::user()->businessID)
                  ->where('customerID',$clientID)
                  ->whereBetween('created_at', [$from, $to])
                  ->select('created_at as Date','invoice_number as Reference','description as Description','transaction_type as Transaction type','balance as Balance')
                  ->get()
                  ->toArray();
      }else{
         $data = invoices::where('businessID',Auth::user()->businessID)
                  ->where('customerID',$clientID)
                  ->where('transaction_type',$transaction)
                  ->whereBetween('created_at', [$from, $to])
                  ->select('created_at as Date','invoice_number as Reference','description as Description','transaction_type as Transaction type','balance as Balance')
                  ->get()
                  ->toArray();
      }

      return Excel::create('Client Invoices', function($excel) use ($data) {
         $excel->sheet('mySheet', function($sheet) use ($data)
         {
            $sheet->fromArray($data);
         });
      })->download('csv');
   }


   /**
 * export to pdf
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function pdf($clientID,$from,$to,$transaction){
      if($transaction == 'All'){
         $invoices = invoices::where('businessID',Auth::user()->businessID)
                  ->where('customerID',$clientID)
                  ->whereBetween('created_at', [$from, $to])
                  ->get();
      }else{
         $invoices = invoices::where('businessID',Auth::user()->businessID)
                  ->where('customerID',$clientID)
                  ->where('transaction_type',$transaction)
                  ->whereBetween('created_at', [$from, $to])
                  ->get();
      }
      
      $client = customers::where('customers.id',$clientID)
                     ->where('customers.businessID', Auth::user()->businessID)
                     ->select('*','customers.id as client')
                     ->first();

      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();
                     
      $creditSettings = creditnote_settings::where('businessID',Auth::user()->businessID)->first();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/finance-statement', compact('client','invoices','from','to','creditSettings','business'));

      return $pdf->download('statement of account'.$from.'-'.$to.'.pdf');
   }
 
   /**
    * export to pdf
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function print($clientID,$from,$to,$transaction){
      if($transaction == 'All'){
         $invoices = invoices::where('businessID',Auth::user()->businessID)
                  ->where('customerID',$clientID)
                  ->whereBetween('created_at', [$from, $to])
                  ->get();
      }else{
         $invoices = invoices::where('businessID',Auth::user()->businessID)
                  ->where('customerID',$clientID)
                  ->where('transaction_type',$transaction)
                  ->whereBetween('created_at', [$from, $to])
                  ->get();
      }
      
      $client = customers::where('customers.id',$clientID)
                     ->where('customers.businessID', Auth::user()->businessID)
                     ->select('*','customers.id as client')
                     ->first();
                     
      $creditSettings = creditnote_settings::where('businessID',Auth::user()->businessID)->first();

      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/finance-statement', compact('client','invoices','from','to','creditSettings','business'));
      return $pdf->stream('statement of account'.$from.'-'.$to.'.pdf');
   }
}
