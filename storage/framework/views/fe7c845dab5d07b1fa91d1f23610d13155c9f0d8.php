<?php $__env->startSection('title','Departments | Human Resource'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<link href="<?php echo asset('assets/plugins/jstree/dist/themes/default/style.min.css'); ?>" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL JS ================== -->
<?php $__env->stopSection(); ?>
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
         <li class="breadcrumb-item active"><a href="<?php echo route('hrm.departments'); ?>">All</a></li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-sitemap"></i> Departments</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">Department List</div>
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Head</th>
                        <th width="9%">Action</th>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo $department->title; ?></td>
                              <td><?php echo $department->code; ?></td>
                              <td>
                                 <?php if(Hr::check_employee($department->head) == 1): ?> 
                                    <?php echo Hr::employee($department->head)->names; ?>

                                 <?php endif; ?>
                              </td>
                              <td>
                                 <a href="<?php echo route('hrm.departments.edit',$department->id); ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                 <a href="<?php echo route('hrm.departments.delete',$department->id); ?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                        
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/organization/departments/index.blade.php ENDPATH**/ ?>