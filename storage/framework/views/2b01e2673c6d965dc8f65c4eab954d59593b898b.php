<?php $__env->startSection('title','Utilities'); ?>
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
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings | Utilities</h1>
   	<div class="row">
         <?php echo $__env->make('app.property.settings._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12 mb-2">
                  <a href="<?php echo route('property.utilities.create'); ?>" class="btn btn-danger float-right"><i class="fal fa-plus-circle"></i> Add Utility</a>
               </div>
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">All Utilities</h4>
                     </div>
                     <div class="panel-body">
                        <table id="example5" class="table table-striped table-bordered">
                           <thead>
                              <th width="1%">#</th>
                              <th>Name</th>
                              <th>Description</th>
                              <th width="13%">Action</th>
                           </thead>
                           <tbody>
                              <?php $__currentLoopData = $utilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $utility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $utility->name; ?></td>
                                    <td><?php echo $utility->description; ?></td>
                                    <td>
                                       <a href="<?php echo route('property.utilities.edit',$utility->id); ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                       <a href="<?php echo route('property.utilities.delete',$utility->id); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i></a>
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
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/settings/utilities/index.blade.php ENDPATH**/ ?>