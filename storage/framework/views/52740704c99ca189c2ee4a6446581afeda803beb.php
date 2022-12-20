<div class="card">
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="13%">Invoice #</th>
               <th>Amount</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th>Invoice #</th>
               <th>Amount</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr role="row" class="odd">
                  <td><?php echo e($crt+1); ?></td>
                  <td>
                     <?php echo e(Finance::invoice_settings('finance')->code); ?>-<?php echo e($v->number); ?>

                  </td>
                  <td><p><?php echo number_format($v->amount); ?> <?php echo $v->currency; ?></p></td>
                  <td><?php echo number_format($v->paidamount); ?> <?php echo $v->currency; ?></td>
                  <td class="v-align-middle">
                     <p>
                        <?php if( $v->status == 'paid' ): ?>
                           <span class="label label-success">Paid</span>
                        <?php else: ?>
                           <?php echo e(number_format(round($v->amount - $v->paidamount))); ?> <?php echo $v->currency; ?>

                        <?php endif; ?>
                     </p>
                  </td>
                  <td><p><?php echo date('F j, Y',strtotime($v->due_date)); ?></p></td>
                  <?php if($v->amount - $v->paidamount < 0): ?>
                     <td><span class="label label-success">Paid</span></td>
                  <?php else: ?>
                     <td><span class="label label-<?php echo e(str_replace('', '-', $v->status)); ?> "><?php echo e($v->status); ?></span></td>
                  <?php endif; ?>
                  <td>
                     <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                        <ul class="dropdown-menu">
                           <li><a href="<?php echo e(route('finance.invoice.product.show', $v->id)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                           <?php if($v->type == 'Random'): ?>
                              <li><a href="<?php echo route('finance.invoice.random.edit', $v->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           <?php endif; ?>
                           <?php if($v->type == 'Product'): ?>
                              <li><a href="<?php echo route('finance.invoice.product.edit', $v->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           <?php endif; ?>
                           <?php if($v->type == 'Recurring'): ?>
                              <li><a href="<?php echo route('finance.invoice.recurring.edit', $v->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           <?php endif; ?>
                           <li><a href="<?php echo route('finance.invoice.product.delete', $v->id); ?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                           <li class="divider"></li>
                           <li><a href="#">The end</a></li>
                        </ul>
                     </div>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/suppliers/invoices.blade.php ENDPATH**/ ?>