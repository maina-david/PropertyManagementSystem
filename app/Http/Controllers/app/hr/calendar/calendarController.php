<?php

namespace App\Http\Controllers\app\hr\calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class calendarController extends Controller
{
   public function index(){
      return view('app.hr.calendar.index');
   }
}
