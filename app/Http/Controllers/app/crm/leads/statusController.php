<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\leads\status;
use Auth;
use Session;

class statusController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $statuses = status::where('businessID',Auth::user()->businessID)->get();
      $count = 1;

      return view('app.crm.settings.leads.settings', compact('statuses','count'));
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
      $this->validate($request,[
         'name' => 'required'
      ]);

      $status = new status;
      $status->name= $request->name;
      $status->businessID = Auth::user()->businessID;
      $status->userID = Auth::user()->id;
      $status->description= $request->description;
      $status->save();

      Session::flash('success','status created successfully');

      return redirect()->back();
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
      $statuses = status::where('businessID',Auth::user()->businessID)->get();
      $edit = status::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $count = 1;

      return view('app.crm.settings.leads.status.edit', compact('statuses','edit','count'));
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

      $status = status::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $status->name= $request->name;
      $status->businessID = Auth::user()->businessID;
      $status->userID = Auth::user()->id;
      $status->description= $request->description;
      $status->save();

      Session::flash('success','status update successfully');

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
      $status = status::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $status->delete();

      Session::flash('success','status deleted successfully');

      return redirect()->back();
   }
}
