<?php

namespace App\Http\Controllers\app\settings\integrations\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_payment_integrations;
use App\Models\finance\creditnote\creditnote_settings;
use App\Models\finance\invoice\invoice_settings;
use App\Models\wingu\payment_integrations;
use Session;
use Auth;
use Wingu;
use Finance;

class paymentsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      //create creditnote settings for the account
      $check = creditnote_settings::where('businessID',Auth::user()->businessID)->count();
         if($check != 1){
         Finance::creditnote_setting_setup();
      }

      //create invoice settings for the account
      $check = invoice_settings::where('businessID',Auth::user()->businessID)->count();
			if($check != 1){
				Finance::invoice_setting_setup();
			}

      $businessIntegrations = business_payment_integrations::join('payment_integrations','payment_integrations.id','=','business_payment_integrations.integrationID')
                           ->join('status','status.id','=','business_payment_integrations.status')
                           ->where('business_payment_integrations.businessID',Auth::user()->businessID)
                           ->orderby('business_payment_integrations.id','desc')
                           ->select('*','business_payment_integrations.id as businessIntegrationID','business_payment_integrations.status as paymentStatus','status.name as statusName','payment_integrations.name as integration_name')
                           ->get();

      $integrations = payment_integrations::where('status',15)->pluck('name','id')->prepend('Choose your preferred payment integrations', '');

      return view('app.settings.integrations.payment.index', compact('businessIntegrations','integrations'));
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
      $this->validate($request, [
         'integration' => 'required',
         'status' => 'required',
      ]);

      //check if this payment is already assigned
      $check = business_payment_integrations::where('businessID',Auth::user()->businessID)->where('integrationID',$request->integration)->count();

      if ($check != 0) {
         Session::flash('error','This integration is already assigned to you account');

         return redirect()->back();
      }

      $integration = new business_payment_integrations;
      $integration->businessID = Auth::user()->businessID;
      $integration->business_code = Wingu::business()->businessID;
      $integration->userID = Auth::user()->id;
      $integration->integrationID = $request->integration;
      $integration->status = $request->status;
      $integration->created_by = Auth::user()->id;
      $integration->save();

      Session::flash('success','Payment gateway successfully added');

      return redirect()->back();
   }

   /**
   * Display the specified resource.
   **/
   public function show($id)
   {
      //
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
   public function status($id,$statusID)
   {
      $update = business_payment_integrations::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $update->status = $statusID;
      $update->save();

      Session::flash('success','Status Successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($id)
   {
      business_payment_integrations::where('businessID',Auth::user()->businessID)->where('id',$id)->delete();

      Session::flash('success','Integration Successfully deleted');

      return redirect()->back();
   }
}
