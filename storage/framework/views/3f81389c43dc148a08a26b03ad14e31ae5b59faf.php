<?php $__env->startSection('title','Sales Orders'); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('finance.salesorders.create'); ?>" class="btn btn-pink"><i class="fas fa-plus"></i> New Sales Orders</a>
         
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-cart-arrow-down"></i> All Sales Orders</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Customer</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Invoiced</th>
                     
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Customer</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Invoiced</th>
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr role="row" class="odd">
                        <td><?php echo e($crt+1); ?></td>
                        <td>
                           <b><?php echo $v->prefix; ?><?php echo $v->salesorder_number; ?></b>
                        </td>
                        <td>
                           <?php echo $v->customer_name; ?>

                        </td>
                        <td class="text-uppercase font-weight-bold">
                           <?php echo $v->reference_number; ?>

                        </td>
                        <td><?php echo $v->symbol; ?> <?php echo number_format($v->balance); ?> </td>
                        <td><span class="badge <?php echo $v->name; ?>"><?php echo ucfirst($v->name); ?></span></td>
                        <td>
                           <?php if($v->invoiceID != ""): ?> 
                              <span class="badge badge-green">Yes</span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php echo date('F j, Y',strtotime($v->createDate)); ?>

                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo e(route('finance.salesorders.show', $v->salesID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="<?php echo route('finance.salesorders.edit', $v->salesID); ?>"><i class="fas fa-edit"></i> Edit</a></li>
                                 <li><a href="<?php echo route('finance.salesorders.delete', $v->salesID); ?>"><i class="fas fa-trash-alt"></i> Delete</a></li>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/salesorders/index.blade.php ENDPATH**/ ?>