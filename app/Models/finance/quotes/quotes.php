<?php

namespace App\Models\finance\quotes;

use Illuminate\Database\Eloquent\Model;

class quotes extends Model
{
   Protected $table = 'quotes';

   public function totalProduct( $qty, $price){
      $price = $qty * $price;
      return $price;
   }

   public function total($qty, $price, $discount, $type, $tax){

		$total 		= 0;

		foreach ($qty as $k => $q)
		{
			$total += $this->totalProduct($qty[$k], $price[$k]);
		}

		if($type == 'amount')
		{
			$discount = $discount;
		}elseif ( $type == 'percentage')
		{

			$discount = $total * ($discount / 100);
		}

		if($tax == 0){
			$tax = 0;
		}else{
			$tax = ($total * ($tax / 100));
		}

		$b4tax = $total - $discount;

		$totalPice = $b4tax + $tax ;

		$amount =  abs($totalPice);

		
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
