<?php $__env->startSection('stylesheet'); ?>
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
<?php $__env->stopSection(); ?>
<div class="col-md-3">
   <div class="panel panel-default">
      <div class="panel-body">
         <ul class="nav nav-pills nav-stacked product">
            <li class="<?php echo e(Nav::isRoute('finance.products.edit')); ?>">
            <a href="<?php echo route('finance.products.edit',$productID); ?>"> <i class="fa fa-info-circle" aria-hidden="true"></i> Information</a>
            </li>
            <li class="<?php echo e(Nav::isRoute('finance.description')); ?> mt-2">
               <a href="<?php echo route('finance.description', $productID); ?>"><i class="far fa-file-alt"></i> Description</a>
            </li>
            <li class="<?php echo e(Nav::isResource('price')); ?>">
               <a href="<?php echo route('finance.price', $productID); ?>"><i class="fal fa-usd-circle"></i> Price</a>
            </li>
            <?php if($product->type == 'product' || $product->type == 'variants'): ?>
               <li class="<?php echo e(Nav::isResource('inventory')); ?>">
                  <a href="<?php echo route('finance.inventory', $productID); ?>"><i class="fal fa-inventory"></i> Inventory</a>
               </li>
            <?php endif; ?>
            <?php if($product->type == 'variants'): ?>
               <li class="<?php echo e(Nav::isRoute('finance.products.variants.index')); ?>">
                  <a href="<?php echo route('finance.products.variants.index', $productID); ?>"> <i class="fas fa-boxes"></i> Variants</a>
               </li>
            <?php endif; ?>
            <li class="<?php echo e(Nav::isResource('images')); ?>">
            <a href="<?php echo route('finance.product.images', $productID); ?>"><i class="fal fa-images"></i> Images</a>
            </li>
            
         </ul>
      </div>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/partials/_shop_menu.blade.php ENDPATH**/ ?>