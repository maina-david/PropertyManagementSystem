<?php $__env->startSection('title','Personal Information '); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
			<li class="breadcrumb-item active">Personal Information</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fas fa-male"></i> Personal Information</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col-md-9">
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        		<?php echo Form::model($edit, ['route' => ['hrm.personalinfo.update',$edit->empid], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data','autocomplete' => 'off']); ?>

        			<?php echo e(csrf_field()); ?>

            	<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title"><span class="green"><?php echo $employee->names; ?> </span> - Personal Information</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('personal_email', 'Personal Email', array('class'=>'control-label')); ?>

										<?php echo Form::email('personal_email', null, array('class' => 'form-control', 'placeholder' => 'Enter Personal Email')); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('personal_number', 'Personal Number', array('class'=>'control-label')); ?>

										<?php echo Form::text('personal_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Personal Number')); ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('id_number', 'ID Number', array('class'=>'control-label')); ?>

										<?php echo Form::text('nationalID', null, array('class' => 'form-control', 'placeholder' => 'Enter ID Number')); ?>

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('marital_status', 'Marital status', array('class'=>'control-label')); ?>

										<?php echo e(Form::select('marital_status',[''=>'Choose Marital multiselect','Single'=>'Single','Married'=>'Married'], null, ['class' => 'form-control'])); ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('passport_number', 'Passport Number', array('class'=>'control-label')); ?>

										<?php echo Form::text('passport_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Passport Number')); ?>

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('nationality', 'Nationality', array('class'=>'control-label')); ?>

										<?php echo e(Form::text('nationality', null, ['class' => 'form-control', 'placeholder' => 'Enter nationality'])); ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('dob', 'Date of Birth', array('class'=>'control-label')); ?>

										<?php echo Form::text('dob', null, array('class' => 'form-control datepicker', 'placeholder' => 'Enter Date of Birth')); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('home_address', 'Home Address', array('class'=>'control-label')); ?>

										<?php echo Form::text('home_address', null, array('class' => 'form-control', 'placeholder' => 'Enter Home Address')); ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('current home location', 'Current Home Location', array('class'=>'control-label')); ?>

										<?php echo Form::text('current_home_location', null, array('class' => 'form-control', 'placeholder' => 'Enter Current Home Location')); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('region_of_birth', 'Region of Birth', array('class'=>'control-label')); ?>

										<?php echo Form::text('region_of_birth', null, array('class' => 'form-control', 'placeholder' => 'Enter Region of Birth')); ?>

									</div>
								</div>
							</div>
							
							<div class="row">
								
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('religion', 'Religion', array('class'=>'control-label')); ?>

										<?php echo Form::select('religion', ['' => 'Choose Religion','Christian' => 'Christian','Islam' => 'Islam','Nonreligious' => 'Nonreligious','Hinduism' => 'Hinduism','Buddhism' => 'Buddhism'], null , array('class' => 'form-control multiselect')); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('hospital_of_choice', 'Hospital of choice', array('class'=>'control-label')); ?>

										<?php echo Form::text('hospital_of_choice', null, array('class' => 'form-control', 'placeholder' => 'Enter Hospital of choice')); ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">

								</div>
							</div>
							<div class="form-group"><br>
								<center><input class="btn btn-pink submit" type="submit" value="Update Information"></center>
								<center><img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%"></center>
							</div>
						</div>
					</div>
	        <?php echo Form::close(); ?>

			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/personal.blade.php ENDPATH**/ ?>