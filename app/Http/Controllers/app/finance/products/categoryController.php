<?php
namespace App\Http\Controllers\app\finance\products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\category;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;

class categoryController extends Controller{

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
      $category = category::where('businessID',Auth::user()->businessID)->orderBy('id','desc')->get();
      $count = 1;
      return view('app.finance.products.category.index', compact('category','count'));
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

      $check = category::where('businessID',Auth::user()->businessID)->where('name',$request->name)->count();
      if($check == 0){
         $url = Helper::seoUrl($request->name);
      }else{
         $url = Helper::seoUrl($request->name).generateRandomString(3);
      }

      $category = new category;
      $category->name = $request->name;
      $category->parentID = $request->parent;
      $category->url = $url;
      $category->businessID = Auth::user()->businessID;
      $category->created_by = Auth::user()->id;
      $category->save();

      session::flash('success','You have successfully created a new Category.');

      return redirect()->route('finance.product.category');
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
      $category = category::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $parents = category::where('businessID',Auth::user()->businessID)
                  ->where('id','!=',$category->id)
                  ->where('businessID',Auth::user()->businessID)
                  ->get();
      $categories = category::where('businessID',Auth::user()->businessID)->orderBy('id','desc')->get();
      $count = 1;
      return view('app.finance.products.category.edit', compact('category','parents','count','categories'));
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

      $category = category::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      if($category->name != $request->name){
         $check = category::where('businessID',Auth::user()->businessID)->where('name',$request->name)->count();
         if($check == 0){
            $url = Helper::seoUrl($request->name);
         }else{
            $url = Helper::seoUrl($request->name).generateRandomString(3);
         }

         $category->url = $url;
      }
      $category->name = $request->name;
      $category->parentID = $request->parent;
      $category->updated_by = Auth::user()->id;
      $category->save();

      session::flash('success','Category successfully updated!');

      return redirect()->route('finance.product.category.edit',$category->id);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      category::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();

      Session::flash('success', 'The category was successfully deleted !');

      return redirect()->route('finance.product.category');
   }
}
