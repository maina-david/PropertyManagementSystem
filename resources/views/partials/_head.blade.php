<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta content="follow,index" name="robots">
	<!-- Disable screen scaling-->
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">

	<!-- Page Title Here -->
	<title>@yield('title') - Property wingu</title>

	<!-- Meta -->
	<!-- Page Description Here -->
	<meta name="description" content="@yield('description')">
	<meta name="keywords" content="@yield('keywords')">

	<!-- Twitter Meta -->
	<meta name="twitter:site" content="@winguPlus">
	<meta name="twitter:creator" content="@winguPlus">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="@yield('title')">
	<meta name="twitter:description" content="@yield('description')">
	<meta name="twitter:image" content="{!! asset('assets/favicon/apple-icon-120x120.png') !!}">

	<!-- Facebook Meta -->
	<meta property="og:url" content="@yield('url')"/>
	<meta property="og:title" content="@yield('title')">
	<meta property="og:description" content="@yield('description')">
	<meta property="og:type" content="website">
	@yield('image')
	<meta property="og:image:secure_url" content="{!! asset('assets/favicon/apple-icon-120x120.png') !!}">
	<meta property="og:image:type" content="image/jpg">
	<meta property="og:image:width" content="500">
	<meta property="og:image:height" content="250">
	<link rel="apple-touch-icon" sizes="57x57" href="{!! asset('assets/favicon/apple-icon-57x57.png') !!}">
	<link rel="apple-touch-icon" sizes="60x60" href="{!! asset('assets/favicon/apple-icon-60x60.png') !!}">
	<link rel="apple-touch-icon" sizes="72x72" href="{!! asset('assets/favicon/apple-icon-72x72.png') !!}">
	<link rel="apple-touch-icon" sizes="76x76" href="{!! asset('assets/favicon/apple-icon-76x76.png') !!}">
	<link rel="apple-touch-icon" sizes="114x114" href="{!! asset('assets/favicon/apple-icon-114x114.png') !!}">
	<link rel="apple-touch-icon" sizes="120x120" href="{!! asset('assets/favicon/apple-icon-120x120.png') !!}">
	<link rel="apple-touch-icon" sizes="144x144" href="{!! asset('assets/favicon/apple-icon-144x144.png') !!}">
	<link rel="apple-touch-icon" sizes="152x152" href="{!! asset('assets/favicon/apple-icon-152x152.png') !!}">
	<link rel="apple-touch-icon" sizes="180x180" href="{!! asset('assets/favicon/apple-icon-180x180.png') !!}">
	<link rel="icon" type="image/png" sizes="192x192"  href="{!! asset('assets/favicon/android-icon-192x192.png') !!}">
	<link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/favicon/favicon-32x32.png') !!}">
	<link rel="icon" type="image/png" sizes="96x96" href="{!! asset('assets/favicon/favicon-96x96.png') !!}">
	<link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/favicon/favicon-16x16.png') !!}">
	<link rel="icon" type="image/png" sizes="512x512" href="{!! asset('assets/favicon/512.png') !!}">
	{{-- <link rel="manifest" href="/manifest.json"> --}}
	<link href="{!! asset('assets/favicon/favicon.ico') !!}" rel="shortcut icon">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="{!! asset('assets/favicon/ms-icon-144x144.png') !!}">
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
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{!! asset('assets/fonts/main/bundled.fonts.css') !!}" rel="stylesheet">
	<link href="{!! asset('assets/fonts/icons/icons.min.css') !!}" rel="stylesheet">
	<link href="{!! asset('assets/plugins/jquery-ui/jquery-ui.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('assets/plugins/bootstrap/4.1.0/css/bootstrap.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('assets/fonts/fontawesome/css/all.css') !!}" rel="stylesheet" />
	<link href="{!! asset('assets/plugins/animate/animate.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('assets/css/default/style.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('assets/css/default/style-responsive.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('assets/css/default/theme/default.css') !!}" rel="stylesheet" id="theme" />
	<link href="{!! asset('assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css') !!}" rel="stylesheet" />

	<!-- ================== END BASE CSS STYLE ================== -->
	<link rel="stylesheet" href="{!! asset('assets/css/custome-form.css') !!}" />
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{!! asset('assets/plugins/pace/pace.min.js') !!}"></script>
	<!-- ================== END BASE JS ================== -->
	<!-- ================== status css ================== -->
	<link rel="stylesheet" href="{!! asset('assets/css/status.css') !!}" />

	<link href="{!! asset('assets/plugins/multi-select/css/multi-select.css') !!}" media="screen" rel="stylesheet" type="text/css">

	<!-- ================== Custom CSS STYLE ================== -->
	<link rel="stylesheet" href="{!! asset('assets/css/custome.css') !!}" />

	<link href="{!! asset('assets/plugins/lightbox2/css/lightbox.css') !!}" rel="stylesheet" />

	@livewireStyles
	@yield('stylesheet')
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-VEV1MHGZ2R"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-VEV1MHGZ2R');
	</script>
</head>
