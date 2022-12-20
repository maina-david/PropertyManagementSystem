
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
{!!  App::setLocale('ksw') !!}
<html lang="en">
<!--<![endif]-->
@include('partials._head')

<body>
	<div id="app">
		<!-- begin #page-loader -->
		<div id="page-loader" class="fade show"><span class="spinner"></span></div>
		<!-- end #page-loader -->

		<!-- begin #page-container -->
		<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">

			<!-- begin #header -->
			@include('partials._header')
			<!-- end #header -->
			<!-- begin #sidebar -->
			@if(Request::is('dashboard'))

			@else
				@yield('sidebar')
			@endif
			<!-- end #sidebar -->

			<!-- begin #content -->

			@yield('content')
			<!-- end #content -->

			<!-- begin _howitworks -->
			@include('partials._howitworks')
			<!-- end _howitworks -->

			<div id="footer" class="footer mt-5">
				© Property Wingu  2018 - @php  echo date('Y') @endphp
			</div>

			<!-- begin scroll to top btn -->
			<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
			<!-- end scroll to top btn -->
		</div>
	</div>
	<!-- end page container -->
	@include('partials._footer')
</body>
</html>
