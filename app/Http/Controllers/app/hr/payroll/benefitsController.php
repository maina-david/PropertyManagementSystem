<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\payroll_allocations;
use App\Models\hr\benefits;
use Auth;
use Session;

class benefitsController extends Controller
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
      $benefits = benefits::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      return view('app.hr.payroll.settings.benefits', compact('benefits','count'));
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

      $benefits = new benefits;
      $benefits->title = $request->title;
      $benefits->taxable = $request->taxable;
      $benefits->rate = $request->rate;
      $benefits->description = $request->description;
      $benefits->created_by = Auth::user()->id;
      $benefits->businessID = Auth::user()->businessID;
      $benefits->save();

      Session::flash('success','Benefit successfully added');

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
      $data = benefits::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
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

      $benefits = benefits::where('id',$request->benefitID)->where('businessID',Auth::user()->businessID)->first();
      $benefits->title = $request->title;
      $benefits->description = $request->description;
      $benefits->taxable = $request->taxable;
      $benefits->rate = $request->rate;
      $benefits->updated_by = Auth::user()->id;
      $benefits->businessID = Auth::user()->businessID;
      $benefits->save();

      Session::flash('success','Benefits successfully added');

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
      //check if benefit is allocated
      $check = payroll_allocations::where('benefitID',$id)->where('businessID',Auth::user()->businessID)->count();
      if($check > 0){
         Session::flash('warning','This benefit is linked to an employee unlink it first then delete it');
         return redirect()->back();
      }

      $benefits = benefits::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();

      Session::flash('success','Benefits successfully deleted');

      return redirect()->back();
   }
}
