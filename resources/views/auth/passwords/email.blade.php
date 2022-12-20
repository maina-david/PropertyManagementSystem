<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
@section('title','Reset Password')
@include('partials._head')
<style>
	.signup {
		margin: 10%;
	}
   a {
      color: #ef5279;
      transition: color .1s ease-in-out;
   }

   @media(max-width: 854px){
      img{
         width:100%;
      }
   }
</style>

<body class="pace-top bg-white">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div class="container">
		<div class="py-4 text-center mt-5">
			<a href="{!! url('/') !!}">
            <img src="{!! asset('assets/img/logo-long.png') !!}" alt="" style="width: 25%">
         </a>
		</div>
		<div class="row mb-5">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				@include('partials._messages')
				<div class="card">
					<div class="card-body">
						<div class="signup">
							<h2 class="font-weight-bolder">Forgot password?</h2>
                     <h4>Please enter your email to reset your password.</h4>
                     @if (session('status'))
                        <div class="alert alert-success">
                           {{ session('status') }}
                        </div>
                     @endif
							<form action="{{ route('password.email') }}" method="post" class="row mt-5" autocomplete="off">
								@csrf
								<div class="col-md-12">
									<div class="form-group">
                              <label class="control-label">Email <span class="text-danger">*</span></label>
                              <input id="email" type="email" class="form-control form-control-lg" name="email" placeholder="email@company.com" value="{{ old('email') }}" required autofocus>
                              @if ($errors->has('email'))
                                 <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                 </span>
                              @endif
									</div>
								</div>
								<div class="col-md-12 mt-3">
									<div class="row">
										<div class="col-md-3"></div>
										<div class="col-md-6">
											<center>
												<button type="submit" class="btn btn-pink btn-block btn-lg submit">Get reset link</button>
												<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="80%">
											</center>
										</div>
										<div class="col-md-3"></div>
									</div>
								</div>
							</form>
						</div>
					</div>
            </div>
				<hr>
				<p class="text-center">&copy; Property Wingu. All Right Reserved 2018 - @php echo date('Y') @endphp </p>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
	<!-- end page container -->
	@include('partials._footer')
</body>
</html>
