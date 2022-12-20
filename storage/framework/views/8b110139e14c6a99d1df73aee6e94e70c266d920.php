<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Customer Balances</title>

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
         <div class="col-xs-12">
            <h3 class="text-center">Customer Balances</h3>
            <h5 class="text-center">From <?php echo date('F jS, Y', strtotime($from)); ?> To <?php echo date('F jS, Y', strtotime($to)); ?></h5>
         </div>
      </div>
      <table class="table table-bordered">
         <thead>
            <tr>  
               <th>Customer Name</th>  
               <th><center>Balance</center></th> 
            </tr>
         </thead> 
         <tbody> 
            <?php $__currentLoopData = $balances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><a href="#"><?php echo $balance->customerName; ?></a></td>
                  <td><center><b><?php echo number_format($balance->total); ?> <?php echo $balance->code; ?></b></center></td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td><b>Total</b></td>
               <td><center><b><?php echo number_format($balances->sum('total')); ?> <?php echo Wingu::currency()->code; ?></b></center></td>
            </tr>
         </tbody>
      </table>
   </div>
</body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/reports/receivables/balance.blade.php ENDPATH**/ ?>