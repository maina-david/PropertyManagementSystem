
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
@section('Verify Your Email Address','Login . winguPlus')
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
	<!-- begin #page-container -->
	<div class="container">
		<div class="py-4 text-center mt-5">
			<a href="{!! url('/') !!}">
            <img src="{!! asset('assets/img/logo-long.png') !!}" alt="" style="width: 25%">
         </a>
		</div>
		<div class="row mb-5">
			<div class="col-md-2"></div>
			<div class="col-md-8">
            @include('partials._messages')
            @if (session('resent'))
               <div class="alert alert-success" role="alert">
                  {{ __('A fresh verification link has been sent to your email address.') }}
               </div>
            @endif
				<div class="card">
					<div class="card-body">
						<div class="signup">
							<h2 class="font-weight-bolder">Verify Your Email Address<h2>
                     <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <p style="font-size: 28px;">
                           {{ __('Before proceeding, please check your email for a verification link.') }}
                           {{ __('If you did not receive the email') }}<br>
                           <button type="submit" class="btn btn-primary">{{ __('click here to request another') }}</button>
                        </p>
                     </form>
						</div>
					</div>
            </div>
				<p class="text-center">&copy; Property Wingu. All Right Reserved 2018 - @php echo date('Y') @endphp </p>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
	<!-- end page container -->
	@include('partials._footer')
</body>
</html>
