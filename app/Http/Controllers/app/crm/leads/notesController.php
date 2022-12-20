<?php
 
namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\notes;
use App\Models\wingu\country;
use App\Models\crm\leads\status;
use Auth; 
use Session;

class notesController extends Controller
{
   public function __construct(){ 
      $this->middleware('auth');
   }
   
  


   /**
   * view note
   *
   * @return \Illuminate\Http\Response
   */
   public function notes($id){
      $notes = notes::where('businessID',Auth::user()->businessID)->where('customerID',$id)->orderby('id','desc')->get();
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$id)->where('category','Lead')->first();
      $phoneCode = country::pluck('phonecode','id')->prepend('Choose phone code', '');
      $status = status::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose status', '');
      $customerID = $id;

      return view('app.crm.leads.show', compact('lead','customerID','notes','phoneCode','status'));
   }

   /**
   * store note
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){
      $this->validate($request,[
         'subject' => 'required',
         'note' => 'required',
         'customerID' => 'required',
      ]);

      $note = new notes;
      $note->subject = $request->subject;
      $note->note = $request->note;
      $note->customerID = $request->customerID;
      $note->created_by = Auth::user()->id;
      $note->businessID = Auth::user()->businessID;
      $note->save();

      Session::flash('success','Note successfully added');

      return redirect()->back();
   }

   /**
   * update note
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id){
      $this->validate($request,[
         'note' => 'required',
         'customerID' => 'required',
      ]);

      $note = notes::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $note->subject = $request->subject;
      $note->note = $request->note;
      $note->customerID = $request->customerID;
      $note->updated_by = Auth::user()->id;
      $note->businessID = Auth::user()->businessID;
      $note->save();

      Session::flash('success','Note successfully updated');

      return redirect()->back();
   }

   /**
   * delete note
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($id){
      notes::where('businessID',Auth::user()->businessID)->where('id',$id)->delete();
      Session::flash('success','Note successfully deleted');
      return redirect()->back();
   }


   


   
}
