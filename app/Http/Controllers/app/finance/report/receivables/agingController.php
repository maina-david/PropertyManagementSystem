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

class agingController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function report(Request $request){

      // SELECT invoice_code,
      // SUM(IF(DATEDIFF(CURDATE(), invoice_due ) BETWEEN 1 AND 30, balance, 0)) AS age130,
      // SUM(IF(DATEDIFF(CURDATE(), invoice_due ) BETWEEN 31 AND 60, balance, 0)) AS age3160,
      // SUM(IF(DATEDIFF(CURDATE(), invoice_due ) BETWEEN 61 AND 90, balance, 0)) AS age6190,
      // SUM(IF(DATEDIFF(CURDATE(), invoice_due ) > 90, balance, 0)) AS agegt90,
      // SUM(balance) AS totalBalance
      // FROM invoices bill
      // WHERE
      //    bill.balance  > 0

      // GROUP BY invoice_code  
      // ORDER BY balance DESC
      
      $date = $request->input('date');

      $ages = invoices::join('customers','customers.id','=','invoices.customerID')
                     ->where('balance','>',0)
                     ->select('invoice_code','customer_name','balance',
                        DB::raw('SUM(IF(DATEDIFF("'.$date.'", invoice_due) BETWEEN 1 AND 30, balance, 0)) AS age130'),
                        DB::raw('SUM(IF(DATEDIFF("'.$date.'", invoice_due ) BETWEEN 31 AND 60, balance, 0)) AS age3160'),
                        DB::raw('SUM(IF(DATEDIFF("'.$date.'", invoice_due ) BETWEEN 61 AND 90, balance, 0)) AS age6190'),
                        DB::raw('SUM(IF(DATEDIFF("'.$date.'", invoice_due ) BETWEEN 91 AND 120, balance, 0)) AS age91120'),
                        DB::raw('SUM(IF(DATEDIFF("'.$date.'", invoice_due ) BETWEEN 121 AND 150, balance, 0)) AS age121150'),
                        DB::raw('SUM(IF(DATEDIFF("'.$date.'", invoice_due ) BETWEEN 151 AND 180, balance, 0)) AS age151180'),
                        //DB::raw('SUM(IF(DATEDIFF("'.$date.'", invoice_due ) > 180, balance, 0) as above')
                        //DB::raw('IF(DATEDIFF("'.$date.'", invoice_due ) > 181, balance, 0)) AS agegt181')
                     )                     
                     ->where('invoices.businessID',Auth::user()->businessID)
                     ->groupBy('customerID')
                     ->orderby('balance','desc')
                     ->get();
      $currency = Wingu::currency();
      return view('app.finance.reports.receivables.aging', compact('date','ages','currency'));
   }
}