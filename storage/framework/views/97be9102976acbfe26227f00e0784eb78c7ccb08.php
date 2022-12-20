<?php $__env->startSection('title','All Requests'); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Leave</li>
         <li class="breadcrumb-item active">Requests</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">All Requests</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<!-- begin widget-list -->
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="widget-list widget-list-rounded mb-2 col-md-4">
							<!-- begin widget-list-item -->
							<div class="widget-list-item">
								<div class="widget-list-media">
									<?php if($leave->statusID == 7): ?>
										<i class="fas fa-calendar-day fa-4x"></i>
									<?php endif; ?>
									<?php if($leave->statusID == 20): ?>
										<i class="fas fa-calendar-times fa-4x text-danger"></i>
									<?php endif; ?>
									<?php if($leave->statusID == 19): ?>
										<i class="fas fa-calendar-check fa-4x text-success"></i>
									<?php endif; ?>
								</div>
								<div class="widget-list-content">
									<h4 class="widget-list-title font-weight-bold">
										<?php echo $leave->names; ?>

									</h4>
									<p class="widget-list-desc">
										<i class="text-info">
											<b>
												<?php echo $leave->leaveName; ?>

											</b>
										</i>
										<br>
										From : <b><?php echo date('d F, Y', strtotime($leave->start_date)); ?></b><br>
										To : <b><?php echo date('d F, Y', strtotime($leave->end_date)); ?></b><br>
										<b><?php echo $leave->days; ?> days</b>
										<br>
										Status : <span class="badge <?php echo $leave->statusName; ?>"><?php echo $leave->statusName; ?></span>
									</p>
								</div>
								<div class="widget-list-action">
									<a href="#" data-toggle="dropdown" class="text-muted pull-right">
										<i class="fa fa-ellipsis-h f-s-14"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="<?php echo route('hrm.leave.edit',$leave->leaveID); ?>">Edit</a></li>
										<?php if($leave->statusID  != 19): ?>
											<li><a href="<?php echo route('hrm.leave.approve',$leave->leaveID); ?>">Approve</a></li>
										<?php endif; ?>
										<?php if($leave->statusID  != 20): ?>
											<li><a href="<?php echo route('hrm.leave.denay',$leave->leaveID); ?>">Denay</a></li> 
										<?php endif; ?>
										<?php if (app('laratrust')->isAbleTo('delete-leave')) : ?>
											<li><a href="<?php echo route('hrm.leave.delete',$leave->leaveID); ?>">Delete</a></li>
										<?php endif; // app('laratrust')->permission ?>
									</ul>
								</div>
							</div>
							<!-- end widget-list-item -->
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card">
					<div class="card-body">
						<div class="leave-tip">
							<h2><?php echo $current; ?></h2>
							<p>Employees on leave currently</p>
						</div>
						<div class="leave-tip">
							<h2><?php echo $pending; ?></h2>
							<p>Pending Requests</p>
						</div>
						<div class="leave-tip">
							<h2><?php echo $approved; ?></h2>
							<p>Approved Request</p>
						</div>
						<div class="leave-tip">
							<h2><?php echo $rejected; ?></h2>
							<p>Rejected Request</p>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	   <!-- end widget-list -->
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/leave/index.blade.php ENDPATH**/ ?>