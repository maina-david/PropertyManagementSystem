<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\finance\suppliers\suppliers as supplier;
use Auth;

class suppliers implements FromCollection, WithHeadings
{
   /**
 * @return \Illuminate\Support\Collection
   */
   public function collection()
   {
      return supplier::join('supplier_address','supplier_address.supplierID','=','suppliers.id')
                           ->where('supplier_address.businessID', Auth::user()->businessID)
                           ->select('contactType','position','department','salutation','supplierName','email','emailCC','otherPhoneNumber','primaryPhoneNumber','website','facebook','twitter','linkedin','bill_attention','bill_street','bill_city','bill_state','bill_postal_address','bill_zip_code')
                           ->get();
   }

   public function headings(): array
   {
      return [
         'contact type',
         'Position',
         'Department',
         'Salutation',
         'Supplier name',
         'Email',
         'Email cc',
         'Other phone number',
         'Primary phone number',
         'Website',
         'facebook',
         'Twitter',
         'Linkedin',
         'Bill attention',
         'Bill street',
         'Bill city',
         'Bill state',
         'Bill postal address',
         'Bill zip code',
      ];
   }
}
