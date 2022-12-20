<div id="sidebar" class="sidebar">
   <?php  $module = 'Asset Management' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         
         <li class="has-sub <?php echo e(Nav::isRoute('assets.create')); ?> <?php echo e(Nav::isRoute('assets.index')); ?> <?php echo e(Nav::isRoute('assets.edit')); ?> <?php echo Nav::isRoute('assets.show'); ?> <?php echo Nav::isResource('events'); ?> ">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-barcode-alt"></i>
               <span>Assets</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('assets.index')); ?>"><a href="<?php echo route('assets.index'); ?>">All Assets</a></li>
               <?php if(Asset::count_assets() != Wingu::plan()->assets && Asset::count_assets() < Wingu::plan()->assets): ?>
                  <?php if (app('laratrust')->isAbleTo('create-assets')) : ?>
                     <li class="<?php echo e(Nav::isRoute('assets.create')); ?>"><a href="<?php echo route('assets.create'); ?>">Add Asset</a></li>
                  <?php endif; // app('laratrust')->permission ?>
               <?php endif; ?>
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('licenses')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-laptop-code"></i>
               <span>Licenses</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('licenses.assets.index')); ?>"><a href="<?php echo route('licenses.assets.index'); ?>">All Licenses</a></li>
               <li class="<?php echo e(Nav::isRoute('licenses.assets.create')); ?>"><a href="<?php echo route('licenses.assets.create'); ?>">Add Licenses</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('types')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-list-ul"></i>
               <span>Asset Type</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('assets.type.index')); ?>"><a href="<?php echo route('assets.type.index'); ?>">All Asset Types</a></li>
               <li class="<?php echo e(Nav::isRoute('assets.type.index')); ?>"><a href="<?php echo route('assets.type.index'); ?>">Add Asset Types</a></li>
            </ul>
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
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/partials/_menu.blade.php ENDPATH**/ ?>