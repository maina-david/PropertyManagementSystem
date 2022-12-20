<?php $__env->startSection('title','Leave Calendar'); ?>
<?php $__env->startSection('stylesheet'); ?>
    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?php echo asset('asset/plugins/fullcalendar/fullcalendar.print.css'); ?>" rel="stylesheet" media='print' />
	<link href="<?php echo asset('asset/plugins/fullcalendar/fullcalendar.min.css'); ?>" rel="stylesheet" />
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
         <li class="breadcrumb-item active">Calendar</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Calendar</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <div class="vertical-box">
            <!-- begin event-list -->
            
            <!-- end event-list -->
            <!-- begin calendar -->
            <div id="calendar" class="vertical-box-column calendar"></div>
            <!-- end calendar -->
         </div>
         <!-- end vertical-box -->
      </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo asset('assets/plugins/fullcalendar/lib/moment.min.js'); ?>"></script>
	<script src="<?php echo asset('assets/plugins/fullcalendar/fullcalendar.min.js'); ?>"></script>
	<script src="<?php echo asset('assets/js/demo/calendar.demo.min.js'); ?>"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			Calendar.init();
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/calendar/index.blade.php ENDPATH**/ ?>