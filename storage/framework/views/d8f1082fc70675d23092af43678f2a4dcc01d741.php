<?php $__env->startSection('title'); ?> <?php echo $details->product_name; ?> | Items  <?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <?php if (app('laratrust')->isAbleTo('update-products')) : ?>
         <a href="<?php echo e(route('finance.products.edit', $details->proID)); ?>"  class="btn btn-primary ml-1"><i class="fal fa-pen-fancy"></i></a>
      <?php endif; // app('laratrust')->permission ?>
      
      <?php if (app('laratrust')->isAbleTo('delete-products')) : ?>
         <a href="<?php echo route('finance.products.destroy', $details->proID); ?>" class="btn btn-danger ml-1 delete">Delete</a>
      <?php endif; // app('laratrust')->permission ?>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><?php echo $details->product_name; ?></h1>
   <div class="row">
      <div class="col-md-12">
         <ul class="nav nav-tabs">
            <li class="nav-item <?php echo Nav::isRoute('finance.products.details'); ?>">
               <a class="nav-link <?php echo Nav::isRoute('finance.products.details'); ?>" href="#"><i class="fal fa-info-circle"></i> Overview</a>
            </li>
            
         </ul>        
      </div>
      <?php if(Request::is('finance/items/'.$details->proID.'/details')): ?>
         <?php echo $__env->make('app.finance.products.details.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
   </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/details/show.blade.php ENDPATH**/ ?>