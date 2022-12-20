<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\deals;
use App\Models\crm\calllog;
use App\Models\wingu\country;
use Auth;
use Session;

class calllogController extends Controller
{

   public function __construct(){
      $this->middleware('auth'); 
   }

   //index
   public function index($id){
      $deal = deals::join('business','business.id','=','deals.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->where('deals.id',$id)
                     ->where('deals.businessID',Auth::user()->businessID)
                     ->orderby('deals.id','desc')
                     ->select('*','deals.id as dealID','deals.created_at as create_date')                     
                     ->first();

      $stages = stages::where('pipelineID',$deal->pipeline)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->get();
      $phoneCode = country::pluck('phonecode','id')->prepend('Choose phone code', '');
      $calllogs = calllog::where('parentID',$id)->where('businessID',Auth::user()->businessID)->where('section','Deal')->orderby('id','desc')->get();

      return view('app.crm.deals.deal.show', compact('deal','stages','phoneCode','calllogs'));
   }

   /**
   * store call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request, $id){
      $this->validate($request,[
         'phone_code' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'hours' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'dealID' => 'required',
      ]);

      $calllogs = new calllog;
      $calllogs->subject = $request->subject;
      $calllogs->note = $request->note;
      $calllogs->parentID = $id;
      $calllogs->phone_code = $request->phone_code;
      $calllogs->phone_number = $request->phone_number;
      $calllogs->contact_person = $request->contact_person;
      $calllogs->hours = $request->hours;
      $calllogs->minutes = $request->minutes;
      $calllogs->seconds = $request->seconds;
      $calllogs->call_type = $request->call_type;
      $calllogs->created_by = Auth::user()->id;
      $calllogs->businessID = Auth::user()->businessID;
      $calllogs->section = 'Deal';
      $calllogs->save();

      Session::flash('success','Call successfully added');

      return redirect()->back();
   }


   /**
   * update call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id){

      $this->validate($request,[
         'phone_code' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'hours' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'dealID' => 'required',
      ]);

      $calllogs = calllog::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $calllogs->subject = $request->subject;
      $calllogs->note = $request->note;
      $calllogs->parentID = $request->dealID;
      $calllogs->phone_code = $request->phone_code;
      $calllogs->phone_number = $request->phone_number;
      $calllogs->contact_person = $request->contact_person;
      $calllogs->hours = $request->hours;
      $calllogs->minutes = $request->minutes;
      $calllogs->seconds = $request->seconds;
      $calllogs->call_type = $request->call_type;
      $calllogs->created_by = Auth::user()->id;
      $calllogs->businessID = Auth::user()->businessID;
      $calllogs->section = 'Deal';
      $calllogs->save();

      Session::flash('success','Call successfully updated');

      return redirect()->back();
   }

   /**
   * delete
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($id){
      calllog::where('businessID',Auth::user()->businessID)->where('section','Deal')->where('id',$id)->delete();
      Session::flash('success','Call successfully deleted');
      return redirect()->back();
   }

}
