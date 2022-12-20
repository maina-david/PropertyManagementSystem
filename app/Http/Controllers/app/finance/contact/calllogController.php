<?php
namespace App\Http\Controllers\app\finance\contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\customer\calllogs;
use App\Models\wingu\country;
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

      $logs = calllogs::where('businessID',Auth::user()->businessID)->where('customerID',$id)->orderby('id','desc')->paginate(4); 
      $status = status::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose status', '');

      return view('app.finance.contacts.view', compact('client','customerID','logs','status','contacts'));
   }


   /**
   * store call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){

      $this->validate($request,[
         'note' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'customerID' => 'required',
      ]);

      $calllog = new calllogs;
      $calllog->subject = $request->subject;
      $calllog->note = $request->note;
      $calllog->customerID = $request->customerID;
      $calllog->phone_number = $request->phone_number;
      $calllog->contact_person = $request->contact_person;
      $calllog->hours = $request->hours;
      $calllog->minutes = $request->minutes;
      $calllog->seconds = $request->seconds;
      $calllog->call_type = $request->call_type;
      $calllog->statusID = $request->statusID;
      $calllog->created_by = Auth::user()->id;
      $calllog->businessID = Auth::user()->businessID;
      $calllog->save();

      Session::flash('success','call log successfully added');

      return redirect()->back();
   }


   /**
   * update call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id){

      $this->validate($request,[
         'note' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'customerID' => 'required',
      ]);

      $calllog = calllogs::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $calllog->subject = $request->subject;
      $calllog->note = $request->note;
      $calllog->customerID = $request->customerID;
      $calllog->phone_number = $request->phone_number;
      $calllog->contact_person = $request->contact_person;
      $calllog->hours = $request->hours;
      $calllog->minutes = $request->minutes;
      $calllog->seconds = $request->seconds;
      $calllog->call_type = $request->call_type;
      $calllog->statusID = $request->statusID;
      $calllog->updated_by = Auth::user()->id;
      $calllog->businessID = Auth::user()->businessID;
      $calllog->save();

      Session::flash('success','call log successfully updated');

      return redirect()->back();
   }

   public function delete($id){
      calllogs::where('businessID',Auth::user()->businessID)->where('id',$id)->delete();

      Session::flash('success','call log is successfully delete');

      return redirect()->back();
   }
}
