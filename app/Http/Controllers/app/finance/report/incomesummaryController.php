<?php

namespace App\Http\Controllers\app\finance\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\invoice\invoices;
use App\Models\finance\expense\expense;
use App\Models\wingu\business;
use App\Models\finance\income\category;
use App\Models\finance\expense\expense_category;
use Wingu;
use Auth;
use PDF;

class incomesummaryController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function report(Request $request){
      $income = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoice_date',[$request->from,$request->to])->sum('main_amount');
      $expense = expense::where('businessID',Auth::user()->businessID)->whereBetween('date',[$request->from,$request->to])->sum('amount');
      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();
      $incomeCategories = category::where('businessID',Auth::user()->businessID)->get();
      $defaultCategories = category::where('businessID',0)->get();
      $from = $request->from;
      $to = $request->to;

      $unCategorisedInvoicesCount = invoices::where('businessID',Auth::user()->businessID)
                                             ->whereBetween('invoice_date',[$request->from,$request->to])
                                             ->whereNull('income_category')
                                             ->count();

      $unCategorisedInvoicesSum = invoices::where('businessID',Auth::user()->businessID)
                                             ->whereBetween('invoice_date',[$request->from,$request->to])
                                             ->whereNull('income_category')
                                             ->sum('main_amount');

      $unCategorisedInvoicesSum2 = invoices::where('businessID',Auth::user()->businessID)
                                             ->whereBetween('invoice_date',[$request->from,$request->to])
                                             ->where('income_category',0)
                                             ->sum('main_amount');

      //expenses 
      $expenseCategory = expense_category::where('businessID',Auth::user()->businessID)->get();

      return view('app.finance.reports.overview.incomesummary', compact('income','expense','business','incomeCategories','from','to','unCategorisedInvoicesSum','unCategorisedInvoicesCount','expenseCategory','defaultCategories','unCategorisedInvoicesSum2'));
   }

   //pdf generator
   public function extract($to,$from){
      $income = invoices::where('businessID',Auth::user()->businessID)->whereBetween('invoice_date',[$from,$to])->sum('main_amount');
      $expense = expense::where('businessID',Auth::user()->businessID)->whereBetween('date',[$from,$to])->sum('amount');
      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();
      $incomeCategories = category::where('businessID',Auth::user()->businessID)->get();

      $unCategorisedInvoicesCount = invoices::whereBetween('invoice_date',[$from,$to])->whereNull('income_category')->count();
      $unCategorisedInvoicesSum = invoices::whereBetween('invoice_date',[$from,$to])->whereNull('income_category')->sum('main_amount');

      //expenses 
      $expenseCategory = expense_category::where('businessID',Auth::user()->businessID)->get(); 

      $pdf = PDF::loadView('templates/'.Wingu::template($business->templateID)->template_name.'/reports/incomesummary', compact('income','expense','business','incomeCategories','from','to','unCategorisedInvoicesSum','unCategorisedInvoicesCount','expenseCategory'));

      return $pdf->stream('incomesummary'.$from.'-'.$to.'.pdf');
   }
}
