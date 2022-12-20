<?php $__env->startSection('title','Add Lead'); ?>

<?php $__env->startSection('stylesheet'); ?>
<script type="text/javascript">
	.nav > li {
		position: relative;
		display: block;
		/* width: 100%; */
	}
</script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo route('crm.dashboard'); ?>">CRM</a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('crm.leads.index'); ?>">Leads</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<form action="" method="post"></form>
	<h1 class="page-header"><i class="fas fa-phone-volume"></i> Add Lead </h1>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo Form::open(array('route' => 'crm.leads.store','enctype'=>'multipart/form-data', 'method'=>'post' )); ?>

		<?php echo csrf_field(); ?>

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Details</h4>
					</div>
					<div class="panel-body">
						<div class="form-group form-group-default">
							<?php echo Form::label('designation', 'Lead Owner', array('class'=>'control-label')); ?>

							<?php echo Form::select('assignedID', $employees, null, array('class' => 'form-control multiselect')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('title', 'Title', array('class'=>'control-label')); ?>

							<?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Lead Type', 'Lead Type', array('class'=>'control-label')); ?>

							<?php echo e(Form::select('lead_type',[''=>'Choose Lead Type','Individual'=>'Individual','Organization'=>'Company/Organization'], null, ['class' => 'form-control multiselect','id' => 'contact_type'])); ?>

						</div>
						<div class="row" style="display:none;" id="individual">
							<div class="col-sm-4">
								<div class="form-group form-group-default">
									<?php echo Form::label('Salutation', 'Salutation', array('class'=>'control-label')); ?>

									<?php echo e(Form::select('salutation',[''=>'Choose Salutation','Mr'=>'Mr','Mrs'=>'Mrs','Ms' => 'Ms','Miss' => 'Miss','Dr' => 'Dr'], null, ['class' => 'form-control multiselect'])); ?>

								</div>
							</div>
							<div class="col-sm-8">
								<div class="form-group form-group-default ">
									<?php echo Form::label('Position', 'Position', array('class'=>'control-label')); ?>

									<?php echo Form::text('position', null, array('class' => 'form-control', 'placeholder' => 'Enter individuals position')); ?>

								</div>
							</div>
						</div>
						<div class="form-group form-group-default required">
							<?php echo Form::label('Leads name', 'Leads Name', array('class'=>'control-label text-danger')); ?>

							<?php echo Form::text('leads_name', null, array('class' => 'form-control', 'placeholder' => 'Enter leads name', 'required' => '')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('email', 'Email Address', array('class'=>'control-label')); ?>

							<?php echo Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact Email')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('designation', 'Industry', array('class'=>'control-label')); ?>

							<?php echo Form::select('industry', $industry, null, array('class' => 'form-control multiselect')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('status', 'Status', array('class'=>'control-label')); ?>

							<?php echo Form::select('status', $status, null, array('class' => 'form-control multiselect')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('website', 'Website', array('class'=>'control-label')); ?>

							<?php echo Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')); ?>

						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Details</h4>
					</div>
					<div class="panel-body">
						<div class="form-group form-group-default">
							<?php echo Form::label('location', 'Location', array('class'=>'control-label')); ?>

							<?php echo Form::text('location', null, array('class' => 'form-control', 'placeholder' => 'Enter location')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Source', 'Source', array('class'=>'control-label')); ?>

							<?php echo Form::select('sourceID', $sources, null, array('class' => 'form-control multiselect')); ?>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-default required">
									<?php echo Form::label('Phone number', 'Phone Number', array('class'=>'control-label text-danger')); ?>

									<?php echo Form::text('phone_number', null, array('class' => 'form-control','required' => '','placeholder' => 'Enter phone number')); ?>

								</div>
							</div>
						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Source', 'Postal address', array('class'=>'control-label')); ?>

							<?php echo Form::text('postal_address', null, array('class' => 'form-control','placeholder' => 'Enter address')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('country', 'Country', array('class'=>'control-label')); ?>

							<?php echo Form::select('country', $country, null, array('class' => 'form-control multiselect')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('City', 'City', array('class'=>'control-label')); ?>

							<?php echo Form::text('city', null, array('class' => 'form-control','placeholder' => 'Enter location')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('state', 'State', array('class'=>'control-label')); ?>

							<?php echo Form::text('state', null, array('class' => 'form-control','placeholder' => 'Enter state')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('zip code', 'Zip Code', array('class'=>'control-label')); ?>

							<?php echo Form::text('zip_code', null, array('class' => 'form-control','placeholder' => 'Enter zip code')); ?>

						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">Contact persons</div>
					<div class="card-body">
						<table class="table table-bordered contact_persons">
							<tr>
								<th><input class='check_all' type='checkbox' onclick="select_all()" /></th>
								<th>#</th>
								<th>Salutation</th>
								<th>Full Names</th>
								<th>Email Address</th>
								<th>Phone Number</th>
								<th>Designation</th>
							</tr>
						</table>
						<button type="button" class='btn btn-danger delete_contact_persons'>- Delete</button>
						<button type="button" class='btn btn-success addmore_contact_persons'>+ Add More</button>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Description</h4>
					</div>
					<div class="panel-body">
						<?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor')); ?>

					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<center>
					<button type="submit" class="btn btn-pink submit btn-lg"><i class="fas fa-save"></i> Create Lead</button>
					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="13%">
				</center>
			</div>
		</div>
	<?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
	$(document).ready(function() {
		$('#contact_type').on('change', function() {
			if (this.value == 'Individual') {
				$('#individual').show();
			} else {
				$('#individual').hide();
			}

			if (this.value == 'Organization') {
				$('#company').show();
			} else {
				$('#company').hide();
			}
		});
	});

	$(".delete_contact_persons").on('click', function() {
		$('.case:checkbox:checked').parents("tr").remove();
		$('.check_all').prop("checked", false);
		check();
	});

	var i = $('.contact_persons tr').length;
	var n = 1;
	$(".addmore_contact_persons").on('click', function() {
		count = $('.contact_persons tr').length;
		var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum" + i + "'>" + n++ + ".</span></td>";
		data +=
			"<td><select id='cn_salutation' class='form-control' name='cn_salutation[]'><option value='' selected='selected'>Choose Salutation</option><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option></select></td><td><input class='form-control' type='text' id='cn_names" +
			i + "' name='cn_names[]'></td><td><input class='form-control' type='text' id='email_address_" + i + "' name='email_address[]'></td><td><input class='form-control' type='text' id='phone_number_" + i +
			"' name='cp_phone_number[]'></td><td><input class='form-control' type='text' id='cn_desgination_" + i + "' name='cn_desgination[]'></td><tr>";
		$('.contact_persons').append(data);
	});


	$("#set-post-thumbnail").click(function() {
		$("input[id='thumbnail']").click();
	});
</script>
<script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
<script type="text/javascript">
	CKEDITOR.replaceClass="ckeditor";
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/leads/create.blade.php ENDPATH**/ ?>