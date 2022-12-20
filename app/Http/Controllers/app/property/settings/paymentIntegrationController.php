<?php

namespace App\Http\Controllers\app\property\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\wingu\payment_integrations;
use App\Models\property\payment_integration as propertyIntegerations;
use Auth;
use Session;
class paymentIntegrationController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($id)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $gateways = payment_integrations::where('status',15)->pluck('name','id')->prepend('Choose your preferred payment gateway', '');
      $intergrations = payment_integrations::join('property_payment_integration','property_payment_integration.gatewayID','=','payment_integrations.id')
                              ->where('property_payment_integration.businessID',Auth::user()->businessID)
                              ->where('propertyID',$id)
                              ->orderby('property_payment_integration.id','desc')
                              ->select('*','property_payment_integration.id as intergrationID','property_payment_integration.status as paymentStatus')
                              ->get();
      $propertyID = $id;

      return view('app.property.accounting.payments.settings', compact('property','intergrations','gateways','propertyID'));
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
   public function activation(Request $request,$propertyID)
   {
      $this->validate($request, [
         'gateway' => 'required',
         'status' => 'required',
      ]);

      //check if this payment is already assigned
      $check = propertyIntegerations::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->where('gatewayID',$request->gateway)->count();

      if ($check != 0) {
         Session::flash('error','This gateway is already assigned to you account');

         return redirect()->back();
      }

      $gateway = new propertyIntegerations;
      $gateway->propertyID = $propertyID;
      $gateway->businessID = Auth::user()->businessID;
      $gateway->created_by = Auth::user()->id;
      $gateway->gatewayID = $request->gateway;
      $gateway->status = $request->status;
      $gateway->save();

      Session::flash('success','Payment gateway successfully added');

      return redirect()->back();
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {

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
   public function delete($propertyID,$integrationID)
   {
      payment_integration::where('businessID',Auth::user()->businessID)->where('id',$integrationID)->where('propertyID',$propertyID)->delete();

      Session::flash('success','Integration successfully deleted');

      return redirect()->back();
   }
}
