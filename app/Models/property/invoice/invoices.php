<?php

namespace App\Models\property\invoice;

use Illuminate\Database\Eloquent\Model;
class invoices extends Model
{
   Protected $table = 'property_invoices';

   public static function search($search){
      return empty($search) ? static::query()->join('property_tenants','property_tenants.id','=','property_invoices.tenantID')
            : static::query()
            ->join('property_tenants','property_tenants.id','=','property_invoices.tenantID')
            ->where('tenant_name', 'like', '%'.$search.'%');
   }
}
