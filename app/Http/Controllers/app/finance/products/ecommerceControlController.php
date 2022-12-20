<?php

namespace App\Http\Controllers\app\finance\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\product_orders;
use Auth;
use Session;
class ecommerceControlController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
   public function orders()
   {
      $orders = product_orders::join('customers','customers.id','=','product_orders.customerID')
               ->join('business','business.id','=','product_orders.businessID')
               ->join('currency','currency.id','=','business.base_currency')
               ->join('status','status.id','=','product_orders.delivery_status')
               ->join('business_payment_gateways','business_payment_gateways.id','=','product_orders.gatewayID')
               ->join('payment_gateways','payment_gateways.id','=','business_payment_gateways.gatewayID')
               ->where('product_orders.businessID',Auth::user()->businessID)
               ->select('*','product_orders.id as orderID','product_orders.orderID as serialNo')
               ->orderby('product_orders.id','desc')
               ->get();
      $count = 1;
      return view('app.finance.products.orders.index', compact('orders','count'));
   }

   /**
    * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
   public function store(Request $request)
   {
      //
   }

   /**
    * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
   public function show($id)
   {
      $orders = product_orders::join('business','business.id','=','product_orders.businessID')
               ->join('currency','currency.id','=','business.base_currency')
               ->join('customers','customers.id','=','product_orders.customerID')
               ->where('product_orders.id',$id)
               ->where('cart','!=',"")
               ->where('product_orders.businessID',Auth::user()->businessID)
               ->get();
      $orders->transform(function($order, $key){
         $order->cart = unserialize($order->cart);
         return $order;
      });

      return view('app.finance.products.orders.show', compact('orders'));
   }

   /**
    * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
   public function edit($id)
   {
      //
   }

   /**
    * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
   public function update(Request $request, $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
   public function destroy($id)
   {
      //
}
}
