<?php

namespace App\Http\Controllers\app\finance\contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\address;
use App\Models\finance\customer\groups;
use App\Models\finance\customer\customer_group;
use App\Imports\customers as import;
use App\Exports\customers as export;
use Helper;
use Session;
use Wingu;
use Auth;
use Excel;
class importController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
	}

   /**
    * import csv
   *
   * @return \Illuminate\Http\Response
   */
   public function import(){
      $groups = groups::where('businessID',Auth::user()->businessID)
                  ->where('status','Active')
                  ->orderby('id','desc')
                  ->pluck('name','id')
                  ->prepend('Choose group','');
      return view('app.finance.contacts.import', compact('groups'));
   }

   /**
    * store uploaded file
   *
   * @return \Illuminate\Http\Response
   */
   public function import_contact(Request $request){
      $this->validate($request, [
         'upload_import' => 'required'
      ]);

      $file = request()->file('upload_import');

		Excel::import(new import, $file);

		Session::flash('success', 'File imported Successfully.');

		return redirect()->route('finance.contact.index');
   }


   /**
    * download contacts to excel
   *
   * @return \Illuminate\Http\Response
   */
   public function export(){
      return Excel::download(new export, 'customers.xlsx');
   }

   /**
    * download sample csv
   *
   * @return \Illuminate\Http\Response
   */
   public function download_import_sample(){
      //PDF file is stored under project/public/download/info.pdf
      $file= public_path(). "/samples/customer_import_sample_file.csv";

      return response()->download($file);
   }

}
