<?php $__env->startSection('title','Add Department | Human Resource'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?> 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human resource</a></li>
         <li class="breadcrumb-item"><a href="#">Organization</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.departments'); ?>">Departments</a></li>
         <li class="breadcrumb-item active"><a href="<?php echo route('hrm.departments'); ?>">Create</a></li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-sitemap"></i> Add Department</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <form action="<?php echo route('hrm.departments.store'); ?>" method="post" class="col-md-12">
            <?php echo csrf_field(); ?>
            <div class="card">
               <div class="card-header">Department Details</div>
               <div class="card-body">                  
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Department Name', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter name', 'required' =>'' )); ?>

                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Department Code', array('class'=>'control-label')); ?>

                           <?php echo Form::text('code', null, array('class' => 'form-control', 'placeholder' => 'Enter code')); ?>

                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Choose Parent Department', array('class'=>'control-label')); ?>

                           <select name="parentID" class="form-control multiselect">
                              <option value="">Choose parent department</option>
                              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $department->id; ?>"><?php echo $department->title; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('head', 'Choose Department Head', array('class'=>'control-label')); ?>

                           <?php echo Form::select('head', $employees, null, array('class' => 'form-control multiselect')); ?>

                        </div>
                     </div>
                  </div>                  
                  <div class="form-group">
                     <?php echo Form::label('names', 'Department details', array('class'=>'control-label')); ?>

                     <?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor')); ?>

                  </div>
                  <div class="form-group mt-4">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Department</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/organization/departments/create.blade.php ENDPATH**/ ?>