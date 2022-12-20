<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Expense Summary</title>

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
            <h3 class="text-center"><?php echo $business->name; ?></h3> 
            <h4 class="text-center">Expense Summary</h4>
            <h5 class="text-center">From <?php echo date('F jS, Y', strtotime($from)); ?> To <?php echo date('F jS, Y', strtotime($to)); ?></h5>
         </div>
      </div>
      <table class="table zi-table financial-comparison table-no-border">
         <thead>
            <tr class="rep-fin-th"> 
            <th class="text-left"><h4>Expense</h4></th> 
            <th class="text-right"><h4>Total</h4></th>  
            </tr>
         </thead> 
         <tbody> 
            <?php $__currentLoopData = $expenseCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if(Finance::check_expense_per_category_by_period($expCat->id,$from,$to) != 0): ?>
                  <?php $__currentLoopData = Finance::expense_per_category($expCat->id,$from,$to); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr class=" balance-tr">
                        <td><?php echo $expCat->category_name; ?></td>  
                        <td class="text-right"><?php echo $business->code; ?><?php echo number_format(Finance::expense_per_category_sum($expCat->id,$from,$to)); ?></td>  
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td><b>Total Expenses</b></td>   
               <td class="text-right"><b><?php echo $business->code; ?><?php echo number_format($expense); ?></b></td>  
            </tr> 
         </tbody>
      </table>
   </div>
</body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/reports/expensesummery.blade.php ENDPATH**/ ?>