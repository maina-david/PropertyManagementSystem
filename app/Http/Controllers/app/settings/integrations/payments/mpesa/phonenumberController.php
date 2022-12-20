<?php

namespace App\Http\Controllers\app\settings\integrations\payments\mpesa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Session;
use Wingu;
class phonenumberController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   /**
   * Get the integration view
   */
   public function phone_number($id){
      //get the phone number integration
      $integration = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',10)->first();

      return view('app.settings.integrations.payment.mpesa.phonenumber', compact('integration'));
   }

   /**
   * update integration details
   */
   public function update_phone_number(Request $request,$id){
      $this->validate($request,[
         'mpesa_phone_number' => 'required',
         'mpesa_name' => 'required',
      ]);

      $update = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',10)->first();
      if($update->business_code == ""){
         $update->business_code = Wingu::business()->businessID;
      }
      $update->mpesa_phone_number = $request->mpesa_phone_number;
      $update->mpesa_name = $request->mpesa_name;
      $update->businessID = Auth::user()->businessID;
      $update->updated_by = Auth::user()->id;
      $update->save();

      Session::flash('success','Mpesa phone number integration successfully updated');

      return redirect()->back();
   }
}
