<?php $__env->startSection('title','Product Attributes | Value'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.attributes'); ?>">Product Attributes</a></li>
         <li class="breadcrumb-item">Values</li>
         <li class="breadcrumb-item active"><?php echo $attribute->name; ?></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Attributes > <?php echo $attribute->name; ?></h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>Value</th>
                              <th width="20%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $value->value; ?></td>
                                    <td>
                                       <a href="<?php echo e(route('finance.product.attributes.value.edit', $value->id)); ?>" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                       <?php if (app('laratrust')->isAbleTo('delete-productcategory')) : ?>
                                       <a href="<?php echo route('finance.product.attributes.value.delete', $value->id); ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                       <?php endif; // app('laratrust')->permission ?>
                                    </td>
                              </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Add value</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     <?php echo Form::open(array('route' => 'finance.product.attributes.value.store')); ?>

                        <?php echo csrf_field(); ?>
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('value', 'value', array('class'=>'control-label')); ?>

                           <?php echo Form::text('value', null, array('class' => 'form-control', 'placeholder' => 'Enter value','required' => '')); ?>

                           <input type="hidden" value="<?php echo $attribute->id; ?>" name="attributeID" required>
                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add value</button>
                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                           </center>
                        </div>
                     <?php echo Form::close(); ?>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/attributes/values/index.blade.php ENDPATH**/ ?>