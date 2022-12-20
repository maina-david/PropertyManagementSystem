<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php $__env->startSection('title','Sign up'); ?>
<?php echo $__env->make('partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
	.signup {
		margin: 5%;
	}
	.select2-container .select2-selection--single .select2-selection__rendered {
		display: block;
		padding-right: 20px;
		padding-left: 10px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		border: 1px solid #e4dfdf;
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
			<a href="<?php echo url('/'); ?>">
            <img src="<?php echo asset('assets/img/logo-long.png'); ?>" alt="" style="width: 25%">
         </a>
		</div>
		<div class="row mb-5">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<div class="card">
					<div class="card-body">
						<div class="signup">
							<h2 class="font-weight-bolder">Get started with Property Wingu</h2>
							<h4>No credit card needed. Create your free account</h4>
							<form action="<?php echo route('signup'); ?>" method="post" class="row mt-3" autocomplete="off">
								<?php echo csrf_field(); ?>
								<input autocomplete="false" name="hidden" type="text" style="display:none;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Full Name <span class="text-danger">*</span></label>
										<?php echo e(Form::text('full_names', null, ['class' => 'form-control','required' => ''])); ?>

										<?php if($errors->has('full_names')): ?>
                                 <span class="help-block">
                                    <strong class="text-danger"><?php echo e($errors->first('full_names')); ?></strong>
                                 </span>
                              <?php endif; ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Email <span class="text-danger">*</span></label>
										<?php echo e(Form::email('email', null, ['class' => 'form-control','required' => ''])); ?>

										<?php if($errors->has('email')): ?>
                                 <span class="help-block">
                                    <strong class="text-danger"><?php echo e($errors->first('email')); ?></strong>
                                 </span>
                              <?php endif; ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Password <span class="text-danger">*</span></label>
										<input type="password" name="password" class="form-control" placeholder="*********************" required/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Confirm Password <span class="text-danger">*</span></label>
										<input type="password" name="password_confirmation" class="form-control" placeholder="*********************" required />
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="checkbox" value="Yes" required>
										By clicking Sign Up, you agree to our <a href="#">Terms</a> and that you have read our <a href="#">Data Policy</a>, including our <a href="javascript:;">Cookie Use</a>.
									</div>
								</div>
								<div class="col-md-12 mt-3">
									<div class="row">
										<div class="col-md-4"></div>
										<div class="col-md-4">
											<center>
												<button type="submit" class="btn btn-pink btn-block btn-lg submit">Create account</button>
												<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="80%">
											</center>
										</div>
										<div class="col-md-4"></div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<p class="text-center"> Already a member? Click <a href="<?php echo url('login'); ?>">here</a> to login.</p>
				<hr>
				<p class="text-center">&copy; Property Wingu All Right Reserved 2018 - <?php echo date('Y') ?> </p>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
	<!-- end page container -->
	<?php echo $__env->make('partials._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/auth/register.blade.php ENDPATH**/ ?>