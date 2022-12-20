<?php

namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_salary as salary;
use App\Models\hr\employees;
use App\Models\hr\employee_bank_info as bank;
use App\Models\hr\payroll_allocations;
use App\Models\finance\payments\payment_type;
use Session;
use Auth;
use Hr;

class salaryController extends Controller
{

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $employee = employees::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $edit = salary::join('hr_employee_bank_info','hr_employee_bank_info.employeeID','=','hr_employee_salary.employeeID')
                     ->where('hr_employee_salary.employeeID',$id)
                     ->where('hr_employee_salary.businessID',Auth::user()->businessID)
                     ->select('*','hr_employee_salary.id as salaryID')
                     ->first();
      $payments = payment_type::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $mainPaymentType = payment_type::where('businessID',0)->orderby('id','desc')->get();

      return view('app.hr.employee.salary', compact('edit','employee','payments','mainPaymentType'));

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
      $this->validate($request,[
         'payment_basis' => 'required',
         'salary_amount' => 'required',
      ]);

      //salary
      $salary = salary::where('id',$id)->where('employeeID',$request->employeeID)->where('businessID',Auth::user()->businessID)->first();
      if($request->salary_amount != $salary->salary_amount){
         //update allocated deduction
         $allocations = payroll_allocations::where('employeeID',$request->employeeID)
                        ->where('businessID',Auth::user()->businessID)
                        ->where('category','Deduction')
                        ->get();

         foreach($allocations as $allocaion){
            $allocateUpdate = payroll_allocations::where('employeeID',$request->employeeID)
                                 ->where('id',$allocaion->id)
                                 ->where('category','Deduction')
                                 ->where('businessID',Auth::user()->businessID)
                                 ->first();
                                 
            $amount = $request->salary_amount * ($allocateUpdate->rate/100);
            $allocateUpdate->amount = $amount;
            $allocateUpdate->save();
         }
      }
      $salary->payment_method = $request->payment_method;
      $salary->payment_basis = $request->payment_basis;
      $salary->salary_amount = $request->salary_amount;
      $salary->mpesa_number = $request->mpesa_number;
      $salary->updated_by = Auth::user()->businessID;
      $salary->save();

      //bank info
      $bank = bank::Where('employeeID',$request->employeeID)->where('businessID',Auth::user()->businessID)->first();
      $bank->account_number = $request->account_number;
      $bank->bank_name = $request->bank_name;
      $bank->bank_branch = $request->bank_branch;
      $bank->updated_by = Auth::user()->businessID;
      $bank->save();

      //update deductions
      $salary = salary::where('employeeID',$request->employeeID)->where('businessID',Auth::user()->businessID)->first();
      $salary->total_deductions = Hr::calculate_deduction($request->employeeID);
      $salary->save();

      Session::flash('success','Salary information successfully updated');

      return redirect()->back();
   }
}
