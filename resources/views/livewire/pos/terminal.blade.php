<div class="row">
   <div class="col-lg-7">
      @include('partials._messages')
      <div class="card">
         <div class="card-body">
            <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter product name or sku code">
         </div>
      </div>
      <div class="row" id="product">
         @foreach($products as $product)
            @if($product->businessID == Auth::user()->businessID)
               @php
                  $checkStoreLink = Finance::check_product_store_link($product->proID);
               @endphp
               {{-- @if($product->track_inventory == 'Yes') --}}
               <div class="col-md-2 col-sm-2 mb-3">
                  <!-- BEGIN item -->
                  <div class="item item-thumbnail">
                     @if($product->type == 'variants')
                        <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg{!! $product->proID !!}" class="item-image">
                     @else
                        @if($product->track_inventory == 'Yes')
                           <!-- check if the product is linked to a specific store -->
                           @if($checkStoreLink == 1)
                              @php
                                 $checkCurrentStock = Finance::inventory($product->proID)->current_stock;
                              @endphp
                              <!-- check if has stock -->
                              @if($checkCurrentStock == 0 || $checkCurrentStock == NULL)
                                 <a href="#" class="item-image">
                              @else
                                 <a wire:click="addToCart({{$product->proID}})" class="item-image">
                              @endif
                           @elseif($checkStoreLink > 1)
                              <!-- product is linked to a store -->
                              @php
                                 $storeInventory = Finance::store_inventory($product->proID)->current_stock;
                              @endphp
                              <!-- get product store inventory -->
                              @if($storeInventory == 0 || $storeInventory == NULL)
                                 <a href="#" class="item-image">
                              @else
                                 <a wire:click="addToCart({{$product->proID}})" class="item-image">
                              @endif
                           @endif
                        @else
                           <a wire:click="addToCart({{$product->proID}})" class="item-image">
                        @endif
                     @endif
                     @if(Finance::check_product_image($product->proID) == 1)
                        <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/products/'.Finance::product_image($product->proID)->file_name) !!}">
                     @else
                        <img src="{!! asset('assets/img/product_placeholder.jpg') !!}">
                     @endif
                        @if($product->track_inventory == 'Yes')
                           @if($checkStoreLink == 1)
                              @php
                                 $checkCurrentStock = Finance::inventory($product->proID)->current_stock;
                              @endphp
                              @if($checkCurrentStock == 0 || $checkCurrentStock == NULL)
                                 <div class="discount">No Stock</div>
                              @else 
                                 <center><div class="discount bg-green">IN: {!! number_format($checkCurrentStock) !!}</div></center>
                              @endif
                           @elseif($checkStoreLink > 1)
                              @php
                                 $storeInventory = Finance::store_inventory($product->proID)->current_stock;
                              @endphp
                              @if($storeInventory == 0 || $storeInventory == NULL)
                                 <div class="discount">No Stock</div>
                              @else 
                                 <center><div class="discount bg-green">IN: {!! number_format($storeInventory) !!}</div></center>
                              @endif
                           @endif
                        @else 
                           <center><div class="discount bg-pink">In Stock</div></center>
                        @endif
                     </a>
                     <div class="item-info mt-1">
                        <h4 class="item-title">
                           @if($product->type == 'variants')
                              <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg{!! $product->proID !!}">{!! $product->product_name !!}</a>
                           @else
                              <a href="#">{!! $product->product_name !!}</a>
                           @endif
                        </h4>
                        <!--check if price is default accrose stores -->
                        @if($product->same_price == 'No')
                           <span class="text-pink"><b>{!! $product->symbol !!}{!! number_format(Finance::store_price($product->proID)->selling_price,2) !!}</b></span>
                        @else
                           <span class="text-pink"><b>{!! $product->symbol !!}{!! number_format($product->selling_price,2) !!}</b></span>
                        @endif
                     </div>
                  </div>
                  <!-- END item -->
               </div>
               {{-- @if($product->type == 'variants')
                  <!-- Modal -->
                  <div class="modal fade bd-example-modal-lg{!! $product->proID !!}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Choose </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <div class="row">
                                 <div class="col-md-12">
                                    <table class="table table-table-striped">
                                       @foreach (Finance::products_variants($product->proID) as $variable)
                                          <tr>
                                             <td>{!! $variable->value !!}</td>
                                             <td width="40%">
                                                <a href="{!! route('add.to.order', $variable->prodID) !!}" class="btn btn-success btn-sm float-right">
                                                   <i class="fa fa-check-circle-o" aria-hidden="true"></i> choose this {!! Finance::products_attributes($product->attributeID)->name !!}
                                                </a>
                                             </td>
                                          </tr>
                                       @endforeach
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
                  </div>
               @endif --}}
            @endif
         @endforeach
         <div class="col-md-12 mt-3">
            {{ $products->links() }}
         </div>
      </div>
   </div>
   <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padding-right">
      <h4>Sales Person : <span class="float-right text-primary font-weight-bolder">{!! Auth::user()->name !!}</span></h4>
      <div class="row mb-3">
         <div class="col-md-4">
            {{-- <a href="#" class="btn btn-block btn-pink"><i class="fas fa-sync-alt"></i> Retrieve Sale</a> --}}
         </div>
         <div class="col-md-4">
            {{-- <a href="#" class="btn btn-block btn-pink"><i class="fas fa-history"></i> Park Sale</a> --}}
         </div>
         <div class="col-md-4">
            <a href="{!! route('pos.cancel.order') !!}" class="btn btn-block btn-pink delete"><i class="fal fa-times-circle"></i> Cancel Sale</a>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4><b>Outlet :</b> {!! Hr::branch(Auth::user()->branch_id)->branch_name !!} </h4>
               </div>
               <div class="card-body text-center">
                  @if($cartItems != Null)
                     @foreach($cartItems as $cart)
                        <div class="accordion" id="accordionExample">
                           <div class="card">
                              <div class="card-header" id="headingTwo">
                                 <div class="row">
                                    <div class="col-md-1">
                                       <p>{!! $cart->qty !!}</p>
                                    </div>
                                    <div class="col-md-7">
                                       <a href="#" class="collapsed text-primary" data-toggle="collapse" data-target="#collapse{!! $cart->id !!}" aria-expanded="false" aria-controls="collapse{!! $cart->id !!}">
                                          {!! $cart->product_name !!}
                                       </a>
                                    </div>
                                    <div class="col-md-4">
                                       <p>
                                          {!! $symbol !!}{!! number_format(($cart->total_amount),2) !!}
                                          <a href="#" class="float-right text-pink collapsed" data-toggle="collapse" data-target="#collapse{!! $cart->id !!}" aria-expanded="false" aria-controls="collapse{!! $cart->id !!}"><i class="fas fa-ellipsis-v"></i></a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div id="collapse{!! $cart->id !!}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                 <div class="card-body">
                                    <form class="row" action="{!! route('pos.update.cart',$cart->id) !!}" method="post">
                                       @csrf
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Quantity</label>
                                             <input type="text" name="quantity" class="form-control" value="{!! $cart->qty !!}" required>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Price</label>
                                             <input type="text" name="price" class="form-control" value="{!! $cart->price !!}" readonly>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Discount</label>
                                             <input type="text" class="form-control" value="{!! $cart->discount !!}" name="discount">
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <textarea type="text" name="note" class="form-control" placeholder="Type to add note" cols="5" rows="5">{!! $cart->note !!}</textarea>
                                          </div>
                                       </div>
                                       <div class="col-md-12 mt-3">
                                          <div class="float-left">
                                             <a class="btn btn-sm btn-danger delete" href="{!! route('pos.remove.cart.item',$cart->id) !!}"><i class="fas fa-trash"></i> Delete Item</a>
                                          </div>
                                          <div class="float-right">
                                             <button class="btn btn-sm btn-success" type="submit"><i class="fas fa-save"></i> Update Item</button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     @endforeach
                  @else
                     <h3>Empty Cart</h3>
                  @endif
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <table class="table">
                     <thead>
                        <tr>
                           <th><h3>Subtotal:</h3></th>
                           <th><h3>{!! $symbol !!}{!! number_format($cartItems->sum('amount'),2) !!}</h3></th>
                        </tr>
                        <tr>
                           <th><h3>Discount:</h3></th>
                           <th><h3>{!! $symbol !!}{!! number_format($cartItems->sum('discount'),2) !!}</h3></th>
                        </tr>
                        <tr>
                           <th><h3>Tax:</h3></th>
                           <th>
                              @if(Session::has('taxRate'))
                                 <div class="row">
                                    <div class="col-md-8">
                                       <h3>{!! Session::get('taxRate')['rate'] !!}%</h3>
                                    </div>
                                    <div class="col-md-4">
                                       <a href="{!! route('pos.sale.remove.tax') !!}" class="btn btn-danger btn-sm">Remove</a>
                                    </div>
                                 </div>
                              @else
                                 <form class="row" action="{!! route('pos.sale.tax.apply') !!}" method="POST">
                                    @csrf
                                    <div class="col-md-8">
                                       <select class="form-control multiselect" name="taxRate" required>
                                          <option value="0">Choose Tax</option>
                                          @foreach($taxes as $tax)
                                             <option value="{!! $tax->rate !!}">{!! $tax->name !!}-{!! $tax->rate !!}%</option>
                                          @endforeach
                                       </select>
                                    </div>
                                    <div class="col-md-4">
                                       <button class="btn btn-success" type="submit">Apply</button>
                                    </div>
                                 </form>
                              @endif
                           </th>
                        </tr>
                        <tr>
                           <th><h3>Total:</h3></th>
                           <th>
                              @if(Session::has('taxRate'))
                                 @php 
                                    $rate = session()->get('taxRate')['rate']/100;
                                    $amount = $cartItems->sum('total_amount') * $rate;
                                    $total = $amount + $cartItems->sum('total_amount');
                                 @endphp
                                 <h3>{!! $symbol !!}{!! number_format($total,2) !!}</h3>
                              @else
                                 <h3>{!! $symbol !!}{!! number_format($cartItems->sum('total_amount'),2) !!}</h3>
                              @endif
                           </th>
                        </tr>
                     </thead>
                  </table>
                  @if($cartItems->sum('qty') > 0)
                     <div class="row">
                        <div class="col-md-12 mt-4">
                           <a class="btn btn-primary btn-lg btn-block" href="{!! route('pos.sale.checkout') !!}"> Checkout and pay</a>
                        </div>
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
