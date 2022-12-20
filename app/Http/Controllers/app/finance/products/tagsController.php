<?php

namespace App\Http\Controllers\app\finance\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\tags;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;

class tagsController extends Controller
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
      $tags = tags::where('businessID',Auth::user()->businessID)->orderBy('id','desc')->get();
      $count = 1;
      return view('app.finance.products.tags.index', compact('tags','count'));
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

      $check = tags::where('businessID',Auth::user()->businessID)->where('name',$request->name)->count();
      if($check == 0){
         $url = Helper::seoUrl($request->name);
      }else{
         $url = Helper::seoUrl($request->name).generateRandomString(3);
      }

      $tags = new tags;
      $tags->name = $request->name;
      $tags->url = $url;
      $tags->businessID = Auth::user()->businessID;
      $tags->userID = Auth::user()->id;
      $tags->save();

      session::flash('success','You have successfully created a new Tag.');

      return redirect()->route('finance.product.tags');
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
      $tag = tags::find($id);
      $tags = tags::where('businessID',Auth::user()->businessID)->orderBy('id','desc')->get();
      $count = 1;
      return view('app.finance.products.tags.edit', compact('tag','count','tags'));
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

      $tags = tags::find($id);
      $tags->name = $request->name;
      $tags->userID = Auth::user()->id;
      $tags->save();

      session::flash('success','Tag successfully updated!');

      return redirect()->route('finance.product.tags.edit',$tags->id);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $tags = tags::find($id);
      $tags->delete();

      Session::flash('success', 'The Tag was successfully deleted !');

      return redirect()->route('finance.product.tags');
   }
}
