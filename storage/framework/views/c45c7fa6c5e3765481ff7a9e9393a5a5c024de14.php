<?php $__env->startSection('title','Bank Information'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
			<li class="breadcrumb-item active">Update</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Bank Information</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col-md-9">
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        		<?php echo Form::model($edit, ['route' => ['hrm.employeebankinformation.update',$employee], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']); ?>

               <?php echo e(csrf_field()); ?>

               <div class="panel panel-default">
                  <div class="panel-heading">
                     <div class="panel-title"><span class="green"><?php echo $edit->names; ?></span> - Bank Information</div>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('account_number', 'BanK Account Number', array('class'=>'control-label')); ?>

                              <?php echo Form::text('account_number', null, array('class' => 'form-control', 'placeholder' => 'BanK Account Number')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('bank_name', 'BanK Name', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bank_name', null, array('class' => 'form-control', 'placeholder' => 'BanK Name')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('bank_branch', 'BanK Branch', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bank_branch', null, array('class' => 'form-control', 'placeholder' => 'BanK Branch')); ?>

                           </div>
                        </div>
                     </div>
                     <div class="form-group"><br>
                        <center><input class="btn btn-pink submit" type="submit" value="Update Information"></center>
                     </div>
                  </div>
               </div>
            <?php echo Form::close(); ?>

         </div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/bank.blade.php ENDPATH**/ ?>