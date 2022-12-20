<div id="sidebar" class="sidebar">
   <?php  $module = 'Point of sale' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub <?php echo e(Nav::isResource('dashboard')); ?>">
            <a href="<?php echo route('pos.dashboard'); ?>">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a> 
         </li>
         
         <li class="has-sub <?php echo e(Nav::isResource('terminal')); ?>">
            <a href="<?php echo route('pos.sell'); ?>">
               <i class="fal fa-cash-register"></i>
               <span>Sales Terminal</span>
            </a>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('history')); ?>">
            <a href="<?php echo route('sales.history'); ?>">
               <i class="fal fa-history"></i>
               <span>Sales history</span>
            </a>
         </li>
         <li class="has-sub <?php echo e(Nav::isRoute('pos.items')); ?>">
            <a href="<?php echo route('pos.items'); ?>">
               <i class="fal fa-shopping-basket"></i>
               <span>Items</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-inventory"></i>
               <span>Inventory </span>
            </a>
            <ul class="sub-menu">
               
               <li class="<?php echo e(Nav::isRoute('finance.lpo.create')); ?>"><a href="<?php echo route('finance.lpo.create'); ?>" target="_blank">purchase</a></li>
               
            </ul>
         </li>
         <li class="has-sub">
            <a href="#" target="_blank">
               <i class="fal fa-users-cog"></i>
               <span>Suppliers</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="<?php echo route('finance.contact.index'); ?>" target="_blank">
               <i class="fal fa-users"></i>
               <span>Customers</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="#" target="_blank">
               <i class="fal fa-chart-pie"></i>
               <span>Reports</span>
            </a>
         </li>
         
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/partials/_hold.blade.php ENDPATH**/ ?>