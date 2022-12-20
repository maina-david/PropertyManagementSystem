
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
							<h2 class="font-weight-bolder">Reset your password</h2>
							<form action="{{ route('password.request') }}" method="post" class="row mt-3" autocomplete="off">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
								<input autocomplete="off" name="hidden" type="text" style="display:none;">
								<div class="col-md-12">
									<div class="form-group">
                              <label class="control-label">Email </label>
                              <input id="email" type="email" class="form-control form-control-lg" name="email" placeholder="Email Address" value="{{ $email }}" required autofocus>
                              @if ($errors->has('email'))
                                 <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                 </span>
                              @endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
                              <label for="">Password</label>
										<input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required />
                              @if ($errors->has('password'))
                                 <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                 </span>
                              @endif
									</div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Confirm Password</label>
                              <input type="password" class="form-control form-control-lg" placeholder="Password" name="password_confirmation" required/>
                              @if ($errors->has('password_confirmation'))
                                 <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password_confirmation') }}</strong>
                                 </span>
                              @endif
                           </div>
                        </div>
								<div class="col-md-12 mt-3">
									<div class="row">
										<div class="col-md-3"></div>
										<div class="col-md-6">
											<center>
												<button type="submit" class="btn btn-pink btn-block btn-lg submit">Reset Password</button>
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
				<p class="text-center">&copy; Property Wingu<sup>TM</sup> All Right Reserved 2018 - @php echo date('Y') @endphp </p>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
	<!-- end page container -->
	@include('partials._footer')
</body>
</html>
