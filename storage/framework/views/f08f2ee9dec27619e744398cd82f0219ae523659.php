<?php $__env->startSection('title','Marketing | Listing '); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Marketing</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Lisitng</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullhorn"></i> Marketing </h1>
      <div class="card card-default">
         <div class="card-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr> 
                     <th width="1%">#</th>
                     <th>Name</th>
                     <th>Type</th>
                     <th>Category</th>
                     <th>Address</th>
                     <th>List Date</th>
                     <th>Expires</th>
                     <th>Price</th>
                     <th>Status</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $property->title; ?></td>
                        <td> 
                           <?php if($property->type != ""): ?>
                              <?php echo Property::property_type($property->type)->name; ?> 
                           <?php endif; ?>
                        </td>
                        <td><?php echo $property->category; ?></td>
                        <td><?php echo $property->geolocation; ?></td>
                        <td><?php echo $property->start_date; ?></td>
                        <td><?php echo $property->end_date; ?></td>
                        <td><b><?php echo $business->code; ?> <?php echo number_format($property->price); ?></b></td>
                        <td><span class="badge <?php echo $property->statusName; ?>"><?php echo $property->statusName; ?></span></td>
                        <td>
                           <a href="<?php echo route('list.property.edit',$property->listID); ?>" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                           <a href="<?php echo route('list.property.cancel',[$property->propertyID,$property->listID]); ?>" class="btn btn-sm btn-warning delete"><i class="fal fa-ban"></i></a>
                           <a href="<?php echo route('list.property.delete',$property->listID); ?>" class="btn btn-sm btn-danger"><i class="far fa-trash"></i></a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>               
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/marketing/listing/index.blade.php ENDPATH**/ ?>