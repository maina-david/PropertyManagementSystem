<?php

namespace App\Http\Livewire\Property\Tenants;

use Livewire\Component;
use App\Models\property\tenants\tenants;
use Livewire\WithPagination;
use Auth;

class Index extends Component
{
   public $search = '';
   public $perPage = 10;

   public function render(){
      $perPage = $this->perPage;
      $tenants = tenants::search($this->search)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->simplePaginate($perPage);
      $count = 1;

      return view('livewire.property.tenants.index', compact('tenants','count'));
   }
}
