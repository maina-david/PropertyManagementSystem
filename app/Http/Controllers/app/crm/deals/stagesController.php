<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\pipeline;
use Auth;
use Session;

class stagesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   //list
   public function store(Request $request){
      $this->validate($request, [
         'title' => 'required',
         'pipelineID' => 'required',
      ]);
      $stage = new stages;
      $stage->title = $request->title;
      $stage->description = $request->description;
      $stage->businessID = Auth::user()->businessID;
      $stage->pipelineID = $request->pipelineID;
      $stage->created_by = Auth::user()->id;
      $stage->save();

      Session::flash('success','Pipeline stage successfully added');

      return redirect()->back();
   }

   //edit
   public function edit($id){
      $edit = stages::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $pipeline = pipeline::where('id',$edit->pipelineID)->where('businessID',Auth::user()->businessID)->first();
      $count = 1;
      $stages = stages::where('pipelineID',$edit->pipelineID)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->get();

      return view('app.crm.deals.pipelines.stages.edit', compact('pipeline','edit','stages','count'));

   }

   //update
   public function update(Request $request, $id){
      $this->validate($request, [
         'title' => 'required',
         'pipelineID' => 'required',
      ]);
      $stage = stages::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $stage->title = $request->title;
      $stage->description = $request->description;
      $stage->businessID = Auth::user()->businessID;
      $stage->pipelineID = $request->pipelineID;
      $stage->created_by = Auth::user()->id;
      $stage->save();

      Session::flash('success','Pipeline stage successfully updated');

      return redirect()->back();
   }

   //delete
   public function delete($id){
      $delete = stages::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $delete->delete();

      Session::flash('success','Pipeline stage successfully updated');

      return redirect()->route('crm.pipeline.show',$delete->pipelineID);
   }

   //position
   public function position(Request $request){
      $this->validate($request, [
         'positions'=>'required'
      ]);

      foreach ($request->positions as $position){

         $index = $position[0];
         $newPosition = $position[1];

         $stage = stages::where('id',$index)->where('businessID',Auth::user()->businessID)->first();         
         $stage->position = $newPosition;         
         $stage->save();
      }
      
      return response()->json('success');
   }
}
