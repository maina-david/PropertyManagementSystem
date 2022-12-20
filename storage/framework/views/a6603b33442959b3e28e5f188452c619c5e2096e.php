<?php $__env->startSection('title','Mpesa Phone Number'); ?>



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
         <li class="breadcrumb-item active">M-Pesa Phone Number</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> M-Pesa Phone Number</h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  M-Pesa Phone Number
               </div>
               <div class="card-body">
                  <?php echo Form::model($integration, ['route' => ['settings.payments.integrations.mpesa.phonenumber.update',$integration->id], 'method'=>'post']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Mpesa Phone Number</label>
                        <?php echo Form::text('mpesa_phone_number',null,['class' => 'form-control','placeholder' => '+254 700 000 000','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Mpesa Name</label>
                        <?php echo Form::text('mpesa_name',null,['class' => 'form-control','placeholder' => 'Enter Mpesa Name','required' => '']); ?>

                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Details</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="20%">
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/integrations/payment/mpesa/phonenumber.blade.php ENDPATH**/ ?>