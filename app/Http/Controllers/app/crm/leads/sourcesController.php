<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\leads\sources;
use Auth;
use Session;

class sourcesController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $sources = sources::where('businessID',Auth::user()->businessID)->get();
      $count = 1;

      return view('app.crm.settings.leads.settings', compact('sources','count'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request,[
         'name' => 'required'
      ]);

      $source = new sources;
      $source->name= $request->name;
      $source->businessID = Auth::user()->businessID;
      $source->userID = Auth::user()->id;
      $source->save();

      Session::flash('success','source created successfully');

      return redirect()->back();
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
      $this->validate($request,[
         'name' => 'required'
      ]);

      $source = sources::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $source->name= $request->name;
      $source->businessID = Auth::user()->businessID;
      $source->userID = Auth::user()->id;
      $source->save();

      Session::flash('success','source update successfully');

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
      $source = sources::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $source->delete();

      Session::flash('success','source deleted successfully');

      return redirect()->back();
   }
}
