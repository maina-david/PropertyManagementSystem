<?php

namespace App\Models\finance\products;

use Illuminate\Database\Eloquent\Model;
use Auth;
class product_information extends Model
{
   protected $table = 'product_information';

   public static function search($search){
      return empty($search) ? static::query() : static::query()
            ->Where('sku_code','like','%'.$search.'%')
            ->orWhere('product_name','like','%'.$search.'%')
            ->where('product_information.businessID',Auth::user()->businessID);
   }
}
