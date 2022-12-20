<?php $__env->startSection('title','Finance Reports'); ?>

<?php $__env->startSection('stylesheet'); ?>
   <style>
      button {
         font-size: 14px;
         border: none;
         background-color: #fff;
         margin-left: -5px;
         color: #007bff;
         font-weight: 900;
      }
   </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item active"><a href="<?php echo route('finance.report'); ?>">Report</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-chart-pie"></i> Reports</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
         $lastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
         $firstdate = \Carbon\Carbon::now()->startOfMonth()->toDateString();
         $currentDate = date('Y-m-d');
      ?>
      <div class="row">
         <div class="col-md-4">
            <div class="card">
               <div class="card-header"><i class="fal fa-building"></i> Business Overview</div>
               <div class="card-body" style="min-height: 120px;">
                  <form action="<?php echo route('finance.report.profitandloss'); ?>" method="GET">
                     <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                     <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                     <button type="submit">Profit and Loss</button>
                  </form>
                  <form action="<?php echo route('finance.report.expensesummary'); ?>" method="GET">
                     <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                     <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                     <button type="submit">Expense Summary</button>
                  </form>
                  <form action="<?php echo route('finance.report.incomesummary'); ?>" method="GET">
                     <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                     <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                     <button type="submit">Income Summary</button>
                  </form>
               </div>
            </div>
         </div>
         <?php if(Wingu::business()->plan != 1): ?>
            <div class="col-md-4">
               <div class="card">
                  <div class="card-header"><i class="fal fa-usd-circle"></i> Sales</div>
                  <div class="card-body" style="min-height: 120px;">
                     <form action="<?php echo route('finance.report.sales.customer'); ?>" method="GET">
                        <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                        <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                        <button type="submit">Sales by Customer</button>
                     </form>
                     <form action="<?php echo route('finance.report.sales.item'); ?>" method="GET">
                        <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                        <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                        <button type="submit">Sales by Item</button>
                     </form>
                     <form action="<?php echo route('finance.report.sales.salesperson'); ?>" method="GET">
                        <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                        <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                        <button type="submit">Sales by Sales person</button>
                     </form>
                  </div>
               </div>
            </div>
         <?php endif; ?>
         <div class="col-md-4">
            <div class="card">
               <div class="card-header"><i class="fal fa-money-check-alt"></i> Receivables</div>
               <div class="card-body" style="min-height: 120px;">
                  <form action="<?php echo route('finance.report.receivables.balance'); ?>" method="GET">
                     <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                     <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                     <button type="submit">Customer Balances</button>
                  </form> 
                  <form action="<?php echo route('finance.report.receivables.aging'); ?>" method="GET">
                     <input type="hidden" name="date" value="<?php echo $currentDate; ?>" required>
                     <button type="submit">Aging Summary</button>
                  </form>
                  
                  
                  
               </div>
            </div>
         </div>
         <?php if(Wingu::business()->plan != 1): ?>
            <div class="col-md-4">
               <div class="card">
                  <div class="card-header"><i class="fal fa-inventory"></i> Inventory</div>
                  <div class="card-body" style="min-height: 120px;">
                     <form action="<?php echo route('finance.report.inventory.summary'); ?>" method="GET">
                        <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                        <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                        <button type="submit">Inventory Summary</button>
                     </form>
                     <form action="<?php echo route('finance.report.inventory.valuation.summary'); ?>" method="GET">
                        <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                        <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                        <button type="submit">Inventory Valuation Summary</button>
                     </form>
                     <form action="<?php echo route('finance.report.inventory.sale.summary'); ?>" method="GET">
                        <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                        <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                        <button type="submit">Product Sales Report</button>
                     </form>
                     
                     
                     
                     
                     
                     
                  </div>
               </div>
            </div>
         <?php endif; ?>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/reports/dashboard.blade.php ENDPATH**/ ?>