<?php $__env->startSection('title','All Payments '); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <div class="pull-right">      
      <?php if (app('laratrust')->isAbleTo('create-payments')) : ?>
         <a href="<?php echo e(route('finance.payments.create')); ?>" title="" class="btn btn-pink"><i class="fal fa-plus"></i> Add Payment</a>
      <?php endif; // app('laratrust')->permission ?>
   </div>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-cash-register"></i> All Payments</h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="panel panel-default mt-2">
      <div class="panel-heading">
         <h4 class="panel-title">Payment List</h4>
      </div>
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered table-hover">
            <thead>
               <tr role="row">
                  <th width="1%">#</th>
                  <th>Date</th>
                  <th>Reference</th>
                  <th>Customer Name</th>
                  <th>Invoice#</th>
                  <th>Payment Method</th>
                  <th>Amount Paid</th>
                  <th width="3%">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr role="row" class="odd">
                     <td><?php echo $count++; ?></td>
                     <td><?php if($pay->payment_date != ""): ?><?php echo date('d F, Y',strtotime($pay->payment_date)); ?><?php endif; ?></td>
                     <td><p class="font-weight-bold"><?php echo $pay->transactionID; ?></p></td>
                     <td>
                        <?php echo $pay->customer_name; ?>

                     </td>
                     <td>
                        <?php if($pay->invoice_prefix == ""): ?><?php echo $pay->prefix; ?><?php else: ?><?php echo $pay->invoice_prefix; ?><?php endif; ?><?php echo $pay->invoice_number; ?>

                     </td>
                     <td>
                        <?php if(Finance::check_default_payment_method($pay->payment_method) == 1): ?>
                           <?php echo Finance::default_payment_method($pay->payment_method)->name; ?>

                        <?php else: ?> 
                           <?php if(Finance::check_payment_method($pay->payment_method) == 1): ?>
                              <?php echo Finance::payment_method($pay->payment_method)->name; ?>

                           <?php endif; ?>
                        <?php endif; ?>
                     </td>
                     <td>
                        <b><?php echo $pay->code; ?> <?php echo number_format($pay->amount); ?></b>
                     </td>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                           <ul class="dropdown-menu">
                              <?php if (app('laratrust')->isAbleTo('update-payments')) : ?>
                                 <li><a href="<?php echo e(route('finance.payments.edit', $pay->paymentID)); ?>"><i class="far fa-edit"></i> Edit</a></li>
                              <?php endif; // app('laratrust')->permission ?>
                              <?php if (app('laratrust')->isAbleTo('read-payments')) : ?>
                                 <li><a href="<?php echo e(route('finance.payments.show', $pay->paymentID)); ?>"><i class="fas fa-eye"></i> View</a></li>
                              <?php endif; // app('laratrust')->permission ?>
                              <?php if (app('laratrust')->isAbleTo('delete-payments')) : ?>
                                 <li><a href="<?php echo route('finance.payments.delete', $pay->paymentID); ?>" class="delete"><i class="fas fa-trash"></i> Delete</a></li>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/payments/index.blade.php ENDPATH**/ ?>