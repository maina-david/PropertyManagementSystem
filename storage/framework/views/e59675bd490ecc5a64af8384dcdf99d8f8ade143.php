<?php $__env->startSection('title','Edit Travel Request | Travel | Human Resource'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo e(Nav::isRoute('hrm.dashboard')); ?>">Human resource</a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('hrm.travel.index'); ?>">Travel</a></li>
		<li class="breadcrumb-item active">Edit Travel Requests</li>
	</ol>
	<h1 class="page-header"><i class="fal fa-plane"></i> Edit Travel Request</h1>
	<!-- end page-header -->
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<!-- begin panel -->
	<?php echo Form::model($travel, ['route' => ['hrm.travel.update',$travel->travelID], 'method'=>'post','class' => 'row']); ?>

		<?php echo csrf_field(); ?>
		<div class="col-md-6"> 
			<div class="panel panel-default">
				<div class="panel-heading">Travel Details</div>
				<div class="panel-body">
					<div class="form-group form-group-default required">
						<label class="text-danger">Employee</label>
						<?php echo Form::select('employee[]',$employees,null,['class'=>'form-control multiple-select2','required'=>'','multiple'=>'multiple']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Department</label>
						<?php echo Form::select('department[]',$departments,null,['class'=>'form-control department-select','required'=>'','multiple'=>'multiple']); ?>

					</div>
					<div class="form-group form-group-default required"> 
						<label class="text-danger">Expected date of departure</label>
						<?php echo Form::date('departure_date',null,['class'=>'form-control','required'=>'']); ?>

					</div>	
					<div class="form-group form-group-default required">
						<label class="text-danger">Expected date of arrival</label>
						<?php echo Form::date('date_of_arrival',null,['class' =>'form-control','required'=>'']); ?>

					</div>	
					<div class="form-group form-group-default required">
						<label class="text-danger">Expected duration in days</label>
						<?php echo Form::number('duration',null,['class' =>'form-control','placeholder'=>'Enter number','required'=>'']); ?>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6"> 
			<div class="panel panel-default">	
				<div class="panel-heading">Travel Details</div>				
				<div class="panel-body">
					<div class="form-group form-group-default required">
						<label class="text-danger">Purpose of visit</label>
						<?php echo FORM::text('purpose_of_visit',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter purpose of visit']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Place of visit</label>
						<?php echo FORM::text('place_of_visit',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter place of visit']); ?>

					</div>	
					<div class="form-group form-group-default required">
						<label class="text-danger">Customer name</label>
						<?php echo Form::select('customer',$customers,null,['class'=>'form-control multiselect','required'=>'']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Is billable to customer</label>
						<?php echo Form::select('bill_customer',['' => 'Choose','Yes' => 'Yes','No' => 'No'],null,['class'=>'form-control','required'=>'']); ?>

					</div>	
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information </button>
			<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
		</div>
	<?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val(<?php echo json_encode($joinEmployees); ?>).trigger('change');
		$(".department-select").select2();
		$(".department-select").select2().val(<?php echo json_encode($joinDepartments); ?>).trigger('change');
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/travel/edit.blade.php ENDPATH**/ ?>