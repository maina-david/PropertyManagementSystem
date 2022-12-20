<?php $__env->startSection('title','Employee Roles'); ?>

<?php $__env->startSection('stylesheets'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-menu'); ?>
	<?php echo $__env->make('limitless.Human-resource.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="content ">
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">				 
					<ul class="breadcrumb">
						<li><a href="#">Forms</a></li>
						<li><a href="#" class="active">Employee Roles</a></li>
					</ul>	
				</div>
			</div>
		</div>
		<div class="container-fluid container-fixed-lg">
			<div class="col-md-12">
            	<!-- employee side -->
				<?php echo $__env->make('limitless.Human-resource.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            	<!-- employee side -->				
        		
        			<?php echo e(csrf_field()); ?>

					<div class="col-md-9">
						<?php echo $__env->make('backend.partials._errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		            	<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title"><span class="green"><?php echo $employee->first_name; ?> <?php echo $employee->last_name; ?></span> - Employee Roles</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<div class="col-sm-3">
											<div class="checkbox check-success">
												<input type="checkbox" value="1"   id="checkbox4">
												<label for="checkbox2"><?php echo $role->name; ?></label>
											</div>
										</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>								
								
								<div class="form-group"><br>
									<center><input class="btn btn-success" type="submit" value="Update roles"></center>
								</div>
							</div>
						</div>
			        </div>
		        
            </div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/roles.blade.php ENDPATH**/ ?>