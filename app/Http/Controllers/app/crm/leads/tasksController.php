<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\crm\leads\tasks;
use App\Models\hr\employees;
Use Auth;
use Wingu;
use Session;

class tasksController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($id)
   {
      //check if user is linked to a business and allow access
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $employees = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose employee');
      $tasks = tasks::where('businessID',Auth::user()->businessID)->where('leadID',$id)->orderby('id','desc')->get();
      $customerID = $id;
      return view('app.crm.leads.show', compact('lead','customerID','employees','tasks'));
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
         'task'  => 'required',
         'date'  => 'required',
         'assigned_to' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'category' => 'required',
         'leadID' => 'required',
         'description' => 'required',
      ]);

      $task = new tasks;
      $task->task = $request->task;
      $task->date = $request->date;
      $task->time = $request->time;
      $task->assigned_to = $request->assigned_to;
      $task->priority = $request->priority;
      $task->status = $request->status;
      $task->category = $request->category;
      $task->leadID = $request->leadID;
      $task->description = $request->description;
      $task->userID = Auth::user()->id;
      $task->businessID = Auth::user()->businessID;
      $task->save();

      Session::flash('success','Task added successfully');

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
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
      $this->validate($request,[
         'task'  => 'required',
         'date'  => 'required',
         'assigned_to' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'category' => 'required',
         'leadID' => 'required',
         'description' => 'required',
      ]);

      $task = tasks::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $task->task = $request->task;
      $task->date = $request->date;
      $task->time = $request->time;
      $task->assigned_to = $request->assigned_to;
      $task->priority = $request->priority;
      $task->status = $request->status;
      $task->category = $request->category;
      $task->leadID = $request->leadID;
      $task->description = $request->description;
      $task->userID = Auth::user()->id;
      $task->businessID = Auth::user()->businessID;
      $task->save();

      Session::flash('success','Task updated successfully');

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
      tasks::where('businessID',Auth::user()->businessID)->where('id',$id)->delete();

      Session::flash('success','Task deleted successfully');

      return redirect()->back();
   }
}
