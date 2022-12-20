<?php $__env->startSection('title','Add Utility'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings | Utilities | Add Utilities</h1>
      <div class="row">
      <?php echo $__env->make('app.property.settings._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-9">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Utility Details</h4>
            </div>
            <div class="panel-body">
               <form action="<?php echo route('property.utilities.store'); ?>" method="post">
                  <?php echo csrf_field(); ?>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'Utility Name', array('class'=>'control-label')); ?>

                     <?php echo e(Form::text('name', null, ['class' => 'form-control', 'required' => '', 'placeholder' => 'Enter name'])); ?>

                  </div>
                  <div class="form-group">
                     <?php echo Form::label('title', 'Utility Description', array('class'=>'control-label')); ?>

                     <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'required' => ''])); ?>

                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Utility</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                     </center>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/settings/utilities/create.blade.php ENDPATH**/ ?>