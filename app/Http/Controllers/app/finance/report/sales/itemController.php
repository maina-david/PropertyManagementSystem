<?php
namespace App\Http\Controllers\app\finance\report\sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\invoice\invoices;
use App\Models\finance\invoice\invoice_products;
use Auth;
use PDF;
use DB;
use Session;
use Wingu;

class itemController extends Controller
{ 
   public function __construct(){
      $this->middleware('auth');
   }
   
   //customer sales
   public function salesbyitem(Request $request){
      $to = $request->to;
      $from = $request->from;

      $products = invoice_products::join('product_information','product_information.id','=','invoice_products.productID') 
                                 ->join('business','business.id','=','product_information.businessID')
                                 ->join('currency','currency.id','=','business.base_currency') 
                                 ->join('invoices','invoices.id','=','invoice_products.invoiceID')                              
                                 ->where('product_information.businessID',Auth::user()->businessID)
                                 ->whereBetween('invoices.invoice_date',[$from, $to ])
                                 ->groupby('invoice_products.productID')
                                 ->select('product_information.id as productID','product_information.sku_code as sku','currency.code as code','product_information.product_name as name',DB::raw('sum(selling_price) total'))
                                 ->get();

      return view('app.finance.reports.sales.item', compact('to','from','products'));
   }

   public function print($to,$from){
      $products = invoice_products::join('product_information','product_information.id','=','invoice_products.productID') 
                  ->join('business','business.id','=','product_information.businessID')
                  ->join('currency','currency.id','=','business.base_currency')    
                  ->join('invoices','invoices.id','=','invoice_products.invoiceID')                                
                  ->where('product_information.businessID',Auth::user()->businessID)
                  ->whereBetween('invoices.invoice_date',[$from, $to ])
                  ->groupby('invoice_products.productID')
                  ->select('product_information.id as productID','product_information.sku_code as sku','currency.code as code','product_information.product_name as name',DB::raw('sum(selling_price) total'))
                  ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/sales/item', compact('to','from','products'));

		return $pdf->stream('item.pdf');
   }

   public function pdf($to,$from){
      $products = invoice_products::join('product_information','product_information.id','=','invoice_products.productID') 
                  ->join('business','business.id','=','product_information.businessID')
                  ->join('currency','currency.id','=','business.base_currency')     
                  ->join('invoices','invoices.id','=','invoice_products.invoiceID')                           
                  ->where('product_information.businessID',Auth::user()->businessID)
                  ->whereBetween('invoices.invoice_date',[$from, $to ])
                  ->groupby('invoice_products.productID')
                  ->select('product_information.id as productID','product_information.sku_code as sku','currency.code as code','product_information.product_name as name',DB::raw('sum(selling_price) total'))
                  ->get();

      $pdf = PDF::loadView('templates/'.Wingu::template(Wingu::business(Auth::user()->businessID)->templateID)->template_name.'/reports/sales/item', compact('to','from','products'));

      return $pdf->download('item.pdf');
   }
}