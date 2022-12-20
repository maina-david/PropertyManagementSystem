 

<?php $__env->startSection('title'); ?> Tenants List | <?php echo $property->title; ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 


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
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>   
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Tenants List</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th width="5">Image</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Phonenumber</th>
                           <th>Lease</th>
                           <th width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr >
                              <td><?php echo $count++; ?></td>
                              <td>
                                 <?php if($tenant->image == ""): ?>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo $tenant->tenant_name; ?>&rounded=true&size=40" alt="<?php echo $tenant->tenant_name; ?>"/>
                                 <?php else: ?>
                                    <img width="40" height="40" alt="" class="img-circle" src="<?php echo url('/'); ?>/storage/files/business/<?php echo Wingu::business(Auth::user()->businessID)->primary_email; ?>/property/tenant/<?php echo $tenant->tenant_code; ?>/images/<?php echo $tenant->image; ?>">
                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php echo $tenant->tenant_name; ?> 
                              </td>
                              <td><?php echo $tenant->contact_email; ?></td>
                              <td><?php echo $tenant->primary_phone_number; ?></td>
                              <td><?php echo Property::count_lease($tenant->tenantID); ?></td>
                              <td>
                                 <a href="<?php echo route('property.tenants.show',[$property->id,$tenant->tenantID]); ?>" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                 <a href="<?php echo route('tenants.edit',$tenant->tenantID); ?>" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/index.blade.php ENDPATH**/ ?>