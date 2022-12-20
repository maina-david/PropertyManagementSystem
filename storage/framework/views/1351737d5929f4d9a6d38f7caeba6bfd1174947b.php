<?php $__env->startSection('title','Edit Job Position'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?> 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Organization</li>
         <li class="breadcrumb-item active">Position</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-briefcase"></i> Edit Job Position</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%"> #</th>
                           <th class="text-nowrap">Title</th>
                           <th class="text-nowrap" width="29%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo $title->name; ?></td>
                              <td>
                                 <a href="<?php echo route('hrm.positions.edit',$title->id); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                 <a href="<?php echo route('hrm.positions.destroy',$title->id); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-body">
                  <?php echo Form::model($edit, ['route' => ['hrm.positions.update',$edit->id], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('name', 'Job Title', array('class'=>'control-label')); ?>

                        <?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter title', 'required' =>'' )); ?>

                     </div>
                     <div class="form-group">
                        <?php echo Form::label('names', 'Describe Position', array('class'=>'control-label')); ?>

                        <?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor', 'required' =>'' )); ?>

                     </div>
                     <div class="form-group mt-4">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/organization/positions/edit.blade.php ENDPATH**/ ?>