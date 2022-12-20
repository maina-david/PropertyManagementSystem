<?php $__env->startSection('title','Users '); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a class="btn btn-pink" href="<?php echo route('settings.users.create'); ?>"><i class="fal fa-user-plus"></i> Add New User</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> Users </h1>
      <div class="panel panel-default" data-sortable-id="ui-widget-1">
         <div class="panel-heading">
            <h4 class="panel-title">All User</h4>
         </div>
         <div class="panel-body">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th width="1%"></th>
                     <th width="10%">Name</th>
                     <th width="12%">email</th>
                     <th width="12%">Last Login</th>
                     <th width="12%">Roles</th>
                     <th width="4%">Status</th>
                     <th width="3%"><center>Action</center></th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                           <?php if($user->avatar != ""): ?>
                              <img class="rounded-circle" width="40" height="40" alt="" class="img-circle FL" src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/hr/employee/images/'.$user->avatar); ?>">
                           <?php else: ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo $user->name; ?>&rounded=true&size=32" alt="">
                           <?php endif; ?>
                        </td>
                        <td>
                           <p>
                              <?php echo $user->name; ?>

                              <?php if($user->branch_id != ""): ?>
                                 <br>
                                 <?php if(Hr::check_branch($user->branch_id) == 1): ?>
                                    <span class="badge badge-pink"><?php echo Hr::branch($user->branch_id)->branch_name; ?></span>
                                 <?php endif; ?>
                              <?php endif; ?>
                           </p>
                        </td>
                        <td><?php echo $user->email; ?></td>
                        <td>
                           <?php if($user->last_login != "" && $user->last_login_ip != ""): ?> 
                              <p>
                                 <b>Date :</b> <?php echo date("F jS, Y", strtotime($user->last_login)); ?>@ <?php echo date("h:i:sa", strtotime($user->last_login)); ?><br>
                                 <b>IP :</b> <?php echo $user->last_login_ip; ?>

                              </p>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                              <a href="#" class="badge badge-primary"><?php echo e($role->name); ?></a>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td>
                           <?php if($user->statusID != ""): ?>
                              <span class="btn btn-sm <?php echo Wingu::status($user->statusID)->name; ?>"><?php echo Wingu::status($user->statusID)->name; ?></span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <a href="<?php echo route('settings.users.edit',$user->id); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/users/index.blade.php ENDPATH**/ ?>