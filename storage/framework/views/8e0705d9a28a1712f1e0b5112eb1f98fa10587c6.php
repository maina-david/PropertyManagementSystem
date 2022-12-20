<?php $__env->startSection('title','Employee Files'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
			<li class="breadcrumb-item active">Employee Files</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Employee Files</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<div class="col-md-9">
						<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">Employee Files</div>
						</div>
						<div class="panel-body">
							<a  href="#" data-toggle='modal' data-target="#myModal" class="btn btn-pink mb-3 pull-right"><i class="fa fa-upload" aria-hidden="true"></i> Upload Files</a><br>
							<table class="table table-bordered">
								<tr>
									<th>#</th>
									<th>File</th>
									<th>File Name</th>
									<th>File Type</th>
									<th>File Size</th>
									<th>Action</th>
								</tr>
								<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td></td>
										<td><?php echo $fl->name; ?></td>
										<td><?php echo $fl->file_mime; ?></td>
										<td><?php echo $fl->file_size/100000; ?> Mb</td>
										<td colspan="" rowspan="" headers="">
											<div class="btn-group sm-m-t-10">
												<a class="btn btn-danger delete" href="<?php echo e(route('hrm.employeefile.delete',$fl->id)); ?>"><i class="fas fa-trash"></i>
												</a>
											</div>
										</td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</table>
						</div>
					</div>
		        </div>
            </div>
		</div>
	</div>
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body col-md-12">
				<?php echo Form::open(array('route' => 'hrm.employeefile.post','class'=>'dropzone','method' => 'post')); ?>

						<?php echo e(csrf_field()); ?>

						<input type="hidden" name="employee_id" value="<?php echo $employee->id; ?>">
						<?php echo Form::close(); ?>

				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-pink submit" data-dismiss="modal" onClick="window.location.href=window.location.href">Save images</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/files.blade.php ENDPATH**/ ?>