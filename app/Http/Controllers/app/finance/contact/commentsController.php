<?php
namespace App\Http\Controllers\app\finance\contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\comments;
use App\Models\finance\customer\contact_persons;
use Session;
use Helper;
use Auth;

class commentsController extends Controller
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
               
      $comments = comments::where('businessID',Auth::user()->businessID)->where('customerID',$customerID)->orderby('id','desc')->get();
				
      return view('app.finance.contacts.view', compact('client','customerID','comments','contacts'));
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
      $this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
		$comment->comment = $request->comment;
		$comment->userID = Auth::user()->id;
		$comment->customerID = $request->customerID;
		$comment->businessID = Auth::user()->businessID;
		$comment->save();

		Session::flash('success', 'comment added');

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
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
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
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($id)
   {
      comments::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();

		Session::flash('success', 'comment deleted');

		return redirect()->back();
   }
}
