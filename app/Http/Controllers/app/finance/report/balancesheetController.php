<?php

namespace App\Http\Controllers\app\finance\report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class balancesheetController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function index(){
      return view('app.finance.reports.balancesheet.index');
   }
}
