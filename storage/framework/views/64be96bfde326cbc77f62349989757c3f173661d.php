<?php $__env->startSection('title','Salary List'); ?>

<?php $__env->startSection('stylesheet'); ?>
	
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-menu'); ?>
	<?php echo $__env->make('limitless.Human-resource.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="normalheader ">
	        <div class="hpanel">
	            <div class="panel-body">
	                <a class="small-header-action" href="">
	                    <div class="clip-header">
	                        <i class="fa fa-arrow-up"></i>
	                    </div>
	                </a>
	                <div id="hbreadcrumb" class="pull-right m-t-lg">
	                    <ol class="hbreadcrumb breadcrumb">
	                        <li><a href="<?php echo e(url('home')); ?>">Human Resource</a></li>
	                        <li>
	                            <span>Salary</span>
	                        </li>
	                        <li class="active">
	                            <span>Salary List</span>
	                        </li>
	                    </ol>
	                </div>
	                <h2 class="font-light m-b-xs">
	                    Salary
	                </h2>
	                <small>All Salary Information</small>
	            </div>
	        </div>
	</div>
	<div class="content ">
		<div class="hpanel">
			<div class="row">
				<button class="btn btn-success pull-right" data-target="#addleave" data-toggle="modal" style="margin-right: 20px;margin-bottom:10px"><i class="fa fa-plus" aria-hidden="true"></i> Apply Salary</button>
			</div>
			<div class="panel-body">
				<div class="panel-body">
					<table id="salary-form" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Image</th>
								<th>Name</th>
								<th>Amount</th>
								<th>Date Requested</th>
								<th>Date Required</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td>1</td>
								<td><img width="40" height="40" alt="" class="img-circle FL" src="<?php echo e(asset('resources/assets/images/profile_avatar.png')); ?>"></td>
								<td><p><?php echo $emp->first_name; ?> <?php echo $emp->middle_name; ?> <?php echo $emp->last_name; ?></p></td>
								<td><p>ksh 20,000</p></td>
								<td><p>12,March 2017</p></td>
								<td><p>12,March 2017</p></td>
								<td><span class="label label-success">Pending</span></td>
								<td>
									<div class="btn-group">
					                    <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle" aria-expanded="true">Choose Action <span class="caret"></span></button>
					                    <ul class="dropdown-menu">
					                        <li><a href="<?php echo e(url('hrm/employee/'.$emp->empid.'/show')); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
											<li><a href="<?php echo e(url('hrm/employee/'.$emp->empid.'/edit')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp; Edit</a></li>
											<li><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp; Delete</a></li>
					                        <li class="divider"></li>
					                        <li><a href="#">the end</a></li>
					                    </ul>
					                </div>
								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>	
	<?php echo $__env->make('Limitless.Models.salary.Add-salary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<br>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script type="text/javascript">
		$(document).ready(function() {
	    $('#salary-form').DataTable( {
	        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	        buttons: [
                {extend: 'copy',className: 'btn-sm'},
                {extend: 'csv',title: 'Finance Contact list', className: 'btn-sm'},
                {extend: 'pdf', title: 'Finance Contact list', className: 'btn-sm'},
                {extend: 'print',className: 'btn-sm'}
            ]
		    } );
		} );
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/Salary/index.blade.php ENDPATH**/ ?>