<?php $__env->startSection('title','Supplier Category'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Supplier</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.supplier.groups.index'); ?>">Category</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Update Category</h1>
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
                              <th>Name</th>
                              <th width="33%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo $group->name; ?></td>
                              <td>
                                 <a href="<?php echo route('finance.supplier.groups.edit',$group->id); ?>" class="btn btn-pink btn-sm"><i class="far fa-edit"></i> Edit</a>
                                 <a href="<?php echo route('finance.supplier.groups.delete',$group->id); ?>" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i> Delete</a>
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
                  <h4 class="panel-title">Update Category</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     <?php echo Form::model($edit, ['route' => ['finance.supplier.groups.update',$edit->id], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

                        <?php echo csrf_field(); ?>
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('name', 'Name', array('class'=>'control-label')); ?>

                           <?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Group Name','required' => '')); ?>

                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Group</button>
                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/suppliers/groups/edit.blade.php ENDPATH**/ ?>