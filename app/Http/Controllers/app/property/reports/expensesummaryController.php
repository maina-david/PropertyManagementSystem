<?php

namespace App\Http\Controllers\app\property\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\expense\expense;
use App\Models\wingu\business;
use App\Models\finance\expense\expense_category;
use App\Models\property\property;
use Wingu;
use Auth;
use PDF;

class expensesummaryController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function report(Request $request, $id){
      $property = property::where('businessID',Auth::user()->businessID)                           
                           ->where('id',$id)
                           ->first();

      $expense = expense::where('businessID',Auth::user()->businessID)
                        ->where('propertyID',$id)
                        ->whereBetween('date',[$request->from,$request->to])
                        ->sum('amount');

      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();
      $from = $request->from;
      $to = $request->to;

      //expenses 
      $expenseCategory = expense_category::where('businessID',Auth::user()->businessID)->get();
      $propertyID = $id;

      return view('app.property.property.reports.expensesummary', compact('expense','business','from','to','expenseCategory','property','propertyID'));
   }

   //extract
   public function generate($id,$to,$from){
      $property = property::where('businessID',Auth::user()->businessID)                           
                           ->where('id',$id)
                           ->first();
      $expense = expense::where('businessID',Auth::user()->businessID)->where('propertyID',$id)->whereBetween('date',[$from,$to])->sum('amount');
      $business = business::where('business.id',Auth::user()->businessID)->join('currency','currency.id','=','business.base_currency')->first();

      //expenses 
      $expenseCategory = expense_category::where('businessID',Auth::user()->businessID)->get();

      $pdf = PDF::loadView('templates/'.Wingu::template($business->templateID)->template_name.'/reports/property/expensesummery', compact('expense','business','from','to','expenseCategory','property'));

      return $pdf->stream('expensesummery'.$from.'-'.$to.'.pdf');
   }
}
