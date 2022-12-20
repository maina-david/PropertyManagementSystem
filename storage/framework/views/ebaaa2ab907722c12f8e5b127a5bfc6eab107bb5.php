<?php $__env->startSection('title','Human Resource '); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- end page-header -->
      <div class="row">
         <div class="col-md-12">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         </div>
      </div>
      <!-- begin row --> 
      <div class="row">
         <!-- begin col-3 -->
         <div class="col-lg-4 col-md-4">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-users fa-fw"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Employes</div>
                  <div class="stats-number"><?php echo $employees; ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="<?php echo route('hrm.employee.index'); ?>" class="text-white">Total Employes</a></div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-4 col-md-4">
            <div class="widget widget-stats bg-gradient-red">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-users-medical fa-fw"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Active Employees</div>
                  <div class="stats-number"><?php echo $activeEmployees; ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="<?php echo route('hrm.employee.index'); ?>" class="text-white">Total Active Employees</a></div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-4 col-md-4">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="far fa-calendar-alt fa-fw"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Leave Requests</div>
                  <div class="stats-number"><?php echo $leaveRequests; ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="<?php echo route('hrm.leave.index'); ?>" class="text-white">Total leave request</a></div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header"><i class="fas fa-calendar-week"></i> Leave Reports</div>
                  <div class="card-body" style="min-height: 380px">
                     <?php echo $leaveReport->container(); ?>

                  </div>
               </div>
            </div>  
         </div>
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo url('/'); ?>/public/backend/plugins/chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
	<?php echo $leaveReport->script(); ?> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/dashboard/dashboard.blade.php ENDPATH**/ ?>