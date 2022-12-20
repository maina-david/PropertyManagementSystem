
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php $__env->startSection('Verify Your Email Address','Login . winguPlus'); ?>
<?php echo $__env->make('partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
			<a href="<?php echo url('/'); ?>">
            <img src="<?php echo asset('assets/img/logo-long.png'); ?>" alt="" style="width: 25%">
         </a>
		</div>
		<div class="row mb-5">
			<div class="col-md-2"></div>
			<div class="col-md-8">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(session('resent')): ?>
               <div class="alert alert-success" role="alert">
                  <?php echo e(__('A fresh verification link has been sent to your email address.')); ?>

               </div>
            <?php endif; ?>
				<div class="card">
					<div class="card-body">
						<div class="signup">
							<h2 class="font-weight-bolder">Verify Your Email Address<h2>
                     <form method="POST" action="<?php echo e(route('verification.resend')); ?>">
                        <?php echo csrf_field(); ?>
                        <p style="font-size: 28px;">
                           <?php echo e(__('Before proceeding, please check your email for a verification link.')); ?>

                           <?php echo e(__('If you did not receive the email')); ?><br>
                           <button type="submit" class="btn btn-primary"><?php echo e(__('click here to request another')); ?></button>
                        </p>
                     </form>
						</div>
					</div>
            </div>
				<p class="text-center">&copy; Property Wingu. All Right Reserved 2018 - <?php echo date('Y') ?> </p>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
	<!-- end page container -->
	<?php echo $__env->make('partials._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/auth/verify.blade.php ENDPATH**/ ?>