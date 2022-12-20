
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Property wingu ERP | 200 Error Page</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="{!! asset('/assets/fonts/main/bundled.fonts.css') !!}" rel="stylesheet">
	<link href="{!! asset('/assets/plugins/jquery-ui/jquery-ui.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('/assets/plugins/bootstrap/4.1.0/css/bootstrap.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('/assets/fonts/fontawesome-5.8/css/all.css') !!}" rel="stylesheet" />
	<link href="{!! asset('/assets/css/default/style.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('/assets/css/default/style-responsive.min.css') !!}" rel="stylesheet" />
	<link href="{!! asset('/assets/css/theme/default.css') !!}" rel="stylesheet" id="theme" />
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
			<div class="error-code m-b-10">200</div>
			<div class="error-content">
				<div class="error-message text-center">
               <h3 class="text-white">OOPS!!! something when wrong</h3>
               <p>Sorry for the inconvenience we are working on it</p>
            </div>
				<div class="error-desc m-b-30">
               <p>Use your browser's back button and try again, or try one of the following:</p>
               <ul style="list-style: none;">
                  <li><a href="{!! url('/') !!}">Property wingu home page</a></li>
                  <li><a href="{!! url('/') !!}">Sign up for a free account</a></li>
                  <li><a href="{!! url('/') !!}">Sign in</a></li>
                  <li><a href="{!! url('/') !!}">Help Center</a></li>
               </ul>
            </div>
            <div>
               <a href="{!! url('/') !!}" class="btn btn-success p-l-20 p-r-20">Go Home</a>
            </div>
         </div>
		</div>
		<!-- end error -->
	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{!! url('/') !!}/public/app/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="{!! url('/') !!}/public/app/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="{!! url('/') !!}/public/app/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
	<!--[if lt IE 9]>
		<script src="{!! url('/') !!}/public/app/crossbrowserjs/html5shiv.js"></script>
		<script src="{!! url('/') !!}/public/app/crossbrowserjs/respond.min.js"></script>
		<script src="{!! url('/') !!}/public/app/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="{!! url('/') !!}/public/app/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="{!! url('/') !!}/public/app/plugins/js-cookie/js.cookie.js"></script>
	<script src="{!! url('/') !!}/public/app/js/theme/default.min.js"></script>
	<script src="{!! url('/') !!}/public/app/js/apps.min.js"></script>
	<!-- ================== END BASE JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>
</html>
