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
         <li class="breadcrumb-item active">pesapal</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-credit-card"></i> Pesapal Integration</h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">
                  Pesapal Information
               </div>
               <div class="card-body">
                  <?php echo Form::model($edit, ['route' => ['settings.integrations.payments.pesapal.update',$edit->id], 'method'=>'post']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default">
                        <label for="name">Customer key</label>
                        <?php echo Form::text('customer_key',null,['class' => 'form-control','placeholder' => 'Enter customer key','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Customer secret</label>
                        <?php echo Form::text('customer_secret',null,['class' => 'form-control','required' => '','placeholder' => 'Enter customer secret']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Iframelink</label>
                        <?php echo Form::text('iframelink',null,['class' => 'form-control','required' => '', 'placeholder' => 'Enter customer iframelink']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Callback url</label>
                        <?php echo Form::text('callback_url',null,['class' => 'form-control','required' => '', 'placeholder' => 'Enter customer callback url']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Choose status</label>
                        <?php echo Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control'] ); ?>

                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update gateway</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>

  
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/integrations/payment/pesapal.blade.php ENDPATH**/ ?>