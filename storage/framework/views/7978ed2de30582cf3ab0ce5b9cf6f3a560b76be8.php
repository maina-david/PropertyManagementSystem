
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Property wingu | 403 Error Page</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="<?php echo asset('/assets/fonts/main/bundled.fonts.css'); ?>" rel="stylesheet">
	<link href="<?php echo asset('/assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/plugins/bootstrap/4.1.0/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/fonts/fontawesome-5.8/css/all.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/css/default/style.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/css/default/style-responsive.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/css/theme/default.css'); ?>" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="fade">
		<!-- begin error -->
		<div class="error">
			<div class="error-code m-b-10">403</div>
			<div class="error-content">
				<div class="error-message">
               Access Denied / Forbidden
            </div>
				<div class="error-desc m-b-30">
               <p>The page or resource you were trying to reach is absolutely forbidden for some reasons</p>
            </div>
            <div>
               <a href="<?php echo url()->previous(); ?>" class="btn btn-success p-l-20 p-r-20"><i class="fas fa-long-arrow-alt-left"></i>  Go Back</a>
            </div>
         </div>
		</div>
		<!-- end error -->
	</div>
	<!-- end page container -->

	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo asset('/assets/plugins/jquery/jquery-3.2.1.min.js'); ?>"></script>
	<script src="<?php echo asset('/assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
   <script src="<?php echo asset('/assets/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js'); ?>"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo asset('/assets/crossbrowserjs/html5shiv.js'); ?>"></script>
		<script src="<?php echo asset('/assets/crossbrowserjs/respond.min.js'); ?>"></script>
		<script src="<?php echo asset('/assets/crossbrowserjs/excanvas.min.js'); ?>"></script>
	<![endif]-->
	<script src="<?php echo asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
	<script src="<?php echo asset('/assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
	<script src="<?php echo asset('/assets/js/theme/default.min.js'); ?>"></script>
	<script src="<?php echo asset('/assets/js/apps.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/errors/403.blade.php ENDPATH**/ ?>