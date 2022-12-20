<?php

namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_family_info;
use App\Models\hr\employees;
use Session;
use Auth;
class familyController extends Controller
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
		$family = employee_family_info::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->get();
		$count = 1;
		$employee = employees::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

		return view('app.hr.employee.family', compact('employee','family','count'));

	}

	public function post_family(Request $request){
	// University/Collage/Institution //
		for($i=0; $i < count($request->family_name); $i++ ) {

		$family = new employee_family_info;

			$family->family_name = $request->family_name[$i];
			$family->relationship = $request->relationship[$i];
			$family->family_dob = $request->family_dob[$i];
			$family->family_contact = $request->family_contact[$i];
			$family->employeeID = $request->employee_id[$i];
			$family->contact_type = $request->contact_type[$i];
			$family->businessID = Auth::user()->businessID;
			$family->userID = Auth::user()->id;
			$family->save();

		}

		Session::flash('success','Family information has been successfully added');

		return redirect()->back();

	}

	public function edit_institution($id){

	}

	public function delete_family_information($id){

		$family = employee_family_info::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$family->delete();
		Session::flash('success', 'Delete was successful !');

		return redirect()->back();
	}
}
