<?php

namespace App\Http\Controllers\app\property\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\emails;
use App\Models\property\listings;
use Auth;
class inquiryController extends Controller
{
   //
   public function index(){
      $inquiries = emails::where('businessID',Auth::user()->businessID)->where('property_code','!=',NULL)->where('section','Property Inquiry')->orderby('id','desc')->get();      
      $count = 1;
      return view('app.property.marketing.inquiry.index', compact('inquiries','count'));
   }
}
