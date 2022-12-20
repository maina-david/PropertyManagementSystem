<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\payroll_settings;
use App\Models\hr\employees;
use App\Models\hr\mid_month_assignee as assignee;
use App\Models\hr\payroll_approver as approvers;
use Session;
use Auth;
use Hr;
class settingsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function payday(){
      $check = payroll_settings::where('businessID',Auth::user()->businessID)->count();
			if($check != 1){
			Hr::payroll_setting_setup();
      }

      //employees
      $employees = employees::where('businessID',Auth::user()->businessID)
                  ->where('statusID',25)
                  ->get();
      $joinemployee = array();
      foreach ($employees as $employee) {
         $joinemployee[$employee->id] = $employee->names;
      }

      //join employees
      $getjoint = assignee::join('hr_employees','hr_employees.id','=','hr_mid_month_assignee.employeeID')
                  ->where('hr_mid_month_assignee.businessID',Auth::user()->businessID)
                  ->select('hr_mid_month_assignee.employeeID as assignID')
                  ->get();

      $jointAssigned = array();
      foreach($getjoint as $ej){
         $jointAssigned[] = $ej->assignID; 
      }
      

      $settings = payroll_settings::where('businessID',Auth::user()->businessID)->first();
      
      return view('app.hr.payroll.settings.index', compact('settings','joinemployee','jointAssigned'));
   }

   public function update(Request $request){
   
      $settings = payroll_settings::where('businessID',Auth::user()->businessID)->first();
      $settings->pay_period = $request->pay_period;
      $settings->monthly_payday = $request->monthly_payday;
      $settings->enable_mid_month_pay = $request->enable_mid_month_pay;
      $settings->mid_month_payday = $request->mid_month_payday;
      $settings->mid_month_rate_type = $request->mid_month_rate_type;
      if($request->mid_month_rate_percentage != ""){
         $settings->mid_month_rate = $request->mid_month_rate_percentage;
      }
      if($request->mid_month_rate_amount != ""){
         $settings->mid_month_rate = $request->mid_month_rate_amount;
      }
      $settings->compute_statutory = $request->compute_statutory;
      $settings->assignee = $request->assignee;
      $settings->save();   

      //assign monthly payment employees
      if($request->assignee == 'Specified'){
         //delete all first
         $delete = assignee::where('businessID',Auth::user()->businessID)->delete();

         $assignees = count(collect($request->employee));
         if($assignees > 0){
            if(isset($_POST['employee'])){
               for($i=0; $i < count($request->employee); $i++ ) {
                  $assignee = new assignee;
                  $assignee->employeeID = $request->employee[$i];
                  $assignee->businessID = Auth::user()->businessID;
                  $assignee->userID = Auth::user()->id;
                  $assignee->save();
               }
            }
         }
      }

      Session::flash('success','Payroll settings updated successfully');

      Return redirect()->back();
   }

   public function approval(){
      //check if account has settings
      $checkSettings = payroll_settings::where('businessID',Auth::user()->businessID)->count();
      if($checkSettings != 1){
         $newSettings = new payroll_settings;
         $newSettings->businessID = Auth::user()->businessID;
         $newSettings->save();
      }
      //employees 
      $employees = employees::where('businessID',Auth::user()->businessID)
                  ->where('statusID',25)
                  ->get();

      $joinemployee = array();
      foreach ($employees as $employee) {
         $joinemployee[$employee->id] = $employee->names;
      }

      //join employees
      $getjoint = approvers::join('hr_employees','hr_employees.id','=','hr_payroll_approvers.employeeID')
            ->where('hr_payroll_approvers.businessID',Auth::user()->businessID)
            ->select('hr_payroll_approvers.employeeID as assignID')
            ->get();

      $jointApprovers = array();
      foreach($getjoint as $ej){
         $jointApprovers[] = $ej->assignID; 
      }

      $settings = payroll_settings::where('businessID',Auth::user()->businessID)->first();

      return view('app.hr.payroll.settings.index', compact('settings','joinemployee','jointApprovers'));
   }

   public function approval_update(Request $request){
      $settings = payroll_settings::where('businessID',Auth::user()->businessID)->first();
      $settings->payroll_approval = $request->payroll_approval;
      $settings->save();

      if($request->payroll_approval == 'Yes') {
         //delete all first
         $delete = approvers::where('businessID',Auth::user()->businessID)->delete();

         $approvers = count(collect($request->employee));
         if($approvers > 0){
            if(isset($_POST['employee'])){
               for($i=0; $i < count($request->employee); $i++ ) {
                  $approver = new approvers;
                  $approver->employeeID = $request->employee[$i];
                  $approver->businessID = Auth::user()->businessID;
                  $approver->userID = Auth::user()->id;
                  $approver->save();
               }
            }
         }
      }

      Session::flash('success','Payroll settings successfully updated');

      return redirect()->back();
   }
}
