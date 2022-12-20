<?php

namespace App\Http\Controllers\app\crm\deals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\hr\employees;
use App\Models\crm\leads\event;
use App\Mail\sendMessage;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\deals;
use App\Models\crm\deals\appointments;
use Mail;
use Session;
use Auth;
use Wingu;
use Crm;

class appointmentsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}
   
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($id)
   {
      $deal = deals::join('business','business.id','=','deals.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->where('deals.id',$id)
                     ->where('deals.businessID',Auth::user()->businessID)
                     ->orderby('deals.id','desc')
                     ->select('*','deals.id as dealID','deals.created_at as create_date')                     
                     ->first();

      $stages = stages::where('pipelineID',$deal->pipeline)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->get();
      $appointments = appointments::where('dealID',$id)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $employees = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose employee','');

      return view('app.crm.deals.deal.show', compact('deal','employees','stages','appointments','employees'));
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
   //
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request,[
         'title' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'owner' => 'required',
         'start_date' => 'required',
         'start_time' => 'required',
         'dealID' => 'required',
      ]);

      $event = new appointments;
      $event->title = $request->title;
      $event->priority = $request->priority;
      $event->status = $request->status;
      $event->owner = $request->owner;
      $event->start_date = $request->start_date;
      $event->start_time = $request->start_time;
      $event->end_date = $request->end_date;
      $event->end_time = $request->end_time;
      $event->description = $request->description;
      $event->created_by = Auth::user()->id;
      $event->dealID = $request->dealID;
      $event->businessID = Auth::user()->businessID;
      $event->save();

      if ($request->send_invitation == 'yes') {
         //send invitation
         $content = '<span style="font-size: 12pt;">Hello '.Crm::lead($request->dealID)->lead_name.'</span><br/><br/>
         This is a meeting invitation with '.Wingu::business(Auth::user()->businessID)->name.', details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         What :&nbsp;<strong> '.$request->title.' </strong><br/>
         When :&nbsp;<strong> '.date("F m, Y", strtotime($request->start_date)).' @ '.$request->start_time.' </strong><br/>
         </strong><br/><br/></span>
         -------------------------------------------------';
         $subject = $request->title;
         $to = Crm::lead($request->dealID)->email;

         Mail::to($to)->send(new sendMessage($content,$subject));
      }


      Session::flash('success','Appointment successfully added');

      return redirect()->back();
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
   //
   }


   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
      $this->validate($request,[
         'title' => 'required',
         'priority' => 'required',
         'status' => 'required',
         'owner' => 'required',
         'start_date' => 'required',
         'start_time' => 'required',
         'dealID' => 'required',
      ]);

      $event = appointments::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $event->title = $request->title;
      $event->priority = $request->priority;
      $event->status = $request->status;
      $event->owner = $request->owner;
      $event->start_date = $request->start_date;
      $event->start_time = $request->start_time;
      $event->end_date = $request->end_date;
      $event->end_time = $request->end_time;
      $event->description = $request->description;
      $event->updated_by = Auth::user()->id;
      $event->dealID = $request->dealID;
      $event->businessID = Auth::user()->businessID;
      $event->save();

      if ($request->send_invitation == 'yes') {
         //send invitation
         $content = '<span style="font-size: 12pt;">Hello '.Crm::lead($request->dealID)->lead_name.'</span><br/><br/>
         This is a meeting invitation with '.Wingu::business(Auth::user()->businessID)->name.', details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         What :&nbsp;<strong> '.$request->title.' </strong><br/>
         When :&nbsp;<strong> '.date("F m, Y", strtotime($request->start_date)).' @ '.$request->start_time.' </strong><br/>
         </strong><br/><br/></span>
         -------------------------------------------------';
         $subject = $request->title;
         $to = Crm::lead($request->dealID)->email;

         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      Session::flash('success','Appointment successfully updated');

      return redirect()->back();

   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete($id)
   {
      appointments::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();

      Session::flash('success','Appointment successfully deleted');

      return redirect()->back();

   }
}
