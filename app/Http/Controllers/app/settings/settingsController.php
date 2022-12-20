<?php

namespace App\Http\Controllers\app\settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\languages;
use App\Models\wingu\setting;
use Session;
use Auth;
use Helper;

class settingsController extends Controller
{
   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $languages = languages::all();
      return view('app.settings.dashboard.dashboard')->withLanguages($languages);
   }
}
