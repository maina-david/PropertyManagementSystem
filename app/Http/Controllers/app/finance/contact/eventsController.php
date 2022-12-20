<?php
namespace App\Http\Controllers\app\finance\contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\hr\employees;
use App\Models\finance\customer\events;
use App\Mail\sendMessage;
use Mail;
use Session;
use Auth;
use Wingu;
use Finance;
use Crm;

class eventsController extends Controller
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
      $customerID = $id;
      $client = customers::join('customer_address','customer_address.customerID','=','customers.id')
               ->join('business','business.id','=','customers.businessID')
               ->join('currency','currency.id','=','business.base_currency')
               ->where('customers.id',$id)
               ->where('customers.businessID',Auth::user()->businessID)
               ->select('*','customers.id as cid')
               ->first();

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

      $events = events::where('businessID', Auth::user()->businessID)->where('customerID',$id)->paginate(21);

      $employees = employees::where('businessID',Auth::user()->businessID)->pluck('names','id')->prepend('Choose employee');

      return view('app.finance.contacts.view', compact('client','customerID','employees','events','contacts'));
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
         'event_name' => 'required',
         'start_date' => 'required',
      ]);

      $event = new events;
      $event->event_name = $request->event_name;
      $event->priority = $request->priority;
      $event->status = $request->status;
      $event->owner = $request->owner;
      $event->start_date = $request->start_date;
      $event->start_time = $request->start_time;
      $event->end_date = $request->end_date;
      $event->end_time = $request->end_time;
      $event->description = $request->description;
      $event->created_by = Auth::user()->id;
      $event->customerID = $request->customerID;
      $event->businessID = Auth::user()->businessID;
      $event->save();

      if ($request->send_invitation == 'yes') {
         //send invitation
         $content = '<span style="font-size: 12pt;">Hello '.Finance::client($request->customerID)->customer_name.'</span><br/><br/>
         This is a meeting invitation with '.Wingu::business()->name.', details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         What :&nbsp;<strong> '.$request->event_name.' </strong><br/>
         When :&nbsp;<strong> '.date("F m, Y", strtotime($request->start_date)).' @ '.$request->start_time.' </strong><br/>
         </strong><br/><br/>
         -------------------------------------------------<br><br>'.$request->description;

         $subject = 'Meeting invitation - '.$request->event_name;
         $to = Finance::client($request->customerID)->email;

         Mail::to($to)->send(new sendMessage($content,$subject));

      }

      Session::flash('success','Event successfully added');

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
         'event_name' => 'required',
         'start_time' => 'required',
      ]);

      $event = events::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $event->event_name = $request->event_name;
      $event->priority = $request->priority;
      $event->status = $request->status;
      $event->owner = $request->owner;
      $event->start_date = $request->start_date;
      $event->start_time = $request->start_time;
      $event->end_date = $request->end_date;
      $event->end_time = $request->end_time;
      $event->description = $request->description;
      $event->updated_by = Auth::user()->id;
      $event->customerID = $request->customerID;
      $event->businessID = Auth::user()->businessID;
      $event->save();

      if ($request->send_invitation == 'yes') {
         //send invitation
         $content = '<span style="font-size: 12pt;">Hello '.Finance::client($request->customerID)->customer_name.'</span><br/><br/>
         This is a meeting invitation with '.Wingu::business()->name.', details below:<br/><br/>
         -------------------------------------------------
         <br/><br/>
         What :&nbsp;<strong> '.$request->event_name.' </strong><br/>
         When :&nbsp;<strong> '.date("F m, Y", strtotime($request->start_date)).' @ '.$request->start_time.' </strong><br/>
         </strong><br/></span>
         -------------------------------------------------<br><br>'.$request->description;
         $subject = 'Meeting invitation - '.$request->event_name;
         $to = Finance::client($request->customerID)->email;

         Mail::to($to)->send(new sendMessage($content,$subject));
      }

      Session::flash('success','Event successfully updated');

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
      $event = events::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $event->delete();

      Session::flash('success','Event successfully deleted');

      return redirect()->back();

   }
}
