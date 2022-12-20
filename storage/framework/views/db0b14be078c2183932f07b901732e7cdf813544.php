<?php $__env->startSection('title','kepler9'); ?>



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
         <li class="breadcrumb-item active">kepler9</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> kepler9 Integration</h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">
                  kepler9 Information
               </div>
               <div class="card-body">
                  <?php echo Form::model($edit, ['route' => ['settings.integrations.payments.kepler9.update',$edit->id], 'method'=>'post']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Client ID	</label>
                        <?php echo Form::text('clientID',null,['class' => 'form-control','placeholder' => 'Enter Client ID','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Client Secret</label>
                        <?php echo Form::text('client_secret',null,['class' => 'form-control','placeholder' => 'Enter Client Key','required' => '']); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Payments Notifications URL</label>
                        <input type="text" name="callback_url" class="form-control" value="<?php echo route('callback.kepler9'); ?>" readonly>
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Redirect URL</label>
                        <input type="text" name="callback_url" class="form-control" value="<?php echo route('callback.kepler9'); ?>" readonly>
                     </div>                     
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/integrations/payment/kepler9.blade.php ENDPATH**/ ?>