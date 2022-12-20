<?php

namespace App\Http\Controllers\app\finance\report\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_information;
use App\Models\finance\invoice\invoice_products;
use Auth;
use Session;
use DB;
use PDF;
use Wingu;
class summaryController extends Controller
{
   /**
    * Filter
    */
   public function report(Request $request){
      $from = $request->from;
      $to = $request->to;

      $products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
                                    ->join('product_price','product_price.productID','=','product_information.id')
                                    ->where('product_information.businessID',Auth::user()->businessID)
                                    ->where('type','product')
                                    ->select('product_information.product_name as product_name','product_information.sku_code as sku_code','product_inventory.current_stock as current_stock','product_information.id as productID','product_price.selling_price as price')
                                    ->orderby('current_stock','desc')
                                    ->get();

      return view('app.finance.reports.inventory.summary', compact('from','to','products'));
   }

   /**
    * print report
    */
   public function print($to,$from){
      $products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
                                       ->join('product_price','product_price.productID','=','product_information.id')
                                       ->where('product_information.businessID',Auth::user()->businessID)
                                       ->where('type','product')
                                       ->select('product_information.product_name as product_name','product_information.sku_code as sku_code','product_inventory.current_stock as current_stock','product_information.id as productID','product_price.selling_price as price')
                                       ->orderby('current_stock','desc')
                                       ->limit(250)
                                       ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/inventory/summary', compact('to','from','products'));

      $name = 'inventory-'.$from.'#'.$to;
		return $pdf->stream($name.'.pdf');
   }

   /**
    * pdf report
    */
   public function pdf($to,$from){
      $products = invoice_products::join('product_information','product_information.id','=','invoice_products.productID')
                                 ->join('product_inventory','product_inventory.productID','=','invoice_products.productID')
                                 ->join('invoices','invoices.id','=','invoice_products.invoiceID')
                                 ->where('invoices.businessID',Auth::user()->businessID)
                                 ->where('type','product')
                                 ->groupby('invoice_products.productID')
                                 ->whereBetween('invoices.invoice_date',[$from, $to ])
                                 ->select('product_information.product_name as product_name','product_information.sku_code as sku_code','product_inventory.current_stock as current_stock',DB::raw('sum(quantity) quantity'))
                                 ->limit(250)
                                 ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/inventory/summary', compact('to','from','products'));

      $name = 'inventory-'.$from.'#'.$to;
      return $pdf->download($name.'.pdf');
   }
}

