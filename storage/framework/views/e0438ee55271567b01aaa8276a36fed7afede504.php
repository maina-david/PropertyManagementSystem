<div class="panel">
   <div class="panel-body">
      <div class="row">
         <div class="col-md-12">
            <ol class="breadcrumb pull-right">
               <a href="#" target="_blank" class="btn btn-pink"><i class="fas fa-print"></i> Export for Print</a>
               <a href="#" class="btn btn-pink ml-2"><i class="fas fa-file-pdf"></i> Export for PDF</a>
               <a href="#" class="btn btn-pink ml-2"><i class="fas fa-file-excel"></i> Export to Excel</a>
               
            </ol>
         </div>
      </div>
      <table class="table table-bordered mt-3">
         <thead>
            <th>Date</th>
            <th>Reference</th>
            <th>Description</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
         </thead>
         <tbody>
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><?php echo date('d/m/Y',strtotime($invoice->created_at)); ?></td>
                  <td><?php echo $invoice->prefix; ?><?php echo $invoice->invoice_number; ?></td>
                  <td>Invoice <?php echo $invoice->description; ?></td>
                  <td>
                     <?php if($invoice->transaction_type == "Debit"): ?>
                        ksh <?php echo number_format($invoice->total); ?>

                     <?php else: ?>
                        0
                     <?php endif; ?>
                  </td>
                  <td>
                     <?php if($invoice->transaction_type == "Credit"): ?>
                        ksh <?php echo number_format($invoice->total); ?>

                     <?php else: ?>
                        0
                     <?php endif; ?>
                  </td>
                  <td>
                     <b>ksh <?php echo number_format($invoice->total); ?></b></br>
                  </td>
               </tr>
               <?php if($invoice->paid != ""): ?>
                  <?php $__currentLoopData = Finance::all_invoice_payments($invoice->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr class="table-active">
                        <td><?php echo date('d/m/Y',strtotime($payments->created_at)); ?></td>
                        <td><?php echo $payments->reference_number; ?></td>
                        <td>Customer payment</td>
                        <td>ksh 0</td>
                        <td>ksh <?php echo number_format($payments->amount); ?></td>
                        <b><td>ksh <?php echo number_format($payments->balance); ?></td></b>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
               <?php if($invoice->credited == 'Yes'): ?>
               <?php $__currentLoopData = Finance::invoice_creditnote($invoice->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr class="table-primary">
                     <td><?php echo date('d/m/Y',strtotime($credit->creditnoteinvoicedate)); ?></td>
                     <td><?php echo $creditSettings->prefix; ?>00<?php echo $credit->creditnote_number; ?></td>
                     <td>Credit Note</td>
                     <td>ksh <?php echo number_format($credit->credited_amount); ?></td>
                     <td>ksh 0</td>
                     <b><td>ksh <?php echo number_format($credit->invoice_balance); ?></td></b>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/statement.blade.php ENDPATH**/ ?>