<?php $__env->startSection('title','Digital Marketing Mediums'); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Digital Marketing</a></li>
         <li class="breadcrumb-item active">Mediums</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Edit Mediums</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">All Mediums</h4>
               </div>
               <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Medium Name</th>
                        <th>Created Date</th>
                        <th width="30%">Action</th>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $mediums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medium): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo $medium->name; ?></td>
                              <td><?php echo date('d F, Y', strtotime($medium->created_at)); ?></td>
                              <td>
                                 <a href="<?php echo e(route('crm.medium.edit',$medium->id)); ?>" class="btn btn-pink"><i class="fas fa-edit"></i> Edit</a>
                                 <a href="<?php echo e(route('crm.medium.delete',$medium->id)); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <?php echo Form::model($edit, ['route' => ['crm.medium.update',$edit->id], 'method'=>'post','class' => 'col-md-6']); ?>

            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Edit Mediums</h4>
               </div>
               <div class="panel-body">
                  <?php echo csrf_field(); ?>
                  <div class="form-group form-group-default">
                     <label for="">Enter Medium name</label>
                     <?php echo Form::text('name', null, ['class' => 'form-control','placeholder' => 'Enter name']); ?>

                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Medium</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>  
         <?php echo Form::close(); ?>

      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/social/medium/edit.blade.php ENDPATH**/ ?>