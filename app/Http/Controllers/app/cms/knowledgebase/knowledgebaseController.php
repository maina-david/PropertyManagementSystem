<?php

namespace App\Http\Controllers\app\cms\knowledgebase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\cms\knowledgebase\groups;
use App\Models\cms\knowledgebase\knowledgebase;
use Auth;
use Wingu;
use Helper;
use Session;

class knowledgebaseController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      //check if user is linked to a business and allow access
      $check = Wingu::user_business_link(Auth::user()->id,Auth::user()->businessID);
      if($check == 1 ){
         $articles = knowledgebase::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
         $count = 1;
         return view('app.cms.knowledgebase.index', compact('count','articles'));
      }else{
         return view('errors.403');
      }
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $articles = knowledgebase::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $groups = groups::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose group', '');
      $count = 1;

      return view('app.cms.knowledgebase.create', compact('count','articles','groups'));
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

      $knowledgebase = new knowledgebase;
      $knowledgebase->name = $request->name;
      $knowledgebase->description = $request->description;
      $knowledgebase->groupID = $request->groupID;
      $knowledgebase->status = $request->status;
      $knowledgebase->slug = Helper::seoUrl($request->name);
      $knowledgebase->businessID = Auth::user()->businessID;
      $knowledgebase->userID = Auth::user()->id;
      $knowledgebase->save();

      Session::flash('success','Article successfully added');

      return redirect()->route('cms.knowledgebase.edit',$knowledgebase->id);
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      $article = knowledgebase::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      return view('app.cms.knowledgebase.show', compact('article'));
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $edit = knowledgebase::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $groups = groups::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose group', '');

      return view('app.cms.knowledgebase.edit', compact('groups','edit'));
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
         'name' => 'required',
      ]);

      $edit = knowledgebase::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $edit->name = $request->name;
      $edit->description = $request->description;
      $edit->groupID = $request->groupID;
      $edit->status = $request->status;
      $edit->slug = Helper::seoUrl($request->name);
      $edit->businessID = Auth::user()->businessID;
      $edit->userID = Auth::user()->id;
      $edit->save();

      Session::flash('success','Article successfully updated');

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
      $delete = knowledgebase::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $delete->delete();

      Session::flash('success','Article successfully deleted');

      return redirect()->back();
   }
}
