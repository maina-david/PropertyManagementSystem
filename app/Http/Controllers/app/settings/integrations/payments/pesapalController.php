<?php

namespace App\Http\Controllers\app\settings\integrations\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_gateways;
use Auth;
use Session;

class pesapalController extends Controller
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
      $edit = business_gateways::where('business_payment_gateways.businessID',Auth::user()->businessID)
               ->where('id',$id)
               ->orderby('id','desc')
               ->first();

      return view('backend.settings.integrations.payment.pesapal', compact('edit'));
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
         'customer_key' => 'required',
         'customer_secret' => 'required',
         'iframelink' => 'required',
         'callback_url' => 'required',
         
      ]);

      $edit = business_gateways::where('business_payment_gateways.businessID',Auth::user()->businessID)
               ->where('id',$id)
               ->orderby('id','desc')
               ->first();

      $edit->customer_key = $request->customer_key;
      $edit->customer_secret = $request->customer_secret;
      $edit->iframelink = $request->iframelink;
      $edit->callback_url = $request->callback_url;
      $edit->status = $request->status;
      $edit->save();

      Session::flash('success','Pesapal information has been successfully updated');

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
