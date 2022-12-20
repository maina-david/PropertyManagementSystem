<?php

namespace App\Models\logistics;

use Illuminate\Database\Eloquent\Model;

class export extends Model
{
   Protected $table = 'lg_export_tariffs';

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
      'weight', 'amount', 'zone',
   ];
}
 