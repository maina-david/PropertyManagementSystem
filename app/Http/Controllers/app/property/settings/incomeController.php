<?php

namespace App\Http\Controllers\app\property\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\income\category;
use Session;
use Auth;
class incomeController extends Controller
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
      $categories = category::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      return view('app.property.settings.income.index', compact('categories','count'));
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
         'name' => 'required',
      ]);

      $category = new category;
      $category->name = $request->name;
      $category->description = $request->description;
      $category->created_by = Auth::user()->id;
      $category->businessID = Auth::user()->businessID;
      $category->save();

      Session::flash('success','Income category successfully added');

      return redirect()->route('property.income.category');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      
   }

   /**
    * edit leave
    *
    * @return \Illuminate\Http\Response
   */
   public function edit($id){
      $data = category::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
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
      $this->validate($request, [
         'name' => 'required',
      ]);

      $category = category::where('businessID',Auth::user()->businessID)->where('id',$request->incomeID)->first();
      $category->name = $request->name;
      $category->description = $request->description;
      $category->updated_by = Auth::user()->id;
      $category->businessID = Auth::user()->businessID;
      $category->save();

      Session::flash('success','Income category successfully updated');

      return redirect()->back();
   }

   /**
    * store income category express
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function express(Request $request){
      $category = new category;
      $category->name = $request->category_name;
      $category->created_by = Auth::user()->id;
      $category->businessID = Auth::user()->businessID;
      $category->save();
   }

   public function get_express()
   {
      $accounts = category::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get(['id', 'name as text']);
      return ['results' => $accounts];
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($id)
   {
      $delete = category::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $delete->delete();

      Session::flash('success','Income category successfully deleted');

      return redirect()->route('property.income.category');
   }
}

