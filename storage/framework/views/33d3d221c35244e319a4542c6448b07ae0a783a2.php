<?php $__env->startSection('title','Product Description'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">Items</a></li>
         <li class="breadcrumb-item active">Description</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Items Description | <?php echo $product->product_name; ?> </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._shop_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <?php echo Form::model($product, ['route' => ['finance.description.update',$product->id], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']); ?>

               <?php echo csrf_field(); ?>

               <div class="panel panel-default">
						<div class="panel-heading">
							<?php echo $product->product_name; ?> -  Description
						</div>
                  <div class="panel-body">
                     <div class="col-md-12">
                        <div class="form-group">
                           <?php echo Form::label('title', 'Short Description (displayed on invoice)', array('class'=>'control-label')); ?>

                           <?php echo Form::textarea('short_description',null,['class'=>'form-control', 'rows' => 5, 'placeholder'=>'Short Description']); ?>

                        </div>
                        <div class="form-group">
                           <?php echo Form::label('title', 'Description', array('class'=>'control-label')); ?>

                           <?php echo Form::textarea('description',null,['class'=>'ckeditor form-control','rows' => 5, 'placeholder'=>'content']); ?>

                        </div>
                        <div class="form-group mt-3">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Items</button>
                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
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
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/description.blade.php ENDPATH**/ ?>