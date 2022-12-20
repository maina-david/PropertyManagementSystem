<?php

namespace App\Http\Controllers\app\hr\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employees;
use App\Models\hr\leaves;
use App\Models\hr\type;
use App\Charts\LeaveReport;  
use Wingu;
use Auth;
use DB;
class dashboardController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function dashboard()
   {
      //check if account has modules
      if(Wingu::check_if_account_has_modules() == 0){
         return redirect()->route('application.setup');
      }
      
      $year = date('Y');

      $employees = employees::where('businessID',Auth::user()->businessID)->count();
      $activeEmployees = employees::where('businessID',Auth::user()->businessID)->where('statusID',25)->count();
      $leaveRequests = leaves::where('businessID',Auth::user()->businessID)->count();

      /*
      * leave report
      * */
      $leaveReport = new LeaveReport;

      $types = type::where('businessID',Auth::user()->businessID)->pluck('name');
      $approved =  DB::table('hr_leave')
                        ->whereYear('end_date','=', $year)
                        ->where('statusID',19)
                        ->select(DB::raw('count(*) as total'))
                        ->where('businessID',Auth::user()->businessID)
                        ->groupBy('leave_type')
                        ->pluck('total');  
      
      $denied =  DB::table('hr_leave')
                        ->whereYear('end_date','=', $year)
                        ->where('statusID',20)
                        ->select(DB::raw('count(*) as total'))
                        ->where('businessID',Auth::user()->businessID)
                        ->groupBy('leave_type')
                        ->pluck('total');  

      $pending =  DB::table('hr_leave')
                        ->whereYear('end_date','=', $year)
                        ->where('statusID',7)
                        ->select(DB::raw('count(*) as total'))
                        ->where('businessID',Auth::user()->businessID)
                        ->groupBy('leave_type')
                        ->pluck('total');  

      $leaveReport->labels($types->values());
      $leaveReport->dataset('Denied', 'bar', $denied->values())->backgroundColor('rgba(221,5,5,0.4)');
      $leaveReport->dataset('Approved', 'bar', $approved->values())->backgroundColor('rgba(17,147,30,0.4)'); 
      $leaveReport->dataset('Pending', 'bar', $pending->values())->backgroundColor('rgba(40,95,255,0.4)');

      return view('app.hr.dashboard.dashboard',compact('employees','activeEmployees','leaveRequests','leaveReport'));     
   } 
}
