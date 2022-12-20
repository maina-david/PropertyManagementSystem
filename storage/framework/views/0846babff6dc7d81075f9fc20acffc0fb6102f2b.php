<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">
   <title>Receipt</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="<?php echo asset('assets/templates/bootstrap-3/style.css'); ?>" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style> 
</head>
<body>
   <div>
      <div class="row">
         <div class="col-xs-12">
            <h3 class="text-center">Receipt</h3> 
            <h4 class="text-center">#<?php echo $invoice->prefix; ?><?php echo $invoice->number; ?></h4>
            <h5 class="text-center"><?php echo date('F jS, Y', strtotime($invoice->invoice_date)); ?></h5>
         </div>
      </div>
      <table class="table">
         <thead>
            <th>Item</th>
            <th>Amount</th>
         </thead>
         <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><p><?php echo $product->quantity; ?> x <?php echo $product->product_name; ?> @ <?php echo $invoice->symbol; ?><?php echo number_format($product->selling_price,2); ?></p></td>
                  <td><?php echo $invoice->symbol; ?><?php echo number_format($product->total_amount,2); ?></td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
      <div class="row">
         <div class="col-md-6"></div>
         <div class="col-md-6">
            <table class="table">
               <tr>
                  <th>Discount</th>
                  <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->discount,2); ?></th>
               </tr>
               <tr>
                  <th>Subtotal</th>
                  <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->sub_total,2); ?></th>
               </tr>
               <tr>
                  <th>Tax (<?php echo $invoice->taxRate; ?>%)</th>
                  <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->taxvalue,2); ?></th>
               </tr>
               <tr>
                  <th>Total</th>
                  <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->total,2); ?></th>
               </tr>
               <tr>
                  <th>Paid</th>
                  <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->total,2); ?></th>
               </tr>
            </table>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <hr>
            <center>Served By <?php echo Wingu::user($invoice->salesperson)->name; ?></center>
            <center><?php echo date('F jS, Y', strtotime($invoice->invoice_date)); ?></center>
         </div>
      </div>
   </div>
</body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/pos/receipt.blade.php ENDPATH**/ ?>