<?php $__env->startSection('title','Create Agents'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb --> 
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('property.agents'); ?>">Agents</a></li>
      <li class="breadcrumb-item active"><a href="">Create</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-user-tie"></i> Agents - Create</h1>
   <!-- end breadcrumb -->
   <div class="card card-default">
      <div class="card-body">
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <form class="row" method="post" action="<?php echo route('property.agents.store'); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="col-sm-6">
               <div class="form-group form-group-default required">
                  <?php echo Form::label('names', 'Agent Names', array('class'=>'control-label text-danger')); ?>

                  <?php echo Form::text('names', null, array('class' => 'form-control', 'placeholder' => 'Enter Names', 'required' =>'' )); ?>

               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group form-group-default required">
                  <?php echo Form::label('Gender', 'Gender', array('class'=>'control-label text-danger')); ?>

                  <?php echo e(Form::select('gender',[''=>'Choose Gender','Male'=>'Male','Female'=>'Female'], null, ['class' => 'form-control multiselect','required' =>''])); ?>

               </div>
            </div>            
            <div class="col-sm-6">
               <div class="form-group form-group-default required">
                  <?php echo Form::label('Email', 'Email', array('class'=>'control-label text-danger')); ?>

                  <?php echo Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Enter email', 'required' => '')); ?>

               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group form-group-default required">
                  <?php echo Form::label('phone_number', 'Phone Number', array('class'=>'control-label text-danger')); ?>

                  <?php echo Form::text('phone_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Phone Number','required' =>'' )); ?>

               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <?php echo Form::label('contract type', 'Contract type', array('class'=>'control-label')); ?>

                  <?php echo e(Form::select('contract_type',[''=>'Select contract','Permanent'=>'Permanent','On Contract'=>'On Contract','Temporary'=>'Temporary','Trainee'=>'Trainee'], null, ['class' => 'form-control multiselect'])); ?>

               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group form-group-default">
                  <?php echo Form::label('hire_date', 'Date joined', array('class'=>'control-label')); ?>

                  <?php echo Form::date('hire_date', null, array('class' => 'form-control', 'placeholder' => 'Date of hire')); ?>

               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group form-group-default">
                  <?php echo Form::label('Agent Image', 'Agent Image', array('class'=>'control-label')); ?><br>
                  <?php echo e(Form::file('image', null, ['class' => 'form-control'])); ?>

               </div>
            </div>
            <div class="col-md-12 mt-3">
               <center>
                  <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Save information</button>
                  <img src="<?php echo asset('assets/app/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/agents/create.blade.php ENDPATH**/ ?>