<?php $__env->startSection('title','Leave Calendar'); ?>
<?php $__env->startSection('stylesheet'); ?>
    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?php echo aaset('assets/plugins/fullcalendar/fullcalendar.print.css'); ?>" rel="stylesheet" media='print' />
	<link href="<?php echo aaset('assets/plugins/fullcalendar/fullcalendar.min.css'); ?>" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?> 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Leave</li>
         <li class="breadcrumb-item active">Calendar</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fad fa-calendar-alt"></i> Calendar</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <div class="vertical-box">
            <!-- begin event-list -->
            
            <!-- end event-list -->
            <!-- begin calendar -->
            
            <?php echo $calendar->calendar(); ?>

            <!-- end calendar -->
         </div>
         <!-- end vertical-box -->
      </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
   <?php echo $calendar->script(); ?>

   
	
	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/leave/calendar.blade.php ENDPATH**/ ?>