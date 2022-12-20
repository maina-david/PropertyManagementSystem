<?php $__env->startSection('title','Assign Leave'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Leave</a></li>
         <li class="breadcrumb-item active">Assign Leave</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fad fa-calendar-check"></i> Assign Leave</h1>
      <?php echo $__env->make('app.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Leave Form
               </div>
               <div class="card-body">
                  <form action="<?php echo route('hrm.leave.store'); ?>" method="post" autocomplete="off">
                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default required">
      						<?php echo Form::label('names', 'Leave Type', array('class'=>'control-label')); ?>

      						<?php echo Form::select('leave_type', $types, null, array('class' => 'form-control multiselect', 'required' => '')); ?>

      					</div>
      					<div class="form-group form-group-default required">
      						<?php echo Form::label('Employee', 'Employee', array('class'=>'control-label')); ?>

      						<?php echo Form::select('employeeID', $employees, null, array('class' => 'form-control multiselect', 'required' => '')); ?>

      					</div>
                     <div class="row">
      						<div class="col-sm-6">
      							<div class="form-group form-group-default required">
      								<?php echo Form::label('names', 'Start', array('class'=>'control-label')); ?>

      								<?php echo Form::text('start_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date', 'required' => '')); ?>

      							</div>
      						</div>
      						<div class="col-sm-6">
      							<div class="form-group form-group-default required">
      								<?php echo Form::label('Time', 'End', array('class'=>'control-label')); ?>

      								<?php echo Form::text('end_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date','required' => '')); ?>

      							</div>
      						</div>
      					</div>
                     <div class="form-group">
      						<?php echo Form::label('Description', 'Reason', array('class'=>'control-label text-danger')); ?>

      						<?php echo e(Form::textarea('reason', null, ['class' => 'form-control','size' => '6x6'])); ?>

      					</div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Application</button>
            					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/leave/create.blade.php ENDPATH**/ ?>