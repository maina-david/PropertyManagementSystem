<?php

namespace App\Http\Controllers\app\property;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\maintenance\category;
use Auth;
use Session;
class maintenanceCategoryController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $category = category::orderby('id','desc')->pluck('name','id')->prepend('Choose parent category','0');
      $categories = category::orderby('id','desc')->get();
      $count = 1;
      return view('app.property.maintenance.category.index', compact('category','categories','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      
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
         'name' => 'required',
      ]);

      $category = new category;
      $category->name = $request->name;
      $category->parentID = $request->parent;
      $category->save();

      Session::flash('success','Category successfully added');

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
      $category = category::orderby('id','desc')->pluck('name','id')->prepend('Choose parent category','0');
      $categories = category::orderby('id','desc')->get();
      $edit = category::find($id);
      $count = 1;
      return view('app.property.maintenance.category.edit', compact('category','categories','count','edit'));
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
         'name' => 'required',
      ]);

      $category = category::find($id);
      $category->name = $request->name;
      $category->parentID = $request->parent;
      $category->save();

      Session::flash('success','Category successfully updated');

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
      $category = category::find($id);
      $category->delete();

      Session::flash('success','Category successfully deleted');

      return redirect()->route('pm.maintenance.category.index');
   }
}
