 

<?php $__env->startSection('title'); ?> Suppliers List <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb --> 
   <ol class="breadcrumb pull-right">
      <a href="<?php echo route('property.supplier.create'); ?>" class="btn btn-pink float-right"><i class="fal fa-plus-circle"></i> Add A Supplier</a>
       
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-users-cog"></i> Suppliers - List</h1>
   <!-- end breadcrumb -->
	<div class="row">
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Suppliers List</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="5">Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="15%">Phone number</th>
                        <th width="15%">Date addded</th>
                        <th width="9%">Action</th>
                     </tr>
                  </thead>
                  <tfoot>
                     <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone number</th>
                        <th>Date addded</th>
                        <th>Action</th>
                     </tr>
                  </tfoot> 
                  <tbody>
                     <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr >
                           <td><?php echo $count++; ?></td>
                           <td>
                              <?php if($supplier->image == ""): ?>
                                 <img src="https://ui-avatars.com/api/?name=<?php echo $supplier->supplierName; ?>&rounded=true&size=32" alt="">
                              <?php else: ?>
                                 <img width="40" height="40" alt="" class="img-circle" src="<?php echo asset('businesses/'.$supplier->business_code.'/suppliers/'. $supplier->customer_code.'/images/'.$supplier->image); ?>">
                              <?php endif; ?>
                           </td>
                           <td><?php echo $supplier->supplierName; ?></td>
                           <td><?php echo $supplier->email; ?></td>
                           <td><?php echo $supplier->primary_phone_number; ?></td>
                           <td><?php echo date('d F, Y', strtotime($supplier->created_at)); ?></td>
                           <td>
                              <a href="<?php echo e(route('property.supplier.edit', $supplier->supplierID)); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                              <a href="<?php echo route('property.supplier.delete', $supplier->supplierID); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/suppliers/index.blade.php ENDPATH**/ ?>