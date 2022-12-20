<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\employee_personal_info;
use App\Models\hr\employee_bank_info;
use App\Models\hr\employee_primary_info;
use App\Models\hr\employee_secondary_info;
use App\Models\hr\employee_family_info;
use App\Models\hr\employee_salary;
use App\Models\hr\department;
use App\Models\hr\position as positions;
use App\Models\hr\department_heads as head;
use App\Models\hr\report_to as report;
use App\Models\hr\branches;
use Session;
use File;
use Auth;
use Helper;
use Wingu;
use Hr;

class employeeController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){
      $employees = employees::join('hr_employee_personal_info','hr_employee_personal_info.employeeID','=','hr_employees.id')
                           ->join('business','business.id','=','hr_employees.businessID')
                           ->where('hr_employees.businessID',Auth::user()->businessID)
                           ->select('*','hr_employees.id as employeeID','business.businessID as businessCode')
                           ->orderby('hr_employees.id','desc')
                           ->get();
      $count = 1;

      return view('app.hr.employee.index', compact('employees','count'));
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create(){
      if(Hr::count_employee() != Wingu::plan()->employees && Hr::count_employee() < Wingu::plan()->employees){
         $departments = department::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose department');
         $branches = branches::where('businessID',Auth::user()->businessID)->pluck('branch_name','id')->prepend('Choose branch','');
         $positions = positions::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose Job title','');
         $employees = employees::where('businessID',Auth::user()->businessID)->where('statusID',25)->pluck('names','id');

         return view('app.hr.employee.create', compact('departments','positions','employees','branches'));
      }else{
         Session::flash('warning','You have reached the maximum number of employees allowed on this plan please upgrade');

         return redirect()->route('wingu.plans');
      }
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){
      $this->validate($request, array(
         'names'=>'required',
      ));

      //check if company_email already taken
      if($request->company_email != ""){
         $check = employees::where('businessID',Auth::user()->businessID)->where('company_email',$request->company_email)->count();
         if($check > 0){
            Session::flash('error','The company email is already in use');
            return redirect()->back();
         }
      }

      $employee = new employees;
      $employee->names = $request->names;
      $employee->gender = $request->gender;
      $employee->leave_days = $request->leave_days;
      $employee->company_email = $request->company_email;
      $employee->employment_status = $request->employment_status;
      $employee->department = $request->department;
      $employee->position = $request->position;
      $employee->companyID = $request->companyID;
      $employee->branch = $request->branch;
      $employee->company_phone_number = $request->company_phone_number;
      $employee->office_phone_extension = $request->office_phone_extension;
      $employee->source_of_hire = $request->source_of_hire;
      $employee->contract_type = $request->contract_type;
      $employee->hire_date = $request->hire_date;
      $employee->statusID = $request->statusID;
      $employee->temporary_exist_date = $request->temporary_exist_date;
      $employee->termination_date = $request->termination_date;
      $employee->employeeID = Helper::generateRandomString(12);
      $employee->created_by = Auth::user()->id;
      $employee->businessID = Auth::user()->businessID;

      if(!empty($request->image)){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/hr/employee/images/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         //update estimate to system
         $file = $request->image;

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE update WITH RANDOM NUMBER
         $fileName = Helper::seoUrl($request->names).'-'.Helper::generateRandomString(4). '.' . $extension;

         // MOVE THE updateED FILES TO THE DESTINATION DIRECTORY
         $file->move($directory, $fileName);

         $employee->image = $fileName;
      }

      $employee->save();

      $report = count(collect($request->report_to));
         if($report > 0){
         //upload new category
         for($i=0; $i < count($request->report_to); $i++ ) {
               $rep = new report;
               $rep->employeeID = $employee->id;
               $rep->leaderID = $request->report_to[$i];
               $rep->businessID = Auth::user()->businessID;
               $rep->userID = Auth::user()->id;
               $rep->save();
         }
      }

      $department = count(collect($request->lead_department));
         if($department > 0){
         //upload new category
         for($i=0; $i < count($request->lead_department); $i++ ) {
               $leaders = new head;
               $leaders->employeeID = $employee->id;
               $leaders->departmentID = $request->lead_department[$i];
               $leaders->businessID = Auth::user()->businessID;
               $leaders->userID = Auth::user()->id;
               $leaders->save();
         }
      }

      //employee personal info  //
      $personalInfo = new employee_personal_info;
      $personalInfo->employeeID = $employee->id;
      $personalInfo->created_by = Auth::user()->id;
      $personalInfo->businessID = Auth::user()->businessID;
      $personalInfo->save();

      // Employee bank info //
      $bank_info = new employee_bank_info;
      $bank_info->employeeID = $employee->id;
      $bank_info->created_by = Auth::user()->id;
      $bank_info->businessID = Auth::user()->businessID;
      $bank_info->save();


      ///primary school information
      $primary_info = new employee_primary_info;
      $primary_info->employeeID = $employee->id;
      $primary_info->created_by = Auth::user()->id;
      $primary_info->businessID = Auth::user()->businessID;
      $primary_info->save();


      ///secondary school information
      $secondary_info = new employee_secondary_info;
      $secondary_info->employeeID = $employee->id;
      $secondary_info->created_by = Auth::user()->id;
      $secondary_info->businessID = Auth::user()->businessID;
      $secondary_info->save();


      ///secondary school information
      $salary = new employee_salary;
      $salary->employeeID = $employee->id;
      $salary->created_by = Auth::user()->id;
      $salary->businessID = Auth::user()->businessID;
      $salary->save();

      //recorded activity
      $activities = Auth::user()->name.' Has added an '.$employee->names.' employee';
      $section = 'Employee';
      $type = 'Add';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
      $activityID = $employee->id;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Employee has been successfully added');

      return redirect()->route('hrm.employee.index');
   }

