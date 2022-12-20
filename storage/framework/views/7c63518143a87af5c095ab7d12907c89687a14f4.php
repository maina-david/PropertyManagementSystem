<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('title'); ?> <?php echo $tenant->tenant_name; ?> | Tenant Units <?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Tenants</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">List</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> <?php echo $property->title; ?> | Tenants </h1>
      <div class="row">
         <?php echo $__env->make('app.property.property.tenants._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
         <div class="col-md-12 mt-3">
            <div class="panel">
               <div class="panel-heading">Tenant Units</div>
               <div class="panel-body">
                  <table id="example5" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>UnitID</th>
                           <th>Unit Type</th>
                           <th>Landlord</th> 
                           <th>Lease ID</th>
                           <th>Rent (p/Mo)</th>
                           <th>Bedrooms</th>
                           <th width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo $unit->serial; ?></td>                     
                              <td>
                                 <?php if($unit->property_type != ""): ?>
                                    <?php echo Property::property_type($unit->property_type)->name; ?>

                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php if(Finance::check_client($unit->landlordID) == 1): ?>
                                    <?php echo Finance::client($unit->landlordID)->customer_name; ?>

                                 <?php endif; ?>                         
                              </td>
                              <td><?php echo $unit->lease_code; ?></td>
                              <td><?php echo $business->code; ?><?php echo number_format($unit->rent_amount); ?></td>
                              <td><?php echo $unit->bedrooms; ?></td>
                              <td><a href="<?php echo route('property.units.edit',[$propertyID,$unit->unitID]); ?>" class="btn btn-primary btn-block"><i class="far fa-edit"></i> Edit</a></td>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/units.blade.php ENDPATH**/ ?>