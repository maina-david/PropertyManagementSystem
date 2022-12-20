<?php $__env->startSection('title','Twilio'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Integrations</li>
         <li class="breadcrumb-item">Telephony</li>
         <li class="breadcrumb-item active">Twilio</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-mobile-alt"></i> Twilio Integration</h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">Twilio Information</div>
               <div class="card-body">
                  <?php echo Form::model($edit, ['route' => ['settings.integrations.telephony.twilio.update',$edit->id], 'method'=>'post']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Twilio SID</label>
                        <?php echo Form::text('tw_sid',null,['class' => 'form-control','placeholder' => 'Enter SID','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Twilio Token</label>
                        <?php echo Form::text('tw_token',null,['class' => 'form-control', 'required' => '','placeholder' => 'Enter token']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Twilio From</label>
                        <?php echo Form::text('sms_from',null,['class' => 'form-control','required' => '', 'placeholder' => 'e.x 254700123456']); ?>

                     </div>  
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Choose status</label>
                        <?php echo Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control multiselect'] ); ?>

                     </div>    
                     <div class="form-group form-group-default">
                        <label for="">Make default telephony</label>
                        <?php echo Form::select('default',['' => 'Choose','Yes' => 'Yes'], null,['class' => 'form-control multiselect'] ); ?>

                     </div>                     
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>

  
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/integrations/telephony/twilio.blade.php ENDPATH**/ ?>