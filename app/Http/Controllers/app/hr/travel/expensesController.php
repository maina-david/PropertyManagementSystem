<?php

namespace App\Http\Controllers\app\hr\travel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\expense\expense;
use App\Models\finance\expense\expense_items;
use App\Models\wingu\file_manager as docs;
use App\Models\wingu\business;
use App\Models\hr\travel;
use Session;
use Wingu;
use File;
use Helper;
use Auth;
use DB;
class expensesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   } 

   /**
   * Travel expense list
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){

      $expenses = expense::join('hr_travels','hr_travels.id','=','fn_expense.travelID')
                          ->join('business','business.id','=','fn_expense.businessID')
                          ->join('currency','currency.id','=','business.base_currency')
                          ->join('status','status.id','=','fn_expense.statusID')
                          ->where('fn_expense.businessID',Auth::user()->businessID)
                          ->where('expence_type','Travel')
                          ->select('hr_travels.amount as amount','hr_travels.travelID as travelCode','fn_expense.date as date','status.name as statusName','fn_expense.updated_at as modifiedDate','fn_expense.expense_name as title','currency.code as code','fn_expense.created_by as createdBy','fn_expense.updated_by as updatedBy','fn_expense.id as expenseID','fn_expense.travelID as expenseTravelID')
                          ->orderby('fn_expense.id','desc')
                          ->get();
      $count = 1;
      return view('app.hr.travel.expenses.index', compact('count','expenses'));
   }

   /**
   * Create travel expense
   *
   * @return \Illuminate\Http\Response
   */
   public function create(){
      $travels = travel::join('customers','customers.id','=','hr_travels.customerID')
                        ->where('hr_travels.businessID',Auth::user()->businessID)
                        ->select('hr_travels.travelID as travel_code','customer_name','place_of_visit','departure_date','hr_travels.id as trID')
                        ->orderby('hr_travels.id','desc')
                        ->get();

      return view('app.hr.travel.expenses.create', compact('travels'));
   }

   /**
   * Store expense
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){
      $this->validate($request, [
         'travel' => 'required',
         'expense' => 'required',
         'price' => 'required',
         'quantity' => 'required',
         'expense_category' => 'required',
         'date' => 'required',
      ]);
      
      //add expense
      $store = new expense;
      $store->date              =  $request->date;
      $store->expense_name      =  $request->expense_name;
      $store->travelID          =  $request->travel;
      $store->expense_category  =  $request->expense_category;
      $store->expence_type      =  'Travel';
      $store->statusID          =  $request->status;
      $store->created_by        =  Auth::user()->id;
      $store->businessID        =  Auth::user()->businessID;
      $store->save();

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/';

         if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();
            $size =  $file->getSize();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(15). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($directory, $fileName);

            $upload = new docs;

            $upload->fileID      = $store->id;
            $upload->folder 	   = 'expenses';
            $upload->name 		   = $request->expense_name.'-'.Helper::generateRandomString();
            $upload->file_name   = $fileName;
            $upload->file_size   = $size;
            $upload->file_mime   = $file->getClientMimeType();
            $upload->created_by  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->save();
         }
      }

      //calculate and add expense Items
      $expenseItems = $request->expense;
		foreach ($expenseItems as $k => $v){
			$mainAmount = $request->price[$k] * $request->quantity[$k];
         $item = new expense_items;
         $item->expenseID		= $store->id;
         $item->travelID		= $request->travel;
			$item->expense		   = $request->expense[$k];
         $item->quantity		= $request->quantity[$k];
         $item->price		   = $request->price[$k];
			$item->total_amount  = $mainAmount;
			$item->businessID  	= Auth::user()->businessID;
			$item->save();         
      };

      //get expense Items for expense calculation
      $getItems = expense_items::where('expenseID',$store->id)
                              ->where('businessID',Auth::user()->businessID)
                              ->select(DB::raw('SUM(total_amount) as amount'))
                              ->first();

      //updated expense
      $expenseUpdate = expense::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
      $expenseUpdate->amount  =  $getItems->amount;  
      $expenseUpdate->save();

      //get travel
      $travel = travel::where('id',$request->travel)
                     ->where('businessID',Auth::user()->businessID)
                     ->first();
      $travel->expenseID = $store->id;
      $travel->amount = $getItems->amount;  
      $travel->save();

      Session::flash('success','Expense successfully added');

      return redirect()->route('hrm.travel.expenses');
   }

   /**
   * Expense edit
   *
   * @return \Illuminate\Http\Response
   */
   public function edit($id){
      $travels = travel::join('customers','customers.id','=','hr_travels.customerID')
                        ->where('hr_travels.businessID',Auth::user()->businessID)
                        ->select('hr_travels.travelID as travel_code','customer_name','place_of_visit','departure_date','hr_travels.id as trID')
                        ->orderby('hr_travels.id','desc')
                        ->get();

      $edit = expense::join('hr_travels','hr_travels.id','=','fn_expense.travelID')
                     ->join('customers','customers.id','=','hr_travels.customerID')
                     ->where('fn_expense.businessID',Auth::user()->businessID)
                     ->where('fn_expense.id',$id)
                     ->where('fn_expense.businessID',Auth::user()->businessID)
                     ->select('*','fn_expense.travelID as expense_travelID','fn_expense.statusID as status','fn_expense.id as expenseID')
                     ->first();

      $expenses = expense_items::where('expenseID',$id)
                              ->where('businessID',Auth::user()->businessID)
                              ->get();

      $files = docs::where('fileID',$id)->where('folder','expenses')->where('businessID',Auth::user()->businessID)->get();

      return view('app.hr.travel.expenses.edit', compact('travels','edit','expenses','files'));
   }

   /**
   * update expense
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id){
      $this->validate($request, [
         'travel' => 'required',
         'expense' => 'required',
         'price' => 'required',
         'quantity' => 'required',
         'expense_category' => 'required',
         'date' => 'required',
      ]);
      
      //add expense
      $store = expense::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $store->date              =  $request->date;
      $store->expense_name      =  $request->expense_name;
      $store->travelID          =  $request->travel;
      $store->expense_category  =  $request->expense_category;
      $store->expence_type      =  'Travel';
      $store->statusID          =  $request->status;
      $store->updated_by        =  Auth::user()->id;
      $store->businessID        =  Auth::user()->businessID;
      $store->save();

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/';

         if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();
            $size =  $file->getSize();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(15). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($directory, $fileName);

            $upload = new docs;

            $upload->fileID      = $store->id;
            $upload->folder 	   = 'expenses';
            $upload->name 		   = $request->expense_name.'-'.Helper::generateRandomString();
            $upload->file_name   = $fileName;
            $upload->file_size   = $size;
            $upload->file_mime   = $file->getClientMimeType();
            $upload->created_by  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->save();
         }
      }

      //delete current expense
      expense_items::where('expenseID',$id)->where('businessID',Auth::user()->businessID)->delete();

      //calculate and add expense Items
      $expenseItems = $request->expense;
		foreach ($expenseItems as $k => $v){
			$mainAmount = $request->price[$k] * $request->quantity[$k];
         $item = new expense_items;
         $item->expenseID		= $store->id;
         $item->travelID		= $request->travel;
			$item->expense		   = $request->expense[$k];
         $item->quantity		= $request->quantity[$k];
         $item->price		   = $request->price[$k];
			$item->total_amount  = $mainAmount;
			$item->businessID  	= Auth::user()->businessID;
			$item->save();         
      };

      //get expense Items for expense calculation
      $getItems = expense_items::where('expenseID',$store->id)
                              ->where('businessID',Auth::user()->businessID)
                              ->select(DB::raw('SUM(total_amount) as amount'))
                              ->first();

      //updated expense
      $expenseUpdate = expense::where('id',$store->id)->where('businessID',Auth::user()->businessID)->first();
      $expenseUpdate->amount  =  $getItems->amount;  
      $expenseUpdate->save();

      //get travel
      $travel = travel::where('id',$request->travel)
                     ->where('businessID',Auth::user()->businessID)
                     ->first();
      $travel->expenseID = $store->id;
      $travel->amount = $getItems->amount;  
      $travel->save();

      Session::flash('success','Expense successfully updated');

      return redirect()->back();
   }


   /**
   * Delete expense files
   *
   * @return \Illuminate\Http\Response
   */
   public function delete_file($expenseID,$id){
      $delete = docs::where('id',$id)->where('fileID',$expenseID)->where('folder','expenses')->where('businessID',Auth::user()->businessID)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/';
      
      //delete document if already exists
		if($delete->file_name != ""){
			$unlink = $directory.$delete->file_name;
			if (File::exists($unlink)) {
				unlink($unlink);
			}
		}
      $delete->delete();

      Session::flash('success','document deleted successfully');

      return redirect()->back();
   }

   /**
   * Delete expenses
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($id){ 
      expense::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();
      expense_items::where('expenseID',$id)->where('businessID',Auth::user()->businessID)->get();
      $delete = docs::where('fileID',$id)->where('folder','expenses')->where('businessID',Auth::user()->businessID)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/';
      
      //delete document if already exists
		if($delete->file_name != ""){
			$unlink = $directory.$delete->file_name;
			if (File::exists($unlink)) {
				unlink($unlink);
			}
		}
      $delete->delete();

      Session::flash('success','Expense deleted successfully');

      return redirect()->signedRoute('hrm.travel.expenses');
   }
}
