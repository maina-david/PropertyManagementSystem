<?php

namespace App\Http\Controllers\app\settings\integrations\telephony;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_telephony;
use App\Models\wingu\business;
use Auth;
use Session;

class africasTalkingController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      //
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
      $edit = business_telephony::where('businessID',Auth::user()->businessID)
               ->where('id',$id)
               ->orderby('id','desc')
               ->first();
      return view('app.settings.integrations.telephony.africastalking', compact('edit'));
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
         'at_username' => 'required',
         'at_apikey' => 'required',
         'sms_from' => 'required',
         'status' => 'required',         
      ]);

      $edit = business_telephony::where('businessID',Auth::user()->businessID)
               ->where('id',$id)
               ->orderby('id','desc')
               ->first();

      $edit->at_username = $request->at_username;
      $edit->at_apikey = $request->at_apikey;
      $edit->sms_from = $request->sms_from;
      $edit->status = $request->status;
      $edit->updated_by = Auth::user()->businessID;
      $edit->save();

      if($request->default){
         $business = business::where('businessID',Auth::user()->code)->where('id',Auth::user()->businessID)->first();
         $business->telephonyID = $id;
         $business->save();
      }

      Session::flash('success','Africas Talking information has been successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
