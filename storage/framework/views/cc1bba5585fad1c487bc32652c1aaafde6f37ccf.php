<?php $__env->startSection('title','Sent Mail'); ?>

<?php $__env->startSection('stylesheet'); ?>
	<style>
	</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<!-- begin #content -->
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">CRM</a></li>
		<li class="breadcrumb-item"><a href="#">Email</a></li>
		<li class="breadcrumb-item active">List</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="far fa-paper-plane"></i> Sent Emails </h1>
	<!-- Right Sidebar -->
	<div class="row">
		<div class="col-md-12">		
			<div class="card">
				<div class="card-body">
					<!-- Left sidebar -->
					<?php echo $__env->make('app.crm.mail._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
					<!-- End Left sidebar -->

					<div class="page-aside-right">
						

						<div class="mt-3">
							<ul class="list-group list-group-lg no-radius list-email">
								<?php $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li class="list-group-item">
										<div class="email-checkbox">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox1">
												<label class="custom-control-label" for="emailCheckbox1"></label>
											</div>
										</div>
										<a href="<?php echo route('crm.mail.details',$email->mailID); ?>" class="email-user bg-blue">
											<span class="text-white"><?php echo mb_substr($email->customer_name, 0, 1);; ?></span>
										</a>
										<div class="email-info">
											<a href="<?php echo route('crm.mail.details',$email->mailID); ?>">
												<span class="email-sender"><b><?php echo $email->customer_name; ?></b></span>
												<span class="email-title"><?php echo $email->subject; ?></span>
												<span class="email-time"><?php echo date('jS M, Y', strtotime($email->sentDate)); ?></span>
											</a>
										</div>
									</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
						<!-- end .mt-4 -->

						<div class="row">
							<div class="col-7 mt-3">
									Showing 1 - <?php echo $emails->currentPage() * 16; ?> of <?php echo $totalEmails; ?>

							</div> <!-- end col-->
							<div class="col-5 mt-3">
								<div class="btn-group float-right">
									<?php if($emails->lastPage() > 1): ?>
										<a href="<?php echo e($emails->url(1)); ?>" class="btn btn-light btn-sm"><i class="mdi mdi-chevron-left"></i></a>
										<a href="<?php echo e($emails->url($emails->currentPage()+1)); ?>" class="btn btn-info btn-sm"><i class="mdi mdi-chevron-right"></i></a>
									<?php endif; ?>
								</div>
							</div> <!-- end col-->
						</div>
						<!-- end row-->
					</div> 
					<!-- end inbox-rightbar-->
				</div>
				<!-- end card-body -->
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- end #content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/mail/sent.blade.php ENDPATH**/ ?>