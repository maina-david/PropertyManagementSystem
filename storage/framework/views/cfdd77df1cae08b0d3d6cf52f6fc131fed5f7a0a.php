<div class="row">
   <div class="col-lg-7">
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="card">
         <div class="card-body">
            <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter product name or sku code">
         </div>
      </div>
      <div class="row" id="product">
         <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($product->businessID == Auth::user()->businessID): ?>
               <?php
                  $checkStoreLink = Finance::check_product_store_link($product->proID);
               ?>
               
               <div class="col-md-2 col-sm-2 mb-3">
                  <!-- BEGIN item -->
                  <div class="item item-thumbnail">
                     <?php if($product->type == 'variants'): ?>
                        <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg<?php echo $product->proID; ?>" class="item-image">
                     <?php else: ?>
                        <?php if($product->track_inventory == 'Yes'): ?>
                           <!-- check if the product is linked to a specific store -->
                           <?php if($checkStoreLink == 1): ?>
                              <?php
                                 $checkCurrentStock = Finance::inventory($product->proID)->current_stock;
                              ?>
                              <!-- check if has stock -->
                              <?php if($checkCurrentStock == 0 || $checkCurrentStock == NULL): ?>
                                 <a href="#" class="item-image">
                              <?php else: ?>
                                 <a wire:click="addToCart(<?php echo e($product->proID); ?>)" class="item-image">
                              <?php endif; ?>
                           <?php elseif($checkStoreLink > 1): ?>
                              <!-- product is linked to a store -->
                              <?php
                                 $storeInventory = Finance::store_inventory($product->proID)->current_stock;
                              ?>
                              <!-- get product store inventory -->
                              <?php if($storeInventory == 0 || $storeInventory == NULL): ?>
                                 <a href="#" class="item-image">
                              <?php else: ?>
                                 <a wire:click="addToCart(<?php echo e($product->proID); ?>)" class="item-image">
                              <?php endif; ?>
                           <?php endif; ?>
                        <?php else: ?>
                           <a wire:click="addToCart(<?php echo e($product->proID); ?>)" class="item-image">
                        <?php endif; ?>
                     <?php endif; ?>
                     <?php if(Finance::check_product_image($product->proID) == 1): ?>
                        <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/products/'.Finance::product_image($product->proID)->file_name); ?>">
                     <?php else: ?>
                        <img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>">
                     <?php endif; ?>
                        <?php if($product->track_inventory == 'Yes'): ?>
                           <?php if($checkStoreLink == 1): ?>
                              <?php
                                 $checkCurrentStock = Finance::inventory($product->proID)->current_stock;
                              ?>
                              <?php if($checkCurrentStock == 0 || $checkCurrentStock == NULL): ?>
                                 <div class="discount">No Stock</div>
                              <?php else: ?> 
                                 <center><div class="discount bg-green">IN: <?php echo number_format($checkCurrentStock); ?></div></center>
                              <?php endif; ?>
                           <?php elseif($checkStoreLink > 1): ?>
                              <?php
                                 $storeInventory = Finance::store_inventory($product->proID)->current_stock;
                              ?>
                              <?php if($storeInventory == 0 || $storeInventory == NULL): ?>
                                 <div class="discount">No Stock</div>
                              <?php else: ?> 
                                 <center><div class="discount bg-green">IN: <?php echo number_format($storeInventory); ?></div></center>
                              <?php endif; ?>
                           <?php endif; ?>
                        <?php else: ?> 
                           <center><div class="discount bg-pink">In Stock</div></center>
                        <?php endif; ?>
                     </a>
                     <div class="item-info mt-1">
                        <h4 class="item-title">
                           <?php if($product->type == 'variants'): ?>
                              <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg<?php echo $product->proID; ?>"><?php echo $product->product_name; ?></a>
                           <?php else: ?>
                              <a href="#"><?php echo $product->product_name; ?></a>
                           <?php endif; ?>
                        </h4>
                        <!--check if price is default accrose stores -->
                        <?php if($product->same_price == 'No'): ?>
                           <span class="text-pink"><b><?php echo $product->symbol; ?><?php echo number_format(Finance::store_price($product->proID)->selling_price,2); ?></b></span>
                        <?php else: ?>
                           <span class="text-pink"><b><?php echo $product->symbol; ?><?php echo number_format($product->selling_price,2); ?></b></span>
                        <?php endif; ?>
                     </div>
                  </div>
                  <!-- END item -->
               </div>
               
            <?php endif; ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <div class="col-md-12 mt-3">
            <?php echo e($products->links()); ?>

         </div>
      </div>
   </div>
   <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padding-right">
      <h4>Sales Person : <span class="float-right text-primary font-weight-bolder"><?php echo Auth::user()->name; ?></span></h4>
      <div class="row mb-3">
         <div class="col-md-4">
            
         </div>
         <div class="col-md-4">
            
         </div>
         <div class="col-md-4">
            <a href="<?php echo route('pos.cancel.order'); ?>" class="btn btn-block btn-pink delete"><i class="fal fa-times-circle"></i> Cancel Sale</a>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4><b>Outlet :</b> <?php echo Hr::branch(Auth::user()->branch_id)->branch_name; ?> </h4>
               </div>
               <div class="card-body text-center">
                  <?php if($cartItems != Null): ?>
                     <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="accordion" id="accordionExample">
                           <div class="card">
                              <div class="card-header" id="headingTwo">
                                 <div class="row">
                                    <div class="col-md-1">
                                       <p><?php echo $cart->qty; ?></p>
                                    </div>
                                    <div class="col-md-7">
                                       <a href="#" class="collapsed text-primary" data-toggle="collapse" data-target="#collapse<?php echo $cart->id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $cart->id; ?>">
                                          <?php echo $cart->product_name; ?>

                                       </a>
                                    </div>
                                    <div class="col-md-4">
                                       <p>
                                          <?php echo $symbol; ?><?php echo number_format(($cart->total_amount),2); ?>

                                          <a href="#" class="float-right text-pink collapsed" data-toggle="collapse" data-target="#collapse<?php echo $cart->id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $cart->id; ?>"><i class="fas fa-ellipsis-v"></i></a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div id="collapse<?php echo $cart->id; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                 <div class="card-body">
                                    <form class="row" action="<?php echo route('pos.update.cart',$cart->id); ?>" method="post">
                                       <?php echo csrf_field(); ?>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Quantity</label>
                                             <input type="text" name="quantity" class="form-control" value="<?php echo $cart->qty; ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Price</label>
                                             <input type="text" name="price" class="form-control" value="<?php echo $cart->price; ?>" readonly>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Discount</label>
                                             <input type="text" class="form-control" value="<?php echo $cart->discount; ?>" name="discount">
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <textarea type="text" name="note" class="form-control" placeholder="Type to add note" cols="5" rows="5"><?php echo $cart->note; ?></textarea>
                                          </div>
                                       </div>
                                       <div class="col-md-12 mt-3">
                                          <div class="float-left">
                                             <a class="btn btn-sm btn-danger delete" href="<?php echo route('pos.remove.cart.item',$cart->id); ?>"><i class="fas fa-trash"></i> Delete Item</a>
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
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                     <h3>Empty Cart</h3>
                  <?php endif; ?>
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <table class="table">
                     <thead>
                        <tr>
                           <th><h3>Subtotal:</h3></th>
                           <th><h3><?php echo $symbol; ?><?php echo number_format($cartItems->sum('amount'),2); ?></h3></th>
                        </tr>
                        <tr>
                           <th><h3>Discount:</h3></th>
                           <th><h3><?php echo $symbol; ?><?php echo number_format($cartItems->sum('discount'),2); ?></h3></th>
                        </tr>
                        <tr>
                           <th><h3>Tax:</h3></th>
                           <th>
                              <?php if(Session::has('taxRate')): ?>
                                 <div class="row">
                                    <div class="col-md-8">
                                       <h3><?php echo Session::get('taxRate')['rate']; ?>%</h3>
                                    </div>
                                    <div class="col-md-4">
                                       <a href="<?php echo route('pos.sale.remove.tax'); ?>" class="btn btn-danger btn-sm">Remove</a>
                                    </div>
                                 </div>
                              <?php else: ?>
                                 <form class="row" action="<?php echo route('pos.sale.tax.apply'); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-md-8">
                                       <select class="form-control multiselect" name="taxRate" required>
                                          <option value="0">Choose Tax</option>
                                          <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo $tax->rate; ?>"><?php echo $tax->name; ?>-<?php echo $tax->rate; ?>%</option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </select>
                                    </div>
                                    <div class="col-md-4">
                                       <button class="btn btn-success" type="submit">Apply</button>
                                    </div>
                                 </form>
                              <?php endif; ?>
                           </th>
                        </tr>
                        <tr>
                           <th><h3>Total:</h3></th>
                           <th>
                              <?php if(Session::has('taxRate')): ?>
                                 <?php 
                                    $rate = session()->get('taxRate')['rate']/100;
                                    $amount = $cartItems->sum('total_amount') * $rate;
                                    $total = $amount + $cartItems->sum('total_amount');
                                 ?>
                                 <h3><?php echo $symbol; ?><?php echo number_format($total,2); ?></h3>
                              <?php else: ?>
                                 <h3><?php echo $symbol; ?><?php echo number_format($cartItems->sum('total_amount'),2); ?></h3>
                              <?php endif; ?>
                           </th>
                        </tr>
                     </thead>
                  </table>
                  <?php if($cartItems->sum('qty') > 0): ?>
                     <div class="row">
                        <div class="col-md-12 mt-4">
                           <a class="btn btn-primary btn-lg btn-block" href="<?php echo route('pos.sale.checkout'); ?>"> Checkout and pay</a>
                        </div>
                     </div>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/livewire/pos/terminal.blade.php ENDPATH**/ ?>