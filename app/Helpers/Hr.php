<?php
namespace App\Helpers;
use App\Models\hr\employees;
use App\Models\hr\type;
use App\Models\hr\leaves;
use App\Models\hr\department;
use App\Models\hr\branches;
use App\Models\hr\payroll_settings;
use App\Models\hr\employee_family_info;
use App\Models\hr\payroll_allocations;
use App\Models\hr\position as positions;
use App\Models\crm\leads\sources;
use App\Models\hr\report_to;
use App\Models\hr\department_heads;
use Auth;
class Hr
{
	//=======================================  Employee   ===========================================
	//===============================================================================================
	public static function employee($id){
		$employee = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $employee;
	}

	public static function check_employee($id){
		$count = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->count();
		return $count;
	}

	//check if employee repors to someone
	public static function check_if_has_leader($id){
		$check = report_to::where('businessID',Auth::user()->businessID)->where('employeeID',$id)->count();
		return $check;
	}

	//get the employee heads
	public static function get_employee_leaders($id){
		$leaders = report_to::join('hr_employees','hr_employees.id','=','hr_employee_report_to.leaderID')
									->where('hr_employee_report_to.businessID',Auth::user()->businessID)
									->where('hr_employee_report_to.employeeID',$id)
									->get();
		return $leaders;
	}

	//check if employee is head of a department
	public static function check_if_heads_departments($id){
		$check = department_heads::where('businessID',Auth::user()->businessID)->where('employeeID',$id)->count();
		return $check;
	}

	//get the employee departments
	public static function get_heading_departments($id){
		$departments = department_heads::join('hr_departments','hr_departments.id','=','hr_employee_department_head.departmentID')
								->where('hr_employee_department_head.businessID',Auth::user()->businessID)
								->where('employeeID',$id)
								->get();
		return $departments;
	}

	public static function employee_children_count($id){
		$children = employee_family_info::where('businessID',Auth::user()->businessID)
							->where('employeeID',$id)
							->where('relationship','Child')
							->count();
		return $children;
	}

	//count employees
	public static function count_employee(){
		$count = employees::where('businessID',Auth::user()->businessID)->count();
		return $count;
	}

	//=======================================  leave type   =========================================
	//===============================================================================================
	public static function check_leave_type($id){
		$check = type::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
		return $check;
	}

	public static function leave_type($id){
		$type = type::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		return $type;
	}

	//=======================================  department   =========================================
	//department links
	public static function department_links($id){
		$links = department::where('parentID',$id)->where('businessID',Auth::user()->businessID)->get();
		return $links;
	}


	//=======================================  payroll   =========================================
	//setup payroll
	public static function payroll_setting_setup(){
		$create = new payroll_settings;
		$create->businessID = Auth::user()->businessID;
		$create->userID = Auth::user()->id;
		$create->save();
	}

	//calculate deductions
	public static function calculate_deduction($employeeID){
		$deductions = payroll_allocations::where('employeeID',$employeeID)->where('businessID',Auth::user()->businessID)->sum('amount');
		return $deductions;
	}


	//=======================================  position   ===========================================
	//===============================================================================================
	public static function position($id){
		$position = positions::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		return $position;
	}

	public static function check_position($id){
		$position = positions::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
		return $position;
	}

	//=======================================  department   =========================================
	//===============================================================================================
	//check department 
	public static function check_department($id){
		$department = department::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
		return $department;
	}

	//get department
	public static function department($id){
		$department = department::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		return $department;
	}

	//=======================================  branch   ===========================================
	//===============================================================================================
	//check branch
	public static function check_branch($id){
		$check = branches::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
		return $check;
	}

	//check branch
	public static function branch($id){
		$branch = branches::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		return $branch;
	}

	//check if account has branches
	public static function count_branches(){
		$count = branches::where('businessID',Auth::user()->businessID)->count();
		return $count;
	}

	//check if branch has main branch
	public static function check_main_branch(){
		$count = branches::where('businessID',Auth::user()->businessID)->where('main_branch','Yes')->count();
		return $count;
	}

	//make main branch
	public static function add_main_branch(){
		//update all branches with no as main branch value
		branches::where('businessID',Auth::user()->businessID)
							->update(['main_branch' => 'No']);

		//get one branch and make it main
		$getBranches = branches::where('businessID',Auth::user()->businessID)->limit(1)->get();

		foreach($getBranches as $branch){
			$update = branches::where('businessID',Auth::user()->businessID)->where('id',$branch->id)->first();
			$update->main_branch = 'Yes';
			$update->save();
		}
	}

	//get main branch
	public static function get_main_branch(){
		$main = branches::where('businessID',Auth::user()->businessID)->where('main_branch','Yes')->first();
		return $main;
	}

	//create main branch
	public static function create_branch(){
		$branches = new branches;
      $branches->branch_name = 'Main branch';
		$branches->main_branch = 'Yes';
      $branches->businessID = Auth::user()->businessID;
      $branches->userID = Auth::user()->id;
      $branches->save();
	}

	//=======================================  source   ===========================================
	//===============================================================================================
	public static function source($id){
		$sources = sources::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		return $sources;
	}

	//check source
	public static function check_source($id){
		$check = sources::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
		return $check;
	}
}
