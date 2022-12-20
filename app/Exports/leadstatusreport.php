<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\finance\customer\customers as customer;
use App\Models\crm\leads\status;
use Auth;

class leadstatusreport implements FromCollection, WithHeadings
{
   protected $statusValue,$start,$end;

   function __construct($statusValue,$start,$end) {
      $this->statusValue = $statusValue;
      $this->start = $start;
      $this->end = $end;
   }

   /**
   * @return \Illuminate\Support\Collection
   */
   public function collection()
   {
      $statusValue =  $this->statusValue;
      $start  =  $this->start;
      $end    =  $this->end;

      $checkStatus = status::where('id',$statusValue)->where('businessID',Auth::user()->businessID)->count();      
      if($checkStatus == 0){
         return customer::join('customer_address','customer_address.customerID','=','customers.id')
                           ->where('customers.businessID',Auth::user()->businessID)
                           ->where('customers.category','Lead')
                           ->select('customer_name','primary_phone_number','email','assignedID','sourceID','industryID','bill_street','bill_city','bill_state','bill_country','customers.created_at as date')
                           ->whereBetween('customers.created_at', [$start, $end])
                           ->OrderBy('customers.id','DESC')
                           ->get();

      }else{
         return customer::join('customer_address','customer_address.customerID','=','customers.id')
                           ->where('customers.businessID',Auth::user()->businessID)
                           ->where('customers.category','Lead')
                           ->whereBetween('customers.created_at', [$start, $end])
                           ->where('customers.statusID',$statusValue)
                           ->select('customer_name','primary_phone_number','email','assignedID','sourceID','industryID','bill_street','bill_city','bill_state','bill_country','customers.created_at as date')
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
         'Sources',
         'Industry',
         'Street',
         'City',
         'State',
         'Country',
         'Date added',
      ];
   }
}
