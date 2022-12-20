<?php $__env->startSection('title','Family Information'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
			<li class="breadcrumb-item active">Family Information</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Family Information</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
				<div class="col-md-9">
					<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            <div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title"> Family Information</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">All Family Information</div>
							<div class="panel-body">
								<div class="row">
									<table class="table table-bordered">
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Relationship</th>
											<th>Date of birth</th>
											<th>Contact (Where Needed)</th>
											<th>Action</th>
										</tr>
										<?php $__currentLoopData = $family; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td><?php echo $count++; ?></td>
												<td>
													<?php echo $fam->family_name; ?><br>
													<?php if($fam->contact_type == 'S'): ?>
														<b>Secondary</b>
													<?php elseif($fam->contact_type == 'P'): ?>
														<b>Primary</b>
													<?php endif; ?>
												</td>
												<td><?php echo $fam->relationship; ?></td>
												<td><?php echo $fam->family_dob; ?></td>
												<td><?php echo $fam->family_contact; ?></td>
												<td>
													<a class="btn btn-danger delete" href="<?php echo e(url('hrm/delete-family-information/'.$fam->id)); ?>">
														<i class="fas fa-trash"></i>
													</a>
												</td>
											</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</table>
								</div>
							</div>
						</div>
		        	</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">Add Information</div>
							<?php echo Form::open(array('url' => 'hrm/family-information-post','enctype'=>'multipart/form-data','data-parsley-validate' => '', 'method'=>'post' )); ?>

							<div class="panel-body">
								<div class="row">
    								<?php echo e(csrf_field()); ?>

									<table class="table table-bordered family">
										<tr>
											<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
											<th>#</th>
											<th>Name</th>
											<th>Relationship</th>
											<th>Date of birth</th>
											<th>Contact (Where Needed)</th>
										</tr>
										<tr>
											<td><input type='checkbox' class='case'/></td>
											<td><span id='snum'>1.</span></td>
											<td><input class="form-control" type='text' id='family_name' name='family_name[]' required></td>
											<td><select class="form-control" id='relationship' name='relationship[]' required><option value="">Select</option><option>Father</option><option>Mother</option><option>Brother</option><option>Sister</option><option>Husband</option><option>Wife</option><option>Child</option></select></td>
											<td><input class="form-control" type='date' id='family_dob' name='family_dob[]' required></td>
											<td>
												<input class="form-control" type='text' id='family_contact' name='family_contact[]'> 
												<select name="contact_type" class="form-control" id="contact_type">
													<option value="">Choose contact type</option>
													<option>Primary</option>
													<option>Secondary</option>
												</select>
											</td>
											<td style='display:none'>
												<input class='form-control' type='text' id='employee_id' name='employee_id[]' value='<?php echo $employee->id; ?>' required=''></td>
										</tr>
									</table>
									<button type="button" class='btn btn-danger delete_family'>- Delete</button>
				               <button type="button" class='btn btn-success addmore_family'>+ Add More</button>
								</div>
								<div class="form-group"><br>
									<center><input class="btn btn-pink submit" type="submit" value="Add Family information">
										<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%"></center>
								</div>
							</div>
							<?php echo Form::close(); ?>

						</div>
		        	</div>
        		</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>

	    $(".delete_family").on('click', function() {
	        $('.case:checkbox:checked').parents("tr").remove();
	        $('.check_all').prop("checked", false);
	        check();
        });

	    var i=$('.family tr').length;
	    $(".addmore_family").on('click',function(){
		    count=$('.family tr').length;
		    var data="<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
		    data +="<td><input class='form-control' type='text' id='family_name_"+i+"' name='family_name[]'/></td><td><select class='form-control' id='relationship_' name='relationship[]' required><option value=''>Select</option><option>Father</option><option>Mother</option><option>Brother</option><option>Sister</option><option>Husband</option><option>Wife</option><option>Child</option></select></td><td><input class='form-control' type='date' id='family_dob_"+i+"' name='family_dob[]' required/></td><td><input class='form-control' type='text' id='family_contact_"+i+"' name='family_contact[]' required/><select name='contact_type' class='form-control' id='contact_type_"+i+"'><option value=''>Choose contact type</option><option>Primary</option><option>Secondary</option></select></td><td style='display:none'><input class='form-control' type='text' id='employee_id' name='employee_id[]' value='<?php echo $employee->id; ?>' required=''></td></tr>";
		    $('.family').append(data);
	    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/family.blade.php ENDPATH**/ ?>