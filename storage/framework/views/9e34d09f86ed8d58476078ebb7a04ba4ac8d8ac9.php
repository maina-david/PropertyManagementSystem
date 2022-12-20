<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Leases <?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)">Leases</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)">All</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-building"></i> <?php echo $property->title; ?> | Leases</h1>
   <div class="row">
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Leases List</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered table-hover">
                  <thead>            
                     <tr>
                        <th width="1%">#</th>
                        <th>Tenant</th>
                        <th>Unit#</th>
                        <th>Type</th>
                        <th>Billing schedule</th>
                        <th>Start Date</th>
                        <th>Expiry</th>
                        <th width="10%">Status</th>    
                        <th width="12%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $leases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lease): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           <td><?php echo $count++; ?></td>
                           <td><?php echo $lease->tenant_name; ?></td>
                           <td>
                              <?php echo Property::property_info($lease->unitID)->serial; ?><br>
                              <span class="badge badge-info"><?php echo $lease->code; ?></span>
                           </td>
                           <td><?php echo $lease->type; ?></td>
                           <td>
                              <?php if($lease->billing_schedule == 7): ?>
                                 Weekly
                              <?php elseif($lease->billing_schedule == 1): ?>
                                 Monthly
                              <?php elseif($lease->billing_schedule == 3): ?>
                                 Quarterly
                              <?php elseif($lease->billing_schedule == 6): ?>
                                 Half Year
                              <?php elseif($lease->billing_schedule == 12): ?>
                                 Yearly
                              <?php endif; ?>
                           </td>  
                           <td>
                              <?php if($lease->lease_start_date != ""): ?>
                                 <?php echo date('F jS, Y', strtotime($lease->lease_start_date)); ?>

                              <?php endif; ?> 
                           </td>            
                           <td>
                              <?php if($lease->lease_end_date != ""): ?>
                                 <?php echo date('M jS, Y', strtotime($lease->lease_end_date)); ?>

                              <?php endif; ?>       
                           </td>
                           <td>
                              
                              <?php if($lease->status != ""): ?>
                                 <center><span class="badge <?php echo Wingu::status($lease->status)->name; ?>"><?php echo Wingu::status($lease->status)->name; ?></span></center>
                              <?php endif; ?>
                           </td>   
                           <td>
                              <a href="<?php echo route('property.tenant.lease.show',[$propertyID,$lease->tenantID,$lease->leaseID]); ?>" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                              <a href="<?php echo route('property.tenant.lease.edit',[$propertyID,$lease->tenantID,$lease->leaseID]); ?>" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a> 
                              <a href="<?php echo route('property.tenant.lease.delete',[$lease->leaseID]); ?>" class="btn btn-danger btn-sm delete"><i class="far fa-trash"></i></a>
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

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/lease/index.blade.php ENDPATH**/ ?>