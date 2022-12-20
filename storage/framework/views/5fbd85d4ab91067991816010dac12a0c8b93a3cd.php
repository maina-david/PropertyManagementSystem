<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Financial Statement</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="<?php echo asset('assets/templates/bootstrap-3/style.css'); ?>" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style> 
</head>
<body class="login-page" style="background: white">
   <div>
      <div class="row">
         <div class="col-xs-7">
            <h4><b>From:</b></h4>
            <strong><?php echo Wingu::business(Auth::user()->businessID)->name; ?></strong><br>
            <?php echo Wingu::business(Auth::user()->businessID)->street; ?>,<?php echo Wingu::business(Auth::user()->businessID)->city; ?><br>
            <?php echo Wingu::business(Auth::user()->businessID)->postal_address; ?> - <?php echo Wingu::business(Auth::user()->businessID)->zip_code; ?><br>
            <b>Phone:</b> <?php echo Wingu::business(Auth::user()->businessID)->primary_phonenumber; ?><br>
            <b>Email:</b> <?php echo Wingu::business(Auth::user()->businessID)->primary_email; ?><br>
            <b>Tax Pin :</b> <?php echo Wingu::business(Auth::user()->businessID)->tax_pin; ?>

            <br>
         </div>
         <div class="col-xs-4">
            <?php if(Wingu::business(Auth::user()->businessID)->logo != ""): ?>
               <img src="<?php echo url('/'); ?>/businesses/<?php echo Wingu::business(Auth::user()->businessID)->primary_email; ?>/documents/images/<?php echo Wingu::business(Auth::user()->businessID)->logo); ?>" class="logo" alt="<?php echo Wingu::business(Auth::user()->businessID)->name; ?>">
            <?php endif; ?>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-6">
            <h4><b>To:</b></h4>
            <address>
               <strong><?php if($client->company_name != ""): ?><?php echo $client->company_name; ?><?php else: ?><?php echo $client->tenant_name; ?><?php endif; ?></strong><br>
               <span>
                  <?php if($client->bill_attention != ""): ?>
                     <strong>ATTN :</strong><?php echo $client->bill_attention; ?>

                  <?php endif; ?>
               </span>
               <span><?php if($client->contact_email != ""): ?><?php echo $client->contact_email; ?>,<br><?php endif; ?></span>
               <span><?php if($client->primary_phone_number != ""): ?><?php echo $client->primary_phone_number; ?>,<br><?php endif; ?></span>
               <span><?php if($client->bill_state != ""): ?><?php echo $client->bill_state; ?>,<br><?php endif; ?></span>
               <span><?php if($client->bill_city != ""): ?><?php echo $client->bill_city; ?>,<br><?php endif; ?></span>
               <span><?php if($client->bill_street != ""): ?><?php echo $client->bill_street; ?><?php endif; ?></span><br>
               
               <?php if($client->bill_street != ""): ?>
               <span>
                  <?php echo $client->bill_zip_code; ?><br>
                  <?php echo Wingu::country($client->bill_country)->name; ?>

               </span><br>
               <?php endif; ?>
               <?php if($client->tax_pin != ""): ?>
                  <span>
                     <b>Tax Pin :</b> <?php echo $client->tax_pin; ?>

                  </span>
               <?php endif; ?>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <td colspan="2" align="center"><b>STATEMENT OF ACCOUNT </b><br></td>
                  </tr>
                  <tr>
                     <th>Period  :</th>
                     <td class="text-right"><b><?php echo date('d M Y', strtotime($from)); ?> - <?php echo date('d M Y', strtotime($to)); ?></b></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table table-bordered">
         <tr>
            <th>Date</th>
            <th>Reference</th>
            <th>Description</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
         </tr>
         <tbody>
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
               <tr>
                  <td><?php echo date('d/m/Y',strtotime($invoice->created_at)); ?></td>
                  <td><?php echo Finance::invoice_settings()->prefix; ?><?php echo $invoice->invoice_number; ?></td>
                  <td>Invoice <?php echo $invoice->description; ?></td>
                  <td>
                     <?php if($invoice->transaction_type == "Debit"): ?>
                        <?php echo $business->code; ?> <?php echo number_format($invoice->total); ?>

                     <?php else: ?>
                        0
                     <?php endif; ?>
                  </td>
                  <td>
                     <?php if($invoice->transaction_type == "Credit"): ?>
                        <?php echo $business->code; ?> <?php echo number_format($invoice->total); ?>

                     <?php else: ?>
                        0
                     <?php endif; ?>
                  </td>
                  <td>
                     <b><?php echo $business->code; ?> <?php echo number_format($invoice->total); ?></b></b>
                  </td>
               </tr>
               <?php if($invoice->paid != ""): ?>
                  <?php $__currentLoopData = Finance::all_invoice_payments($invoice->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr class="table-active">
                        <td><?php echo date('d/m/Y',strtotime($payments->created_at)); ?></td>
                        <td><?php echo $payments->reference_number; ?></td>
                        <td>Invoice payment</td>
                        <td><?php echo $business->code; ?> 0</td>
                        <td><?php echo $business->code; ?> <?php echo number_format($payments->amount); ?></td>
                        <b><td><?php echo $business->code; ?> <?php echo number_format($payments->balance); ?></td></b>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
               <?php if($invoice->credited == 'Yes'): ?>
                  <?php $__currentLoopData = Finance::invoice_creditnote($invoice->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr class="table-primary">
                        <td><?php echo date('d/m/Y',strtotime($credit->creditnoteinvoicedate)); ?></td>
                        <td><?php echo $creditSettings->prefix; ?><?php echo $creditSettings->creditnote_number; ?></td>
                        <td>Credit Note</td>
                        <td><?php echo $business->code; ?> <?php echo number_format($credit->credited_amount); ?></td>
                        <td><?php echo $business->code; ?> 0</td>
                        <b><td><?php echo $business->code; ?> <?php echo number_format($credit->invoice_balance); ?></td></b>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>

</body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/reports/finance-statement.blade.php ENDPATH**/ ?>