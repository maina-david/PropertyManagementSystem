<?php

namespace App\Http\Controllers\app\property\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\invoice\invoices;
use App\Models\property\expense\expense;
use App\Models\wingu\business;
use App\Models\finance\income\category;
use App\Models\finance\expense\expense_category;
use App\Models\property\property;
use Wingu;
use Auth;
use PDF;
class profitandlossController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function report(Request $request,$id){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $income = invoices::where('businessID',Auth::user()->businessID)
                        ->where('propertyID',$id)
                        ->whereBetween('invoice_date',[$request->from,$request->to])
                        ->sum('main_amount');

      $expense = expense::where('businessID',Auth::user()->businessID)
                        ->where('propertyID',$id)
                        ->whereBetween('date',[$request->from,$request->to]) 
                        ->sum('amount');

      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();
      $incomeCategories = category::where('businessID',Auth::user()->businessID)->get();
      $originalIncomes = category::where('businessID',0)->get();

      $from = $request->from;
      $to = $request->to;

      $unCategorisedInvoicesCount = invoices::where('businessID',Auth::user()->businessID)
                                             ->where('propertyID',$id)
                                             ->whereBetween('invoice_date',[$request->from,$request->to])
                                             ->whereNull('income_category')
                                             ->count();

      $unCategorisedInvoicesSum = invoices::where('businessID',Auth::user()->businessID)
                                             ->where('propertyID',$id)
                                             ->whereBetween('invoice_date',[$request->from,$request->to])
                                             ->whereNull('income_category')
                                             ->sum('main_amount');

      //expenses 
      $expenseCategory = expense_category::where('businessID',Auth::user()->businessID)->get();
      $propertyID = $id; 

      return view('app.property.property.reports.profitandloss', compact('income','expense','business','incomeCategories','from','to','unCategorisedInvoicesSum','unCategorisedInvoicesCount','expenseCategory','property','originalIncomes','propertyID'));
   }

   //pdf generator
   public function generate($id,$to,$from){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $income = invoices::where('businessID',Auth::user()->businessID)->where('propertyID',$id)->whereBetween('invoice_date',[$from,$to])->sum('main_amount');
      $expense = expense::where('businessID',Auth::user()->businessID)->where('propertyID',$id)->whereBetween('date',[$from,$to])->sum('amount');
      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();
      $incomeCategories = category::where('businessID',Auth::user()->businessID)->get();
      $originalIncomes = category::where('businessID',0)->get();

      $unCategorisedInvoicesCount = invoices::whereBetween('invoice_date',[$from,$to])->where('propertyID',$id)->whereNull('income_category')->count();
      $unCategorisedInvoicesSum = invoices::whereBetween('invoice_date',[$from,$to])->where('propertyID',$id)->whereNull('income_category')->sum('main_amount');

      //expenses 
      $expenseCategory = expense_category::where('businessID',Auth::user()->businessID)->get(); 

      $pdf = PDF::loadView('templates/'.Wingu::template($business->templateID)->template_name.'/reports/property/profitandloss', compact('income','expense','business','incomeCategories','from','to','unCategorisedInvoicesSum','unCategorisedInvoicesCount','expenseCategory','property','originalIncomes'));

      return $pdf->stream('profitandloss'.$from.'-'.$to.'.pdf');
   }
}
