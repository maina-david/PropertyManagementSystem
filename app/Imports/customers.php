<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\finance\customer\customers as customer;
use App\Models\finance\customer\address;
use Helper;
use Auth;

class customers implements ToCollection,WithHeadingRow
{
   /**
   * @param Collection $collection
   */
   public function collection(Collection $rows){
      foreach ($rows as $row){
         $primary = new customer;
   		$code = Helper::generateRandomString(10);
   		$primary->customer_name = $row['name'];
   		$primary->reference_number = Helper::generateRandomString(10);
   		$primary->email = $row['email'];
    		$primary->primary_phone_number = $row['phonenumber'];
   		$primary->customer_code = $code; 
			$primary->website = $row['website'];
         $primary->created_by = Auth::user()->id;
         $primary->updated_by = Auth::user()->id;
			$primary->businessID = Auth::user()->businessID;
    		$primary->save();

    		//address
    		$address = new address;
   		$address->customerID = $primary->id;
   		$address->bill_attention = $row['name'];
         $address->bill_street = $row['street'];
         $address->bill_state = $row['state'];
    		$address->bill_city = $row['city'];
    		$address->bill_zip_code = $row['zipcode'];
    		$address->bill_country = 110;
			$address->bill_postal_address = $row['postaladdress'];
    		$address->save();
      }
   }
}
