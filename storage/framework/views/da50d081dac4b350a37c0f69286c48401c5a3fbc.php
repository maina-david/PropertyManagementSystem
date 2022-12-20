<?php $__env->startSection('title','Edit Item'); ?>
<?php $__env->startSection('stylesheet'); ?>
	<style>
      ul.product li {
         width: 100%;
      }
   </style>
	<link href="<?php echo asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.css'); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>
<?php  
   $property = Wingu::get_account_module_details(1);
?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">Item</a></li>
      <li class="breadcrumb-item active">Edit Item</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Edit Item</h1>
   <!-- end page-header -->
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row">
      <?php echo $__env->make('app.finance.partials._shop_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-9">
         <?php echo Form::model($product, ['route' => ['finance.products.update',$product->productID], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']); ?>

            <?php echo csrf_field(); ?>

            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title"><?php echo $product->product_name; ?> - Information</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required ">
                           <?php echo Form::label('title', 'Item type', array('class'=>'control-label text-danger')); ?>

                           <?php echo e(Form::select('type',[''=>'Choose type','service'=>'Service','product'=>'Standard Product'], null, ['class' => 'form-control multiselect', 'required' => '', 'id' => 'type'])); ?>

                        </div>
                     </div>
                     <?php if($product->type == 'variants'): ?>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required ">
                                 <?php echo Form::label('title', 'Varient Attribute', array('class'=>'control-label')); ?>

                                 <?php echo e(Form::select('attributeID',$attributes, null, ['class' => 'form-control multiselect'])); ?>

                           </div>
                        </div>
                     <?php endif; ?>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'Name', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter Product Name','required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required ">
                           <?php echo Form::label('title', 'Is Item Active', array('class'=>'control-label text-danger')); ?>

                           <?php echo e(Form::select('status',['Yes'=>'Yes','No'=>'No'], null, ['class' => 'form-control multiselect', 'required' => ''])); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'SKU code', array('class'=>'control-label')); ?>

                           <?php echo Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code', 'required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('title', 'Brand', array('class'=>'control-label')); ?>

                           <?php echo e(Form::select('brandID', $brands, null, ['class' => 'form-control multiselect'])); ?>

                        </div>
                     </div>
                     <?php if($property->module_status == 15 && $property->payment_status == 1): ?>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('title', 'Supplier', array('class'=>'control-label')); ?>

                              <?php echo Form::select('supplierID',$suppliers,null,['class' => 'form-control multiselect']); ?>

                           </div>
                        </div>
                     <?php endif; ?>
							<div class="col-md-12">
                        <div class="row">
                           <?php if(Wingu::check_business_modules(7) == 1): ?>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('title', 'Sell on Point-of-Sale', array('class'=>'control-label')); ?>

                                    <?php echo e(Form::select('pos_item',[''=>'Choose option','No'=>'No','Yes'=>'Yes'], null, ['class' => 'form-control multiselect'])); ?>

                                 </div>
                              </div>
                           <?php endif; ?>
                           <?php if(Wingu::check_business_modules(20) == 1): ?>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('title', 'Sell on eCommerce site', array('class'=>'control-label')); ?>

                                    <?php echo e(Form::select('ecommerce_item',[''=>'Choose option','No'=>'No','Yes'=>'Yes'], null, ['class' => 'form-control multiselect'])); ?>

                                 </div>
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="col-md-12">
                     <div class="form-group required form-group-default">
                        <?php echo Form::label('title', 'Product category', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('category[]',$joincat,null,['class' => 'form-control multiple-select2','multiple' => 'multiple'])); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <?php echo Form::label('title', 'Product Tags', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('tags[]',$jointag,null,['class' => 'form-control multiple-tag', 'multiple' => 'multiple'])); ?>

                     </div>
                     <div class="form-group mt-3">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Item</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         <?php echo Form::close(); ?>

      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val(<?php echo json_encode($jointcategories); ?>).trigger('change');
		$(".multiple-tag").select2();
		$(".multiple-tag").select2().val(<?php echo json_encode($jointtags); ?>).trigger('change');
	</script>
	<script>
		$(document).ready(function() {
			$('#size').tagsInput({
				'height':'auto',
				'width':'100%',
				'interactive':true,
				'defaultText':'add a size',
				'removeWithBackspace' : true,
				'placeholderColor' : '#666666'
			});
			$('#color').tagsInput({
				'height':'auto',
				'width':'100%',
				'interactive':true,
				'defaultText':'add a color',
				'removeWithBackspace' : true,
				'placeholderColor' : '#666666'
			});
		});
	</script>
	<script src="<?php echo asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.js'); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/edit.blade.php ENDPATH**/ ?>