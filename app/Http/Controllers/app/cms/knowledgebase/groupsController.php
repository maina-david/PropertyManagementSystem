<?php

namespace App\Http\Controllers\app\cms\knowledgebase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\cms\knowledgebase\groups;
use Auth;
use Wingu;
use Helper;
use Session;

class groupsController extends Controller
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
         $groups = groups::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
         $count = 1;
         return view('app.cms.groups.index', compact('groups','count'));
      }else{
         return view('errors.403');
      }
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

      $group = new groups;
      $group->name = $request->name;
      $group->description = $request->description;
      $group->status = $request->status;
      $group->slug = Helper::seoUrl($request->name);
      $group->businessID = Auth::user()->businessID;
      $group->userID = Auth::user()->id;
      $group->save();

      Session::flash('success','Groups successfully added');

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
      $groups = groups::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      $edit = groups::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      return view('app.cms.groups.edit', compact('groups','count','edit'));
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

      $group = groups::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $group->name = $request->name;
      $group->description = $request->description;
      $group->status = $request->status;
      $group->slug = Helper::seoUrl($request->name);
      $group->businessID = Auth::user()->businessID;
      $group->userID = Auth::user()->id;
      $group->save();

      Session::flash('success','Groups successfully updated');

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
      $delete = groups::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $delete->delete();

      Session::flash('success','Group successfully deleted');

      return redirect()->route('cms.groups.index');
   }
}
