<?php

namespace App\Http\Controllers\app\finance\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoices;
use App\Models\finance\products\product_information;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\income\category;
use App\Models\finance\expense\expense_category;
use App\Models\finance\invoice\invoice_payments;
use App\Charts\IncomePerCategory;
use App\Charts\IncomePerMonth;
use App\Charts\ExpensePerCategory;
use Auth;
use DB;
use Wingu;
class dashboardController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function home()
   {
      //check if account has modules
      if(Wingu::check_if_account_has_modules() == 0){
         return redirect()->route('application.setup');
      }

      $year = date('Y');

      $dueInvoicescount = invoices::where('businessID', Auth::user()->businessID)
                           ->where('invoice_number','!=',0)
                           ->where('statusID','!=',1)
                           ->whereYear('invoice_date', '=', $year)
                           ->where('invoice_due', '>=', date('Y-m-d'))
                           ->count();

      $dueInvoices = invoices::join('business','business.id','=','invoices.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->join('customers','customers.id','=','invoices.customerID')
                     ->join('status','status.id','=','invoices.statusID')
                     ->join('invoice_settings','invoice_settings.businessID','=','business.id')
                     ->whereYear('invoice_date', '=', $year)
                     ->where('invoices.businessID', Auth::user()->businessID)
                     ->where('invoice_number','!=',0)
                     ->where('invoices.statusID','!=',1)
                     ->where('invoice_due', '>=', date('Y-m-d'))
                     ->orderby('invoices.id','desc')
                     ->select('*','invoices.id as invoiceID','status.name as statusName')
                     ->limit(12)
                     ->get();

      $client = customers::where('businessID',Auth::user()->businessID)->count();
      $products = product_information::where('businessID',Auth::user()->businessID)->count();
      $suppliers = suppliers::where('businessID',Auth::user()->businessID)->count();


      /*
      * Income per category
		* */
		$incomePerCategoryChart = new IncomePerCategory;

      $category = category::join('invoice_payments','invoice_payments.incomeID','=','fn_income_category.id')
                           ->where('invoice_payments.businessID',Auth::user()->businessID)
									->groupby('invoice_payments.incomeID')
                           ->pluck('name');


      $totalIncome =  DB::table('invoice_payments')
                           ->whereYear('payment_date', '=', $year)
                           ->select(DB::raw('SUM(amount) as total'))
                           ->where('businessID',Auth::user()->businessID)
									->groupBy('incomeID')
                           ->pluck('total');
		$incomePerCategoryChart->labels($category->values());
      $incomePerCategoryChart->dataset('Income', 'bar', $totalIncome->values())
                           ->backgroundColor(collect(['rgba(220,53,69,0.6)','rgba(255,193,7,0.6)','rgba(25,135,84,0.6)','rgba(254,153,175,0.6)','rgba(40,95,255,0.6)','rgba(52,186,187,0.6)']));


       /*
      * Income per month
      * */
      $incomePerMonth = new IncomePerMonth;

      $month  = invoice_payments::where('invoice_payments.businessID',Auth::user()->businessID)
                           ->whereYear('payment_date', '=', $year)
                           ->groupby(DB::raw('MONTH(payment_date)'))
                           ->select(DB::raw('month(payment_date) as month'))
                           ->selectRaw("DATE_FORMAT(payment_date, '%M') AS month")
                           ->pluck('month');

      $totalMonth =  DB::table('invoice_payments')
                           ->whereYear('payment_date', '=', $year)
                           ->select(DB::raw('SUM(amount) as total'))
                           ->where('businessID',Auth::user()->businessID)
									->groupby('invoice_payments.payment_date')
                           ->pluck('total');


		$incomePerMonth->labels($month->values());
      $incomePerMonth->dataset('Total income', 'line', $totalMonth->values())
                     ->backgroundColor(collect(['rgba(243,71,112,0.2)','rgba(254,153,175,0.6)','rgba(40,95,255,0.6)','rgba(52,186,187,0.6)']));

      /*
      * Expense per category
      * */
      $expensePerCategory = new ExpensePerCategory;
      $category = expense_category::join('fn_expense','fn_expense.expense_category','=','fn_expense_category.id')
                           ->where('fn_expense.businessID',Auth::user()->businessID)
                           ->groupBy('fn_expense.expense_category')
                           ->pluck('category_name');

      $totalexpence = expense_category::join('fn_expense','fn_expense.expense_category','=','fn_expense_category.id')
                           ->where('fn_expense.businessID',Auth::user()->businessID)
                           ->groupBy('fn_expense.expense_category')
                           ->select(DB::raw('SUM(amount) as total'))
                           ->pluck('total');

      $expensePerCategory->labels($category->values());
      $expensePerCategory->dataset('Expence per category', 'pie', $totalexpence->values())->backgroundColor(collect(['rgba(254,153,175,0.6)','rgba(40,95,255,0.6)','rgba(52,186,187,0.6)']));

      return view('app.finance.dashboard.dashboard', compact('client','dueInvoices','dueInvoicescount','products','suppliers','incomePerCategoryChart','incomePerMonth','expensePerCategory'));
   }
}
