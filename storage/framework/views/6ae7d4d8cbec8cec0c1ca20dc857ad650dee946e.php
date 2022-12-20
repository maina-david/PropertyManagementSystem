<?php $__env->startSection('title','Assets'); ?>

<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <div class="row">
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-boxes-alt"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Number of Active Assets</div>
                  <div class="stats-number">0</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-blue">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-door-open"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Checked-out</div>
                  <div class="stats-number">0</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-yellow">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-tools"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Under repair</div>
                  <div class="stats-number">0</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-search"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Lost/Missing</div>
                  <div class="stats-number">0</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
      </div>
      <div class="row">
         <div class="col-md-12">            
            <div class="card">
               <div class="card-header">Current Assets</div>
               <div class="card-body">

               </div>
            </div>
         </div>
         <div class="col-md-6">            
            <div class="card">
               <div class="card-header">Alert</div>
               <div class="card-body">

               </div>
            </div>
         </div>
         <div class="col-md-6">            
            <div class="card">
               <div class="card-header">Asset Value</div>
               <div class="card-body">

               </div>
            </div>
         </div>
         <div class="col-md-12">            
            <div class="card">
               <div class="card-header">Location</div>
               <div class="card-body">

               </div>
            </div>
         </div>
         <div class="col-md-6">            
            <div class="card">
               <div class="card-header">Check out</div>
               <div class="card-body">

               </div>
            </div>
         </div>
         <div class="col-md-6">            
            <div class="card">
               <div class="card-header">Check in</div>
               <div class="card-body">

               </div>
            </div>
         </div>
         <div class="col-md-12">            
            <div class="card">
               <div class="card-header">Under Maintainance</div>
               <div class="card-body">

               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/dashboard/dashboard.blade.php ENDPATH**/ ?>