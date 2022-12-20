<?php
namespace App\Http\Controllers\app\crm\dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\crm\deals\appointments;
use App\Models\crm\deals\deals;
use App\Charts\dealReport; 
use Auth;
use DB;
use Wingu;
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
      
      $month = date('m');
      $year = date('Y');

      $leads = customers::where('businessID',Auth::user()->businessID)->whereMonth('created_at', '=', $month)->where('category','Lead')->count();
      $dealsCount = deals::where('businessID',Auth::user()->businessID)->orderby('id','desc')->whereMonth('created_at', '=', $month)->count();
      $won = deals::where('status',45)->whereMonth('created_at', '=', $month)->count();
      $lost = deals::where('status',46)->whereMonth('created_at', '=', $month)->count();

      $appointments = appointments::whereMonth('start_date',$month)
                                    ->where('businessID',Auth::user()->businessID)
                                    ->orderby('id','desc')
                                    ->get();

      // deal report
      $dealReport = new dealReport;

      //   $types = type::where('businessID',Auth::user()->businessID)->pluck('name');
      //   $approved =  DB::table('hr_leave')
      //                     ->whereYear('end_date','=', $year)
      //                     ->where('statusID',19)
      //                     ->select(DB::raw('count(*) as total'))
      //                     ->where('businessID',Auth::user()->businessID)
      //                     ->groupBy('leave_type')
      //                     ->pluck('total');  
        
      //   $denied =  DB::table('hr_leave')
      //                     ->whereYear('end_date','=', $year)
      //                     ->where('statusID',20)
      //                     ->select(DB::raw('count(*) as total'))
      //                     ->where('businessID',Auth::user()->businessID)
      //                     ->groupBy('leave_type')
      //                     ->pluck('total');  

      //   $pending =  DB::table('hr_leave')
      //                     ->whereYear('end_date','=', $year)
      //                     ->where('statusID',7)
      //                     ->select(DB::raw('count(*) as total'))
      //                     ->where('businessID',Auth::user()->businessID)
      //                     ->groupBy('leave_type')
      //                     ->pluck('total');  

      //   $leaveReport->labels($types->values());
      //   $leaveReport->dataset('Denied', 'bar', $denied->values())->backgroundColor('rgba(221,5,5,0.4)');
      //   $leaveReport->dataset('Approved', 'bar', $approved->values())->backgroundColor('rgba(17,147,30,0.4)'); 
      //   $leaveReport->dataset('Pending', 'bar', $pending->values())->backgroundColor('rgba(40,95,255,0.4)');


      $month  = deals::where('businessID',Auth::user()->businessID)
                        ->whereYear('created_at', '=', $year)
                        ->groupby(DB::raw('MONTH(created_at)'))
                        ->select(DB::raw('month(created_at) as month'))
                        ->selectRaw("DATE_FORMAT(created_at, '%M') AS month")
                        ->pluck('month');

      $lostValue =  DB::table('deals')
                        ->whereYear('created_at','=', $year)
                        ->where('status',46)
                        ->select(DB::raw('SUM(value) as value'))
                        ->where('businessID',Auth::user()->businessID)
                        ->groupBy('status')
                        ->pluck('value'); 

      $wonValue =  DB::table('deals')
                        ->whereYear('created_at','=', $year)
                        ->where('status',45)
                        ->select(DB::raw('SUM(value) as value'))
                        ->where('businessID',Auth::user()->businessID)
                        ->groupBy('status')
                        ->pluck('value'); 

      $openValue =  DB::table('deals')
                        ->whereYear('created_at','=', $year)
                        ->whereNull('status')
                        ->select(DB::raw('SUM(value) as value'))
                        ->where('businessID',Auth::user()->businessID)
                        ->groupBy('status')
                        ->pluck('value'); 
                        
      $dealReport->labels($month->values());
      $dealReport->dataset('Lost', 'bar', $lostValue->values())->backgroundColor('rgba(24,49,83,0.4)');
      $dealReport->dataset('Won', 'bar', $wonValue->values())->backgroundColor('rgba(4,151,50,0.4)');
      $dealReport->dataset('Open', 'bar', $openValue->values())->backgroundColor('rgba(255,34,177,0.4)');


      return view('app.crm.dashboard.dashboard', compact('leads','dealsCount','won','lost','appointments','dealReport'));
   }
}
