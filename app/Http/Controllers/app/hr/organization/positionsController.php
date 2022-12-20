<?php

namespace App\Http\Controllers\app\hr\organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\position;
use Auth;
use Limitless;
use Helper;
use Session;
class positionsController extends Controller
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
      $titles = position::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      return view('app.hr.organization.positions.index', compact('count','titles'));
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
         'name' => 'required',
      ]);

      $title = new position;
      $title->name = $request->name;
      $title->description = $request->description;
      $title->businessID = Auth::user()->businessID;
      $title->save();

      Session::flash('success','Job title added successfully');

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
      $edit = position::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $titles = position::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;

      return view('app.hr.organization.positions.edit', compact('count','titles','edit'));
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

      $title = position::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $title->name = $request->name;
      $title->description = $request->description;
      $title->businessID = Auth::user()->businessID;
      $title->save();

      Session::flash('success','Job title updated successfully');

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
        $title = position::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
        $title->delete();

        Session::flash('success','Job title deleted successfully');

        return redirect()->route('hrm.positions');
    }
}