   /**
 * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($id){
      $employee = employees::join('business','business.id','=','hr_employees.businessID')
                     ->join('hr_employee_bank_info','hr_employee_bank_info.employeeID','=','hr_employees.id')
                     ->join('hr_employee_personal_info','hr_employee_personal_info.employeeID','=','hr_employees.id')
                     ->where('hr_employees.businessID',Auth::user()->businessID)
                     ->where('hr_employees.id',$id)
                     ->select('*','hr_employees.id as employeeID','hr_employees.names as employee_name','business.businessID as businessCode')
                     ->first();

      return view('app.hr.employee.show', compact('employee'));
   }

   /**
 * Show the form for editing the specified resource.
   * 
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id){
      $employee = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->select('*')->first();
      $departments = department::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose Department','');
      $branches = branches::where('businessID',Auth::user()->businessID)->pluck('branch_name','id')->prepend('Choose department','');
      $positions = positions::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose Job title','');

      //get leaders
      $employees = employees::where('businessID',Auth::user()->businessID)
                  ->where('statusID',25)
                  ->get();

      $joinReport = array();
      foreach ($employees as $joint) {
         $joinReport[$joint->id] = $joint->names;
      }

      //join report table
      $getLeaders = report::join('hr_employees','hr_employees.id', '=' ,'hr_employee_report_to.leaderID')
                  ->where('hr_employee_report_to.employeeID',$id)
                  ->select('hr_employees.id as reportID')
                  ->get();
      $jointLeaders = array();
      foreach($getLeaders as $gl){
         $jointLeaders[] = $gl->reportID;
      }

      //get departments
      $department = department::where('businessID',Auth::user()->businessID)->get();
      $departments = department::where('businessID',Auth::user()->businessID)
                     ->pluck('title','id')
                     ->prepend('choose department','');

      $joinDepartments = array();
      foreach ($department as $dept) {
         $joinDepartments[$dept->id] = $dept->title;
      }

      //join department head
      $getHeads = head::join('hr_departments','hr_departments.id', '=' ,'hr_employee_department_head.departmentID')
                  ->where('employeeID',$id)
                  ->select('hr_departments.id as departmentsID')
                  ->get();

      $jointHeads = array();
      foreach($getHeads as $gh){
         $jointHeads[] = $gh->departmentsID;
      }

      return view('app.hr.employee.edit', compact('employee','departments','positions','employees','branches','joinReport','jointLeaders','jointHeads','joinDepartments'));
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

      $this->validate($request, array(
         'names'=>'required',
      ));

      $update = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $update->names = $request->names;
      $update->gender = $request->gender;
      $update->leave_days = $request->leave_days;
      $update->company_email = $request->company_email;
      $update->employment_status = $request->employment_status;
      $update->department = $request->department;
      $update->position = $request->position;
      $update->companyID = $request->companyID;
      $update->branch = $request->branch;
      $update->company_phone_number = $request->company_phone_number;
      $update->office_phone_extension = $request->office_phone_extension;
      $update->source_of_hire = $request->source_of_hire;
      $update->contract_type = $request->contract_type;
      $update->hire_date = $request->hire_date;
      $update->statusID = $request->statusID;
      $update->temporary_exist_date = $request->temporary_exist_date;
      $update->termination_date = $request->termination_date;
      if($update->employeeID == ""){
         $update->employeeID = Helper::generateRandomString(12);
      }      
      $update->updated_by = Auth::user()->id;
      $update->businessID = Auth::user()->businessID;

      if(!empty($request->image)){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/hr/employee/images/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
               mkdir($directory, 0777,true);
         }

         //delete estimate if already exists
         if($update->image != ""){
               $delete = $directory.$update->image;
               if (File::exists($delete)) {
               unlink($delete);
               }
         }

         //update estimate to system
         $file = $request->image;

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE update WITH RANDOM NUMBER
         $fileName = Helper::seoUrl($request->names).'-'.Helper::generateRandomString(4). '.' . $extension;

         // MOVE THE updateED FILES TO THE DESTINATION DIRECTORY
         $update_success = $file->move($directory, $fileName);

         $update->image = $fileName;
      }
      $update->save();

      //report to
      $report = count(collect($request->report_to));
      if($report > 0){

         report::where('businessID',Auth::user()->businessID)->where('employeeID',$id)->delete();

         //upload new category
         for($i=0; $i < count($request->report_to); $i++ ) {
            $rep = new report;
            $rep->employeeID = $id;
            $rep->leaderID = $request->report_to[$i];
            $rep->businessID = Auth::user()->businessID;
            $rep->userID = Auth::user()->id;
            $rep->save();
         }
      }

      $department = count(collect($request->lead_department));
            if($department > 0){

            head::where('businessID',Auth::user()->businessID)->where('employeeID',$id)->delete();
            //upload new category
            for($i=0; $i < count($request->lead_department); $i++ ) {
               $leaders = new head;
               $leaders->employeeID = $id;
               $leaders->departmentID = $request->lead_department[$i];
               $leaders->businessID = Auth::user()->businessID;
               $leaders->userID = Auth::user()->id;
               $leaders->save();
            }
      }

      //recorded activity
      $activities = Auth::user()->name.' Has updated '.$request->names.' information';
      $section = 'Employee';
      $type = 'Update';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
         $activityID = $id;

         Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Employee has been updated');

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
      //
   }
}
