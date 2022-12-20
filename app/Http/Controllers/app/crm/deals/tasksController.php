<?php
namespace App\Http\Controllers\app\crm\deals;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\deals\deals;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\tasks;
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
      $deal = deals::join('business','business.id','=','deals.businessID')
                        ->join('currency','currency.id','=','business.base_currency')
                        ->where('deals.id',$id)
                        ->where('deals.businessID',Auth::user()->businessID)
                        ->orderby('deals.id','desc')
                        ->select('*','deals.id as dealID','deals.created_at as create_date')                     
                        ->first();
      $stages = stages::where('pipelineID',$deal->pipeline)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->get();
      $tasks = tasks::where('businessID',Auth::user()->businessID)->where('dealID',$id)->orderby('id','desc')->get();
      $employees = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose employee','');

      return view('app.crm.deals.deal.show', compact('deal','stages','tasks','employees'));
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
         'time'  => 'required',
         'assigned_to' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'category' => 'required',
         'dealID' => 'required',
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
      $task->dealID = $request->dealID;
      $task->description = $request->description;
      $task->created_by = Auth::user()->id;
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
         'time'  => 'required',
         'assigned_to' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'category' => 'required',
         'dealID' => 'required',
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
      $task->dealID = $request->dealID;
      $task->description = $request->description;
      $task->updated_by = Auth::user()->id;
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
