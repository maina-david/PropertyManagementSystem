<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\employee_files;
use App\Models\hr\employees;
use Helper;
use Session;
use file;
use Wingu;
use Auth;
use input;

class filesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $files = employee_files::where('employeeID',$id)->get();
      $count = 1;
      $employee = employees::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      return view('app.hr.employee.files', compact('employee','files','count'));
   }

   public function post_file(Request $request){
      //return $request->employee_id;
   //get file name
      $file = $request->file('file');

      //change file name
      $filename = Helper::generateRandomString().$file->getClientOriginalName();

      //move file
      $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->primary_email.'/hr/employee/files/';

       //create directory if it doesn't exists
       if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
      }


      $upload_success = $file->move($directory, $filename);

      //save the image details into the database
      $emp_file = new employee_files;

      $emp_file->employeeID = $request->employee_id;
      $emp_file->name = $filename;
      $emp_file->file_name = $filename;
      //$emp_file->file_size = $file->getClientSize();
      $emp_file->file_mime = $file->getClientMimeType();
      $emp_file->businessID = Auth::user()->businessID;
      $emp_file->userID = Auth::user()->id;

      $emp_file->save();
	}

	public function edit_institution($id){

	}

	public function delete_file($id){

      $files = employee_files::where('businessID',$id)->where('businessID',Auth::user()->businessID)->first();

      $check  = employee_files::where('id',$id)->where('file_name','!=','NULL')->count();

      $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->primary_email.'/hr/employee/files/'.$files->file_name;

      if ($check > 0) {
         unlink($directory);
      }

      $files->delete();

      Session::flash('Success', 'Delete was successful !');

      return redirect()->back();
	}
}
