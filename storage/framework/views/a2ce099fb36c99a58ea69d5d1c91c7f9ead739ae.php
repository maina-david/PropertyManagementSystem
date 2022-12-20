<?php $__env->startSection('title','All Invoices'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<div class="pull-right">
         <?php if(Finance::count_invoice() != Wingu::plan()->invoices && Finance::count_invoice() < Wingu::plan()->invoices): ?>
            <?php if (app('laratrust')->isAbleTo('create-invoice')) : ?>
               <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> <i class="fas fa-plus"></i> New invoice</button>
                  <ul class="dropdown-menu">
                     <li><a href="<?php echo route('finance.invoice.product.create'); ?>">Create New Invoice</a></li>
                     
                     
                  </ul>
               </div>
            <?php endif; // app('laratrust')->permission ?>
         <?php else: ?> 
            <a href="<?php echo route('wingu.plans'); ?>" class="btn btn-danger">You have reached your invoice limit of <?php echo Wingu::plan()->invoices; ?>, Upgrade your current plan</a>
         <?php endif; ?>
         
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> All Invoices</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Invoice List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="10%">Invoice #</th>
                     <th>Title </th>
                     <th width="21%">Customer</th>
                     <th>Paid</th>
                     <th>Balance</th>
                     <th>Issue Date</th>
                     <th>Due Date</th>
                     <th>Status</th>
                     <th width="10%">Action</th> 
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th width="8%">Invoice #</th>
                     <th>Title </th>
                     <th width="18%">Customer</th>
                     <th>Paid</th>
                     <th>Balance</th>
                     <th width="10%">Issue Date</th>
                     <th width="10%">Due Date</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
						<?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr role="row" class="odd">
                        <td><?php echo e($crt+1); ?></td>
                        <td>
                           <?php if($v->invoice_prefix == ""): ?><?php echo e($v->prefix); ?><?php else: ?><?php echo e($v->invoice_prefix); ?><?php endif; ?><?php echo e($v->invoice_number); ?>

                        </td>
                        <td><?php echo $v->invoice_title; ?> </td>
                        <td>
							      <?php echo $v->customer_name; ?>

                        </td>
                        <td>
                           <?php if( $v->paid < 0 ): ?>
                              <b class="text-info"><?php echo $v->symbol; ?><?php echo number_format((float)$v->main_amount); ?> </b>
                           <?php else: ?> 
                              <b class="text-info"><?php echo $v->symbol; ?><?php echo number_format((float)$v->paid); ?> </b>
                           <?php endif; ?>   
                        </td>
                        <td>
                           <?php if( $v->statusID == 1 ): ?>
                              <span class="badge <?php echo $v->statusName; ?>"><?php echo ucfirst($v->statusName); ?></span>
                           <?php else: ?>
                              <?php if($v->balance < 0): ?>
                                 <b class="text-primary">0 <?php echo $v->symbol; ?></b>
                              <?php else: ?> 
                                 <b class="text-primary"><?php echo $v->symbol; ?><?php echo e(number_format(round($v->balance))); ?></b>
                              <?php endif; ?>
                           <?php endif; ?>
                        </td>
                        <td><?php if($v->invoice_date != ""): ?><?php echo date('M j, Y',strtotime($v->invoice_date)); ?><?php endif; ?></td>
                        <td><?php if($v->invoice_due != ""): ?><?php echo date('M j, Y',strtotime($v->invoice_due)); ?><?php endif; ?></td>
                        <?php if((int)$v->total - (int)$v->paid < 0): ?>
                           <td><span class="badge <?php echo $v->statusName; ?>"><?php echo ucfirst($v->statusName); ?></span></td>
                        <?php else: ?>
                            <td>
                                <span class="badge <?php echo Helper::seoUrl($v->statusName); ?>"><?php echo ucfirst($v->statusName); ?></span>
                            </td>
                        <?php endif; ?>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
                                    <li><a href="<?php echo e(route('finance.invoice.show', $v->invoiceID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('update-invoice')) : ?>
                                 <?php if($v->invoice_type == 'Product'): ?>
                                    <li><a href="<?php echo route('finance.invoice.product.edit', $v->invoiceID); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 <?php endif; ?>
                                 <?php if($v->invoice_type == 'Subscription' && $v->subscriptionID != ""): ?>
                                    <li><a href="<?php echo route('subscriptions.edit',$v->subscriptionID); ?>" target="_blank"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 <?php endif; ?>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('delete-invoice')) : ?>
                                    <li><a href="<?php echo route('finance.invoice.delete', $v->invoiceID); ?>" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
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

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/invoices/index.blade.php ENDPATH**/ ?>