<?php $__env->startSection('title','Authorization & Allocations'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
			<li class="breadcrumb-item active">Authorization & Allocations</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Authorization & Allocations</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col-md-9">
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            <div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">
								Authorization and Company equipments/products Allocation
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">All Allocation</div>
							<div class="panel-body">
								<div class="row">
									<table class="table table-bordered">
										<tr>
											<th>#</th>
												<th>Item Name</th>
												<th>Reff Number</th>
												<th>Date Allocated</th>
												<th>Previous Condition</th>
												<th>Comment</th>
												<th>Action</th>
										</tr>
										<?php $__currentLoopData = $allocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td><?php echo $count++; ?></td>
												<td><?php echo $all->equipment_name; ?></td>
												<td><?php echo $all->reff_no; ?></td>
												<td><?php echo $all->date_allocated; ?></td>
												<td><?php echo $all->condition_before_allocation; ?></td>
												<td><?php echo $all->comments; ?></td>
												<td>
													<a class="btn btn-danger" href="<?php echo route('hrm.allocation.delete',$all->id); ?>">
														<i class="fas fa-trash">
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
							<div class="panel-title">Add Allocation</div>
							<?php echo Form::open(array('route' => 'hrm.allocation.store','enctype'=>'multipart/form-data','method'=>'post' )); ?>

							<div class="panel-body">
								<div class="row">
    								<?php echo e(csrf_field()); ?>

									<table class="table table-bordered experience">
										<tr>
											<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
											<th>#</th>
											<th>Item Name</th>
											<th>Reff Number</th>
											<th>Date Allocated</th>
											<th>Previous Condition</th>
											<th>Comment</th>
										</tr>
										<tr>
											<td><input type='checkbox' class='case'/></td>
											<td><span id='snum'>1.</span></td>
											<td><input class="form-control" type='text' id='equipment_name' name='equipment_name[]' required></td>
											<td><input class="form-control" type='text' id='reff_no' name='reff_no[]' required></td>
											<td><input class="form-control date-picker" type='date' id='date_allocated' name='date_allocated[]' required></td>
											<td><input class="form-control date-picker" type='text' id='condition_before_allocation' name='condition_before_allocation[]' required> </td>
											<td><input class="form-control" type='text' id='comments' name='comments[]' required> </td>
											<td style='display:none'><input class="form-control" type='text' id='employee_id' name='employee_id[]' value='<?php echo $employee->id; ?>' required></td>
										</tr>
									</table>
	                        <button type="button" class="btn btn-danger delete_experience ml-2">- Delete</button>
				               <button type="button" class="btn btn-success addmore_experience" > + Add More</button>
								</div>
								<div class="form-group"><br>
									<center><input class="btn btn-pink submit" type="submit" value="Add Allocation"></center>
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

	    $(".delete_experience").on('click', function() {
	        $('.case:checkbox:checked').parents("tr").remove();
	        $('.check_all').prop("checked", false);
	        check();
        });

	    var i=$('.experience tr').length;
	    $(".addmore_experience").on('click',function(){
		    count=$('.experience tr').length;
		    var data="<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
		    data +="<td><input class='form-control' type='text' id='equipment_name_"+i+"' name='equipment_name[]'/></td><td><input class='form-control' type='text' id='reff_no_"+i+"' name='reff_no[]'/></td><td><input class='form-control date-picker' type='date' id='date_allocated_"+i+"' name='date_allocated[]'/></td><td><input class='form-control' type='text' id='condition_before_allocation_"+i+"' name='condition_before_allocation[]'/></td><td><input class='form-control' type='text' id='comments_"+i+"' name='comments[]'/></td><td style='display:none'><input class='form-control' type='text' id='employee_id' name='employee_id[]' value='<?php echo $employee->id; ?>' required=''></td></tr>";
		    $('.experience').append(data);
	    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/allocations.blade.php ENDPATH**/ ?>