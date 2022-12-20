<?php

namespace App\Http\Controllers\app\crm\digitalmarketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\digital\accounts;
use App\Models\finance\customer\customers; 
use App\Models\crm\digital\channels;
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
      
      $accounts = accounts::join('customers','customers.id','=','crm_marketing_accounts.customerID')
                  ->join('status','status.id','=','crm_marketing_accounts.status')
                  ->orderby('crm_marketing_accounts.id','desc')
                  ->where('crm_marketing_accounts.businessID',Auth::user()->businessID)
                  ->select('*','crm_marketing_accounts.id as accountID')
                  ->get();
      
      $count = 1;
      
      return view('app.crm.socialmedia.account.index', compact('accounts','count'));
   }

   /**
    * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $clients = customers::where('businessID',Auth::user()->businessID)->get();
      return view('app.crm.socialmedia.account.create', compact('clients'));
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
         'customer' => 'required',
      ]);

      $account = new accounts;
      $account->businessID = Auth::user()->businessID;
      $account->userID = Auth::user()->userID;
      $account->customerID = $request->customer;
      $account->description = $request->description; 
      $account->budget = $request->budget; 
      $account->status = $request->status; 
      $account->account_date = $request->account_date; 
      $account->save();

      Session::flash('success','Account successfully added');

      return redirect()->route('crm.account.index');
   }

   /**
    * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      return view('app.crm.socialmedia.account.show');
   }

   /**
    * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $clients = customers::where('businessID',Auth::user()->businessID)->get();
      $edit = accounts::join('customers','customers.id','=','crm_marketing_accounts.customerID')
               ->where('crm_marketing_accounts.businessID',Auth::user()->businessID)
               ->where('crm_marketing_accounts.id',$id)
               ->select('*','customers.id as customerID','crm_marketing_accounts.id as accountID','crm_marketing_accounts.status as status')
               ->first();

      return view('app.crm.socialmedia.account.edit', compact('clients','edit'));
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
         'customer' => 'required',
      ]);

      $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $account->businessID = Auth::user()->businessID;
      $account->userID = Auth::user()->userID;
      $account->customerID = $request->customer;
      $account->description = $request->description; 
      $account->budget = $request->budget; 
      $account->status = $request->status; 
      $account->account_date = $request->account_date; 
      $account->save();

      Session::flash('success','Account successfully updated');

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
      //channels
      $channels = channels::where('accountID',$id)->where('businessID',Auth::user()->businessID)->count();

      if($channels == 0){
         $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
         $account->delete();

         Session::flash('success','Account successfully deleted');

         return redirect()->route('crm.account.index');
      }else{
         Session::flash('error','You have linked channels to this account. Hence, this account cannot be deleted.');

			return redirect()->route('crm.account.index');
      }
   }
}
