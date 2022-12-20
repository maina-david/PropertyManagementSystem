<?php
namespace App\Http\Controllers\app\settings\integrations\payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Finance;
use Session;
class ipayController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $edit = business_payment_integrations::where('id',$id)
                     ->where('businessID',Auth::user()->businessID)
                     ->where('integrationID',12)
                     ->select('*','mpesa_phone_number as phone_number','merchant_consumer_secret as secretKey','merchantID as vendorID')
                     ->first();

      return view('app.settings.integrations.payment.ipay', compact('edit'));
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
      $this->validate($request, [
         'vendorID' => 'required',
         'secretKey' => 'required',
         'currency_code' => 'required',
         'callback_url' => 'required',
         'live_or_sandbox' => 'required',
         'phone_number' => 'required',
      ]);

      $edit = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',12)->first();
      $edit->merchantID = $request->vendorID;
      $edit->merchant_consumer_secret = $request->secretKey;
      $edit->currency_code = $request->currency_code;
      $edit->callback_url = $request->callback_url;
      $edit->wingustore_callback_url = $request->wingustore_callback_url;
      $edit->live_or_sandbox = $request->live_or_sandbox;
      $edit->mpesa_phone_number = $request->phone_number;
      $edit->save();

      Session::flash('success','Ipay information has been successfully updated');

      return redirect()->back();
   }
}
