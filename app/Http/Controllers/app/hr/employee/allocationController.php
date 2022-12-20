<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_all_allocations;
use App\Models\hr\employees;
use App\Models\hr\employee_company_allocations;
use Session;
use Auth;

class allocationController extends Controller
{
	public function __construct(){
	$this->middleware('auth');
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */


	public function edit($id)
	{
		$allocations = employee_all_allocations::where('employee_id',$id)->get();
		$employee = employees::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		$count = 1;
		$edit_emp = employee_company_allocations::where('hr_employee_company_allocation.employee_id',$id)
						->join('hr_emloyee_basic_info','hr_emloyee_basic_info.id','=','hr_employee_company_allocation.employee_id')
						->select('*','employee_id as empid')
						->first();

		return view('app.hr.employee.allocations', compact('employee','allocations','count'));
	}

	public function store(Request $request){
	// University/Collage/Institution //
		for($i=0; $i < count($request->equipment_name); $i++ ) {

		$allocation = new employee_all_allocations;

			$allocation->equipment_name = $request->equipment_name[$i];
			$allocation->reff_no = $request->reff_no[$i];
			$allocation->date_allocated = $request->date_allocated[$i];
			$allocation->condition_before_allocation = $request->condition_before_allocation[$i];
			$allocation->comments = $request->comments[$i];
			$allocation->employee_id = $request->employee_id[$i];

			$allocation->save();

		}

		Session::flash('success','Allocation has been successfully added');

		return redirect()->back();

	}


	public function delete($id){

		$allocation = employee_all_allocations::find($id);

		$allocation->delete();

		Session::flash('success', 'Delete was successful !');

		return redirect()->back();
	}
}
