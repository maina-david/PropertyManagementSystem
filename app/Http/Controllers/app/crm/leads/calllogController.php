<?php

namespace App\Http\Controllers\app\crm\leads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\calllogs;
use App\Models\finance\customer\customers;
use App\Models\crm\leads\status;
use Auth; 
use Session;


class calllogController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}
    

    /**
   * calllog
   *
   * @return \Illuminate\Http\Response
   */
   public function calllog($id){
      $logs = calllogs::where('businessID',Auth::user()->businessID)->where('customerID',$id)->orderby('id','desc')->get(); 
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$id)->where('category','Lead')->first();
      $status = status::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose status', '');
      $customerID = $id;

      return view('app.crm.leads.show', compact('lead','customerID','logs','status'));
   }


   /**
   * store call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function store_calllog(Request $request){

      $this->validate($request,[
         'note' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'customerID' => 'required',
      ]);

      $note = new calllogs;
      $note->subject = $request->subject;
      $note->note = $request->note;
      $note->customerID = $request->customerID;
      $note->phone_number = $request->phone_number;
      $note->contact_person = $request->contact_person;
      $note->hours = $request->hours;
      $note->minutes = $request->minutes;
      $note->seconds = $request->seconds;
      $note->call_type = $request->call_type;
      $note->statusID = $request->statusID;
      $note->created_by = Auth::user()->id;
      $note->businessID = Auth::user()->businessID;
      $note->save();

      Session::flash('success','Note successfully added');

      return redirect()->back();
   }


   /**
   * update call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function update_calllog(Request $request, $id){

      $this->validate($request,[
         'note' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'customerID' => 'required',
      ]);

      $note = calllogs::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $note->subject = $request->subject;
      $note->note = $request->note;
      $note->customerID = $request->customerID;
      $note->phone_number = $request->phone_number;
      $note->contact_person = $request->contact_person;
      $note->hours = $request->hours;
      $note->minutes = $request->minutes;
      $note->seconds = $request->seconds;
      $note->call_type = $request->call_type;
      $note->statusID = $request->statusID;
      $note->updated_by = Auth::user()->id;
      $note->businessID = Auth::user()->businessID;
      $note->save();

      Session::flash('success','Note successfully updated');

      return redirect()->back();
   }

   public function delete($id){
      calllogs::where('businessID',Auth::user()->businessID)->where('id',$id)->delete();

      Session::flash('success','call log is successfully delete');

      return redirect()->back();
   }

}
 