<?php $__env->startSection('title','Roles'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">        
         <a href="<?php echo route('settings.roles.create'); ?>" class="btn btn-success"><i class="fal fa-plus-circle"></i> Add Roles</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shield-alt"></i> All Roles </h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Role Name</th>
                     <th>Description</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Role Name</th>
                     <th>Description</th>
                     <th width="12%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo e($role->display_name); ?></td>
                        <td><?php echo $role->description; ?></td>
                        <td>
                           <a href="<?php echo route('settings.roles.edit',$role->id); ?>" class="btn btn-primary">Edit</a>
                           <?php if($role->id != 1): ?>
                              <a href="<?php echo route('settings.roles.delete',$role->id); ?>" class="btn btn-danger delete">Delete</a>
                           <?php endif; ?>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/roles/index.blade.php ENDPATH**/ ?>