<?php

namespace App\Http\Controllers\app\finance\report\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_information;
use App\Models\finance\invoice\invoice_products;
use App\Models\wingu\business;
use Auth;
use Session;
use DB;
use PDF;
use Wingu;
class valuationController extends Controller
{
   /**
    * Filter
    */
   public function report(Request $request){
      $from = $request->from;
      $to = $request->to;
      $business = business::where('business.id',Auth::user()->businessID)
                           ->join('currency','currency.id','=','business.base_currency')
                           ->select('currency.code as code')
                           ->first();

      $products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
                                 ->join('product_price','product_price.productID','=','product_information.id')
                                 ->where('product_information.businessID',Auth::user()->businessID)
                                 ->where('type','product')
                                 ->select('product_information.product_name as product_name','product_information.sku_code as sku_code','product_inventory.current_stock as current_stock','product_information.id as productID','product_price.selling_price as price')
                                 ->orderby('current_stock','desc')
                                 ->get();

      return view('app.finance.reports.inventory.valuation', compact('from','to','products','business'));
   }

   /**
    * print report
    */
   public function print($to,$from){
      $business = business::where('business.id',Auth::user()->businessID)
                           ->join('currency','currency.id','=','business.base_currency')
                           ->select('currency.code as code')
                           ->first();
                           
      $products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
                                 ->join('product_price','product_price.productID','=','product_information.id')
                                 ->where('product_information.businessID',Auth::user()->businessID)
                                 ->where('type','product')
                                 ->select('product_information.product_name as product_name','product_information.sku_code as sku_code','product_inventory.current_stock as current_stock','product_information.id as productID','product_price.selling_price as price')
                                 ->orderby('current_stock','desc')
                                 ->limit(250)
                                 ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/inventory/valuation', compact('to','from','products','business'));

      $name = 'inventoryValuation-'.$from.'#'.$to;
		return $pdf->stream($name.'.pdf');
   }

   /**
    * pdf report
    */
   public function pdf($to,$from){
      $business = business::where('business.id',Auth::user()->businessID)
                           ->join('currency','currency.id','=','business.base_currency')
                           ->select('currency.code as code')
                           ->first();
                           
      $products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
                           ->join('product_price','product_price.productID','=','product_information.id')
                           ->where('product_information.businessID',Auth::user()->businessID)
                           ->where('type','product')
                           ->select('product_information.product_name as product_name','product_information.sku_code as sku_code','product_inventory.current_stock as current_stock','product_information.id as productID','product_price.selling_price as price')
                           ->orderby('current_stock','desc')
                           ->limit(250)
                           ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/inventory/valuation', compact('to','from','products','business'));

      $name = 'inventoryValuation-'.$from.'#'.$to;
      return $pdf->download($name.'.pdf');
   }
}

