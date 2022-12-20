<?php
namespace App\Http\Controllers\app\finance\expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\expense\expense;
use App\Models\finance\expense\expense_category;
use App\Models\finance\payments\payment_type;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\accounts;
use App\Models\finance\tax;
use App\Models\wingu\file_manager as docs;
use Session;
use File;
use Helper;
use Wingu;
use Auth;

class expenseController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(){
      $expense = expense::join('fn_expense_category','fn_expense_category.id','=','fn_expense.expense_category')
                        ->join('status','status.id','=','fn_expense.statusID')
                        ->join('business','business.id','=','fn_expense.businessID')
                        ->join('currency','currency.id','=','business.base_currency')
                        ->where('expence_type','expense')
                        ->where('fn_expense.businessID',Auth::user()->businessID)
                        ->select('*','fn_expense.id as eid','status.name as statusName')
                        ->OrderBy('eid','DESC')
                        ->get();
      $count = 1;
      return view('app.finance.expense.expense.index', compact('expense','count'));
   }

   public function create(){
      $category = expense_category::where('businessID',Auth::user()->businessID)
                  ->OrderBy('id','DESC')
                  ->pluck('category_name','id')
                  ->prepend('Choose Expense Category');
      $tax = tax::OrderBy('id','DESC')
                  ->where('businessID',Auth::user()->businessID)
                  ->pluck('rate','id')
                  ->prepend('Choose VAT type');
      
      $accountPayment = payment_type::where('businessID',Auth::user()->businessID)->get();
      $defaultPayment = payment_type::where('businessID',0)->get();
      $suppliers = suppliers::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      return view('app.finance.expense.expense.create', compact('category','tax','defaultPayment','suppliers','accountPayment'));
   }

   public function store(Request $request){

      $this->validate($request, array(
         'date'              => 'Required',
         'expense_name'      => 'Required',
         'status'            => 'Required',
         'amount'            => 'Required',
         'expense_category'  => 'Required',
         'payment_method'    => 'Required',
      ));

      $expense = new expense;
      $expense->date              =  $request->date;
      $expense->deduct            = $request->deduct;
      $expense->expense_name      =  $request->expense_name;
      $expense->accountID         =  $request->account;
      $expense->expense_category  =  $request->expense_category;
      $expense->amount            =  $request->amount;
      $expense->tax_rate          =  $request->tax_rate;
      $expense->refrence_number   =  $request->refrence_number;
      $expense->supplierID        =  $request->supplier;
      $expense->payment_method    =  $request->payment_method;
      $expense->statusID          =  $request->status;
      $expense->description       =  $request->description;
      $expense->expence_type      =  'expense';
      $expense->created_by        =  Auth::user()->id;
      $expense->businessID        =  Auth::user()->businessID;
      $expense->save();

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

            $upload->fileID      = $expense->id;
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

      // if($request->deduct == 'Yes' ){
      //    //deduct from account
      //    $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$request->account)->first();
      //    $account->initial_balance = $account->initial_balance - $request->amount;
      //    $account->save();
      // }

      //record activity
      $activities = 'An expense has been created by '.Auth::user()->name;
      $section = 'Expense';
      $type = 'expense';
      $adminID = Auth::user()->id;
      $activityID = $expense->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','expense added');

      return redirect()->route('finance.expense.index');
   }

   public function edit($id){
      $expense = expense::where('id',$id)->where('businessID',Auth::user()->businessID)->select('*','accountID as account')->first();
      $category = expense_category::OrderBy('id','DESC')
                  ->where('businessID',Auth::user()->businessID)
                  ->pluck('category_name','id');
      $tax = tax::OrderBy('id','DESC')
                  ->where('businessID',Auth::user()->businessID)
                  ->pluck('rate','id')
                  ->prepend('Choose VAT type');
      $files = docs::where('fileID',$id)
               ->where('folder','=','expenses')
               ->where('businessID',Auth::user()->businessID)
               ->get();
      $accountPayment = payment_type::where('businessID',Auth::user()->businessID)->get();
      $defaultPayment = payment_type::where('businessID',0)->get();
      $suppliers = suppliers::where('businessID', Auth::user()->businessID)->pluck('supplierName','id')->prepend('','choose supplier');
      $bankAccounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose Account','');

      return view('app.finance.expense.expense.edit', compact('expense','category','tax','defaultPayment','files','suppliers','bankAccounts','accountPayment'));
   }

   public function update(Request $request,$id){
      $this->validate($request, array(
         'date'              => 'Required',
         'expense_name'      => 'Required',
         'expense_category'  => 'Required',
      ));
      

      $expense = expense::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      //make new update
      $expense->date              =  $request->date;
      $expense->deduct            = $request->deduct;
      $expense->expense_name      =  $request->expense_name;
      $expense->accountID         =  $request->account;
      $expense->expense_category  =  $request->expense_category;
      $expense->amount            =  $request->amount;
      $expense->tax_rate          =  $request->tax_rate;
      $expense->refrence_number   =  $request->refrence_number;
      $expense->supplierID        =  $request->supplierID;
      $expense->payment_method    =  $request->payment_method;
      $expense->statusID          =  $request->statusID;
      $expense->description       =  $request->description;
      $expense->payment_method    =  $request->payment_method;
      $expense->updated_at        =  Auth::user()->id;
      $expense->businessID        =  Auth::user()->businessID;
      $expense->save();

      // if($request->deduct == 'No' && $expense->deduct == 'Yes'){         
      //    //update the account
      //    $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$expense->accountID)->first();
      //    $account->initial_balance = $account->initial_balance + $expense->amount;
      //    $account->save();
      // }

      // if($request->deduct == 'Yes' && $expense->deduct == 'No'){
      //    //deduct from account and save new amount
      //    $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$request->account)->first();
      //    $account->initial_balance = $account->initial_balance - $request->amount;
      //    $account->save();
      // }


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
            $fileName = Helper::generateRandomString(16). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($directory, $fileName);

            $upload = new docs;

            $upload->fileID      = $expense->id;
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

      //record activity
      $activities = 'expense has been updated by '.Auth::user()->name;
      $section = 'Expense';
      $type = 'expense';
      $adminID = Auth::user()->id;
      $activityID = $expense->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Expense Updated');

      return redirect()->back();
   }

   public function destroy($id){

      //delete expense
      $expense = expense::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      //add the amount to specific account
      if($expense->deduct == 'Yes'){
         $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$expense->accountID)->first();
         $account->initial_balance = $account->initial_balance + $expense->amount;
         $account->save();
      }


      //delete files
      $check = docs::where('fileID',$id)
               ->where('folder','expenses')
               ->where('businessID',Auth::user()->businessID)
               ->count();

      if($check > 0){
         $files = docs::where('fileID',$id)->where('businessID',Auth::user()->businessID)->get();
         foreach ($files as $file) {
            $delete = docs::where('id',$file->id)->where('businessID',Auth::user()->businessID)->first();
            $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/';
            $path = $directory.$file->file_name;
            if (File::exists($path)) {
                  unlink($path);
            }
            $delete = $file->delete();
         }
      }

      $expense->delete();

      //record activity
      $activities = 'expense has been deleted by '.Auth::user()->name;
      $section = 'Expense';
      $type = 'expense';
      $adminID = Auth::user()->id;
      $activityID = $expense->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Expense delete successfully');

      return redirect()->back();
   } 

   public function file_delete($id){

      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/';

      $delete = docs::where('id',$id)->where('folder','expenses')->where('businessID',Auth::user()->businessID)->first();
      $file = $directory.$delete->file_name;
      if (File::exists($file)) {
         unlink($file);
      }
      $delete->delete();
 
      //record activity
      $activities = 'expense has been deleted by '.Auth::user()->name;
      $section = 'Expense';
      $type = 'expense';
      $adminID = Auth::user()->id;
      $activityID = $id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','File deleted successfully');

      return redirect()->back();
   }

   public function download($id) {
      $file = docs::where('id',$id)->where('folder','expenses')->where('businessID',Auth::user()->businessID)->first();
      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/';
      $path = $directory.$file->file_name;
      return response()->download($path);
   }
}
