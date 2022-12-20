<?php

namespace App\Http\Controllers\app\finance\account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\accounts;
use App\Models\finance\invoice\invoice_payments;
use Auth;
use Session;

class accountController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $accounts = accounts::join('business','business.id','=','bank_accounts.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->where('bank_accounts.businessID',Auth::user()->businessID)
                  ->select('*','bank_accounts.id as accountID')
                  ->get();
      $count = 1;

      return view('app.finance.accounts.index', compact('accounts','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      return view('app.finance.accounts.create');
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
      ]);

      $account = new accounts;
      $account->title = $request->title;
      $account->description = $request->description;
      $account->initial_balance = $request->initial_balance;
      $account->account_number = $request->account_number;
      $account->contact_person = $request->contact_person;
      $account->phone_number = $request->phone_number;
      $account->banking_url = $request->banking_url;
      $account->businessID = Auth::user()->businessID;
      $account->userID = Auth::user()->id;
      $account->save();

      Session::flash('success','Financial Account successfully added');

      return redirect()->route('finance.account');
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
      $edit = accounts::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      return view('app.finance.accounts.edit', compact('edit'));
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
      ]);

      $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $account->title = $request->title;
      $account->description = $request->description;
      $account->account_number = $request->account_number;
      $account->contact_person = $request->contact_person;
      $account->phone_number = $request->phone_number;
      $account->banking_url = $request->banking_url;
      $account->businessID = Auth::user()->businessID;
      $account->userID = Auth::user()->id;
      $account->save();

      Session::flash('success','Financial Account successfully updated');

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
      $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $payments = invoice_payments::where('businessID',Auth::user()->businessID)->where('accountID',$id)->count();

      if($account->initial_balance <= 0 && $payments == 0){
         $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
         $account->delete();

         Session::flash('success','Account successfully deleted');

         return redirect()->back();
      }else{
         Session::flash('error','You have recorded transactions for this account. Hence, this account cannot be deleted.');

			return redirect()->back();
      }
   }

   public function express(Request $request){
      $account = new accounts;
      $account->title = $request->title;
      $account->businessID = Auth::user()->businessID;
      $account->userID = Auth::user()->id;
      $account->save();
   }

   public function list(Request $request)
   {
      $accounts = accounts::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get(['id', 'title as text']);
      return ['results' => $accounts];
   }
}
