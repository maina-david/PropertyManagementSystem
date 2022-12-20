<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_summery;
use App\Models\hr\employees;
use Session;
use Auth;
class employeesummeryController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function edit($id){
      $edit = employee_summery::where('hr_employee_summery.employee_id',$id)
               ->join('hr_emloyee_basic_info','hr_emloyee_basic_info.id','=','hr_employee_summery.employee_id')
               ->select('*','hr_employee_summery.employee_id as empid')
               ->first();
      
      $employee = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
 
      return view('app.hr.employee.summery', compact('edit','employee'));

   }

   public function update(Request $request, $id){

   $employee_summery = employee_summery::where('employee_id',$id)->first();
   $employee_summery->job_description = $request->job_description;
   $employee_summery->about_me = $request->about_me;
   $employee_summery->save();

   Session::flash('success','Employee summery has been successfully updated');

   return redirect()->back();
   }
}
