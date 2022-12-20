<?php $__env->startSection('title'); ?> Update User <?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;"><?php echo trans('general.settings'); ?></a></li>
         <li class="breadcrumb-item"><a href="#">Users</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Update User</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	   <div class="panel panel-default" data-sortable-id="ui-widget-1">
         <div class="panel-heading">
            <h4 class="panel-title">Update User</h4>
         </div>
         <div class="panel-body">            
            <?php echo Form::model($user, ['route' => ['settings.users.update',$user->id], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

               <?php echo e(csrf_field()); ?>

               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo e($user->name); ?>" required>
                     </div>
                     <?php if($user->id != Wingu::business()->userID): ?>                       
                        <div class="form-group">
                           <label for="email" class="">Email:</label>
                           <input type="text" class="form-control" name="email" id="email" value="<?php echo e($user->email); ?>" required>
                        </div> 
                     <?php endif; ?>
                     <div class="form-group">
                        <label for="">Branch</label>
                        <?php echo Form::select('branch',$branches,null,['class'=>'form-control multiselect','required'=>'']); ?>

                     </div>
                  </div>
                  <?php if($user->id != Wingu::business()->userID): ?>
                     <div class="col-md-6">
                        <label for="roles" class="">Roles:</label>
                        <div class="row">
                           <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <div class="col-md-4">
                                 <input type="checkbox" name="roles[]" value="<?php echo e($role->id); ?>" <?php if($user->roles->contains($role->id)): ?> checked <?php endif; ?>> <?php echo $role->display_name; ?></input>
                              </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                     </div>
                  <?php endif; ?>
               </div>
               <div class="col-md-12">
                  <div class="column">
                     <hr />
                     <button class="btn btn-pink pull-right submit" type="submit"><i class="fas fa-save"></i> Update user</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                  </div>
               </div>
            <?php echo Form::close(); ?>

         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/users/edit.blade.php ENDPATH**/ ?>