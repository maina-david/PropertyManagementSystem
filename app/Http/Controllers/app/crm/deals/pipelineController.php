<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\deals\pipeline;
use App\Models\crm\deals\stages;
use Auth;
use Session;

class pipelineController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   // list
   public function index(){
      $pipelines = pipeline::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      
      return view('app.crm.deals.pipelines.pipeline.index', compact('pipelines','count'));
   }

   // store
   public function store(Request $request){
      $this->validate($request, [
         'title' => 'required',
      ]);
      $pipeline = new pipeline;
      $pipeline->title = $request->title;
      $pipeline->description = $request->description;
      $pipeline->businessID = Auth::user()->businessID;
      $pipeline->created_by = Auth::user()->id;
      $pipeline->save();
      Session::flash('success','Pipeline successfully added');

      return redirect()->back();
   }

   // edit
   public function edit($id){
      $pipelines = pipeline::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      $edit = pipeline::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      return view('app.crm.deals.pipelines.pipeline.edit', compact('edit','pipelines','count'));
   }

   // update
   public function update(Request $request,$id){
      $this->validate($request, [
         'title' => 'required',
      ]);
      $pipeline = pipeline::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $pipeline->title = $request->title;
      $pipeline->description = $request->description;
      $pipeline->businessID = Auth::user()->businessID;
      $pipeline->updated_by = Auth::user()->id;
      $pipeline->save();
      Session::flash('success','Pipeline successfully updated');

      return redirect()->back();
   }
   
   //show pipeline
   public function show($id){
      $pipeline = pipeline::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $stages = stages::where('pipelineID',$id)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->get();
      $count = 1;
      return view('app.crm.deals.pipelines.pipeline.show', compact('pipeline','stages','count'));
   }

   //delete
   public function delete($id){

      $delete = pipeline::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $delete->delete();

      stages::where('pipelineID',$id)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->delete();

      Session::flash('success','Pipeline delete successfully');

      return redirect()->route('crm.pipeline.index');
   }

}
