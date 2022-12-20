<?php

namespace App\Http\Controllers\app\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business_modules;
use App\Models\hr\branches;
use Wingu;
use Auth;

class dashboardController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
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

      //check expired applications
      $today =  date('Y-m-d');
      $checkApplications = business_modules::where('end_date','<', $today)->where('businessID',Auth::user()->businessID)->where('module_status',15)->where('payment_status',1)->count();
      if($checkApplications > 0){
         $applications = business_modules::where('end_date','<', $today)->where('businessID',Auth::user()->businessID)->where('module_status',15)->where('payment_status',1)->get();
         foreach($applications as $updated){
            $change = business_modules::where('id',$updated->id)
                                       ->where('end_date','<', $today)
                                       ->where('businessID',Auth::user()->businessID)
                                       ->where('module_status',15)
                                       ->where('payment_status',1)
                                       ->first();
            $change->payment_status = 2;
            $change->version = 15;
            $change->save();
         }
      }

      //check if account has no branches
      $checkBranches = branches::where('businessID',Auth::user()->businessID)->count();
      if($checkBranches == 0){
         $branches = new branches;
         $branches->branch_name = 'Main branch';
         $branches->main_branch = 'Yes';
         $branches->businessID = Auth::user()->businessID;
         $branches->userID = Auth::user()->id;
         $branches->save();
      }  
          
      return view('app.dashboard.dashboard');
   }
}
