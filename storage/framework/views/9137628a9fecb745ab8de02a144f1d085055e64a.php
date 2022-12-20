<?php $__env->startSection('title','Applications'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('wingu.dashboard'); ?>">Settings</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('settings.business.index'); ?>"> Applications</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-gem"></i> Account Applications.</h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
               <div class="col-md-4">
                  <div class="card">
                     <div class="card-body text-center">
                        <?php echo $app->icon; ?>

                        <p class="mt-1"><?php echo $app->name; ?></p>          
                     </div>
                     <div class="card-footer">
                        <div class="row">
                           <div class="col-md-4">
                              <h4 class="font-weight-bold text-pink">$<?php echo number_format($app->price); ?>/Mo</h4>
                           </div>
                           <div class="col-md-8">
                              <?php if($app->module_status == 15 && $app->payment_status == 1): ?>
                                 <a href="#" class="float-right ml-1 btn btn-sm btn-success">Active</a>
                              <?php else: ?> 
                                 <a href="<?php echo route('settings.applications.billing',$app->business_module_id); ?>" class="float-right ml-1 btn btn-sm btn-pink"><i class="fal fa-usd-circle"></i> Make Payment</a>
                                 <a href="<?php echo route('settings.application.delete',$app->moduleID); ?>" class="float-right ml-1 btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Remove</a>
                              <?php endif; ?>
                           </div>                             
                        </div>                          
                     </div>
                  </div>
               </div>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>           
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/applications/index.blade.php ENDPATH**/ ?>