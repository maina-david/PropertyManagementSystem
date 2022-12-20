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

class expensesummaryController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function details(Request $request){
      $expense = expense::where('businessID',Auth::user()->businessID)->whereBetween('date',[$request->from,$request->to])->sum('amount');
      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();
      $from = $request->from;
      $to = $request->to;

      //expenses 
      $expenseCategory = expense_category::where('businessID',Auth::user()->businessID)->get();

      return view('app.finance.reports.overview.expensesummery', compact('expense','business','from','to','expenseCategory'));
   }

   //extract
   public function extract($to,$from){
      $expense = expense::where('businessID',Auth::user()->businessID)->whereBetween('date',[$from,$to])->sum('amount');
      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();

      //expenses 
      $expenseCategory = expense_category::where('businessID',Auth::user()->businessID)->get();

      $pdf = PDF::loadView('templates/'.Wingu::template($business->templateID)->template_name.'/reports/expensesummery', compact('expense','business','from','to','expenseCategory'));

      return $pdf->stream('expensesummery'.$from.'-'.$to.'.pdf');
   }
}
