<?php
namespace App\Http\Controllers\app\settings\integrations\payments\mpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Session;
use Wingu;
class paybillnumberController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   /**
   * Get the integration view
   */
   public function paybill_number($id){
      //get the phone number integration
      $integration = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',8)->first();

      return view('app.settings.integrations.payment.mpesa.paybillnumber', compact('integration'));
   }

   /**
   * update integration details
   */
   public function update_paybill_number(Request $request,$id){
      $this->validate($request,[
         'paybill_number' => 'required',
         'mpesa_name' => 'required',
         'paybill_account_number' => 'required',
      ]);

      $update = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',8)->first();
      if($update->business_code == ""){
         $update->business_code = Wingu::business()->businessID;
      }
      $update->paybill_number = $request->paybill_number;
      $update->mpesa_name = $request->mpesa_name;
      $update->paybill_account_number = $request->paybill_account_number;
      $update->businessID = Auth::user()->businessID;
      $update->updated_by = Auth::user()->id;
      $update->save();

      Session::flash('success','Mpesa Paybill number integration successfully updated');

      return redirect()->back();
   }
}
