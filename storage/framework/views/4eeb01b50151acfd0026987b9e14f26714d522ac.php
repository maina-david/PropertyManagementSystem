<?php $__env->startSection('title','Edit Asset'); ?>

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
		<li class="breadcrumb-item active">Edit</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-barcode"></i> Edit Asset </h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php echo Form::model($edit, ['route' => ['assets.update',$edit->id], 'method'=>'post','enctype' => 'multipart/form-data']); ?>

		<?php echo csrf_field(); ?>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Details</h4>
					</div>
					<div class="panel-body">						
						<div class="form-group form-group-default required">
							<?php echo Form::label('title', 'Asset Name', array('class'=>'control-label')); ?>

							<?php echo Form::text('asset_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name','required' => '')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Asset Type', 'Asset Type', array('class'=>'control-label')); ?>

                     <select name="asset_type" id="type" class="form-control multiselect">
								<?php if($edit->asset_type == ""): ?>
									<option value="">Choose</option>
								<?php elseif($edit->asset_type == 1): ?>
									<option value="1">Vehicle</option>
								<?php else: ?>
									<option value="<?php echo $edit->asset_type; ?>"><?php echo Asset::type(2)->name; ?></option>
								<?php endif; ?>								
								<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Asset Image', 'Asset Image', array('class'=>'control-label')); ?>

                     <input type="file" name="asset_image" accept="image/*" id="file">
                  </div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Asset Tag', 'Asset Tag', array('class'=>'control-label')); ?>

							<?php echo Form::text('asset_tag', null, array('class' => 'form-control', 'placeholder' => 'Enter tag')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Serial', 'Serial', array('class'=>'control-label')); ?>

							<?php echo Form::text('serial', null, array('class' => 'form-control', 'placeholder' => 'Enter serial')); ?>

						</div>	
                  <div class="form-group form-group-default">
							<?php echo Form::label('manufacture', 'Manufacture', array('class'=>'control-label')); ?>

							<?php echo Form::text('manufacture', null, array('class' => 'form-control', 'placeholder' => 'Enter manufacture')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Asset Model', 'Asset Model', array('class'=>'control-label')); ?>

							<?php echo Form::text('asset_model', null, array('class' => 'form-control', 'placeholder' => 'Enter model')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Asset Brand', 'Asset Brand', array('class'=>'control-label')); ?>

							<?php echo Form::text('asset_brand', null, array('class' => 'form-control', 'placeholder' => 'Enter brand')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Supplier', 'supplier', array('class'=>'control-label')); ?>

							<?php echo Form::select('supplier', $suppliers, null, array('class' => 'form-control multiselect')); ?>

                  </div>			
						<div class="form-group form-group-default">
							<?php echo Form::label('Order Number', 'Order Number', array('class'=>'control-label')); ?>

							<?php echo Form::text('order_number', null, array('class' => 'form-control', 'placeholder' => 'Enter number')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Has insurance cover', 'Has insurance cover', array('class'=>'control-label')); ?>

							<?php echo Form::select('has_inurance_cover',['' => 'choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Insurance expiry date', 'Insurance expiry date', array('class'=>'control-label')); ?>

							<?php echo Form::text('insurance_expiry_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Last Audit Date and Time', 'Last Audit Date and Time', array('class'=>'control-label')); ?>

							<?php echo Form::text('last_audit', null, array('class' => 'form-control datetimepicker', 'placeholder' => 'Choose date and time')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('End of life', 'End of life', array('class'=>'control-label')); ?>

							<?php echo Form::text('end_of_life', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Asset condition', 'Asset condition', array('class'=>'control-label')); ?>

							<?php echo Form::select('asset_condition',['' => 'Choose','New' => 'New','Used' => 'Used'], null, array('class' => 'form-control multiselect')); ?>

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
						<?php if($edit->asset_type == 1): ?>
							<div id="vehicle-details">
								<h4>Vehicle details</h4>
								<div class="form-group form-group-default">
									<?php echo Form::label('Mileage', 'Mileage', array('class'=>'control-label')); ?>

									<?php echo Form::text('mileage', null, array('class' => 'form-control', 'placeholder' => 'Enter mileage')); ?>

								</div>
								<div class="form-group form-group-default">
									<?php echo Form::label('Next oil change', 'Next oil change', array('class'=>'control-label')); ?>

									<?php echo Form::text('oil_change', null, array('class' => 'form-control datepicker', 'placeholder' => 'Enter date')); ?>

								</div>
								<div class="form-group form-group-default">
									<?php echo Form::label('Licence plate', 'Licence plate', array('class'=>'control-label')); ?>

									<?php echo Form::text('licence_plate', null, array('class' => 'form-control', 'placeholder' => 'Enter licence plate')); ?>

								</div>
								<div class="form-group form-group-default">
									<?php echo Form::label('Vehicle Types', 'Vehicle Types', array('class'=>'control-label')); ?>

									<?php echo Form::select('vehicle_type',$carTypes, null, array('class' => 'form-control multiselect')); ?>

								</div>
								<div class="form-group form-group-default">
									<?php echo Form::label('Vehicle make', 'Vehicle make', array('class'=>'control-label')); ?>

									<?php echo e(Form::select('vehicle_make',$makes, null, ['class' => 'form-control multiselect', 'id'=>'car_make','onchange' => 'get_model()'])); ?>

								</div>
								<div class="form-group form-group-default">
									<label for="Car Model">Model</label>
									<select class="form-control multiselect" name="vehicle_model" id="model">
										<?php if($edit->vehicle_model != ""): ?>
											<option value="<?php echo $edit->vehicle_model; ?>"><?php echo Asset::car_model($edit->vehicle_model)->name; ?></option>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group form-group-default">
									<?php echo Form::label('year of manufacture', 'Year of manufacture', array('class'=>'control-label')); ?>

									<?php echo Form::select('vehicle_year_of_manufacture',['' => 'choose'], null, array('class' => 'form-control multiselect')); ?>

								</div>
								<div class="form-group form-group-default">
									<?php echo Form::label('Vehicle color', 'Vehicle color', array('class'=>'control-label')); ?>

									<?php echo Form::select('vehicle_color',['' => 'choose'], null, array('class' => 'form-control multiselect')); ?>

								</div>
								<hr>
							</div>  
						<?php endif; ?>    
						<div class="form-group form-group-default">
							<?php echo Form::label('Maintained', 'Maintained', array('class'=>'control-label')); ?>

							<?php echo Form::select('maintained', ['' => 'Choose','Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')); ?>

                  </div>	            
                  <div class="form-group form-group-default">
							<?php echo Form::label('Accessories', 'Accessories linked to asset', array('class'=>'control-label')); ?>

							<?php echo Form::text('accessories', null, array('class' => 'form-control','id'=>'accessories','placeholder' => 'Enter accessories')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Depreciable assets', 'Depreciable assets', array('class'=>'control-label')); ?>

							<?php echo Form::select('depreciable_assets',['' => 'Choose','Yes'=>'Yes','No'=>'No'], null, array('class' => 'form-control multiselect')); ?>

                  </div>                  
                  <div class="form-group form-group-default">
							<?php echo Form::label('Purchase Cost', 'Purchase Cost', array('class'=>'control-label')); ?>

							<?php echo Form::number('purches_cost', null, array('class' => 'form-control', 'placeholder' => 'Enter Cost','step'=>'0.01')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Purchase date', 'Purchase date', array('class'=>'control-label')); ?>

							<?php echo Form::text('purchase_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Warranty', 'Warranty (In months)', array('class'=>'control-label')); ?>

							<?php echo Form::number('warranty', null, array('class' => 'form-control', 'placeholder' => 'Enter warranty')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('warranty expiration', 'warranty expiration', array('class'=>'control-label')); ?>

							<?php echo Form::text('warranty_expiration', null, array('class' => 'form-control datepicker', 'placeholder' => 'Enter datepicker')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Asset color', 'Asset color', array('class'=>'control-label')); ?>

							<?php echo Form::select('asset_color',['' => 'Choose','Red' => 'Red','Black' => 'Black','Blue' => 'Blue','Yellow' => 'Yellow','Brown' => 'Brown','Pink' => 'Pink','Purple' => 'Purple','Grey' => 'Grey','White' => 'White','Silver' => 'Silver','Gold' => 'Gold','Nevy Blue' => 'Nevy Blue','Orange' => 'Orange','Green' => 'Green'], null, array('class' => 'form-control multiselect')); ?>

						</div>
						<div class="form-group form-group-default">
							<?php echo Form::label('Location', 'Location (if located outside business area)', array('class'=>'control-label')); ?>

							<?php echo Form::text('default_location',null, array('class' => 'form-control', 'placeholder' => 'Enter location')); ?>

                  </div>
                  <div class="form-group form-group-default">
							<?php echo Form::label('Requestable', 'Is asset requestable', array('class'=>'control-label')); ?>

							<?php echo Form::select('requestable',['No' => 'No','Yes' => 'Yes'], null, array('class' => 'form-control multiselect')); ?>

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
					<button type="submit" class="btn btn-pink submit btn-lg"><i class="fas fa-save"></i> Edit Asset</button>
					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
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
<script> 
	$(document).ready(function() {
		$('#assignedTo').on('change', function() {
			if (this.value == 'Employee') {
				$('#employee').show();
			} else {
				$('#employee').hide();
			}

			if(this.value == 'Customer') {
				$('#customer').show();
			} else {
				$('#customer').hide();
			}
		});
		$('#type').on('change', function() {
			if(this.value == 1) {
				$('#vehicle-details').show();
			} else {
				$('#vehicle-details').hide();
			}
		});
		$('#accessories').tagsInput({
			'height':'auto',
			'width':'100%',
			'interactive':true,
			'defaultText':'add accessories',
			'removeWithBackspace' : true,
			'placeholderColor' : '#666666'
		});
	});
	function get_model() {
		var url = '<?php echo url('/'); ?>';
		var make = document.getElementById("car_make").value;
		$.get(url+'/assets/retrive/model/'+make, function(data){
			//success data
			$('#model').empty();
			$.each(data, function(car_model, carModel){
					$('#model').append('<option value="'+ carModel.id +'">'+ carModel.name +'</option>');
			});
		});
	} 
</script>
<script src="<?php echo asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.js'); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/assets/edit.blade.php ENDPATH**/ ?>