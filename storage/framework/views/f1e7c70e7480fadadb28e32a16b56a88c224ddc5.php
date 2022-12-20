<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Inventory Valuation Summary</title>

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
            <h3 class="text-center">Inventory Valuation Summary</h3>
            <h5 class="text-center">From <?php echo date('F jS, Y', strtotime($from)); ?> To <?php echo date('F jS, Y', strtotime($to)); ?></h5>
         </div>
      </div>
      <table class="table table-bordered">
         <thead>
            <tr>  
               <th>Item Name</th>  
               <th>SKU</th>  
               <th>Stock in hand</th> 
               <th>Asset Value</th>
            </tr>
         </thead> 
         <tbody> 
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><?php echo $product->product_name; ?></td>
                  <td><?php echo $product->sku_code; ?></td>                              
                  <td><?php echo $product->current_stock; ?></td>
                  <td><?php echo $business->code; ?> <?php echo number_format($product->current_stock * $product->price); ?></td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/reports/inventory/valuation.blade.php ENDPATH**/ ?>