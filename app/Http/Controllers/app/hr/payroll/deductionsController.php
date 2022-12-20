<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\deductions;
use App\Models\hr\payroll_allocations;
use Auth;
use Session;

class deductionsController extends Controller
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
      $deductions = deductions::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      return view('app.hr.payroll.settings.deductions', compact('deductions','count'));
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
         'title' => 'required',
      ]);

      $deduction = new deductions;
      $deduction->title = $request->title;
      $deduction->description = $request->description;
      $deduction->userID = Auth::user()->id;
      $deduction->businessID = Auth::user()->businessID;
      $deduction->save();

      Session::flash('success','Deduction successfully added');

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
      $data = deductions::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      return response()->json(['data' => $data]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {
      $this->validate($request,[
         'title' => 'required',
      ]);

      $deduction = deductions::where('id',$request->deductionID)->where('businessID',Auth::user()->businessID)->first();
      $deduction->title = $request->title;
      $deduction->description = $request->description;
      $deduction->userID = Auth::user()->id;
      $deduction->businessID = Auth::user()->businessID;
      $deduction->save();

      Session::flash('success','Deduction successfully added');

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
      $check = payroll_allocations::where('deductionID',$id)->where('businessID',Auth::user()->businessID)->count();
      if($check > 0){
         Session::flash('warning','This deduction is linked to an employee unlink it first then delete it');
         return redirect()->back();
      }

      $deduction = deductions::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $deduction->delete();

      Session::flash('success','Deduction successfully deleted');

      return redirect()->back();
   }
}
