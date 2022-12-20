<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_bank_info;
use Session;

class bankinformationController extends Controller
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
      $edit = employee_bank_info::where('hr_employee_bank_info.employee_id',$id)
               ->join('hr_emloyee_basic_info','hr_emloyee_basic_info.id','=','hr_employee_bank_info.employee_id')
               ->select('*','employee_id as empid')
               ->first();
      $employee = $id;
      return view('app.hr.employee.bank', compact('edit','employee'));
   }

   public function update(Request $request, $id){

   $bank_info = employee_bank_info::where('employee_id',$id)->first();

      $bank_info->account_number = $request->account_number;
      $bank_info->bank_name = $request->bank_name;
      $bank_info->bank_branch = $request->bank_branch;

      $bank_info->save();

      Session::flash('success','Bank information has been successfully updated');

      return redirect()->back();
   }
}
