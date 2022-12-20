<?php

namespace App\Http\Controllers\app\cms\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Wingu;
class dashboardController extends Controller
{
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
      
      return redirect()->route('cms.groups.index');
   }
}
