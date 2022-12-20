<?php

namespace App\Http\Controllers\app\finance\payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\payments\payment_type;
use App\Models\finance\invoice\invoice_payments;
use Auth;
use Session;

class paymentModeController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function index(){
      $accounts = payment_type::where('businessID',Auth::user()->businessID)->get();
      $defaults = payment_type::where('businessID',0)->get();
      $count = 1;

      return view('app.finance.payments.settings.index', compact('count','defaults','accounts'));
   }

   public function store(Request $request){

      $mode = new payment_type;
      $mode->name = $request->name;
      $mode->description = $request->description;
      $mode->created_by = Auth::user()->id;
      $mode->businessID = Auth::user()->businessID;
      $mode->save();

      Session::flash('success','Payment mode successfully updated');

      return redirect()->back();
   }

   public function update(Request $request,$id){
      $edit = payment_type::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $edit->name = $request->name;
      $edit->description = $request->description;
      $edit->updated_by = Auth::user()->id;
      $edit->businessID = Auth::user()->businessID;
      $edit->save();

      Session::flash('success','Payment mode successfully updated');

      return redirect()->back();
   }

   public function delete($id){

      //check if in use in payments
      $payment = invoice_payments::where('businessID',Auth::user()->businessID)->where('payment_method',$id)->count();

      if($payment == 0){

         $delete = payment_type::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();
         
         Session::flash('success','payment mode successfully deleted');

         return redirect()->back();
      }else{
         Session::flash('error','You have recorded transactions on this payment mode. Hence, this mode cannot be deleted.');

			return redirect()->back();
      }

   }

   public function express_store(Request $request){
      $mode = new payment_type;
      $mode->name = $request->name;
      $mode->created_by = Auth::user()->id;
      $mode->businessID = Auth::user()->businessID;
      $mode->save();
   }


   public function express_list(){
      $method = payment_type::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get(['id', 'name as text']);
      return ['results' => $method];
   }
}
