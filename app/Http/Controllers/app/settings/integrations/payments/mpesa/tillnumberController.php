<?php

namespace App\Http\Controllers\app\settings\integrations\payments\mpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Session;
use Wingu;
class tillnumberController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   /**
   * Get the integration view
   */
   public function till_number($id){
      //get the phone number integration
      $integration = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',9)->first();

      return view('app.settings.integrations.payment.mpesa.tillnumber', compact('integration'));
   }

   /**
   * update integration details
   */
   public function update_till_number(Request $request,$id){
      $this->validate($request,[
         'till_number' => 'required',
         'mpesa_name' => 'required',
      ]);

      $update = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',9)->first();
      if($update->business_code == ""){
         $update->business_code = Wingu::business()->businessID;
      }
      $update->till_number = $request->till_number;
      $update->mpesa_name = $request->mpesa_name;
      $update->businessID = Auth::user()->businessID;
      $update->updated_by = Auth::user()->id;
      $update->save();

      Session::flash('success','Mpesa Till number integration successfully updated');

      return redirect()->back();
   }
}
