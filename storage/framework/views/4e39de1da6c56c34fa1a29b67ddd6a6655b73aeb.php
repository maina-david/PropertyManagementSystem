
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<?php echo App::setLocale('ksw'); ?>

<html lang="en">
<!--<![endif]-->
<?php echo $__env->make('partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body>
	<div id="app">
		<!-- begin #page-loader -->
		<div id="page-loader" class="fade show"><span class="spinner"></span></div>
		<!-- end #page-loader -->

		<!-- begin #page-container -->
		<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">

			<!-- begin #header -->
			<?php echo $__env->make('partials._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<!-- end #header -->
			<!-- begin #sidebar -->
			<?php if(Request::is('dashboard')): ?>

			<?php else: ?>
				<?php echo $__env->yieldContent('sidebar'); ?>
			<?php endif; ?>
			<!-- end #sidebar -->

			<!-- begin #content -->

			<?php echo $__env->yieldContent('content'); ?>
			<!-- end #content -->

			<!-- begin _howitworks -->
			<?php echo $__env->make('partials._howitworks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<!-- end _howitworks -->

			<div id="footer" class="footer mt-5">
				© Property Wingu  2018 - <?php  echo date('Y') ?>
			</div>

			<!-- begin scroll to top btn -->
			<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
			<!-- end scroll to top btn -->
		</div>
	</div>
	<!-- end page container -->
	<?php echo $__env->make('partials._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/layouts/app.blade.php ENDPATH**/ ?>