<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\finance\customer\customers as customer;
use App\Models\crm\leads\sources;
use Auth;

class leadsourcereport implements FromCollection, WithHeadings
{
   protected $source,$start,$end;

   function __construct($source,$start,$end) {
      $this->source = $source;
      $this->start = $start;
      $this->end = $end;
   }

   /**
   * @return \Illuminate\Support\Collection
   */
   public function collection()
   {
      $source =  $this->source;
      $start  =  $this->start;
      $end    =  $this->end;
      $checkSource = sources::where('id',$source)->where('businessID',Auth::user()->businessID)->count();      
      if($checkSource == 0){
         return customer::join('customer_address','customer_address.customerID','=','customers.id')
                           ->where('customers.businessID',Auth::user()->businessID)
                           ->where('customers.category','Lead')
                           ->select('customer_name','primary_phone_number','email','assignedID','statusID','industryID','bill_street','bill_city','bill_state','bill_country','customers.created_at as date')
                           ->whereBetween('customers.created_at', [$start, $end])
                           ->OrderBy('customers.id','DESC')
                           ->get();

      }else{
         return customer::join('customer_address','customer_address.customerID','=','customers.id')
                           ->where('customers.businessID',Auth::user()->businessID)
                           ->where('customers.category','Lead')
                           ->whereBetween('customers.created_at', [$start, $end])
                           ->where('customers.sourceID',$source)
                           ->select('customer_name','primary_phone_number','email','assignedID','statusID','industryID','bill_street','bill_city','bill_state','bill_country','customers.created_at as date')
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
         'Status',
         'Industry',
         'Street',
         'City',
         'State',
         'Country',
         'Date added',
      ];
   }
}
