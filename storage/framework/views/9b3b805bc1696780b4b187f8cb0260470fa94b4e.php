<?php $__env->startSection('title'); ?> Transactions <?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?><?php echo route('home.page'); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      td+td{
         text-align: center;
      }

      
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div class="section-container head-section bg-white">
      <!-- BEGIN container -->
      <div class="container text-center mb-5">
         <center><h2><i class="fal fa-credit-card-front fa-5x"></i></h2></center>
         <h2 class="mt-5 head-title">Transaction has been canceled</h2>
      </div>
      <!-- END container -->
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/wingu/hold/cancel.blade.php ENDPATH**/ ?>