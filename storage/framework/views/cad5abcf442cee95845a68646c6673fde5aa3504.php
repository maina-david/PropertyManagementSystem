<?php $__env->startSection('title','Payment Gateways'); ?>



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
         <li class="breadcrumb-item active">M-pesa</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-credit-card"></i> M-pesa daraja</h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  M-pesa daraja
               </div>
               <div class="card-body">
                  <?php echo Form::model($edit, ['route' => ['settings.integrations.payments.mpesa.update',$edit->id], 'method'=>'post']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default">
                        <label for="name">Business Name</label>
                        <?php echo Form::text('title',null,['class' => 'form-control','placeholder' => 'Enter app name','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Consumer key</label>
                        <?php echo Form::text('merchant_consumer_key',null,['class' => 'form-control','placeholder' => 'Enter Consumer key','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Customer secret</label>
                        <?php echo Form::text('merchant_consumer_secret',null,['class' => 'form-control','required' => '','placeholder' => 'Enter Consumer secret']); ?>

                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Paybill Number</label>
                              <?php echo Form::text('paybill_number',null,['class' => 'form-control','placeholder' => 'Enter paybill Number']); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Lipa Na Mpesa</label>
                              <?php echo Form::text('till_number',null,['class' => 'form-control','placeholder' => 'Enter Lipa Na Mpesa Number']); ?>

                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name">Payment Confrimation callback URL</label>
                        <?php if($edit->daraja_url_registered == ""): ?>
                           <a class="btn btn-sm btn-primary pull-right" href="<?php echo route('settings.integrations.daraja.register.urls',Wingu::business()->businessID); ?>">Register URL</a>
                        <?php endif; ?>
                        <input type="text" name="callback_url" value="<?php echo route('daraja.payment.callback',Wingu::business()->businessID); ?>" class="form-control mt-1" readonly>
                     </div>
                     <div class="form-group">
                        <label for="name">Payment Cancellation callback URL</label>
                        <input type="text" name="cancel_url" value="<?php echo route('daraja.payment.cancel.callback',Wingu::business()->businessID); ?>" class="form-control" readonly>
                     </div>
                     <div class="row">                        
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Choose status</label>
                              <?php echo Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control'] ); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Environment</label>
                              <?php echo Form::select('live_or_sandbox',['' => 'Choose your environment','sandbox' => 'Sandbox', 'live' => 'Live'], null,['class' => 'form-control','required' => ''] ); ?>

                           </div>
                        </div>
                     </div>                     
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="40%">
                     </div>
                     <br>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/integrations/payment/mpesa/daraja.blade.php ENDPATH**/ ?>