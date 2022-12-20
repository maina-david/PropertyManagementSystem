<?php

namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_personal_info;
use App\Models\hr\employees;
use App\Models\wingu\country;
use Session;
use Wingu;
use Auth;
class personalinfoController extends Controller
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
      $edit = employee_personal_info::where('hr_employee_personal_info.employeeID',$id)
            ->join('hr_employees','hr_employees.id','=','hr_employee_personal_info.employeeID')
            ->select('*','employeeID as empid')
            ->first();
      $country = country::OrderBy('id','DESC')->pluck('name','id')->prepend('Choose nationality country','0');
      $employee = employees::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      return view('app.hr.employee.personal',compact('edit','employee','country'));
   }

   public function update(Request $request, $id){

      $person = employee_personal_info::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->first();
      $person->personal_email = $request->personal_email;
      $person->personal_number = $request->personal_number;
      $person->nationalID = $request->nationalID;
      $person->passport_number = $request->passport_number;
      $person->nationality = $request->nationality;
      $person->home_address = $request->home_address;
      $person->current_home_location = $request->current_home_location;
      $person->region_of_birth = $request->region_of_birth;
      $person->marital_status = $request->marital_status;
      $person->nssf_number = $request->nssf_number;
      $person->nhif_number = $request->nhif_number;
      $person->dob = $request->dob;
      $person->religion = $request->religion;
      $person->helb_loan_amount = $request->helb_loan_amount;
      $person->hospital_of_choice = $request->hospital_of_choice;
      $person->businessID = Auth::user()->businessID;
      $person->updated_by = Auth::user()->id;
      $person->save();

      //recorded activity
		$activities = Auth::user()->name.' Has updated employee information';
		$section = 'Employee';
		$type = 'Update';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
		$activityID = $id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Personal information has been successfully updated');

      return redirect()->back();
   }
}
