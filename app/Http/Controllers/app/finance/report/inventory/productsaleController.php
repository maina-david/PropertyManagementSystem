<?php

namespace App\Http\Controllers\app\finance\report\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_products;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class productsaleController extends Controller
{ 
   public function __construct(){
      $this->middleware('auth');
   }
   
   //customer sales
   public function report(Request $request){
      $to = $request->to;
      $from = $request->from;

      $products = invoice_products::join('product_information','product_information.id','=','invoice_products.productID') 
                                 ->join('business','business.id','=','product_information.businessID')
                                 ->join('invoices','invoices.id','=','invoice_products.invoiceID')
                                 ->join('currency','currency.id','=','business.base_currency')                               
                                 ->where('product_information.businessID',Auth::user()->businessID)
                                 ->whereBetween('invoices.invoice_date',[$from, $to ])
                                 ->groupby('invoice_products.productID')
                                 ->where('type','product')
                                 ->select('product_information.id as productID','product_information.sku_code as sku','currency.code as code','product_information.product_name as name',DB::raw('sum(selling_price) total'))
                                 ->get();

      return view('app.finance.reports.inventory.productsales', compact('to','from','products'));
   }

   public function print($to,$from){
      $products = invoice_products::join('product_information','product_information.id','=','invoice_products.productID') 
                                 ->join('business','business.id','=','product_information.businessID')
                                 ->join('invoices','invoices.id','=','invoice_products.invoiceID')
                                 ->join('currency','currency.id','=','business.base_currency')                               
                                 ->where('product_information.businessID',Auth::user()->businessID)
                                 ->whereBetween('invoices.invoice_date',[$from, $to ])
                                 ->groupby('invoice_products.productID')
                                 ->where('type','product')
                                 ->select('product_information.id as productID','product_information.sku_code as sku','currency.code as code','product_information.product_name as name',DB::raw('sum(selling_price) total'))
                                 ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/inventory/productsales', compact('to','from','products'));

      $name = 'productSales'.$from.'#'.$to;
		return $pdf->stream($name.'.pdf');
   }

   public function pdf($to,$from){
      $products = invoice_products::join('product_information','product_information.id','=','invoice_products.productID') 
                                 ->join('business','business.id','=','product_information.businessID')
                                 ->join('invoices','invoices.id','=','invoice_products.invoiceID')
                                 ->join('currency','currency.id','=','business.base_currency')                               
                                 ->where('product_information.businessID',Auth::user()->businessID)
                                 ->whereBetween('invoices.invoice_date',[$from, $to ])
                                 ->groupby('invoice_products.productID')
                                 ->where('type','product')
                                 ->select('product_information.id as productID','product_information.sku_code as sku','currency.code as code','product_information.product_name as name',DB::raw('sum(selling_price) total'))
                                 ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/inventory/productsales', compact('to','from','products'));

      $name = 'productSales'.$from.'#'.$to;

      return $pdf->download($name.'.pdf');
   }
}