<?php
namespace App\Http\Controllers\app\settings\integrations\payments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business_payment_integrations;
use Auth;
use Finance;
use Session;
class kepler9Controller extends Controller
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
                     ->where('integrationID',13)
                     ->select('*','customer_key as clientID','customer_secret as client_secret')
                     ->first();

      return view('app.settings.integrations.payment.kepler9', compact('edit'));
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
         'clientID' => 'required',
         'client_secret' => 'required',
         'callback_url' => 'required',
      ]);

      $edit = business_payment_integrations::where('id',$id)->where('businessID',Auth::user()->businessID)->where('integrationID',13)->first();
      $edit->customer_key = $request->clientID;
      $edit->customer_secret = $request->client_secret;
      $edit->callback_url = $request->callback_url;
      $edit->save();

      Session::flash('success','Kepler9 information has been successfully updated');

      return redirect()->back();
   }
}
