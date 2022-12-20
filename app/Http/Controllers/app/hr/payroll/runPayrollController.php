<?php

namespace App\Http\Controllers\app\hr\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\payroll;
use App\Models\hr\payroll_allocations;
use App\Models\hr\payroll_people;
use App\Models\hr\payroll_items;
use App\Models\hr\department;
use App\Models\hr\branches;
use Helper;
use Auth;
use Session;
use Wingu;
class runPayrollController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * payrolls
   **/
   public function index(){
      $payrolls = payroll::join('business','business.id','=','hr_payroll.businessID')
                        ->join('currency','currency.id','=','business.base_currency')
                        ->where('hr_payroll.businessID',Auth::user()->businessID)
                        ->select('payroll_code','symbol','payroll_date','total_net_pay','total_gross_pay','total_deductions')
                        ->orderby('hr_payroll.id','desc')
                        ->get();
      $count = 1;
      return view('app.hr.payroll.payroll.index', compact('payrolls','count'));
   }

   /**
   * Payroll process
   **/
   public function create(){
      $branches = branches::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();

      return view('app.hr.payroll.payroll.create', compact('branches'));
   }

   /**
   * submit Payroll process
   **/
   public function run(Request $request){
      $this->validate($request,[
         'branch' => 'required',
         'payroll_date' => 'required',
      ]);

      $checkPayroll = payroll::where('businessID',Auth::user()->businessID)->where('payroll_date','payroll_date')->where('payroll_type',$request->payroll_type)->count();
      if($checkPayroll != 0){
         Session::flash('warning','You already have a payroll processes with the same parameters that you have provided');

         return redirect()->back();
      }
      $branch = $request->branch;
      $type = $request->payroll_type;
      $payroll_date = $request->payroll_date;         
     
      return redirect()->route('hrm.payroll.process.review',[$payroll_date,$type,$branch]);
   }

   /**
   * review payroll information
   **/
   public function review($payroll_date,$type,$branch){
      if($branch == 'All') {
         $results = employees::join('hr_employee_personal_info','hr_employee_personal_info.employeeID','=','hr_employees.id')
                        ->join('hr_employee_salary','hr_employee_salary.employeeID','=','hr_employees.id')
                        ->join('business','business.id','=','hr_employees.businessID')
                        ->join('currency','currency.id','=','business.base_currency')
                        ->where('hr_employees.businessID',Auth::user()->businessID)
                        ->where('payment_basis',$type)
                        ->select('hr_employees.id as empID','symbol','hr_employees.names as employee_name','hr_employees.image as avator','business.businessID as business_code','salary_amount','total_additions','total_deductions','payment_basis')
                        ->orderby('hr_employees.id','desc')
                        ->get();
      }else{
         $results = employees::join('hr_employee_personal_info','hr_employee_personal_info.employeeID','=','hr_employees.id')
                        ->join('hr_employee_salary','hr_employee_salary.employeeID','=','hr_employees.id')
                        ->join('business','business.id','=','hr_employees.businessID')
                        ->join('currency','currency.id','=','business.base_currency')
                        ->where('hr_employees.businessID',Auth::user()->businessID)
                        ->where('hr_employees.branch',$branch)
                        ->where('payment_basis',$type)
                        ->select('hr_employees.id as empID','symbol','hr_employees.names as employee_name','hr_employees.image as avator','business.businessID as business_code','salary_amount','total_additions','total_deductions','payment_basis')
                        ->orderby('hr_employees.id','desc')
                        ->get();
      }

      $count = 1;

      return view('app.hr.payroll.payroll.review', compact('payroll_date','type','branch','count','results'));
   }

   /**
   * runpayroll
   **/
   public function process(Request $request){
      $this->validate($request,[
         'type' => 'required',
         'branch' => 'required',
         'payroll_date' => 'required',
      ]);

      $code = Helper::generateRandomString(12);
      //payroll
      $payroll = new payroll;
      $payroll->businessID = Auth::user()->businessID;
      $payroll->payroll_code = $code;
      $payroll->branch = $request->branch;
      $payroll->total_net_pay = $request->net_pay;
      $payroll->total_gross_pay = $request->gross_pay;
      $payroll->total_additions = $request->total_additions;
      $payroll->total_deductions = $request->total_deductions;
      $payroll->total_salary = $request->salary_amount;
      $payroll->payroll_date = $request->payroll_date;
      $payroll->payroll_type = $request->type;
      $payroll->created_by = Auth::user()->id;
      $payroll->save();

      //payroll people
      $peoples = $request->people_employeeID;

      foreach ($peoples as $i => $people){
         $people = new payroll_people();
         $people->payroll_id = $code;
         $people->employeeID = $request->people_employeeID[$i];
         $people->businessID = Auth::user()->businessID;
         $people->salary = $request->people_salary[$i];
         // $people->addition = $request->people_additions[$i];
         $people->gross_pay = $request->people_gross_pay[$i];
         $people->deduction = $request->people_deduction[$i];
         $people->net_pay = $request->people_net_pay[$i];
         $people->payment_type = $request->people_type[$i];
         $people->balance = $request->people_net_pay[$i];
         $people->created_by = Auth::user()->id; 
         $people->save();

         //payroll items
         //deduction
         $deductions = payroll_allocations::Join('hr_payroll_deductions','hr_payroll_deductions.id','=','hr_payroll_allocations.deductionID')
                                          ->where('hr_payroll_deductions.businessID',Auth::user()->businessID)
                                          ->where('category','Deduction')
                                          ->where('employeeID',$request->people_employeeID[$i])
                                          ->get();

         foreach($deductions as $deduc){
            $deduction = new payroll_items();
            $deduction->payroll_id = $code;
            $deduction->businessID = Auth::user()->businessID;
            $deduction->item = $deduc->title;
            $deduction->employeeID = $request->people_employeeID[$i];
            $deduction->amount = $deduc->amount;
            $deduction->item_category = 'Deduction';
            $deduction->created_by = Auth::user()->id;
            $deduction->save();
         }

         //additions
         $additions = payroll_allocations::Join('hr_payroll_benefits','hr_payroll_benefits.id','=','hr_payroll_allocations.benefitID')
                     ->where('hr_payroll_benefits.businessID',Auth::user()->businessID)
                     ->where('employeeID',$request->people_employeeID[$i])
                     ->where('category','Benefits')
                     ->get();

         foreach($additions as $add){
            $add = new payroll_items();
            $add->payroll_id = $code;
            $add->businessID = Auth::user()->businessID;
            $add->employeeID = $request->people_employeeID[$i];
            $add->item = $add->title;
            $add->amount = $add->amount;
            $add->item_category = 'Benefits';
            $add->created_by = Auth::user()->id;
            $add->save();
         }

      }

      return redirect()->route('hrm.payroll.index');
   }

   /**
   * payroll details
   **/
   public function payroll_details($code){
      $payroll = payroll::where('payroll_code',$code)->where('businessID',Auth::user()->businessID)->first();

      $payslips = payroll_people::join('hr_employees','hr_employees.id','=','hr_payroll_people.employeeID')
                  ->join('business','business.id','=','hr_employees.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->where('payroll_id',$code)
                  ->select('*','symbol','hr_employees.id as employeeID')
                  ->get();
      $count = 1;
      return view('app.hr.payroll.payroll.details', compact('payroll','count','payslips'));
   }

   /**
   * payroll payslips
   **/
   public function payslip($employeeID,$payroll_code){
      $currency = Wingu::currency();

      $person = payroll_people::join('hr_employees','hr_employees.id','=','hr_payroll_people.employeeID')
                           ->join('hr_employee_personal_info','hr_employee_personal_info.employeeID','=','hr_employees.id')
                           ->join('hr_payroll','hr_payroll.payroll_code','=','hr_payroll_people.payroll_id')
                           ->where('hr_employees.businessID',Auth::user()->businessID)
                           ->where('hr_payroll_people.payroll_id',$payroll_code)
                           ->where('hr_payroll_people.employeeID',$employeeID)
                           ->select('personal_number','names','payroll_date','balance','net_pay','salary','hr_payroll_people.id as payrollID','hr_payroll_people.payroll_id as payroll_code')
                           ->first();

      $check_deductions = payroll_items::where('payroll_id',$payroll_code)
               ->where('employeeID',$employeeID)
               ->where('item_category','Deduction')
               ->count();

      $deductions = payroll_items::where('payroll_id',$payroll_code)
               ->where('employeeID',$employeeID)
               ->where('item_category','Deduction')
               ->get();

      $check_benefits = payroll_items::where('payroll_id',$payroll_code)
                        ->where('employeeID',$employeeID)
                        ->where('item_category','Benefits')
                        ->count();

      $benefits = payroll_items::where('payroll_id',$payroll_code)
               ->where('employeeID',$employeeID)
               ->where('item_category','Benefits')
               ->get();

      return view('app.hr.payroll.payroll.payslip', compact('person','check_deductions','deductions','benefits','check_benefits','currency'));
   }

   /**
   * delete payslip
   **/
   public function payslip_delete($employeeID,$id){
      payroll_items::where('businessID',Auth::user()->businessID)->where('employeeID',$employeeID)->where('payroll_id',$id)->delete();
      payroll_people::where('businessID',Auth::user()->businessID)->where('employeeID',$employeeID)->where('payroll_id',$id)->delete();

      Session::flash('success','Payslip successfully deleted');

      return redirect()->back();
   }

   /**
   * delete payroll
   **/
   public function delete_payroll($id){
      payroll::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();
      payroll_items::where('businessID',Auth::user()->businessID)->where('payroll_id',$id)->delete();
      payroll_people::where('businessID',Auth::user()->businessID)->where('payroll_id',$id)->delete();

      Session::flash('success','Payroll successfully deleted');

      return redirect()->back();
   }
}
