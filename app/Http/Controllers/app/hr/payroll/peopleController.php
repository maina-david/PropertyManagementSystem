<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\employee_bank_info as bank;
use App\Models\hr\employee_salary as salary;
use App\Models\finance\payments\payment_type;
use Auth;
use Session;

class peopleController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      $employees = employees::join('hr_employee_salary','hr_employee_salary.employeeID','=','hr_employees.id')
                  ->join('business','business.id','=','hr_employees.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->where('hr_employees.businessID',Auth::user()->businessID)
                  ->where('hr_employees.statusID',25)
                  ->orderby('hr_employees.id','desc')
                  ->select('*','hr_employees.id as empID')
                  ->get();
      $count = 1;

      return view('app.hr.payroll.people.index', compact('employees','count'));
   }

   public function show($id){
      $details = employees::join('hr_employee_bank_info','hr_employee_bank_info.employeeID','=','hr_employees.id')
                  ->join('hr_employee_salary','hr_employee_salary.employeeID','=','hr_employees.id')
                  ->where('hr_employees.id',$id)
                  ->select('*','hr_employees.id as empID')
                  ->first();
      $payments = payment_type::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $mainPaymentType = payment_type::where('businessID',0)->orderby('id','desc')->get();
      return view('app.hr.payroll.people.show', compact('details','payments','mainPaymentType'));
   }

   public function update(Request $request,$id){

      //bank info
      $bank = bank::Where('employeeID',$id)->where('businessID',Auth::user()->businessID)->first();
      $bank->account_number = $request->account_number;
      $bank->bank_name = $request->bank_name;
      $bank->bank_branch = $request->bank_branch;
      $bank->save();

      //salary
      $salary = salary::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->first();
      $salary->payment_method = $request->payment_method;
      $salary->salary_amount = $request->salary_amount;
      $salary->mpesa_number = $request->mpesa_number;
      $salary->payment_basis = $request->payment_basis;
      $salary->save();

      Session::flash('success','Payroll payment information successfully updated');

      return redirect()->back();
   }
}
