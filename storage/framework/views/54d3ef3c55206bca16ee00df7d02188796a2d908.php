<?php $__env->startSection('title','Leave Settings'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item active">Leave</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-calendar-times"></i>  Leave Settings</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.hr.partials._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('hrm.leave.settings.type')); ?>" href="<?php echo route('hrm.leave.settings.type'); ?>"><i class="fas fa-user-clock"></i> Leave Types</a>
                     </li>
                     
                  </ul>
               </div>
               <div class="card-block">
                  <?php if(Request::is('hrm/leave/holiday')): ?>
                     <?php echo $__env->make('app.hr.leave.settings.holiday', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endif; ?>
                  <?php if(Request::is('hrm/leave/type')): ?>
                     <?php echo $__env->make('app.hr.leave.settings.type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endif; ?>
                  <?php if(Request::is('hrm/leave/workdays')): ?>
                     <?php echo $__env->make('app.hr.leave.settings.workdays', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/leave/settings/index.blade.php ENDPATH**/ ?>