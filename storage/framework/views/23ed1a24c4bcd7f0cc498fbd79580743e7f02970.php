<?php $__env->startSection('title','Finance'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- begin #content -->
<div id="content" class="content">
   <div class="row">
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-teal">
            <div class="stats-icon stats-icon-lg"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="stats-content">
               <div class="stats-title">Due invoices</div>
               <div class="stats-number"><?php echo $dueInvoicescount; ?></div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc">Invoice</div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-blue">
            <div class="stats-icon stats-icon-lg"><i class="fas fa-users fa-fw"></i></div>
            <div class="stats-content">
               <div class="stats-title">Total Clients</div>
               <div class="stats-number"><?php echo $client; ?></div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc">Clients</div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-purple">
            <div class="stats-icon stats-icon-lg"><i class="fab fa-product-hunt fa-fw"></i></div>
            <div class="stats-content">
               <div class="stats-title">Total Products & Services</div>
               <div class="stats-number"><?php echo $products; ?></div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc">Products</div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-black">
            <div class="stats-icon stats-icon-lg"><i class="fas fa-users-cog fa-fw"></i></div>
            <div class="stats-content">
               <div class="stats-title">Total Suppliers</div>
               <div class="stats-number"><?php echo $suppliers; ?></div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc">Supplier</div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
   </div>
   <div class="row">
      <div class="col-md-12">
         <!-- begin panel -->
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Income by category </h4>
            </div>
            <div class="panel-body">
               <?php echo $incomePerCategoryChart->container(); ?>

            </div>
         </div>
         <!-- end panel -->
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <!-- begin panel -->
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Income by month </h4>
            </div>
            <div class="panel-body">
               <?php echo $incomePerMonth->container(); ?>

            </div>
         </div>
         <!-- end panel -->
      </div>
   </div>
   
</div>
<!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo asset('assets/plugins/chart.js/2.7.1/Chart.min.js'); ?>" charset="utf-8"></script>
	<?php echo $incomePerMonth->script(); ?> 
   <?php echo $incomePerCategoryChart->script(); ?>

   <?php echo $expensePerCategory->script(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/dashboard/dashboard.blade.php ENDPATH**/ ?>