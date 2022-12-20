<?php $__env->startSection('title','Integration | Payment | Ipay'); ?>



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
         <li class="breadcrumb-item active">Ipay</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> Ipay Integration</h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">
                  Ipay Information
               </div>
               <div class="card-body">
                  <?php echo Form::model($edit, ['route' => ['settings.payments.integrations.ipay.update',$edit->id], 'method'=>'post']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">vendorID</label>
                        <?php echo Form::text('vendorID',null,['class' => 'form-control','placeholder' => 'Enter vendorID','required' => '']); ?>

                     </div> 
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Secret Key</label>
                        <?php echo Form::text('secretKey',null,['class' => 'form-control','placeholder' => 'Enter Secret Key','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Phone Number</label>
                        <?php echo Form::text('phone_number',null,['class' => 'form-control','placeholder' => 'Enter phone number','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Currency Code</label>
                        <?php echo Form::select('currency_code',['' => 'Choose Currency','USD' => 'USD','KES' => 'KES'],null,['class' => 'form-control']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Status</label>
                        <?php echo Form::select('live_or_sandbox',['' => 'Choose','Live' => 'Live','Sandbox' => 'Sandbox'],null,['class' => 'form-control']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Redirect URL </label>
                        <input type="text" name="callback_url" class="form-control" value="<?php echo route('callback.ipay'); ?>" readonly>
                     </div>   
                     <?php if(Wingu::check_business_modules(20) == 1): ?>
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Wingu store Redirect URL </label>
                           <input type="text" name="wingustore_callback_url" class="form-control" value="<?php echo ecommerce::get_ecommerce_details()->domain; ?>/callback/ipay" readonly>
                        </div>  
                     <?php endif; ?>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Details</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/integrations/payment/ipay.blade.php ENDPATH**/ ?>