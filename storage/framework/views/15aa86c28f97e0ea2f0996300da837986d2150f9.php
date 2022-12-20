<?php $__env->startSection('title','Settings'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">Items</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Items Settings | <?php echo $product->product_name; ?></h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._shop_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <?php echo $product->product_name; ?> -  Settings
               </div>
               <div class="panel-body">
                  <div class="col-md-12">
                     <div class="form-group">
                        <?php echo Form::label('title', 'Online Payment Link', array('class'=>'control-label')); ?>

                        <input type="text" class="form-control" value="<?php echo Wingu::payment_link(); ?>/product/<?php echo Wingu::business()->businessID; ?>/<?php echo $product->product_code; ?>" readonly>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/settings.blade.php ENDPATH**/ ?>