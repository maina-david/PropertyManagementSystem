<?php $__env->startSection('title','Landlords'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb --> 
      <ol class="breadcrumb pull-right">
         
         <a href="<?php echo route('landlord.create'); ?>" class="btn btn-pink mr-2"><i class="fal fa-plus-circle"></i> Add Landlord</a>    
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-crown"></i> Landlords</h1>
      <!-- end breadcrumb -->
      <div class="card card-default">
         <div class="card-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phonenumber</th>
                     <th>Properties</th>
                     <th width="9%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $landlords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $landlord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr >
                        <td><?php echo $count++; ?></td>                    
                        <td>
                           <?php if($landlord->contact_type == 'Individual'): ?> 
                              <?php echo $landlord->salutation; ?> <?php echo $landlord->customer_name; ?>

                           <?php else: ?> 
                              <?php echo $landlord->customer_name; ?>

                           <?php endif; ?>
                        </td>
                        <td><?php echo $landlord->email; ?></td>
                        <td><?php echo $landlord->primary_phone_number; ?></td>
                        <td><?php echo Property::landlord_properties($landlord->propertyID); ?></td>
                        <td>
                           
                           <a href="<?php echo e(route('landlord.edit', $landlord->propertyID)); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="<?php echo route('landlord.delete', $landlord->propertyID); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash-alt"></i></a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/landlord/index.blade.php ENDPATH**/ ?>