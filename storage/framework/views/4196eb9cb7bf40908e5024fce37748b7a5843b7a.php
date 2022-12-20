<div class="row">
   <div class="col-md-4">
      <?php if($client->logo != ""): ?>
         <img src="<?php echo asset('businesses/'.$client->business_code.'/documents/images/'.$client->logo); ?>" class="logo" alt="<?php echo $client->businessName; ?>">
      <?php endif; ?>
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong><?php echo $client->businessName; ?></strong>
         <?php if($client->street != ""): ?>
         <br><?php echo $client->street; ?><br>
         <?php endif; ?>
         <?php if($client->city != ""): ?>
         <?php echo $client->city; ?>,
         <?php endif; ?>
         <?php if($client->postal_address != "" ): ?>
         <?php echo $client->postal_address; ?>

         <?php endif; ?>
         <?php if($client->postal_address != "" && $client->zip_code != "" ): ?>
            - <?php echo $client->zip_code; ?>

         <?php endif; ?>
         <br>
         <b>Phone:</b> <?php echo $client->primary_phonenumber; ?><br>
         <b>Email:</b> <?php echo $client->primary_email; ?>

      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Statement of Accounts</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong><?php echo $client->customer_name; ?></strong>
         <span><br><?php if($client->bill_state != ""): ?><?php echo $client->bill_state; ?>,<?php endif; ?></span>
         <span><?php if($client->bill_city != ""): ?><?php echo $client->bill_city; ?>,<?php endif; ?></span>
         <span><?php if($client->bill_street != ""): ?><?php echo $client->bill_street; ?><br><?php endif; ?></span>
         <span>
            <?php if($client->bill_street != ""): ?>
               <?php echo $client->bill_zip_code; ?><br>
            <?php endif; ?>
            <?php if($client->bill_country != ""): ?>
               <?php echo Wingu::country($client->bill_country)->name; ?><br>
            <?php endif; ?>
         </span>
         <span><b>Email: </b><?php if($client->email != ""): ?><?php echo $client->email; ?><?php endif; ?></span>
      </address>
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th bgcolor="#dcdcdc" colspan="2"><b>Account Summary</b></th>
            </tr>
            <tr>
               <th><b>Invoiced Amount :</b></th>
               <td align="right" colspan="2"><?php echo $client->symbol; ?><?php echo number_format($invoicedAmount,2); ?></td>                
            </tr>
            <tr>
               <th><b>Amount Received :</b></th>
               <td align="right" colspan="2"><?php echo $client->symbol; ?><?php echo number_format($amountReceived,2); ?></td>                
            </tr>
            <tr>
               <th><b>Balance Due :</b></th>
               <td align="right" colspan="2">
                  <?php if($invoicesBalance < 0): ?>
                     <?php echo $client->symbol; ?>0
                  <?php else: ?> 
                     <?php echo $client->symbol; ?><?php echo number_format($invoicesBalance,2); ?>

                  <?php endif; ?>                  
               </td>               
            </tr>
         </tbody>
      </table>
   </div>
</div>
<table class="table table-striped table-bordered mt-3">
   <thead>
      <tr>
         <th>Date</th>
         <th>Transactions</th>
         <th>Details</th>
         <th>Amount</th>
         <th>Payments</th>
         <th>Balance</th>
      </tr>
   </thead>
   <tbody>
      <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <tr>
            <td><?php echo date('d M Y', strtotime($invoice->invoice_date)); ?></td>
            <td>Invoice</td>
            <td>
               <span class="text-primary"><?php echo $invoice->invoice_prefix; ?><?php echo $invoice->invoice_number; ?> - due on <?php echo date('d M Y', strtotime($invoice->invoice_due)); ?></span>
            </td>
            <td><b><?php echo $client->symbol; ?><?php echo number_format($invoice->main_amount,2); ?></b></td>
            <td></td>
            <td>               
               <?php if($invoice->balance < 0): ?>
                  <?php echo $client->symbol; ?>0
               <?php else: ?> 
                  <?php echo $client->symbol; ?><?php echo number_format($invoice->balance,2); ?>

               <?php endif; ?>
            </td>
         </tr>
         <?php $__currentLoopData = Finance::all_invoice_payments($invoice->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td><?php echo date('d M Y', strtotime($payment->payment_date)); ?></td>
               <td>
                  <?php if($payment->payment_category == 'Credited'): ?>
                     Credited
                  <?php else: ?>
                     Payment Received
                  <?php endif; ?>
               </td>
               <td> 
                  <span class="text-info">
                     <?php echo $client->symbol; ?><?php echo number_format($payment->amount); ?> for payment of <?php echo $invoice->invoice_prefix; ?><?php echo $invoice->invoice_number; ?>

                  </span>
               </td>
               <td></td>
               <td><b><?php echo $client->symbol; ?><?php echo number_format($payment->amount,2); ?></b></td>
               <td>
                  <b>
                     <?php if($payment->balance < 0): ?>
                        <?php echo $client->symbol; ?>0
                     <?php else: ?> 
                        <?php echo $client->symbol; ?><?php echo number_format($payment->balance,2); ?>

                     <?php endif; ?>  
                  </b>  
               </td>
            </tr>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </tbody>
</table><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/statement/preview.blade.php ENDPATH**/ ?>