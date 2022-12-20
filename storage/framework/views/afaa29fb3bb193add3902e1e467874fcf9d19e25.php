<?php $__env->startSection('title','Payroll settings'); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Payroll</li>
         <li class="breadcrumb-item active">Payroll settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-cog"></i> Payroll settings </h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.hr.payroll.settings._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('hrm.payroll.settings.approval')); ?>" href="<?php echo route('hrm.payroll.settings.approval'); ?>">
                           Approver setting
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('hrm.payroll.settings.deduction')); ?>" href="<?php echo route('hrm.payroll.settings.deduction'); ?>">
                           Deductions
                        </a>
                     </li>
                     
                  </ul>
               </div>
               <div class="card-block">
                  <?php if(Request::is('hrm/payroll/settings')): ?>
                     <?php echo $__env->make('app.hr.payroll.settings.payday', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endif; ?>
                  <?php if(Request::is('hrm/payroll/settings/approval')): ?>
                     <?php echo $__env->make('app.hr.payroll.settings.approval', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/settings/index.blade.php ENDPATH**/ ?>