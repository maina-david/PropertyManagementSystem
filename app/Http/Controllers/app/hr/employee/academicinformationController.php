<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_primary_info;
use App\Models\hr\employee_secondary_info;
use App\Models\hr\employee_institution_info;
use App\Models\hr\employees;
use Session;
use Auth;

class academicinformationController extends Controller
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
		$institution = employee_institution_info::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->get();
		$count = 1;

		//return $institution;
		$edit = employee_primary_info::join('hr_employee_secondary_info','hr_employee_secondary_info.employeeID','=','hr_employee_primary_info.employeeID')
					->where('hr_employee_primary_info.employeeID',$id)
					->select('*','hr_employee_primary_info.employeeID as empid')
					->first();

		$employee = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

		return view('app.hr.employee.academic', compact('edit','institution','count','employee'));
	}

	public function update(Request $request, $id){

		///primary information
		$primary = employee_primary_info::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->first();
		$primary->pri_school_name = $request->pri_school_name;
		$primary->pri_year_of_study = $request->pri_year_of_study;
		$primary->pri_results = $request->pri_results;
		$primary->businessID = Auth::user()->businessID;
		$primary->updated_by = Auth::user()->id;
		$primary->save();


		///secondary information
		$secondary = employee_secondary_info::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->first();
		$secondary->sec_school_name = $request->sec_school_name;
		$secondary->sec_year_of_study = $request->sec_year_of_study;
		$secondary->sec_results = $request->sec_results;
		$secondary->businessID = Auth::user()->businessID;
		$secondary->updated_by = Auth::user()->id;
		$secondary->save();

		Session::flash('success','Academic information has been successfully updated');

		return redirect()->back();
	}


	public function post_institution(Request $request){
		// University/Collage/Institution //
		for($i=0; $i < count($request->institution_name); $i++ ) {

			$institution = new employee_institution_info;
			$institution->school_name = $request->institution_name[$i];
			$institution->result_type = $request->dip_degere[$i];
			$institution->field_of_study = $request->uni_field[$i];
			$institution->year_of_study = $request->uni_date[$i];
			$institution->results = $request->uni_result[$i];
			$institution->employeeID = $request->employeeID[$i];
			$institution->year_of_completion = $request->date_of_competion[$i];
			$institution->businessID = Auth::user()->businessID;
			$institution->userID = Auth::user()->id;
			$institution->save();
		}

		Session::flash('success','Institution information has been successfully updated');

		return redirect()->back();
	}

	public function edit_institution($id){

	}

	public function delete_institution($id){
		$inst = employee_institution_info::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$inst->delete();
		Session::flash('success', 'The Institution was successfully deleted !');

		return redirect()->back();
	}
}
