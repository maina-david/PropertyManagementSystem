<?php

namespace App\Http\Controllers\app\property\integration\payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\property\property;
use App\Models\wingu\payment_gateways;
use App\Models\property\payment_integration;
use Auth;
use Session;

class bankController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   //bank1
   public function bank($propertyID,$getwayID){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
      $bank = payment_integration::join('payment_gateways','payment_gateways.id','=','property_payment_integration.gatewayID')
                                    ->where('property_payment_integration.businessID',Auth::user()->businessID)
                                    ->where('propertyID',$propertyID)
                                    ->where('property_payment_integration.id',$getwayID)
                                    ->select('*','property_payment_integration.id as integrationID','property_payment_integration.status as status')
                                    ->first();

      return view('app.property.property.show', compact('property','bank','propertyID'));      
   }

   //update bank1
   public function bank1_update(Request $request,$propertyID,$id){
      $this->validate($request, [
         'bank_name' => 'required',
         'bank_account_name' => 'required',
         'bank_account_number' => 'required'  
      ]);

      $edit = payment_integration::where('businessID',Auth::user()->businessID)->where('id',$id)->where('propertyID',$propertyID)->first();
      $edit->bank_name = $request->bank_name;
      $edit->bank_branch = $request->bank_branch;
      $edit->bank_account_name = $request->bank_account_name;
      $edit->bank_account_number = $request->bank_account_number;
      $edit->updated_by = Auth::user()->id;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Bank information has been successfully updated');

      return redirect()->back();
   }

   //update bank2
   public function bank2_update(Request $request,$propertyID,$id){
      $this->validate($request, [
         'bank_name' => 'required',
         'bank_account_name' => 'required',
         'bank_account_number' => 'required'  
      ]);

      $edit = payment_integration::where('businessID',Auth::user()->businessID)->where('id',$id)->where('propertyID',$propertyID)->first();
      $edit->bank_name = $request->bank_name;
      $edit->bank_branch = $request->bank_branch;
      $edit->bank_account_name = $request->bank_account_name;
      $edit->bank_account_number = $request->bank_account_number;
      $edit->updated_by = Auth::user()->id;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Bank information has been successfully updated');

      return redirect()->back();
   }

   //update bank3
   public function bank3_update(Request $request,$propertyID,$id){
      $this->validate($request, [
         'bank_name' => 'required',
         'bank_account_name' => 'required',
         'bank_account_number' => 'required'  
      ]);

      $edit = payment_integration::where('businessID',Auth::user()->businessID)->where('id',$id)->where('propertyID',$propertyID)->first();
      $edit->bank_name = $request->bank_name;
      $edit->bank_branch = $request->bank_branch;
      $edit->bank_account_name = $request->bank_account_name;
      $edit->bank_account_number = $request->bank_account_number;
      $edit->updated_by = Auth::user()->id;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Bank information has been successfully updated');

      return redirect()->back();
   }

   //update bank4
   public function bank4_update(Request $request,$propertyID,$id){
      $this->validate($request, [
         'bank_name' => 'required',
         'bank_account_name' => 'required',
         'bank_account_number' => 'required'  
      ]);

      $edit = payment_integration::where('businessID',Auth::user()->businessID)->where('id',$id)->where('propertyID',$propertyID)->first();
      $edit->bank_name = $request->bank_name;
      $edit->bank_branch = $request->bank_branch;
      $edit->bank_account_name = $request->bank_account_name;
      $edit->bank_account_number = $request->bank_account_number;
      $edit->updated_by = Auth::user()->id;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Bank information has been successfully updated');

      return redirect()->back();
   }

    //update bank5
    public function bank5_update(Request $request,$propertyID,$id){
      $this->validate($request, [
         'bank_name' => 'required',
         'bank_account_name' => 'required',
         'bank_account_number' => 'required'  
      ]);

      $edit = payment_integration::where('businessID',Auth::user()->businessID)->where('id',$id)->where('propertyID',$propertyID)->first();
      $edit->bank_name = $request->bank_name;
      $edit->bank_branch = $request->bank_branch;
      $edit->bank_account_name = $request->bank_account_name;
      $edit->bank_account_number = $request->bank_account_number;
      $edit->updated_by = Auth::user()->id;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Bank information has been successfully updated');

      return redirect()->back();
   }
}
