<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\finance\customer\customers as customer;
use App\Models\wingu\industry;
use Auth;

class leadindustryreport implements FromCollection, WithHeadings
{
   protected $industry,$start,$end;

   function __construct($industry,$start,$end) {
      $this->industry = $industry;
      $this->start = $start;
      $this->end = $end;
   }

   /**
   * @return \Illuminate\Support\Collection
   */
   public function collection()
   {
      $industry =  $this->industry;
      $start  =  $this->start;
      $end    =  $this->end;
      $checkindustry = industry::where('id',$industry)->count();      
      if($checkindustry == 0){
         return customer::join('customer_address','customer_address.customerID','=','customers.id')
                           ->where('customers.businessID',Auth::user()->businessID)
                           ->where('customers.category','Lead')
                           ->select('customer_name','primary_phone_number','email','assignedID','statusID','sourceID','bill_street','bill_city','bill_state','bill_country','customers.created_at as date')
                           ->whereBetween('customers.created_at', [$start, $end])
                           ->OrderBy('customers.id','DESC')
                           ->get();

      }else{
         return customer::join('customer_address','customer_address.customerID','=','customers.id')
                           ->where('customers.businessID',Auth::user()->businessID)
                           ->where('customers.category','Lead')
                           ->whereBetween('customers.created_at', [$start, $end])
                           ->where('customers.industryID',$industry)
                           ->select('customer_name','primary_phone_number','email','assignedID','statusID','sourceID','bill_street','bill_city','bill_state','bill_country','customers.created_at as date')
                           ->OrderBy('customers.id','DESC')
                           ->get();
      } 
   }

   public function headings(): array
   {
      return [
         'Customer name',
         'Phone number',
         'email',
         'Lead owner',
         'status',
         'source',
         'Street',
         'City',
         'State',
         'Country',
         'Date added',
      ];
   }
}
