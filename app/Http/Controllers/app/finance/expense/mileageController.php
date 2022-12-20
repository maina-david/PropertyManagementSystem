<?php

namespace App\Http\Controllers\app\finance\expense;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\expense\expense;
use App\Models\finance\expense\expense_category;
use App\Models\hr\employee_basic_info;
use App\Models\finance\payments\payment_type;
use App\Models\wingu\documents;
use App\Models\finance\tax;
use Helper;
use Session;
use Auth;
use File;
use Wingu;

class mileageController extends Controller
{
   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){
      $expense = expense::join('fn_expense_category','fn_expense_category.id','=','fn_expense.expense_category')
      ->where('expence_type','mileage')
      ->where('fn_expense.businessID',Auth::user()->businessID)
      ->select('*','fn_expense.id as eid')
      ->OrderBy('eid','DESC')
      ->get();
      $count = 1;
      return view('app.finance.expense.mileage.index', compact('expense','count'));
   }

   public function create(){
      $category = expense_category::where('businessID',Auth::user()->businessID)
         ->OrderBy('id','DESC')
         ->where('businessID',Auth::user()->businessID)
         ->pluck('category_name','id')
         ->prepend('Choose Expense Category');
      $tax = tax::OrderBy('id','DESC')
         ->where('businessID',Auth::user()->businessID)
         ->pluck('rate','id')
         ->prepend('Choose VAT type');
      $payment = payment_type::pluck('name','id')->prepend('Choose Payment Method');
      $employee = employee_basic_info::where('businessID',Auth::user()->businessID)
                  ->where('trash',0)
                  ->OrderBy('id','DESC')
                  ->pluck('names','id');
      return view('app.finance.expense.mileage.create', compact('category','tax','employee','payment'));
   }

   public function store(Request $request){

      $this->validate($request, array(
         'date'              => 'Required',
         'expense_name'      => 'Required',
         'expense_category'  => 'Required',
         'amount'            => 'Required',
         'tax_rate'          => 'Required',
         'reference'   => 'Required',
         'claimant'          => 'Required',
      ));

      $expense = new expense;
      $expense->date              =  $request->date;
      $expense->expense_name      =  $request->expense_name;
      $expense->expense_category  =  $request->expense_category;
      $expense->amount            =  $request->amount;
      $expense->tax_rate          =  $request->tax_rate;
      $expense->refrence_number   =  $request->refrence_number;
      $expense->payed_to          =  $request->payed_to;
      $expense->payment_method    =  $request->payment_method;
      $expense->status            =  $request->status;
      $expense->description       =  $request->description;
      $expense->payment_method    =  $request->payment_method;
      $expense->expence_type      =  'mileage';
      $expense->admin_id          =  Auth::user()->id;
      $expense->businessID        =  Auth::user()->businessID;
      $expense->distance         =  $request->distance;
      $expense->calculate_type    =  $request->calculate_type;
      $expense->odometer_start    =  $request->odometer_start;
      $expense->odometer_stop     =  $request->odometer_stop;
      $expense->claimant          =  $request->claimant;
      $expense->save();

      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->primary_email.'/finance/expense/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::seoUrl($expense->expense_name).'-'.Helper::generateRandomString(). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($directory, $fileName);

            $upload = new documents;
            $upload->parentid = $expense->id;
            $upload->file_name = $fileName;
            $upload->folder    = 'Finance';
            $upload->section   = 'expenses';
            $upload->file_mime = $file->getClientMimeType();
            $upload->admin_id  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->name = $request->expense_name.'-'.Helper::generateRandomString();
            $upload->save();
         }
      }

      //record activity
		$activities = 'An expense has been created by '.Auth::user()->name;
		$section = 'Expense';
		$type = 'Mileage expense';
		$adminID = Auth::user()->id;
		$activityID = $expense->id;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Mileage Expense Added');

      return redirect()->route('finance.mileage.edit',$expense->id);
   }

   public function edit($id){
      $expense = expense::where('id',$id)->first();
      $category = expense_category::where('businessID',Auth::user()->businessID)
         ->OrderBy('id','DESC')
         ->pluck('category_name','id')
         ->prepend('Choose Expense Category');
      $tax = tax::OrderBy('id','DESC')
         ->where('businessID',Auth::user()->businessID)
         ->pluck('rate','id')
         ->prepend('Choose VAT type');
      $employee = employee_basic_info::where('trash',0)->OrderBy('id','DESC')->pluck('names','id');
      $payment = payment_type::pluck('name','id')->prepend('choose payment method');
      $files = documents::where('parentid',$id)
               ->where('folder','=','Finance')
               ->where('section','=','expenses')
               ->where('businessID',Auth::user()->businessID)
               ->get();

      return view('app.finance.expense.mileage.edit', compact('expense','category','tax','employee','payment','files'));
   }

   public function update(Request $request,$id){
      $this->validate($request, array(
         'date'              => 'Required',
         'expense_name'      => 'Required',
         'expense_category'  => 'Required',
         'amount'            => 'Required',
         'tax_rate'          => 'Required',
         'refrence_number'   => 'Required',
         'claimant'          => 'Required',
      ));

      $expense = expense::where('id',$id)->first();
      $expense->date              =  $request->date;
      $expense->expense_name      =  $request->expense_name;
      $expense->expense_category  =  $request->expense_category;
      $expense->amount            =  $request->amount;
      $expense->tax_rate          =  $request->tax_rate;
      $expense->refrence_number   =  $request->refrence_number;
      $expense->payed_to          =  $request->payed_to;
      $expense->payment_method    =  $request->payment_method;
      $expense->status            =  $request->status;
      $expense->description       =  $request->description;
      $expense->payment_method    =  $request->payment_method;
      $expense->expence_type      =  'mileage';
      $expense->admin_id          =  Auth::user()->id;
      $expense->businessID        =  Auth::user()->businessID;
      $expense->calculate_type    =  $request->calculate_type;
      $expense->distance         =  $request->distance;
      $expense->odometer_start    =  $request->odometer_start;
      $expense->odometer_stop     =  $request->odometer_stop;
      $expense->claimant          =  $request->claimant;
      $expense->save();

      //upload images
      if($request->hasFile('files')){

         //directory
         $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->primary_email.'/finance/expense/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::seoUrl($expense->expense_name).'-'.Helper::generateRandomString(). '.' .$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($directory, $fileName);

            $upload = new documents;
            $upload->parentid = $expense->id;
            $upload->file_name = $fileName;
            $upload->folder    = 'Finance';
            $upload->section   = 'expenses';
            $upload->file_mime = $file->getClientMimeType();
            $upload->admin_id  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->name = $request->expense_name.'-'.Helper::generateRandomString();
            $upload->save();
         }
      }

      //record activity
		$activities = 'An expense has been created by '.Auth::user()->name;
		$section = 'Expense';
		$type = 'Mileage expense';
		$adminID = Auth::user()->id;
		$activityID = $expense->id;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Mileage Expense Updated');

      return redirect()->back();
   }

   public function destroy($id){
      //delete expense
      $expense = expense::find($id);
      $expense->delete();

      //delete files
      $check = documents::where('parentid',$id)
               ->where('folder','Expense')
               ->where('section','expense')
               ->where('businessID',Auth::user()->businessID)
               ->count();
      if($check > 0){
         $files = documents::where('parentid',$id)->get();
         foreach ($files as $file) {
            $delete = documents::find($file->id);
            $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->primary_email.'/finance/expense/';
            $path = $directory.$file->file_name;
            if (File::exists($path)) {
               unlink($path);
            }
            $delete = $file->delete();
         }
      }

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

      $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->primary_email.'/finance/expense/';

      $delete = documents::find($id);
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
		$activityID = $delete->parentid;
		$businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','File deleted successfully');

      return redirect()->back();
   }

   public function download($id) {
      $file = documents::find($id);
      $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->primary_email.'/finance/expense/';
      $path = $directory.$file->file_name;
      return response()->download($path);
   }
}
