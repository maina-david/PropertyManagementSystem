<?php

namespace App\Http\Controllers\app\crm\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
   public function dashboard(){
      return view('app.crm.reports.dashboard');
   }
}
