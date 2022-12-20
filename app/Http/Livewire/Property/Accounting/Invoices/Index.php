<?php

namespace App\Http\Livewire\Property\Accounting\Invoices;

use Livewire\Component;
use App\Models\property\invoice\invoices;
use Livewire\WithPagination;
use Auth;

class Index extends Component
{
   public $propertyID;
   public $property;
   public $search = '';
   public $perPage = 10;
   public $from = '';
   public $to = '';

   public function render(){
      $propertyID = $this->propertyID;
      $property = $this->property;
      $perPage = $this->perPage;
      $from = $this->from;
      $to = $this->to;

      $query = invoices::search($this->search)
                        ->join('property','property.id','=','property_invoices.propertyID') 
                        ->join('status','status.id','=','property_invoices.statusID')
                        ->where('property_invoices.propertyID',$propertyID)
                        ->where('property_invoices.businessID',Auth::user()->businessID)
                        ->where('property_invoices.invoice_type','Rent')
                        ->select('property_invoices.id as invoiceID','status.name as statusName','property_invoices.invoice_number as invoice_number','tenant_name','invoice_date','balance','total','paid','invoice_due','property_invoices.unitID as unitID','invoice_prefix','property_tenants.id as tenantID','property_invoices.businessID as businessID') 
                        ->orderby('property_invoices.id','desc');
                        

      if($from != '' && $to != ''){
         $fromDate = $from;
         $query->whereBetween('invoice_date',[$from,$to]);
      }
      

      $invoices = $query->simplePaginate($perPage);
      $count = 1;

      return view('livewire.property.accounting.invoices.index', compact('invoices','property'));
   }
}
