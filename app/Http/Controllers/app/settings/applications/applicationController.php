<?php

namespace App\Http\Controllers\app\settings\applications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business_modules;
use App\Models\wingu\modules;
use Stevebauman\Location\Facades\Location;
use Auth;
use Session;
class applicationController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Get all account applications
   **/
   public function index(){
      $applications = modules::join('business_modules','business_modules.moduleID','=','modules.id')
                              ->where('business_modules.module_status','!=',22)
                              ->where('business_modules.businessID',Auth::user()->businessID)
                              ->select('*','modules.id as moduleID','business_modules.id as business_module_id')
                              ->get();

      return view('app.settings.applications.index', compact('applications'));
   }

   /**
   * delete application from account 
   **/
   public function delete($id){
      $module = business_modules::where('businessID',Auth::user()->businessID)->where('moduleID',$id)->first();
      $module->module_status = 22;
      $module->updated_by = Auth::user()->id;
      $module->save();

      Session::flash('success','Application successfully removed');
      
      return redirect()->back();
   }

   /**
   * application billing
   **/
   public function billing($applicationID){
      $days = 31;
      $invoiceDate = date('Y-m-d');
      $invoiceDue = date('Y-m-d', strtotime($invoiceDate. ' + '.$days.' days'));

      $module = business_modules::join('modules','modules.id','=','business_modules.moduleID')
                                 ->where('businessID',Auth::user()->businessID)
                                 ->where('business_modules.id',$applicationID)
                                 ->where('payment_status',2)
                                 ->where('module_status',15)
                                 ->select('*','business_modules.price as module_price','business_modules.id as business_module_id')
                                 ->first(); 
      $location = Location::get(request()->ip());

      $durations = date('F j, Y', strtotime($invoiceDate)).' - '.date('F j, Y', strtotime($invoiceDue));

      return view('app.settings.billing.payment', compact('module','durations','location'));      
   }
}
 