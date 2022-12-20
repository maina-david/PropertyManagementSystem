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
                     <h5>
                        <?php echo $email->subject; ?>

                        <span class="float-right">
                           Opened <?php echo $email->view_count; ?> times
                        </span>
                     </h5>
                     <hr>
                     <div class="media mb-3 mt-1">
                        <?php if($email->image == ""): ?>
                           <img alt="<?php echo $email->customer_name; ?>" src="<?php echo "https://www.gravatar.com/avatar/". md5(strtolower(trim($email->email))) . "?s=200&d=wavatar"; ?>" class="d-flex mr-2 rounded-circle" width="40" height="40">
                        <?php else: ?>
                           <img width="40" height="40" alt="" class="img-circle" src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/clients/'.$email->email.'/images/'.$email->image); ?>">
                        <?php endif; ?>
                        <div class="media-body">
                           <small class="float-right"><?php echo date('jS F, Y h:i:A', strtotime($email->sentDate)); ?></small>
                           <h6 class="m-0 font-14"><?php echo $email->customer_name; ?></h6>
                           <small class="text-muted">To: <?php echo $email->mail_to; ?></small>
                        </div>
                     </div>

                     <?php echo $email->message; ?>

                     
                                             
                     
                  </div>
						<!-- end .mt-4 -->
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/mail/details.blade.php ENDPATH**/ ?>