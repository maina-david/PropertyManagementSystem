<?php

namespace App\Models\property\tenants;

use Illuminate\Database\Eloquent\Model;

class tenants extends Model
{
   Protected $table = 'property_tenants';

   public static function search($search){
      return empty($search) ? static::query()
            : static::query()
            ->where('tenant_name', 'like', '%'.$search.'%');
   }
}
