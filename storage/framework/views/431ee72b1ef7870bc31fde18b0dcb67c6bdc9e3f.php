<?php $__env->startSection('title','Telephony'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a href="#" class="btn btn-pink" data-toggle="modal" data-target=".gateway"><i class="fas fa-plus"></i> Add Telephony</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-phone-volume"></i> Telephony </h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php $__currentLoopData = $businessTelephony; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <a href="#">
                        <center>
                           <img alt="<?php echo $provider->name; ?>" src="<?php echo asset('assets/img/telephony/'.$provider->logo); ?>" class="img-responsive payment-logo">
                        </center>
                     </a>
                  </div>
                  <div class="panel-body">
                     <h3 class="text-center"><?php echo $provider->name; ?>.</h3>
                     <?php if($provider->telephonyID == 1): ?>
                        <a href="<?php echo route('settings.integrations.telephony.twilio.edit',$provider->businessTelephonyID); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     <?php endif; ?>
                     <?php if($provider->telephonyID == 2): ?>
                        <a href="<?php echo route('settings.integrations.telephony.africasTalking.edit',$provider->businessTelephonyID); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     <?php endif; ?>                     
                     <?php if($provider->telephonyStatus == 15): ?>
                        <a href="#" class="btn btn-sm btn-success float-right mt-3">Active</a>
                     <?php else: ?> 
                        <a href="#" class="btn btn-sm btn-warning float-right mt-3">Inactive</a>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>

   <!-- Modal -->
   <form action="<?php echo route('settings.integrations.telephony.store'); ?>" method="post">
      <div class="modal fade gateway" tabindex="-1" role="dialog" aria-labelledby="gatewayTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Telephony</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group form-group-default">
                     <label for="">Choose Telephony</label>
                     <?php echo Form::select('telephony',$telephony, null,['class' => 'form-control'] ); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="">Choose status</label>
                     <?php echo Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control'] ); ?>

                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Telephony</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </div>
            </div>
         </div>
      </div>
   </form>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/integrations/telephony/index.blade.php ENDPATH**/ ?>