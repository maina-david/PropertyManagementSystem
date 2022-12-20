<?php

namespace App\Http\Controllers\app\hr\leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr\leaves;
use App\Models\hr\type;
use Auth;
use Session;

class leaveapplyController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   //personal list
   public function my_list(){
      $leaves = leaves::join('hr_employees','hr_employees.id','=','hr_leave.employeeID')
                  ->join('status','status.id','=','hr_leave.statusID')
                  ->join('hr_leave_type','hr_leave_type.id','=','hr_leave.leave_type')
                  ->where('hr_leave.businessID',Auth::user()->businessID)
                  ->where('hr_leave.employeeID',Auth::user()->employeeID)
                  ->orderby('hr_leave.id','desc')
                  ->select('*','hr_leave.statusID as statusID','status.name as statusName','hr_leave_type.name as leaveName','hr_leave.id as leaveID')
                  ->get();

      return view('app.hr.leave.application.index', compact('leaves'));
   }

   //application
   public function application(){
      $types = type::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose leave type','');
      return view('app.hr.leave.application.create', compact('types'));
   }

   // store application
   public function store(Request $request){
      $this->validate($request, [
         'start_date' => 'required',
         'end_date' => 'required',
         'leave_type' => 'required',
         'reason' => 'required',
      ]);

      $leave = new leaves;
      $leave->start_date = $request->start_date;
      $leave->end_date = $request->end_date;
      $leave->reason = $request->reason;
      $leave->leave_type = $request->leave_type;
      $leave->statusID = 7;
      $leave->employeeID = Auth::user()->employeeID;
      $leave->businessID = Auth::user()->businessID;
      $leave->created_by = Auth::user()->id;
      $leave->save();

      //send email to hr head to notify the request

      Session::flash('success', 'Application successful, awaiting approval');

      return redirect()->route('hrm.leave.apply.index');
   }

   //edit
   public function edit($id){
      $types = type::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose leave type','');
      $edit = leaves::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      return view('app.hr.leave.application.edit', compact('edit','types'));
   }

   // store application
   public function update(Request $request, $id){
      $this->validate($request, [
         'start_date' => 'required',
         'end_date' => 'required',
         'leave_type' => 'required',
         'reason' => 'required',
      ]);

      $leave = leaves::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $leave->start_date = $request->start_date;
      $leave->end_date = $request->end_date;
      $leave->reason = $request->reason;
      $leave->leave_type = $request->leave_type;
      $leave->statusID = 7;
      $leave->employeeID = Auth::user()->employeeID;
      $leave->businessID = Auth::user()->businessID;
      $leave->created_by = Auth::user()->id;
      $leave->save();

      //send email to hr head to notify the request

      Session::flash('success', 'Application successful updated');

      return redirect()->back();
   }

}
