<?php

namespace App\Http\Controllers\app\property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr\employees;
use App\Models\hr\employee_personal_info;
use App\Models\hr\employee_bank_info;
use App\Models\hr\employee_primary_info;
use App\Models\hr\employee_secondary_info;
use App\Models\hr\employee_salary;
use Session;
use Auth;
use Wingu;
use Helper;

class agentsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Agents List 
   */ 
   public function index(){
      $agents = employees::join('hr_employee_personal_info','hr_employee_personal_info.employeeID','=','hr_employees.id')
                        ->where('hr_employees.businessID',Auth::user()->businessID)
                        ->select('*','hr_employees.id as agentID')
                        ->orderby('hr_employees.id','desc')
                        ->get();
      $count = 1;
      return view('app.property.agents.index', compact('agents','count'));
   }

   /**
   * Create agent form 
   */ 
   public function create(){
      return view('app.property.agents.create');
   }

   /**
   * Store agent 
   */ 
   public function store(Request $request){
      $this->validate($request, array(
         'names'=>'required',
         'gender'=>'required',
         'email'=>'required',
         'phone_number'=>'required',
      ));

      //check if company_email already taken
      if($request->email != ""){
         $check = employee_personal_info::where('businessID',Auth::user()->businessID)->where('personal_email',$request->email)->count();
         if($check > 0){
               Session::flash('error','The company email is already in use');
               return redirect()->back();
         }
      }

      $employee = new employees;
      $employee->names = $request->names;
      $employee->gender = $request->gender;
      $employee->contract_type = $request->contract_type;
      $employee->hire_date = $request->hire_date;
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

      //employee personal info  //
      $personalInfo = new employee_personal_info;
      $personalInfo->employeeID = $employee->id;
      $personalInfo->personal_email = $request->email;
      $personalInfo->personal_number = $request->phone_number;
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
      $section = 'Property';
      $type = 'Agents';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
      $activityID = $employee->id;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Agent has been successfully added');

      return redirect()->route('property.agents');
   }

   /**
   * edit agent 
   */ 
   public function edit($id){
      $edit = employees::join('hr_employee_personal_info','hr_employee_personal_info.employeeID','=','hr_employees.id')
                        ->where('hr_employees.id',$id)
                        ->where('hr_employees.businessID',Auth::user()->businessID)
                        ->select('*','hr_employees.id as agentID','hr_employee_personal_info.personal_email as email','hr_employee_personal_info.personal_number as phone_number')
                        ->first();

      return view('app.property.agents.edit', compact('edit'));
   }

   /**
   * update agent 
   */ 
   public function update(Request $request,$id){
      $this->validate($request, array(
         'names'=>'required',
         'gender'=>'required',
         'email'=>'required',
         'phone_number'=>'required',
      ));

      $employee = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $employee->names = $request->names;
      $employee->gender = $request->gender;
      $employee->contract_type = $request->contract_type;
      $employee->hire_date = $request->hire_date;
      $employee->updated_by = Auth::user()->id;
      $employee->businessID = Auth::user()->businessID;
      if(!empty($request->image)){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/hr/employee/images/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
               mkdir($directory, 0777,true);
         }

         //delete estimate if already exists
         if($employee->image != ""){
               $delete = $directory.$employee->image;
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
         $file->move($directory, $fileName);

         $employee->image = $fileName;
      }
      $employee->save();

      //employee personal info  
      $personalInfo = employee_personal_info::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->first();
      $personalInfo->employeeID = $employee->id;
      $personalInfo->personal_email = $request->email;
      $personalInfo->personal_number = $request->phone_number;
      $personalInfo->created_by = Auth::user()->id;
      $personalInfo->businessID = Auth::user()->businessID;
      $personalInfo->save();

      Session::flash('success','Agent has been successfully Updated');

      return redirect()->back();
   }

   /**
   * delete agent 
   */ 
   public function delete($id){
      Session::flash('success','Agent has been successfully deleted');

      return redirect()->back();
   }
}
