<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use Auth;
use Helper;
class items implements ToCollection,WithHeadingRow
{
	/**
 * @param Collection $collection
	*/
	public function collection(Collection $rows){
		foreach ($rows as $row){
			$product = new product_information;
			
			// if($row['serial'] == ""){
			// 	$product->sku_code = Helper::generateRandomString(9);
			// }else{
			// 	$product->sku_code = $row['serial'];
			// }
			$product->product_name = $row['name'];
			$product->type = 'product';
			$product->status = $row['active'];
			$product->description = $row['description'];
			$product->businessID = Auth::user()->businessID;
			$product->created_by = Auth::user()->id;
			$product->save();
	
			//product price
			$product_price = new product_price;
			$product_price->productID = $product->id;
			$product_price->selling_price = $row['price'];
			$product_price->businessID = Auth::user()->businessID;
			$product_price->created_by = Auth::user()->id;
			$product_price->save();
	
			//product quantities
			$product_inventory = new product_inventory;
			$product_inventory->current_stock = $row['inventory'];
			$product_inventory->productID = $product->id;
			$product_inventory->businessID = Auth::user()->businessID;
			$product_inventory->created_by = Auth::user()->id;
			$product_inventory->save();
      }
	}
}
