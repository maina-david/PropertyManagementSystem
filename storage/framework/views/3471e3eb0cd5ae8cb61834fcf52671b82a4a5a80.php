<?php $__env->startSection('title','Summary'); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
			<li class="breadcrumb-item active">Summery</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fas fa-address-card"></i> Employee Summery</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col-md-9">
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        		<?php echo Form::model($edit, ['route' => ['hrm.employeesummery.update',$edit->empid], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']); ?>

        			<?php echo e(csrf_field()); ?>

            	<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title"><span class="green"><?php echo $edit->names; ?></span> - Summery Information</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<?php echo Form::label('Job Description', 'Job Description', array('class'=>'control-label')); ?>

										<?php echo Form::textarea('job_description',null,['class'=>'ck4standard form-control ckeditor', 'rows' => 5, 'placeholder'=>'content']); ?>

									</div>
								</div>
								<div class="col-md-12 mt-5">
									<div class="form-group">
										<?php echo Form::label('About Employee', 'About Employee', array('class'=>'control-label')); ?>

										<?php echo Form::textarea('about_me',null,['class'=>'ck4standard form-control ckeditor', 'rows' => 5, 'placeholder'=>'content']); ?>

									</div>
								</div>
							</div>
							<div class="form-group">
								<center>
									<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information</button>
									<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
								</center>
							</div>
						</div>
					</div>
		      <?php echo Form::close(); ?>

         </div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo asset('assets/plugins/ckeditor/4/full/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/summery.blade.php ENDPATH**/ ?>