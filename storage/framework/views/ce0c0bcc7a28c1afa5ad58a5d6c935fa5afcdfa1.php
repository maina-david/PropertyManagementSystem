<?php $__env->startSection('title','Edit Employee '); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
                <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human Resource</a></li>
                <li class="breadcrumb-item"><a href="<?php echo route('hrm.employee.index'); ?>">Employee</a></li>
            <li class="breadcrumb-item active">Details</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header"><i class="fas fa-user-circle"></i> Employement Details</h1>
        <!-- end page-header -->
		<div class="row">
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col-md-9">
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title"><?php echo $employee->names; ?> - Employement Details</div>
					</div>
					<div class="panel-body">
						<?php echo Form::model($employee, ['route' => ['hrm.employee.update',$employee->id], 'method'=>'post','enctype' => 'multipart/form-data','class' => 'row']); ?>

							<?php echo csrf_field(); ?>
							<div class="col-sm-6">
								<div class="form-group form-group-default required">
									<?php echo Form::label('names', 'Employee Names', array('class'=>'control-label text-danger')); ?>

									<?php echo Form::text('names', null, array('class' => 'form-control', 'placeholder' => 'Employee Names','required' => '')); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('Gender', 'Gender', array('class'=>'control-label')); ?>

									<?php echo e(Form::select('gender',[''=>'Choose Gender','Male'=>'Male','Female'=>'Female'], null, ['class' => 'form-control'])); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('Leave Days', 'Leave Days', array('class'=>'control-label')); ?>

									<?php echo e(Form::number('leave_days',null, ['class' => 'form-control','placeholder'=>'Enter leave days'])); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="">Department</label>
									<?php echo e(Form::select('department',$departments, null, ['class' => 'form-control multiselect'])); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="">Position/Job title</label>
									<?php echo e(Form::select('position',$positions, null, ['class' => 'form-control multiselect'])); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="">Branch</label>
									<?php echo e(Form::select('branch',$branches, null, ['class' => 'form-control multiselect'])); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="">People to report to.</label>
									<?php echo e(Form::select('report_to[]',$joinReport, null, ['class' => 'form-control multiple-select2','multiple' => 'multiple'])); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="">Departments to head</label>
									<?php echo e(Form::select('lead_department[]',$joinDepartments, null, ['class' => 'form-control multiple-deps','multiple' => 'multiple'])); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('company_id', 'Company ID', array('class'=>'control-label')); ?>

									<?php echo Form::text('companyID', null, array('class' => 'form-control', 'placeholder' => 'Enter Company ID')); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('company_email', 'Company Email', array('class'=>'control-label')); ?>

									<?php echo Form::email('company_email', null, array('class' => 'form-control', 'placeholder' => 'Enter company email')); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('company_phone_number', 'Company Phone Number', array('class'=>'control-label')); ?>

									<?php echo Form::text('company_phone_number', null, array('class' => 'form-control', 'placeholder' => 'Enter company Phone Number')); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('office_phone_extention', 'Office phone extention', array('class'=>'control-label')); ?>

									<?php echo Form::text('office_phone_extension', null, array('class' => 'form-control', 'placeholder' => 'Enter company phone extention')); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('source_of_hire', 'Source of Hire', array('class'=>'control-label')); ?>

									<?php echo Form::text('source_of_hire', null, array('class' => 'form-control', 'placeholder' => 'Enter source of hire')); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('employment_type', 'Contract type', array('class'=>'control-label')); ?>

									<?php echo e(Form::select('contract_type',[''=>'Select contract','Permanent'=>'Permanent','On Contract'=>'On Contract','Temporary'=>'Temporary','Trainee'=>'Trainee'], null, ['class' => 'form-control multiselect'])); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('hire_date', 'Date joined', array('class'=>'control-label')); ?>

									<?php echo Form::date('hire_date', null, array('class' => 'form-control')); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('employment_status', 'Employment status', array('class'=>'control-label')); ?>

									<?php echo e(Form::select('statusID',[''=>'Choose Status','25'=>'Employed','26'=>'Terminated','27'=>'Deceased','28'=>'Resigned'], null, ['class' => 'form-control multiselect'])); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('temporary_exist_date', 'Date of Exit if Temporary', array('class'=>'control-label')); ?>

									<?php echo Form::date('temporary_exist_date', null, array('class' => 'form-control')); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('termination_date', 'Termination date', array('class'=>'control-label')); ?>

									<?php echo Form::date('termination_date', null, array('class' => 'form-control')); ?>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<?php echo Form::label('Employee Image', 'Employeent Image', array('class'=>'control-label')); ?>

									<?php echo e(Form::file('image', null, ['class' => 'form-control'])); ?>

								</div>
								<?php if($employee->image != ""): ?>
									<a href="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/hr/employee/images/'.$employee->image); ?>" target="_blank">Click here to view image</a>
								<?php endif; ?>
							</div>
							<div class="col-md-12 mt-3">
								<center>
									<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save information</button>
									<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
								</center>
							</div>
						<?php echo Form::close(); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val(<?php echo json_encode($jointLeaders); ?>).trigger('change');
		$(".multiple-deps").select2();
		$(".multiple-deps").select2().val(<?php echo json_encode($jointHeads); ?>).trigger('change');
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/edit.blade.php ENDPATH**/ ?>