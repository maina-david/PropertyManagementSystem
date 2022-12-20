<?php

namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\payroll_allocations;
use App\Models\hr\employee_salary as salary;
use App\Models\hr\deductions;
use App\Models\limitless\business;
use Session;
use File;
use Auth;
use Input;
use Helper;
use Hr;

class deductionsController extends Controller
{

   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($id)
   {
      $deductions = deductions::where('businessID',Auth::user()->businessID)
                     ->orderby('id','desc')
                     ->pluck('title','id')
                     ->prepend('choose deduction','');
      $employee = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $allocations = payroll_allocations::join('hr_payroll_deductions','hr_payroll_deductions.id','=','hr_payroll_allocations.deductionID')
                     ->where('employeeID',$id)
                     ->where('hr_payroll_allocations.businessID',Auth::user()->businessID)
                     ->select('*','hr_payroll_allocations.id as deductID')
                     ->get();
      $count = 1;
      return view('app.hr.employee.deductions', compact('employee','deductions','allocations','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      //
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function allocate(Request $request)
   {
      $this->validate($request, [
         'deduction' => 'required',
         'type' => 'required',
         'employeeID' => 'required'
      ]);

      if($request->rate == "" && $request->amount == ""){
         Session::flash('error', 'You need to provide either the rate or amount');

         return redirect()->back();
      }

      if($request->rate != "" && $request->amount != ""){
         Session::flash('error', 'Please choose either rate or amount');

         return redirect()->back();
      }

      $employee = employees::join('hr_employee_salary','hr_employee_salary.employeeID','=','hr_employees.id')
                  ->where('hr_employees.businessID',Auth::user()->businessID)
                  ->where('hr_employees.id',$request->employeeID)
                  ->first();

      if($request->rate != ""){
         $amount = $employee->salary_amount * ($request->rate/100);
         $rate = $request->rate;
      }

      if($request->amount != ""){
         $rate = ($request->amount / $employee->salary_amount ) * 100;
         $amount = $request->amount;
      }

      $allocations = new payroll_allocations;
      $allocations->businessID = Auth::user()->businessID;
      $allocations->userID = Auth::user()->id;
      $allocations->employeeID = $request->employeeID;
      $allocations->deductionID = $request->deduction;
      $allocations->rate = $rate;
      $allocations->amount = $amount;
      $allocations->category = 'Deduction';
      $allocations->save();

      //update deductions
      $salary = salary::where('employeeID',$request->employeeID)->where('businessID',Auth::user()->businessID)->first();
      $salary->total_deductions = Hr::calculate_deduction($request->employeeID);
      $salary->save();

      Session::flash('success','Deduction successfully allocated');

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
      $delete = payroll_allocations::where('businessID',Auth::user()->businessID)->where('Deduction')->where('id',$id)->first();

      //update deductions
      $salary = salary::where('employeeID',$delete->employeeID)->where('businessID',Auth::user()->businessID)->first();
      $salary->total_deductions = $salary->total_deductions - $delete->amount;
      $salary->save();

      $delete->delete();

      Session::flash('success','Deduction successfully deleted');

      return redirect()->back();
   }
}
