<?php $__env->startSection('title','Edit Licenses'); ?>

<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?> 
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo route('assets.dashboard'); ?>">Assets</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('assets.index'); ?>">Assets</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('assets.index'); ?>">License</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fal fa-laptop-code"></i> Edit License </h1>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo Form::model($edit, ['route' => ['licenses.assets.update',$edit->id], 'method'=>'post','enctype' => 'multipart/form-data', 'autocomplete' => 'off']); ?>

		<?php echo csrf_field(); ?>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Details</h4>
					</div>
					<div class="panel-body">						
						<div class="form-group form-group-default required">
							<?php echo Form::label('title', 'Software Name', array('class'=>'control-label')); ?>

							<?php echo Form::text('asset_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name','required' => '')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Status', 'Status', array('class'=>'control-label')); ?>

							<?php echo Form::select('status', ['' => 'choose status', '37' => 'Allocated', '29' => 'Ready to deploy', '30' => 'Archived'], null, array('class' => 'form-control multiselect')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Asset Image', 'Asset Image', array('class'=>'control-label')); ?>

                     <input type="file" name="asset_image"><br>
                  </div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Product Key', 'Product Key', array('class'=>'control-label')); ?>

							<?php echo Form::text('product_key', null, array('class' => 'form-control', 'placeholder' => 'Enter key')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Seats', 'Seats', array('class'=>'control-label')); ?>

							<?php echo Form::number('seats', null, array('class' => 'form-control', 'placeholder' => 'Enter Seats')); ?>

						</div>						
						<div class="form-group form-group-default">
							<?php echo Form::label('Manufacture', 'Manufacture', array('class'=>'control-label')); ?>

							<?php echo Form::text('manufacture', null, array('class' => 'form-control', 'placeholder' => 'Enter manufacture')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Licensed to Name', 'Licensed to Name', array('class'=>'control-label')); ?>

							<?php echo Form::text('licensed_to_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Licensed to Email', 'Licensed to Email', array('class'=>'control-label')); ?>

							<?php echo Form::email('licensed_to_email', null, array('class' => 'form-control', 'placeholder' => 'Enter model')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Reassignable', 'Reassignable', array('class'=>'control-label')); ?>

							<?php echo Form::select('reassignable', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')); ?>

                  </div>	
						<div class="form-group form-group-default">
							<?php echo Form::label('Supplier', 'supplier', array('class'=>'control-label')); ?>

							<?php echo Form::select('supplier', $suppliers, null, array('class' => 'form-control multiselect')); ?>

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
							<?php echo Form::label('Order Number', 'Order Number', array('class'=>'control-label')); ?>

							<?php echo Form::text('order_number', null, array('class' => 'form-control', 'placeholder' => 'Enter number')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Purchase Cost', 'Purchase Cost', array('class'=>'control-label')); ?>

							<?php echo Form::text('purches_cost', null, array('class' => 'form-control', 'placeholder' => 'Enter Cost')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Purchase date', 'Purchase date', array('class'=>'control-label')); ?>

							<?php echo Form::text('purchase_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Chooose date')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Termination Date', 'Termination Date', array('class'=>'control-label')); ?>

							<?php echo Form::text('end_of_life', null, array('class' => 'form-control datepicker', 'placeholder' => 'Chooose date')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Maintained', 'Is software maintained', array('class'=>'control-label')); ?>

							<?php echo Form::select('maintained', ['' => 'Choose','Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Next maintenance', 'Next maintenance', array('class'=>'control-label')); ?>

							<?php echo Form::text('next_maintenance', null, array('class' => 'form-control datepicker', 'placeholder' => 'Chooose date')); ?>

                  </div>	
                  <div class="form-group form-group-default">
							<?php echo Form::label('Note', 'Note', array('class'=>'control-label')); ?>

							<?php echo Form::textarea('note', null, array('class' => 'form-control ckeditor')); ?>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<center>
					<button type="submit" class="btn btn-pink submit btn-lg"><i class="fas fa-save"></i> Update License</button>
					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
				</center>
			</div>
		</div>
	<?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
<script type="text/javascript">
	CKEDITOR.replaceClass="ckeditor";
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/licenses/edit.blade.php ENDPATH**/ ?>