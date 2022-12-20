<?php

namespace App\Http\Controllers\app\property\settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\utilities;
use App\Models\property\lease_utility;
use Auth;
use Session;
class utilitiesController extends Controller
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
      $utilities = utilities::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      return view('app.property.settings.utilities.index', compact('utilities','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      return view('app.property.settings.utilities.create');
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

      $utility = new utilities;
      $utility->name = $request->name;
      $utility->description = $request->description;
      $utility->businessID = Auth::user()->businessID;
      $utility->created_by =  Auth::user()->id;
      $utility->save();

      Session::flash('success','Utility successfully added');

      return redirect()->route('property.utilities');
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
      $edit = utilities::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      return view('app.property.settings.utilities.edit', compact('edit'));
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

      $utility = utilities::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $utility->name = $request->name;
      $utility->description = $request->description;
      $utility->businessID = Auth::user()->businessID;
      $utility->updated_by =  Auth::user()->id;
      $utility->save();

      Session::flash('success','Utility successfully updated');

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
      //check if utility is linked to lease
      $check = lease_utility::where('utilityID',$id)->where('businessID',Auth::user()->businessID)->count();
      if($check == 0){
         $delete = utilities::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
         $delete->delete();

         Session::flash('success','Utility successfully deleted');
      }else{

         Session::flash('warning','This utility is linked to several leases, Unlink them then try to delete the utility again');
      }      

      return redirect()->back();
   }
}
