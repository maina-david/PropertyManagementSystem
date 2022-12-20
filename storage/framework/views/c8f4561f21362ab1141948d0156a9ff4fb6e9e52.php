<?php $__env->startSection('title','Items Images'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">Items</a></li>
         <li class="breadcrumb-item active">Item Images</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-images"></i> Item Images | <?php echo $product->product_name; ?> </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._shop_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title"><?php echo $product->product_name; ?> - Item Images</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="col-sm-12">
                           <button class="btn btn-pink" data-toggle="modal" data-target="#custom-width-modal" style="float:right"><i class="fa fa-upload"></i> Upload Images</button>
                        </div>
                     </div>
                  </div>
					   <br>
                  <div class="col-md-12">
                     <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th style="width:2%">#</th>
                              <th>cover</th>
                              <th>Name</th>
                              <th>File Size</th>
                              <th>File Mime</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td><?php echo e($count++); ?></td>
                                 <td style="width:12%">
                                    <center><img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/finance/products/'. $image->file_name); ?>" width="80px" height="60px"></center>
                                 </td>
                                 <td><?php echo $image->caption; ?></td>
                                 <td><?php echo $image->file_size/100000; ?> mb</td>
                                 <td><?php echo $image->file_mime; ?></td>
                                 <td style="width:27%">
                                    <?php if($image->cover == 0): ?>
                                       <center style="float:left;">
                                          <?php echo Form::model($image, ['route' => ['finance.product.images.update',$image->id], 'method'=>'post']); ?>

                                          <?php echo Form::hidden('product_id', $product->id); ?>

                                          <?php echo Form::Submit('Make Cover Image',['class'=>'btn btn-info']); ?>

                                          <?php echo Form::close(); ?>

                                       </center>
                                    <?php else: ?>
                                       <a href="#" class="btn btn-success" style="width:134px;">is cover</a>
                                    <?php endif; ?>
                                    <center style="float:right;">
                                       <?php echo Form::open(['route' => ['finance.product.images.destroy', $image->id],'method'=>'post']); ?>

                                       <?php echo Form::hidden('product_image_id', $image->product_image_id); ?>

                                       <?php echo Form::Submit('Delete',['class'=>'btn btn-danger delete']); ?>

                                       <?php echo Form::close(); ?>

                                    </center>
                                 </td>
                              </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                     </table>
                  </div>
	            </div>
	         </div>
         </div>
      </div>
   </div>
   <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" style="width:100%;">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="custom-width-modalLabel">Upload your images</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <?php echo Form::open(array('route' => 'finance.product.images.store','class'=>'dropzone','id'=>'addimages','action' => 'post')); ?>

                  <?php echo csrf_field(); ?>
                  <?php echo e(Form::hidden('productID',$productID)); ?>

               <?php echo Form::close(); ?>

            </div>
            <div class="modal-footer">
               <a href="#" class="btn btn-pink" onClick="window.location.href=window.location.href">Save changes</a>
            </div>
         </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/images.blade.php ENDPATH**/ ?>