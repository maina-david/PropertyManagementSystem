<?php $__env->startSection('title','Payment Modes'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.payment.mode'); ?>">Payment Modes</a></li>
         <li class="breadcrumb-item active">All Models</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fab fa-amazon-pay"></i>  Payment Modes</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('finance.expense.category.index')); ?>" href="#"><i class="fab fa-amazon-pay"></i> Payment Modes </a>
                     </li>
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
                     <?php if(Request::is('finance/settings/payment/modes')): ?>
                        <?php echo $__env->make('app.finance.payments.settings.list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>                        
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/payments/settings/index.blade.php ENDPATH**/ ?>