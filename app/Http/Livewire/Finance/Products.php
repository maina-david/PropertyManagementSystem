<?php

namespace App\Http\Livewire\Finance;
use App\Models\finance\products\product_information;
use Livewire\Component;
use Auth;
use Livewire\WithPagination;

class Products extends Component
{
   use WithPagination;
   public $perPage = 10;
   public $search = '';
   public $orderBy = 'proID';
   public $orderAsc = true;

   public function render()
   {
     
      $products =  product_information::search($this->search)->join('business','business.id','=','product_information.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->join('product_inventory','product_inventory.productID','=','product_information.id')
                     ->join('product_price','product_price.productID','=','product_information.id')
                     ->where('type','!=','subscription')
                     ->whereNull('parentID')
                     ->where('default_inventory','Yes')
                     ->where('default_price','Yes')
                     ->where('product_information.businessID', Auth::user()->businessID)
                     ->select('product_information.id as proID','product_information.created_at as date','product_price.selling_price as price','product_information.product_name as product_name','currency.symbol as symbol','product_inventory.current_stock as stock','product_information.type as type','product_information.created_at as date','product_information.businessID as businessID')
                     ->orderBy($this->orderBy,$this->orderAsc ? 'desc' : 'asc')
                     ->simplePaginate($this->perPage);

      return view('livewire.finance.products', compact('products'));
   }
}
