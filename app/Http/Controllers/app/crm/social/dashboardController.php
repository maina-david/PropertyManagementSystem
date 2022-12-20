<?php

namespace App\Http\Controllers\app\crm\social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
   public function dashboard(){
      return view('app.crm.social.dashboard.dashboard');
   }
}
