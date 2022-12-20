<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta content="follow,index" name="robots">
	<!-- Disable screen scaling-->
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">

	<!-- Page Title Here -->
	<title><?php echo $__env->yieldContent('title'); ?> - Property wingu</title>

	<!-- Meta -->
	<!-- Page Description Here -->
	<meta name="description" content="<?php echo $__env->yieldContent('description'); ?>">
	<meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>">

	<!-- Twitter Meta -->
	<meta name="twitter:site" content="@winguPlus">
	<meta name="twitter:creator" content="@winguPlus">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="<?php echo $__env->yieldContent('title'); ?>">
	<meta name="twitter:description" content="<?php echo $__env->yieldContent('description'); ?>">
	<meta name="twitter:image" content="<?php echo asset('assets/favicon/apple-icon-120x120.png'); ?>">

	<!-- Facebook Meta -->
	<meta property="og:url" content="<?php echo $__env->yieldContent('url'); ?>"/>
	<meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?>">
	<meta property="og:description" content="<?php echo $__env->yieldContent('description'); ?>">
	<meta property="og:type" content="website">
	<?php echo $__env->yieldContent('image'); ?>
	<meta property="og:image:secure_url" content="<?php echo asset('assets/favicon/apple-icon-120x120.png'); ?>">
	<meta property="og:image:type" content="image/jpg">
	<meta property="og:image:width" content="500">
	<meta property="og:image:height" content="250">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo asset('assets/favicon/apple-icon-57x57.png'); ?>">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo asset('assets/favicon/apple-icon-60x60.png'); ?>">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo asset('assets/favicon/apple-icon-72x72.png'); ?>">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo asset('assets/favicon/apple-icon-76x76.png'); ?>">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo asset('assets/favicon/apple-icon-114x114.png'); ?>">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo asset('assets/favicon/apple-icon-120x120.png'); ?>">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo asset('assets/favicon/apple-icon-144x144.png'); ?>">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo asset('assets/favicon/apple-icon-152x152.png'); ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo asset('assets/favicon/apple-icon-180x180.png'); ?>">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo asset('assets/favicon/android-icon-192x192.png'); ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo asset('assets/favicon/favicon-32x32.png'); ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo asset('assets/favicon/favicon-96x96.png'); ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo asset('assets/favicon/favicon-16x16.png'); ?>">
	<link rel="icon" type="image/png" sizes="512x512" href="<?php echo asset('assets/favicon/512.png'); ?>">
	
	<link href="<?php echo asset('assets/favicon/favicon.ico'); ?>" rel="shortcut icon">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo asset('assets/favicon/ms-icon-144x144.png'); ?>">
	<meta name="theme-color" content="#ffffff">
	<script>
	// if ('serviceWorker' in navigator) {
	// 	window.addEventListener('load', function() {
	// 		navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
	// 		// Registration was successful
	// 		console.log('ServiceWorker registration successful with scope: ', registration.scope);
	// 		}, function(err) {
	// 		// registration failed :(
	// 		console.log('ServiceWorker registration failed: ', err);
	// 		});
	// 	});
	// }
	</script>
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<link href="<?php echo asset('assets/fonts/main/bundled.fonts.css'); ?>" rel="stylesheet">
	<link href="<?php echo asset('assets/fonts/icons/icons.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo asset('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('assets/plugins/bootstrap/4.1.0/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('assets/fonts/fontawesome/css/all.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('assets/plugins/animate/animate.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('assets/css/default/style.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('assets/css/default/style-responsive.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('assets/css/default/theme/default.css'); ?>" rel="stylesheet" id="theme" />
	<link href="<?php echo asset('assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet" />

	<!-- ================== END BASE CSS STYLE ================== -->
	<link rel="stylesheet" href="<?php echo asset('assets/css/custome-form.css'); ?>" />
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo asset('assets/plugins/pace/pace.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	<!-- ================== status css ================== -->
	<link rel="stylesheet" href="<?php echo asset('assets/css/status.css'); ?>" />

	<link href="<?php echo asset('assets/plugins/multi-select/css/multi-select.css'); ?>" media="screen" rel="stylesheet" type="text/css">

	<!-- ================== Custom CSS STYLE ================== -->
	<link rel="stylesheet" href="<?php echo asset('assets/css/custome.css'); ?>" />

	<link href="<?php echo asset('assets/plugins/lightbox2/css/lightbox.css'); ?>" rel="stylesheet" />

	<?php echo \Livewire\Livewire::styles(); ?>

	<?php echo $__env->yieldContent('stylesheet'); ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-VEV1MHGZ2R"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-VEV1MHGZ2R');
	</script>
</head>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/partials/_head.blade.php ENDPATH**/ ?>