<?php

namespace App\Http\Controllers\Limitless\HumanResource\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HumanResource\employee_roles_link;
use App\Role;
use App\Model\HumanResource\employee_basic_info;
use Session;
class EmployeeRolesController extends Controller
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
    	$roles = Role::OrderBy('id','DESC')->get();
        $edit_emp = employee_roles_link::where('hr_employee_roles_link.employee_id',$id)->join('hr_emloyee_basic_info','hr_emloyee_basic_info.id','=','hr_employee_roles_link.employee_id')->select('*','hr_employee_roles_link.employee_id as empid')->first();
        return view('Limitless.Human-resource.Employee.roles')->withEmployee($edit_emp)->withRoles($roles);
    }

    public function update(Request $request, $id){

    	$employee_summery = employee_summery::where('employee_id',$id)->first();

	    $employee_summery->job_description = $request->job_description;
	    $employee_summery->about_me = $request->about_me;

	    $employee_summery->save();
	    
        Session::flash('Success','Employee Summery has been successfully updated');

        return redirect()->back();
    } 
}
