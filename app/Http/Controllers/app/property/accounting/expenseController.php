<?php
namespace App\Http\Controllers\app\property\accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\expense\expense;
use App\Models\wingu\business;
use App\Models\finance\expense\expense_category;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\payments\payment_type; 
use App\Models\property\lease;
use App\Models\finance\accounts;
use App\Models\finance\tax;
use App\Models\wingu\file_manager as documents; 
use App\Models\property\property;
use Auth;
use Session;
use Wingu; 
use Helper;
use File;

class expenseController extends Controller
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
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $expense = expense::join('fn_expense_category','fn_expense_category.id','=','property_expense.expense_category')
                           ->join('status','status.id','=','property_expense.statusID')
                           ->join('business','business.id','=','property_expense.businessID')
                           ->join('currency','currency.id','=','business.base_currency')
                           ->where('expence_type','expense')
                           ->where('property_expense.propertyID',$id)
                           ->where('property_expense.businessID',Auth::user()->businessID)
                           ->select('*','property_expense.id as eid','status.name as statusName')
                           ->OrderBy('eid','DESC')
                           ->get();
      $count = 1;
                           
      $propertyID = $id;

      return view('app.property.accounting.expense.index', compact('property','expense','count','propertyID'));
   } 

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create($id)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
    
      $leases = property::join('property_type','property_type.id','=','property.property_type')
                  ->join('property_tenants','property_tenants.id','=','property.tenantID')
                  ->join('property_lease','property_lease.id','=','property.leaseID')
                  ->where('property.businessID',Auth::user()->businessID)
                  ->where('property.parentID',$id)
						->where('property.tenantID','!=', '')
						->where('property_lease.statusID',15)
                  ->orderby('property.id','desc')
                  ->select('*', 'property.id as propID','property_lease.id as leaseID')
						->get();

      $units = property::join('property_type','property_type.id','=','property.property_type')
                  ->where('businessID',Auth::user()->businessID)
                  ->where('parentID',$id)
                  ->orderby('property.id','desc')
                  ->select('*', 'property.id as propID','property.property_type as typeID')
                  ->get();

      $mainMethods =  payment_type::where('businessID',0)->get();
      $paymentmethod = payment_type::where('businessID',Auth::user()->businessID)->get();
      $propertyID = $id;

      return view('app.property.accounting.expense.create', compact('mainMethods','paymentmethod','property','leases','units','propertyID'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request, $propertyID)
   {
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
      $expense->propertyID        =  $propertyID;
      $expense->unitID            =  $request->unitID;
      $expense->leaseID           =  $request->leaseID;
      $expense->expence_type      =  'expense';
      $expense->created_by        =  Auth::user()->id;
      $expense->businessID        =  Auth::user()->businessID;
      $expense->save();

      //upload images
      if($request->hasFile('files')){
         $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->first();

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/expense/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            $size =  $file->getSize();
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(20).'.'.$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new documents;
            $upload->fileID      = $expense->id;
            $upload->folder 	   =  $property->property_code;
            $upload->section 	   = 'property/expense';
            $upload->name 		   = $expense->expense_name;
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

      Session::flash('success','expense added to property');

      return redirect()->route('property.expense',$propertyID);
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
   public function edit($propertyID,$id)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->first();

      $expense = expense::where('id',$id)
                        ->where('propertyID',$propertyID)
                        ->where('businessID',Auth::user()->businessID)
                        ->select('*','accountID as account')
                        ->first();
         
      $payment = payment_type::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose Payment Method','');
      $files = documents::where('fileID',$id)
                        ->where('folder','=',$property->property_code)
                        ->where('section','=','property/expense')
                        ->where('businessID',Auth::user()->businessID)
                        ->get();

      $leases = property::join('property_type','property_type.id','=','property.property_type')
                  ->join('property_tenants','property_tenants.id','=','property.tenantID')
                  ->join('property_lease','property_lease.id','=','property.leaseID')
                  ->where('property.businessID',Auth::user()->businessID)
                  ->where('property.parentID',$propertyID)
                  ->where('property.tenantID','!=', '')
                  ->where('property_lease.statusID',15)
                  ->orderby('property.id','desc')
                  ->select('*', 'property.id as propID','property_lease.id as leaseID')
                  ->get();

      $leaseInfo = property::join('property_type','property_type.id','=','property.property_type')
                  ->join('property_tenants','property_tenants.id','=','property.tenantID')
                  ->join('property_lease','property_lease.id','=','property.leaseID')
                  ->where('property.businessID',Auth::user()->businessID)
                  ->where('property.parentID',$propertyID)
                  ->where('property.tenantID','!=', '')
                  ->where('property_lease.id',$expense->leaseID)
                  ->select('*', 'property.id as propID','property_lease.id as leaseID')
                  ->first();

      $units = property::join('property_type','property_type.id','=','property.property_type')
                  ->where('businessID',Auth::user()->businessID)
                  ->where('parentID',$propertyID)
                  ->select('property.id as unitID','property.serial as serial')
                  ->pluck('serial','unitID')
                  ->prepend('choose unit','');

      $mainMethods =  payment_type::where('businessID',0)->get();
      $paymentmethod = payment_type::where('businessID',Auth::user()->businessID)->get();

      $supplier = suppliers::where('businessID', Auth::user()->businessID)->where('id',$expense->supplierID)->first(); 

      $expenseCategory = expense_category::where('id',$expense->expense_category)->where('businessID',Auth::user()->businessID)->first();

      $tax = tax::where('id',$expense->tax_rate)->where('businessID',Auth::user()->businessID)->first();

      return view('app.property.accounting.expense.edit', compact('expense','payment','files','supplier','leases','units','property','mainMethods','paymentmethod','business','leaseInfo','expenseCategory','tax','propertyID'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request,$propertyID,$id)
   {
      $this->validate($request, array(
         'date'              => 'Required',
         'expense_name'      => 'Required',
         'expense_category'  => 'Required',
      ));
      

      $expense = expense::where('businessID',Auth::user()->businessID)->where('propertyID',$propertyID)->where('id',$id)->first();
      //make new update
      $expense->date              =  $request->date;
      //$expense->deduct            = $request->deduct;
      $expense->expense_name      =  $request->expense_name;
      $expense->accountID         =  $request->account;
      $expense->expense_category  =  $request->expense_category;
      $expense->amount            =  $request->amount;
      $expense->tax_rate          =  $request->tax_rate;
      $expense->refrence_number   =  $request->refrence_number;
      $expense->supplierID        =  $request->supplier;
      $expense->payment_method    =  $request->payment_method;
      $expense->statusID          =  $request->statusID;
      $expense->description       =  $request->description;
      $expense->payment_method    =  $request->payment_method;
      $expense->propertyID        =  $propertyID;
      $expense->unitID            =  $request->unitID;
      $expense->leaseID           =  $request->leaseID;
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
         $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->first();

         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/expense/';

         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('files');

         foreach($files as $file) {
            $size =  $file->getSize();
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(20).'.'.$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new documents;
            $upload->fileID      = $expense->id;
            $upload->folder 	   =  $property->property_code;
            $upload->section 	   = 'property/expense';
            $upload->name 		   = $expense->expense_name;
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

      Session::flash('success','Expense Updated successfully');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($propertyID,$id)
   {
      $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->first();

      //get expense details
      $expense = expense::where('businessID',Auth::user()->businessID)->where('propertyID',$propertyID)->where('id',$id)->first();

      //add the amount to specific account
      // if($expense->deduct == 'Yes'){
      //    $account = accounts::where('businessID',Auth::user()->businessID)->where('id',$expense->accountID)->first();
      //    $account->initial_balance = $account->initial_balance + $expense->amount;
      //    $account->save();
      // }

      //delete files
      $check = documents::where('fileID',$id)
               ->where('businessID',Auth::user()->businessID)
               ->where('folder','=',$property->property_code)
               ->where('section','=','property/expense')
               ->count();

      if($check > 0){
         $files = documents::where('fileID',$id)
                           ->where('businessID',Auth::user()->businessID)
                           ->where('folder','=',$property->property_code)
                           ->where('section','=','property/expense')
                           ->get();
         foreach($files as $file) {
            $delete = documents::where('id',$file->id)->where('businessID',Auth::user()->businessID)->where('fileID',$id)->first();

            $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/expense/';

            $path = $directory.$delete->file_name;
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
      $type = 'delete';
      $adminID = Auth::user()->id;
      $activityID = $expense->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Expense delete successfully');

      return redirect()->back();
   }

   /**
    * Delete expense file 
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function delete_file($propertyID,$parentID,$fileID){
      $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/expense/';
      
      $delete = documents::where('id',$fileID)
                        ->where('fileID',$parentID)
                        ->where('businessID',Auth::user()->businessID)
                        ->where('folder','=',$property->property_code)
                        ->where('section','=','property/expense')
                        ->first();

      $file = $directory.$delete->file_name;
      if(File::exists($file)) {
         unlink($file);
      }
      $delete->delete();

      //record activity
      $activities = 'expense file has been deleted by '.Auth::user()->name;
      $section = 'Property';
      $type = 'expesnse';
      $adminID = Auth::user()->id;
      $activityID = $parentID;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','File deleted successfully');

      return redirect()->back();
   }
}
