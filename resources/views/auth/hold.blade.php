<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
   <!--<![endif]-->
   @section('title','Login . Verify Your Email Address')
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
      {{-- <div id="page-loader" class="fade show"><span class="spinner"></span></div> --}}
      <!-- end #page-loader -->
      
      <!-- begin #page-container -->
      <div class="container">
         <div class="row justify-content-center mt-5">
            <div class="col-md-8 mt-5">
               <div class="card">
                  <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                  <div class="card-body">
                     @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                              {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                     @endif
                     <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }}<br><br>
                        <button type="submit" class="btn btn-primary">{{ __('click here to request another') }}</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>

         <!-- end page container -->
      @include('partials._footer')
   </body>
</html>
