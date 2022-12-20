<?php $__env->startSection('title','Agents'); ?>
<?php $__env->startSection('sidebar'); ?> 
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb --> 
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.agents'); ?>">Agents</a></li>
         <li class="breadcrumb-item active"><a href="">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-tie"></i> Agents - List</h1>
      <!-- end breadcrumb -->
      <div class="card card-default">
         <div class="card-body">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="21%">Name</th>
                     <th>Phone Number</th>
                     <th>Email</th>
                     <th>Allocations</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $agent->names; ?></td>
                        <td><?php echo $agent->personal_number; ?></td>
                        <td><?php echo $agent->personal_email; ?></td>
                        <td></td>
                        <td></td>
                        <td>
                           <a href="<?php echo route('property.agents.edit',$agent->agentID); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="<?php echo route('property.agents.delete',$agent->agentID); ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/agents/index.blade.php ENDPATH**/ ?>