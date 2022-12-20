<?php

namespace App\Http\Controllers\app\hr\organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\department;
use App\Models\hr\employees;
use Auth;
use Session;
use Helper;
class departmentsController extends Controller
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
      $departments = department::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      return view('app.hr.organization.departments.index', compact('departments','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $employees = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose an employee');
      $departments = department::where('businessID',Auth::user()->businessID)->whereNull('parentID')->orderby('id','desc')->get();

      return view('app.hr.organization.departments.create', compact('employees','departments'));
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
         'title' => 'required',
      ]);

      $department = new department;
      $department->title = $request->title;
      $department->code = $request->code;
      $department->parentID = $request->parentID;
      $department->description = $request->description;
      $department->businessID = Auth::user()->businessID;
      $department->created_by = Auth::user()->id;
      $department->head = $request->head;
      $department->save();

      Session::flash('success','Department successfully added');

      return redirect()->route('hrm.departments');
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
      $edit = department::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $employees = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose an employee','');
      $departments = department::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('choose department','');
     
      return view('app.hr.organization.departments.edit', compact('employees','departments','edit'));
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
         'title' => 'required',
      ]);

      $department = department::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $department->title = $request->title;
      $department->parentID = $request->parentID;
      $department->code = $request->code;
      $department->description = $request->description;
      $department->businessID = Auth::user()->businessID;
      $department->updated_by = Auth::user()->id;
      $department->head = $request->head;
      $department->save();

      Session::flash('success','Department successfully updated');

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
      $department = department::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $department->delete();

      Session::flash('success','Department successfully deleted');

      return redirect()->back();
   }
}
