<?php
namespace App\Http\Controllers\app\property\landlords;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\landlords as import;
use App\Exports\landlords as export;
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
   public function import(){
      return view('app.property.landlord.import');
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

		Session::flash('success', 'Landlords imported Successfully.');

      return redirect()->route('landlord.index');
   }


   /**
    * download contacts to excel
   *
   * @return \Illuminate\Http\Response
   */
   public function export(){
      return Excel::download(new export, 'landlord.xlsx');
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
