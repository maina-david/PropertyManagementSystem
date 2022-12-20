<?php

namespace App\Http\Controllers\app\documents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class documentsController extends Controller
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
  public function documents()
  {
   return view('app.documents.sections.documents');
  }
}
