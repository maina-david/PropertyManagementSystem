<?php

namespace App\Http\Livewire\Property\Utility;

use Livewire\Component;
use App\Models\property\invoice\invoices;
use App\Models\property\utilities;
use Livewire\WithPagination;
use Auth;

class Index extends Component
{
   use WithPagination;

   public $propertyID; 
   public $perPage = 10;
   public $search = '';
   public $utility = '';
    
   public function render()
   {
      $propertyID = $this->propertyID;
      $count = 1;
      $utilities = utilities::where('businessID',Auth::user()->businessID)->get();

      $query =  invoices::search($this->search)
                  ->join('property_invoice_products','property_invoice_products.invoiceID','=','property_invoices.id')    
                  ->join('property_lease_utility','property_lease_utility.leaseID','=','property_invoices.leaseID')                           
                  ->join('business','business.id','=','property_invoices.businessID')
                  ->join('currency','currency.id','=','business.base_currency')
                  ->join('status','status.id','=','property_invoices.statusID')
                  ->where('property_invoices.propertyID',$propertyID)
                  ->where('property_invoices.businessID',Auth::user()->businessID)
                  ->where('property_invoices.invoice_type','Utility')
                  ->select('property_invoice_products.price as unitPrice','property_invoice_products.id as invoiceProductID','property_invoices.id as invoiceID','code','current_units','previous_units','last_reading','item_name','tenant_name','invoice_date','invoice_due','current_units','quantity','total_amount','leaseUtilityID','utility_No','property_invoices.paid as paid','property_invoices.total as invoice_total','status.name as status_name')
                  ->orderby('property_invoices.id','desc');
      if($this->utility != ''){
         $query->where('property_invoices.utilityID',$this->utility);
      }

      $invoices = $query->simplePaginate($this->perPage);

      return view('livewire.property.utility.index', compact('invoices','count','propertyID','utilities'));
   }
}
