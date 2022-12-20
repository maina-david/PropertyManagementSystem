<?php
namespace App\Http\Controllers\app\finance\contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\customer\notes;
use App\Models\crm\leads\status;
use Auth; 
use Session;

class notesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   

   /**
   * notes
   *
   * @return \Illuminate\Http\Response
   */
   public function index($id){
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

      $notes = notes::where('businessID',Auth::user()->businessID)->where('customerID',$id)->orderby('id','desc')->paginate(6);

      $status = status::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose status', '');

      return view('app.finance.contacts.view', compact('client','customerID','notes','status','contacts'));
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
