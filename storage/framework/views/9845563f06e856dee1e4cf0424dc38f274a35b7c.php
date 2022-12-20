<?php $__env->startSection('title','Statement Of Account Results'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a href="<?php echo route('finance.report.account.statement.export.print',[$clientID,$from,$to,$transaction]); ?>" target="_blank" class="btn btn-pink"><i class="fas fa-print"></i> Export for Print</a>
         <a href="<?php echo route('finance.report.account.statement.export.pdf',[$clientID,$from,$to,$transaction]); ?>" class="btn btn-pink ml-2"><i class="fas fa-file-pdf"></i> Export for PDF</a>
         <a href="<?php echo route('finance.report.account.statement.export.excel',[$clientID,$from,$to,$transaction]); ?>" class="btn btn-pink ml-2"><i class="fas fa-file-excel"></i> Export to Excel</a>
         <a href="#" class="btn btn-pink ml-2"><i class="fas fa-envelope-open-text"></i> Email Client</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Statement Of Account Results</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12">
         <h4>Customer : <?php echo $client->customer_name; ?> <br>Period : <?php echo date('d F, Y', strtotime($from)); ?> - <?php echo date('d F, Y', strtotime($to)); ?></h4>

         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Results</h4>
            </div>
            <div class="panel-body">
               <table class="table table-bordered">
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
                           <td><?php echo Finance::invoice_settings()->prefix; ?><?php echo $invoice->invoice_number; ?></td>
                           <td>Invoice <?php echo $invoice->description; ?></td>
                           <td>
                              <?php echo $currency->code; ?> <?php echo number_format($invoice->total); ?>

                           </td>
                           <td>
                              0
                           </td>
                           <td>
                              <b><?php echo $currency->code; ?> <?php echo number_format($invoice->total); ?></b></br>
                           </td>
                        </tr>
                        <?php $__currentLoopData = Finance::flow_per_invoice($invoice->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($flow->section == 'Payment'): ?>
                              <?php $__currentLoopData = Finance::flow_per_payment($invoice->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr class="table-primary">
                                    <td><?php echo date('d/m/Y',strtotime($payment->payment_date)); ?></td>
                                    <td><?php echo $payment->reference_number; ?></td>
                                    <td>Customer payment</td>
                                    <td><?php echo $currency->code; ?> 0</td>
                                    <td><?php echo $currency->code; ?> <?php echo number_format($payment->amount); ?></td>
                                    <td><b><?php echo $currency->code; ?> <?php echo number_format($payment->balance); ?></b></td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>
                           <?php if($flow->section == 'Credit'): ?>
                              <?php $__currentLoopData = Finance::flow_per_credit($invoice->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr class="table-active">
                                    <td><?php echo date('d/m/Y',strtotime($credit->credit_date)); ?></td>
                                    <td><?php echo $creditSettings->prefix; ?><?php echo $credit->creditnote_number; ?></td>
                                    <td>Credit Note</td>                             
                                    <td><?php echo $currency->code; ?> 0</td>
                                    <td><?php echo $currency->code; ?> <?php echo number_format($credit->credited_amount); ?></td>
                                    <td><b><?php echo $currency->code; ?> <?php echo number_format($credit->invoice_balance); ?></b></td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/reports/account_statement/results.blade.php ENDPATH**/ ?>