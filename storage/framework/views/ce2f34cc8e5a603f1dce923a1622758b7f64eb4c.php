<?php $__env->startSection('title','Product variants'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">Products</a></li>
		<li class="breadcrumb-item active">Edit variants</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-boxes"></i> Product variants</h1>
	<!-- end page-header -->
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="row">
		<?php echo $__env->make('app.finance.partials._shop_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="col-md-9">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Edit variants</h4>
            </div>
            <div class="panel-body">
               <?php echo Form::model($edit, ['route' => ['finance.products.variants.update',$edit->prodID], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('title', 'variant', array('class'=>'control-label')); ?>

                           <?php echo e(Form::select('variant',$values, null, ['class' => 'form-control', 'required' => ''])); ?>

                           <input type="hidden" name="attribute" value="<?php echo $product->attributeID; ?>">
                           <input type="hidden" name="name" value="<?php echo $product->product_name; ?>">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'SKU code', array('class'=>'control-label')); ?>

                           <?php echo Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code')); ?>

                        </div>
                     </div>
                     <div class="col-md-12"><hr></div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'Current Quantity', array('class'=>'control-label')); ?>

                           <?php echo Form::number('current_stock', null, array('class' => 'form-control', 'placeholder' => '0','required' => '','step' => '0.01')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('title', 'Re-order Point', array('class'=>'control-label')); ?>

                           <?php echo Form::number('reorder_level', null, array('class' => 'form-control', 'placeholder' => '0','step' => '0.01')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('title', 'Re-order Quantity:', array('class'=>'control-label')); ?>

                           <?php echo Form::number('replenish_level', null, array('class' => 'form-control', 'placeholder' => '0','step' => '0.01')); ?>

                        </div>
                     </div>
                     <div class="col-md-12"><hr></div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'Buying Price', array('class'=>'control-label')); ?>

                           <?php echo Form::number('buying_price', null, array('class' => 'form-control','placeholder' => 'Buying Price','step' => '0.01','required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'Selling Price Per Unit', array('class'=>'control-label')); ?>

                           <?php echo Form::number('selling_price', null, array('class' => 'form-control', 'placeholder' => 'Selling Price','step' => '0.01','required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('title', 'Offer Price Per Unit', array('class'=>'control-label')); ?>

                           <?php echo Form::number('offer_price', null, array('class' => 'form-control', 'placeholder' => 'Offer Price','step' => '0.01')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('title', 'Tax rule:', array('class'=>'control-label')); ?>

                           <select name="taxID" id="" class="form-control">
                              <option value=""> Choose tax</option>
                              <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $tax->id; ?>"><?php echo $tax->name; ?>-<?php echo $tax->rate; ?>%</option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12"><hr></div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'Image', array('class'=>'control-label')); ?>

                           <?php echo Form::file('image', null, array('class' => 'form-control', 'placeholder' => 'Offer Price','required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <center>
                           <button type="submit" class="btn btn-pink submit">Update changes</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                        </center>
                     </div>
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script>
      $(document).ready(function() {
         $('#sku').on('change', function() {
            if (this.value == 'Custom') {
               $('#custom-sku').show();
            }
            if (this.value == 'Auto') {
               $('#custom-sku').hide();
            }
         });
      });
   </script>
   <script src="<?php echo asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.js'); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/variants/edit.blade.php ENDPATH**/ ?>