 

<?php $__env->startSection('title'); ?> Occupied Units | <?php echo $property->title; ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 



<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)">Units</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)">Occupied</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-building"></i> <?php echo $property->title; ?> | Occupied Units</h1>
   <div class="row">
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Occupied Units</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th class="text-nowrap">UnitID</th>
                        <th class="text-nowrap">Unit Type</th>
                        <th class="text-nowrap">Rent (p/Mo)</th>
                        <th class="text-nowrap">Tenant</th>
                        <th class="text-nowrap">Ownership Type</th>
                        <th class="text-nowrap" width="8%">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           <td><?php echo $count++; ?></td>
                           <td><b><?php echo $unit->serial; ?></b></td>
                           <td>
                              <?php if($unit->property_type != ""): ?>
                                 <?php echo Property::property_type($unit->property_type)->name; ?>

                              <?php endif; ?>
                           </td>
                           <td><b><?php echo $business->code; ?><?php echo number_format($unit->rent_amount); ?></b></td>
                           <td><?php echo $unit->tenant_name; ?></td>
                           <td><?php echo $unit->ownwership_type; ?></td>
                           <td>
                              <a href="<?php echo route('property.units.edit',[$property->id,$unit->propID]); ?>" class="btn btn-primary"><i class="far fa-edit"></i></a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/units/occupied.blade.php ENDPATH**/ ?>