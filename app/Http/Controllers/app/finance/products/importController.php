<?php

namespace App\Http\Controllers\app\finance\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\product_information;
use App\Imports\items as import;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;
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
      return view('app.finance.products.import');
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

		Session::flash('success', 'Item imported Successfully.');

		return redirect()->route('finance.product.index');
   }


   /**
    * download contacts to excel
   *
   * @return \Illuminate\Http\Response
   */
   public function export($type){
      $data = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
               ->join('product_price','product_price.productID','=','product_information.id')
               ->select('type','product_name','sku_code','description','buying_price','selling_price','current_stock','reorder_level','replenish_level','expiration_date','product_information.created_at as date_created')
               ->get()
               ->toArray();

      return Excel::create('items', function($excel) use ($data) {
         $excel->sheet('mySheet', function($sheet) use ($data)
         {
            $sheet->fromArray($data);
         });
      })->download($type);
   }

   /**
    * download sample csv
   *
   * @return \Illuminate\Http\Response
   */
   public function download_import_sample(){
      //PDF file is stored under project/public/download/info.pdf
      $file= public_path(). "/samples/item_import_sample_file.csv";

      return response()->download($file);
   }

}
