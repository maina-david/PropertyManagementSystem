@section('stylesheet')
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
@endsection
<div class="col-md-3">
   <div class="panel panel-default">
      <div class="panel-body">
         <ul class="nav nav-pills nav-stacked product">
            <li class="{{ Nav::isRoute('finance.products.edit') }}">
            <a href="{!! route('finance.products.edit',$productID) !!}"> <i class="fa fa-info-circle" aria-hidden="true"></i> Information</a>
            </li>
            <li class="{{ Nav::isRoute('finance.description') }} mt-2">
               <a href="{!! route('finance.description', $productID) !!}"><i class="far fa-file-alt"></i> Description</a>
            </li>
            <li class="{{ Nav::isResource('price') }}">
               <a href="{!! route('finance.price', $productID) !!}"><i class="fal fa-usd-circle"></i> Price</a>
            </li>
            @if($product->type == 'product' || $product->type == 'variants')
               <li class="{{ Nav::isResource('inventory') }}">
                  <a href="{!! route('finance.inventory', $productID) !!}"><i class="fal fa-inventory"></i> Inventory</a>
               </li>
            @endif
            @if($product->type == 'variants')
               <li class="{{ Nav::isRoute('finance.products.variants.index') }}">
                  <a href="{!! route('finance.products.variants.index', $productID) !!}"> <i class="fas fa-boxes"></i> Variants</a>
               </li>
            @endif
            <li class="{{ Nav::isResource('images') }}">
            <a href="{!! route('finance.product.images', $productID) !!}"><i class="fal fa-images"></i> Images</a>
            </li>
            {{-- <li class="{{ Nav::isResource('settings') }}">
               <a href="{!! route('finance.product.settings.edit', $productID) !!}"><i class="far fa-cogs"></i> Settings</a>
            </li> --}}
         </ul>
      </div>
   </div>
</div>
