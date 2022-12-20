<div>
    <div class="row mb-3">
       <div class="col-md-3">
          <label for="">Search</label>
          <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Product name">
       </div>
       <div class="col-md-3">
          <label for="">Order By</label>
          <select wire:model="orderBy" class="form-control">
             <option value="proID">ID</option>
             <option value="product_name">Name</option>
             <option value="date">Date</option>
             <option value="price">Price</option>
             <option value="stock">Current Stock</option>
          </select>
       </div>
       <div class="col-md-3">
          <label for="">Order</label>
          <select wire:model="orderAsc" class="form-control">
             <option value="1">Ascending</option>
             <option value="0">Descending</option>
          </select>
       </div>
       <div class="col-md-3">
          <label for="">Items Per</label>
          <select wire:model="perPage" class="form-control">`
             <option value="10" selected>10</option>
             <option value="25">25</option>
             <option value="50">50</option>
             <option value="100">100</option>
          </select>
       </div>
    </div>
    <div class="panel panel-default">
       <div class="panel-body">         
          <table class="table table-striped table-bordered">
             <thead>
                <tr>
                   <th width="1%"><input type="checkbox" name="" class="i-checks" id=""></th>
                   <th width="5%">Image</th>
                   <th>Name</th>
                   <th width="10%">Price</th>
                   <th width="13%">Current Stock</th>
                   <th width="15%">Created at</th>
                   <th width="12%">Actions</th>
                </tr>
             </thead>
             <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <?php if($product->businessID == Auth::user()->businessID): ?>
                     <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td>
                           <center>
                           <?php if(Finance::check_product_image($product->proID) == 1): ?>
                              <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/finance/products/'.Finance::product_image($product->proID)->file_name); ?>" width="80px" height="60px">
                           <?php else: ?>
                              <img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>" width="80px" height="60px">
                           <?php endif; ?>
                           </center>
                        </td>
                        <td><?php echo $product->product_name; ?></td>
                        <td>
                           <?php echo $product->symbol; ?><?php echo number_format($product->price); ?>

                        </td>
                        <td>
                           <?php echo $product->stock; ?>

                        </td>
                        <td><?php echo date('F d, Y', strtotime($product->date)); ?></td>
                        <td>
                           <a href="<?php echo e(route('pos.products.details', $product->proID)); ?>" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                           <a href="<?php echo e(route('pos.products.edit', $product->proID)); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="<?php echo route('pos.products.destroy', $product->proID); ?>" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                   <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </tbody>
          </table>
          <?php echo $products->links(); ?>

       </div>
    </div>
 </div>
 <?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/livewire/pos/products.blade.php ENDPATH**/ ?>