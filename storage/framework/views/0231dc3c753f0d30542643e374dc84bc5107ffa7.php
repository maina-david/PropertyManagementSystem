<?php $__env->startSection('title','Maintenance'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.agents'); ?>">Maintenance</a></li>
         <li class="breadcrumb-item active"><a href="">Requests</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> Maintenance </h1>
      <div class="row">
         <div class="col-md-12">
            <a href="<?php echo route('property.maintenance.create'); ?>" class="btn btn-danger float-right mb-2"> <i class="fal fa-plus-circle"></i> Add Maintenance Request</a>
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead>
                        <th width="1%">#</th>
                        <th>RequestID</th>
                        <th>Title</th>
                        <th>Tenant</th>
                        <th>Priority</th>
                        <th>Request Date</th>           
                        <th>Complete Date</th>                     
                        <th width="10%">Action</th>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo $request->requestID; ?></td>
                              <td><?php echo $request->issue_title; ?></td>   
                              <td><?php echo $request->tenant_name; ?></td>  
                              <td><span class="badge <?php echo $request->priority; ?>"><?php echo $request->priority; ?></span></td>  
                              <td><?php echo date('F jS, Y', strtotime($request->initiated_date)); ?></td>   
                              <td><?php echo date('F jS, Y', strtotime($request->completed_work_date)); ?></td>                       
                              <td>
                                 <a href="<?php echo route('property.maintenance.edit',$request->reqID); ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                 <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/maintenance/index.blade.php ENDPATH**/ ?>