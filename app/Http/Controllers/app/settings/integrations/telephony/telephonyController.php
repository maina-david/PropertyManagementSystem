<?php

namespace App\Http\Controllers\app\settings\integrations\telephony;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_telephony;
use App\Models\wingu\telephony;
use Auth;
use Session;
class telephonyController extends Controller
{
   public function index(){
      $telephony = telephony::where('status',15)->pluck('name','id')->prepend('choose telephony provider','');
      $businessTelephony = business_telephony::join('telephony','telephony.id','=','business_telephony.telephonyID')
                           ->where('businessID',Auth::user()->businessID)
                           ->orderby('business_telephony.id','desc')
                           ->select('*','business_telephony.status as telephonyStatus','business_telephony.id as businessTelephonyID')
                           ->get();

      return view('app.settings.integrations.telephony.index', compact('telephony','businessTelephony'));
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
         'telephony' => 'required',
         'status' => 'required',
      ]);

      //check if this payment is already assigned 
      $check = business_telephony::where('businessID',Auth::user()->businessID)->where('telephonyID',$request->telephony)->count();

      if ($check != 0) {
         Session::flash('error','This telephony provider is already assigned to you account');

         return redirect()->back();
      }

      $telephony = new business_telephony;
      $telephony->businessID = Auth::user()->businessID;
      $telephony->created_by = Auth::user()->id;
      $telephony->telephonyID = $request->telephony;
      $telephony->status = $request->status;
      $telephony->save();

      Session::flash('success','Telephony provider successfully added');

      return redirect()->back();
   }
}
