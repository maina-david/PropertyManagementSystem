<?php

namespace App\Http\Controllers\app\property\integration\payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\wingu\payment_gateways;
use App\Models\property\payment_integration;
use Auth;
use Session;

class mpesaController extends Controller
{  
   public function __construct(){
		$this->middleware('auth');
   }
   
   //mpesa api
   public function api($propertyID,$getwayID){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
      $mpesaApi = payment_integration::join('payment_gateways','payment_gateways.id','=','property_payment_integration.gatewayID')
                                    ->where('property_payment_integration.businessID',Auth::user()->businessID)
                                    ->where('propertyID',$propertyID)
                                    ->where('property_payment_integration.id',$getwayID)
                                    ->select('*','property_payment_integration.id as integrationID','property_payment_integration.status as status')
                                    ->first();
      return view('app.property.property.show', compact('property','mpesaApi','propertyID'));      
   }

   //update api
   public function api_update(Request $request,$propertyID,$id){
      $this->validate($request, [
         'customer_key' => 'required',
         'customer_secret' => 'required',
         'iframelink' => 'required',
         'callback_url' => 'required',         
      ]);

      $edit = payment_integration::where('businessID',Auth::user()->businessID)->where('id',$id)->where('propertyID',$propertyID)->first();
      $edit->customer_key = $request->customer_key;
      $edit->customer_secret = $request->customer_secret;
      $edit->iframelink = $request->iframelink;
      $edit->callback_url = $request->callback_url;
      $edit->updated_by = Auth::user()->id;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Mpesa API information has been successfully updated');

      return redirect()->back();
   }

   //mpesa till
   public function till($propertyID,$getwayID){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
      $mpesaTill = payment_integration::join('payment_gateways','payment_gateways.id','=','property_payment_integration.gatewayID')
                                    ->where('property_payment_integration.businessID',Auth::user()->businessID)
                                    ->where('propertyID',$propertyID)
                                    ->where('property_payment_integration.id',$getwayID)
                                    ->select('*','property_payment_integration.id as integrationID','property_payment_integration.status as status')
                                    ->first();

      return view('app.property.property.show', compact('property','mpesaTill','propertyID'));      
   }

   //update till
   public function till_update(Request $request,$propertyID,$id){
      $this->validate($request, [
         'business_name' => 'required',
         'till_number' => 'required'        
      ]);

      $edit = payment_integration::where('businessID',Auth::user()->businessID)->where('id',$id)->where('propertyID',$propertyID)->first();
      $edit->business_name = $request->business_name;
      $edit->till_number = $request->till_number;
      $edit->updated_by = Auth::user()->id;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Mpesa Till information has been successfully updated');

      return redirect()->back();
   }

   //mpesa paybill
   public function paybill($propertyID,$getwayID){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
      $mpesaPaybill = payment_integration::join('payment_gateways','payment_gateways.id','=','property_payment_integration.gatewayID')
                                    ->where('property_payment_integration.businessID',Auth::user()->businessID)
                                    ->where('propertyID',$propertyID)
                                    ->where('property_payment_integration.id',$getwayID)
                                    ->select('*','property_payment_integration.id as integrationID','property_payment_integration.status as status')
                                    ->first();

      return view('app.property.property.show', compact('property','mpesaPaybill','propertyID'));      
   }

   //update paybill
   public function paybill_update(Request $request,$propertyID,$id){
      $this->validate($request, [
         'business_name' => 'required',
         'paybill_number' => 'required',  
         'paybill_account' => 'required'        
      ]);

      $edit = payment_integration::where('businessID',Auth::user()->businessID)->where('id',$id)->where('propertyID',$propertyID)->first();
      $edit->business_name = $request->business_name;
      $edit->paybill_number = $request->paybill_number;
      $edit->paybill_account = $request->paybill_account;
      $edit->updated_by = Auth::user()->id;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Mpesa Paybill information has been successfully updated');

      return redirect()->back();
   }


}
 