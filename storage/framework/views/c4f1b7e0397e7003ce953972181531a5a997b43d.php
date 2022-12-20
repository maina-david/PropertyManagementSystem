<?php $__env->startSection('title','Edit Exit Details'); ?>

<?php $__env->startSection('stylesheets'); ?>
	<?php echo Html::style('resources/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css'); ?>

	<?php echo Html::style('resources/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css'); ?>

	<?php echo Html::style('resources/assets/plugins/datatables-responsive/css/datatables.responsive.css'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-menu'); ?>
	<?php echo $__env->make('Limitless.Human-resource.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="content clearfix"> 
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">					 
					<ul class="breadcrumb">
						<li><a href="#">Human Resource</a></li>
						<li><a href="#" class="active">Edit Exit Details</a></li>
					</ul>
				</div>
			</div>
		</div> 
		<br>
		<div class="col-md-6"> 
			<div class="panel panel-default">
				<div class="panel-body">	
					<p><b>Separation</b></p>					
					<form class="" role="form">
						<div class="form-group form-group-default form-group-default-select2">
							<label>Choose Employee</label>
							<select class="full-width" data-init-plugin="select2" id="client_select" name="customer_id" required="">
								<option value="">Choose Employee</option>
								<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo $emp->id; ?>"> <?php echo $emp->first_name; ?> <?php echo $emp->middle_name; ?> <?php echo $emp->last_name; ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							</select>
						</div>
						<div class="form-group form-group-default form-group-default-select2">
							<label>Choose Interviewer</label>
							<select class="full-width" data-init-plugin="select2" id="client_select" name="customer_id" required="">
								<option value="">Choose Interviewer</option>
								<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo $emp->id; ?>"> <?php echo $emp->first_name; ?> <?php echo $emp->middle_name; ?> <?php echo $emp->last_name; ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							</select>
						</div>
						<div class="form-group form-group-default required">
							<label>Separation date</label>
							<input type="text" class="form-control datepicker" placeholder="Separation date" required="">
						</div>
						<div class="form-group form-group-default required">
							<label>Reason for leaving</label>
							<textarea type="text" class="form-control tinymce" placeholder="Separation date"></textarea>
						</div>						
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-6"> 
			<div class="panel panel-default">					
				<div class="panel-body">
					<p><b>Checklist for Exit Interview</b></p>			
					<form class="" role="form">
						<div class="form-group form-group-default required ">
							<label>Company Vehicle handed in</label>
							<input type="email" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required ">
							<label>Exit interview conducted</label>
							<input type="email" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required ">
							<label>Resignation letter submitted</label>
							<input type="email" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required ">
							<label>All library books submitted</label>
							<input type="email" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required">
							<label>Manager/Supervisor clearance</label>
							<input type="password" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required">
							<label>Security</label>
							<input type="password" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required">
							<label>Notice period followed</label>
							<input type="password" class="form-control" required="">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-12"> 
			<div class="panel panel-default">
				<div class="panel-body">	
					<p><b>Questionairre</b></p>					
					<form class="" role="form">
						<div class="form-group form-group-default required">
							<label>Think the organization do to improve staff welfare</label>
							<textarea type="text" class="form-control " rows="9" placeholder="Think the organization do to improve staff welfare" style="height: 150px"></textarea>
						</div>
						<div class="form-group form-group-default required">
							<label>What did you like the most of the organization</label>
							<textarea type="text" class="form-control " cols="6" placeholder="What did you like the most of the organization" style="height: 150px"></textarea>
						</div>
						<div class="form-group form-group-default required">
							<label>Anything you wish to share with us</label>
							<textarea type="text" class="form-control " row="6" placeholder="Anything you wish to share with us" style="height: 150px"></textarea>
						</div>	
					</form>
				</div>
			</div>
			<button type="submit" class="btn btn-info">Save Exit Details</button>
		</div>

	</div>		
<br>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

	<script src="<?php echo e(url('/')); ?>/resources/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js" type="text/javascript"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo e(url('/')); ?>/resources/assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
	<script type="text/javascript" src="<?php echo e(url('/')); ?>/resources/assets/plugins/datatables-responsive/js/lodash.min.js"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/pages/js/pages.min.js"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/js/datatables.js" type="text/javascript"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/ExitDetails/edit.blade.php ENDPATH**/ ?>