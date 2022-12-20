<?php

namespace App\Http\Livewire\Finance\Customers;

use Livewire\Component;
use App\Models\finance\customer\customers;
use Livewire\WithPagination;
use Auth;
class Index extends Component
{
   use WithPagination;
   public $perPage = 10;
   public $search = '';
   public function render()
   {
      $contacts = customers::search($this->search)->join('business','business.id','=','customers.businessID')
								->where('customers.businessID',Auth::user()->businessID)
								->whereNull('category')
								->select('*','customers.id as customerID','customers.created_at as date_added','business.businessID as business_code','customers.businessID as businessID')
								->OrderBy('customers.id','DESC')
								->simplePaginate($this->perPage);
      $count = 1;

      return view('livewire.finance.customers.index', compact('contacts','count'));
   }
}
