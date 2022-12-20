<?php $__env->startSection('title','Add Users'); ?>



<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li>
         <li class="breadcrumb-item"><a href="#">Users</a></li>
         <li class="breadcrumb-item active">Add</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-plus"></i> Add Users </h1>
      <div class="panel panel-default" data-sortable-id="ui-widget-1">
         <div class="panel-heading">
            <h4 class="panel-title">Add User</h4>
         </div>
         <div class="panel-body">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <form action="<?php echo route('settings.users.store'); ?>" method="post" accept-charset="utf-8">
               <?php echo csrf_field(); ?>
               <div class="row">
                  <div class="col-md-6">
                     <div class="column">
                        <div class="field">
                           <div class="form-group">
                              <label for="" class="text-danger">User Name</label>
                              <?php echo Form::text('name',null,['class' => 'form-control', 'required' => '']); ?>

                           </div>
                           <div class="form-group">
                              <label for="" class="text-danger">Email Address</label>
                              <?php echo Form::email('email',null,['class' => 'form-control', 'required' => '']); ?>

                           </div>
                           <div class="form-group">
                              <label for="">Branch</label>
                              <select name="branch" class="from-control multiselect" required>
                                 <option value="">Choose Branch</option>
                                 <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $branch->id; ?>"><?php echo $branch->branch_name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                           <div class="form-group">
                              <label for="" class="text-danger">Password</label>
                              <input type="password" name="password" class="form-control" placeholder="Enter password" required />
                           </div>
                           <div class="form-group">
                              <label for="" class="text-danger">Confirm Password</label>
                              <input type="password" name="password_confirmation" class="form-control" placeholder="Password" required />
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label class="">Roles:</label>
                     <div class="row">
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="col-md-4">
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" id="<?php echo $role->display_name; ?>"  name="roles[]" value="<?php echo e($role->id); ?>"> 
                                 <label class="custom-control-label" for="<?php echo $role->display_name; ?>"><?php echo $role->display_name; ?></label>
                              </div>
                           </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="column">
                     <hr/>                     
                     <button class="btn btn-pink pull-right submit" type="submit"><i class="fas fa-save"></i> Add user</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/users/create.blade.php ENDPATH**/ ?>