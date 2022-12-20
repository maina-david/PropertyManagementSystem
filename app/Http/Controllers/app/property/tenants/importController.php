<?php

namespace App\Http\Controllers\app\property\tenants;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\tenants as import;
use App\Exports\tenants as export;
use Session;
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
   public function index(){
      //check if user is linked to a business and allow access
      return view('app.property.tenants.import');
   }

   /**
    * store uploaded file
   *
   * @return \Illuminate\Http\Response
   */
   public function import(Request $request){

      $this->validate($request, [
         'upload_import' => 'required'
      ]);

      $file = request()->file('upload_import');

		Excel::import(new import, $file);

		Session::flash('success', 'Tenants imported Successfully.');

      return redirect()->route('tenants.index');
   }


   /**
    * download contacts to excel
   *
   * @return \Illuminate\Http\Response
   */
   public function export(){
      return Excel::download(new export, 'tenants.xlsx');
   }

   /**
    * download sample csv
   *
   * @return \Illuminate\Http\Response
   */
   public function download_import_sample(){
      //PDF file is stored under project/public/download/info.pdf
      $file= storage_path(). "/files/samples/import_sample_file.csv";

      return response()->download($file);
   }

}
