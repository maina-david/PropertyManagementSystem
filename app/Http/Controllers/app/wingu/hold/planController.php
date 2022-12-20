<?php

namespace App\Http\Controllers\app\wingu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class planController extends Controller
{
   // public function __construct(){
   //    $this->middleware('auth');
   // }
   
   public function plans(){
      return view('app.plan.plans');
   }

   public function payment(){
      return view('app.plan.payment');
   }
}
