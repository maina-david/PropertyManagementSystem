<?php

namespace App\Http\Controllers\app\crm\digitalmarketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\digital\medium;
use Auth;
use Session;

class mediumController extends Controller
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
      $mediums = medium::get();
      $count = 1;
      return view('app.crm.socialmedia.medium.index', compact('mediums','count'));
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
         'name' => 'required'
      ]);

      $medium = new medium;
      $medium->name = $request->name;
      $medium->userID = Auth::user()->id;
      $medium->save();

      Session::flash('success','Medium successfully added');

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
      $edit = medium::find($id);
      $mediums = medium::get();
      $count = 1;
      return view('app.crm.socialmedia.medium.edit', compact('mediums','count','edit'));
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
         'name' => 'required'
      ]);

      $medium = medium::find($id);
      $medium->name = $request->name;
      $medium->userID = Auth::user()->id;
      $medium->save();

      Session::flash('success','Medium successfully updated');

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
      $medium = medium::find($id);
      $medium->delete();

      Session::flash('success','Medium successfully deleted');

      return redirect()->route('crm.medium.index');
   }
}
