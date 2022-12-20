<?php

namespace App\Http\Controllers\app\finance\report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class reportsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function dashboard(){
      return view('app.finance.reports.dashboard');
   }

   
}
