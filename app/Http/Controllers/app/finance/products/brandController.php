<?php

namespace App\Http\Controllers\app\finance\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\brand;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;

class brandController extends Controller
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
      $brands = brand::where('businessID',Auth::user()->businessID)->orderBy('id','desc')->get();
      $count = 1;
      return view('app.finance.products.brands.index', compact('brands','count'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request,array(
         'name'=>'required',
      ));

      $check = brand::where('businessID',Auth::user()->businessID)->where('name',$request->name)->count();
      if($check == 0){
         $url = Helper::seoUrl($request->name);
      }else{
         $url = Helper::seoUrl($request->name).generateRandomString(3);
      }

      $brand = new brand;
      $brand->name = $request->name;
      $brand->url = $url;
      $brand->businessID = Auth::user()->businessID;
      $brand->userID = Auth::user()->id;
      $brand->save();

      session::flash('success','You have successfully created a new brand.');

      return redirect()->route('finance.product.brand');
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
      $brand = brand::find($id);
      $brands = brand::where('businessID',Auth::user()->businessID)->orderBy('id','desc')->get();
      $count = 1;
      return view('app.finance.products.brands.edit', compact('brand','count','brands'));
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
         'name' => '',
      ]);

      $brand = brand::find($id);
      $brand->name = $request->name;
      $brand->userID = Auth::user()->id;
      $brand->save();

      session::flash('success','Brand successfully updated!');

      return redirect()->route('finance.product.brand.edit',$brand->id);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $brand = brand::find($id);
      $brand->delete();

      Session::flash('success', 'The brand was successfully deleted !');

      return redirect()->route('finance.product.brand');
   }
}
