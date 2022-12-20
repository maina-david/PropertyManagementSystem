<?php

namespace App\Models\finance\creditnote;

use Illuminate\Database\Eloquent\Model;

class creditnote extends Model
{
   Protected $table = 'creditnote';

   public function totalProduct( $qty, $price){
      $price = $qty * $price;
      return $price;
   }

   public function total($qty, $price){

		$total = 0;

		foreach ($qty as $k => $q)
		{
			$total += $this->totalProduct($qty[$k], $price[$k]);
		}

		$amount =  abs($total);

		return $amount;
	}

   public function amount($qty, $price){
		$total 	 = 0;
		$sum = 0;

		foreach ($qty as $k => $q)
		{
			$sum += $this->totalProduct($qty[$k], $price[$k]);
		}

		return $sum;
	}

}
