<?php

namespace App\Http\Controllers\app\hr\leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\type;
use App\Models\hr\leaves;
use App\Models\hr\employees;
use App\Mail\sendMessage;
use Calendar;
use Session;
use Helper;
use Mail;
use Auth;


class leaveController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
    * show leave requests
    *
    * @return \Illuminate\Http\Response
    */
   public function index(){
      $date = date('Y-m-d');
      $leaves = leaves::join('hr_employees','hr_employees.id','=','hr_leave.employeeID')
                  ->join('status','status.id','=','hr_leave.statusID')
                  ->join('hr_leave_type','hr_leave_type.id','=','hr_leave.leave_type')
                  ->where('hr_leave.businessID',Auth::user()->businessID)
                  ->orderby('hr_leave.id','desc')
                  ->select('*','hr_leave.statusID as statusID','status.name as statusName','hr_leave_type.name as leaveName','hr_leave.id as leaveID')
                  ->get();

      $current = leaves::where('statusID',19)->where('businessID',Auth::user()->businessID)->where('start_date','<',$date)->where('end_date','>',$date)->count();

      $pending = leaves::where('statusID',7)->where('businessID',Auth::user()->businessID)->count();
      $approved = leaves::where('statusID',19)->where('businessID',Auth::user()->businessID)->count();
      $rejected = leaves::where('statusID',20)->where('businessID',Auth::user()->businessID)->count();


      return view('app.hr.leave.index', compact('leaves','current','pending','approved','rejected'));
   }

   /**
   * create
   *
   * @return \Illuminate\Http\Response
   */
   public function create(){
      $types = type::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose leave type','');
      $employees = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('choose employee','');

      return view('app.hr.leave.create', compact('types','employees'));
   }

   /**
    * store leave
    *
    * @return \Illuminate\Http\Response
    */
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
      $leave->days = Helper::date_difference($request->end_date,$request->start_date);
      $leave->reason = $request->reason;
      $leave->leave_type = $request->leave_type;
      $leave->statusID = 7;
      $leave->employeeID = $request->employeeID;
      $leave->businessID = Auth::user()->businessID;
      $leave->created_by = Auth::user()->id;
      $leave->save();

      //send email to hr head to notify the request

      Session::flash('success', 'Request successful, awaiting approval');

      return redirect()->route('hrm.leave.index');
   }

   /**
    * edit leave
    *
    * @return \Illuminate\Http\Response
   */
   public function edit($id){
      $edit = leaves::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $types = type::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose leave type','');
      $employees = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('choose employee','');
      return view('app.hr.leave.edit', compact('types','employees','edit'));
   }

   /**
    * update leave
    *
    * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id){

      $leave = leaves::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $leave->start_date = $request->start_date;
      $leave->end_date = $request->end_date;
      $leave->days = Helper::date_difference($request->end_date,$request->start_date);
      $leave->reason = $request->reason;
      $leave->leave_type = $request->leave_type;
      $leave->employeeID = $request->employeeID;
      $leave->businessID = Auth::user()->businessID;
      $leave->updated_by = Auth::user()->id;
      $leave->save();

      Session::flash('success','Leave successfully updated');

      return redirect()->back();
   }

   /**
   * show leave balance
   *
   * @return \Illuminate\Http\Response
   */
   public function balance(){
      return view('app.hr.leave.balance');
   }

   /**
   * show leave balance
   *
   * @return \Illuminate\Http\Response
   */
   public function calendar(){
      $events = [];
      $data = leaves::join('hr_employees','hr_employees.id','=','hr_leave.employeeID')
                     ->join('status','status.id','=','hr_leave.statusID')
                     ->join('hr_leave_type','hr_leave_type.id','=','hr_leave.leave_type')
                     ->where('hr_leave.businessID',Auth::user()->businessID)
                     ->select('*','hr_leave_type.name as leaveName')
                     ->get();

      if($data->count()) {
         foreach ($data as $key => $value) {
            $events[] = Calendar::event(
               $value->names.'-'.$value->leaveName,
               true,
               new \DateTime($value->start_date),
               new \DateTime($value->end_date),
               null,
               // Add color and link on event
               [
                  'color' => $value->color,
                  //'url' => 'pass here url and any route',
               ]
            );
         }
      }

      $calendar = Calendar::addEvents($events);

      return view('app.hr.leave.calendar', compact('calendar'));
   }

   /**
   * approve leave
   *
   * @return \Illuminate\Http\Response
   */
   public function approve($id){
      $leave = leaves::where('id',$id)->where('hr_leave.businessID',Auth::user()->businessID)->first();

      $employee = employees::where('id',$leave->employeeID)->where('businessID',Auth::user()->businessID)->first();

      if($employee->leave_days == 0 || $employee->leave_days == ""){
         Session::flash('warning','Please check the leave days alocated to '.$employee->names.' Its currently reading 0 days');
         return redirect()->back();
      }

      $employee->leave_days = $employee->leave_days - $leave->days;
      $employee->save();

      //updated leave
      $leave->statusID = 19;
      $leave->save();

      //send system email for leave approval
      if($employee->company_email != ""){
         $subject = 'Leave Approval Notification';
         $to = $employee->company_email;
         $content = '<h3>Hi, '.$employee->names.'</h3>
                     <p>Your leave application has been approved</p>
                     <p>Thank you.</p>';
         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      Session::flash('success','Leave successfully approved');

      return redirect()->back();
   }

   /**
   * denay leave
   *
   * @return \Illuminate\Http\Response
   */
   public function denay($id){
      $leave = leaves::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      $employee = employees::where('id',$leave->employeeID)->where('businessID',Auth::user()->businessID)->first();

      if($employee->leave_days == 0 || $employee->leave_days == ""){
         Session::flash('warning','Please check the leave days alocated to '.$employee->names.' Its currently reading 0 days');
         return redirect()->back();
      }

      //updated leave
      $leave->statusID = 20;
      $leave->save();

      //send system email for leave approval
      if($employee->company_email != ""){
         $subject = 'Leave Denial Notification';
         $to = $employee->company_email;
         $content = '<h3>Hi, '.$employee->names.'</h3>
                     <p>Your leave application has been denied</p>
                     <p>Thank you.</p>';
         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      Session::flash('success','Leave successfully denied');

      return redirect()->back();
   }

   /**
   * Delete leave
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($id){
      $leave = leaves::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $leave->delete();

      Session::flash('success','Leave successfully deleted');

      return redirect()->back();
   }

}
