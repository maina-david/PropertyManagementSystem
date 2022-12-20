<?php $__env->startSection('title','Supplier List'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <?php if(Finance::count_suppliers() != Wingu::plan()->suppliers && Finance::count_suppliers() < Wingu::plan()->suppliers): ?>
            <?php if (app('laratrust')->isAbleTo('create-vendors')) : ?>
               <a href="<?php echo route('finance.supplier.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add A Supplier</a>
               <a href="<?php echo route('supplier.import.index'); ?>" class="btn btn-pink"><i class="fal fa-file-upload"></i> Import Supplier</a>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>
         <?php if (app('laratrust')->isAbleTo('export-supplier')) : ?>
            <a href="<?php echo route('supplier.export','csv'); ?>" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Supplier</a>
         <?php endif; // app('laratrust')->permission ?>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-cog"></i> All Supplier</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Supplier List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th width="15%">Phone number</th>
                     <th width="15%">Date addded</th>
                     <th width="8%">Action</th>
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
                              <img src="https://ui-avatars.com/api/?name=<?php echo $supplier->supplier_name; ?>&rounded=true&size=32"  class="img-circle"  alt="<?php echo $supplier->supplier_name; ?>" width="40" height="40">
                           <?php else: ?>
                              <img width="40" height="40" alt="" class="img-circle" src="<?php echo asset('businesses/'.$supplier->business_code.'/suppliers/'.$supplier->supplierCode.'/images/'.$supplier->image); ?>">
                           <?php endif; ?>
                        </td>
                        <td><?php echo $supplier->supplier_name; ?></td>
                        <td><?php echo $supplier->email; ?></td>
                        <td><?php echo $supplier->primary_phone_number; ?></td>
                        <td><?php echo date('d F, Y', strtotime($supplier->created_at)); ?></td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 
                                 <?php if (app('laratrust')->isAbleTo('update-vendors')) : ?>
                                    <li><a href="<?php echo e(route('finance.supplier.edit', $supplier->supplierID)); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('delete-vendors')) : ?>
                                 <li><a href="<?php echo route('finance.supplier.delete', $supplier->supplierID); ?>" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/suppliers/index.blade.php ENDPATH**/ ?>