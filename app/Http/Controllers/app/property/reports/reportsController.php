<?php

namespace App\Http\Controllers\app\property\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use Auth;

class reportsController extends Controller
{
   public function dashboard($id){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $propertyID = $id;
      
      return view('app.property.property.reports.dashboard', compact('property','propertyID'));
   }
}
