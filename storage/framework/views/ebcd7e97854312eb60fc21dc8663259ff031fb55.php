<div class="card mt-3">
   <div class="card-header"><i class="fal fa-file-invoice-dollar"></i> Invoices</div>
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
                     <b><?php echo e(Finance::invoice_settings()->prefix); ?><?php echo e($v->invoice_number); ?></b>
                  </td>
                  <td><b><?php echo $client->code; ?> <?php echo number_format($v->total); ?></b></td>
                  <td><?php echo $client->code; ?> <?php echo number_format($v->paid); ?></td>
                  <td class="v-align-middle">

                     <?php if( $v->statusID == 1 ): ?>
                        <span class="badge <?php echo Wingu::status($v->statusID)->name; ?>"><?php echo ucfirst(Wingu::status($v->statusID)->name); ?></span>
                     <?php else: ?>

                        <b>
                     <?php echo $client->code; ?> <?php echo e(number_format(round($v->total - $v->paid))); ?></b>
                     <?php endif; ?>
                  </td>
                  <td><p><?php echo date('F j, Y',strtotime($v->invoice_due)); ?></p></td>
                  <?php if($v->total - $v->paid < 0): ?>
                     <td><span class="badge <?php echo Wingu::status($v->statusID)->name; ?>"><?php echo ucfirst(Wingu::status($v->statusID)->name); ?></span></td>
                  <?php else: ?>
                     <td>
                        <?php if($v->statusID != ""): ?>
                           <span class="badge <?php echo Wingu::status($v->statusID)->name; ?>"><?php echo ucfirst(Wingu::status($v->statusID)->name); ?></span>
                        <?php endif; ?>
                     </td>
                  <?php endif; ?>
                  <td>
                     <a href="<?php echo e(route('finance.invoice.show', $v->id)); ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> view</a>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/customers/invoices.blade.php ENDPATH**/ ?>