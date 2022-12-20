<div class="col-md-12 mt-3">   
   <div class="panel">
      <div class="panel-heading"><b>Tenant Invoices</b></div>
      <div class="panel-body">
         <table id="example5" class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="13%">Invoice #</th>
                  <th>Amount</th>
                  <th>Paid</th>
                  <th>Balance</th>
                  <th>Due Date</th>
                  <th>Status</th>
                  <th width="11%">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr role="row" class="odd"> 
                     <td><?php echo e($crt+1); ?></td>
                     <td>
                        <?php echo e($v->invoice_prefix); ?><?php echo e($v->invoice_number); ?>

                     </td>
                     <td><?php echo $business->code; ?><?php echo number_format($v->total); ?></td>
                     <td><?php echo $business->code; ?><?php echo number_format($v->paid); ?></td>
                     <td class="v-align-middle">
                       
                           <?php if( $v->statusID == 1 ): ?>
                              <span class="label label-success">Paid</span>
                           <?php else: ?>
                           <?php echo $business->code; ?> <?php echo e(number_format(round($v->total - $v->paid))); ?> 
                           <?php endif; ?>
                     </td>
                     <td><?php echo date('F j, Y',strtotime($v->invoice_due)); ?></td>
                     <td><span class="label <?php echo $v->statusName; ?>"><?php echo e($v->statusName); ?></span></td>
                     <td>
                        <a href="<?php echo route('property.invoice.show',[$propertyID,$v->invoiceID]); ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a href="<?php echo route('property.rental.billing.edit',[$propertyID,$v->invoiceID]); ?>" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                        <a href="<?php echo route('property.invoice.delete',[$propertyID,$v->invoiceID]); ?>" class="btn btn-danger btn-sm delete"><i class="far fa-trash"></i></a>
                     </td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/invoices.blade.php ENDPATH**/ ?>