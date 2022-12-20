<div id="sidebar" class="sidebar">
   <?php  $module = 'Customer relationship management' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub <?php echo Nav::isRoute('crm.dashboard'); ?>">
            <a href="<?php echo route('crm.dashboard'); ?>">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('customer')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Customer</span>
            </a>
            <ul class="sub-menu">
               <li><a href="<?php echo route('crm.customers.index'); ?>">Customer List</a></li>
               <li><a href="<?php echo route('crm.customers.create'); ?>">Add Customer</a></li>
               <li class="<?php echo Nav::isRoute('crm.customers.groups.index'); ?> <?php echo Nav::isRoute('crm.customers.groups.edit'); ?>">
               <a href="<?php echo route('crm.customers.groups.index'); ?>">Customer category</a>
               </li>
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isRoute('crm.leads.create')); ?> <?php echo e(Nav::isRoute('crm.leads.index')); ?> <?php echo Nav::isRoute('crm.leads.status'); ?> <?php echo Nav::isRoute('crm.leads.sources'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-phone-volume"></i>
               <span>Leads</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('crm.leads.index')); ?>"><a href="<?php echo route('crm.leads.index'); ?>">Leads List</a></li>
               <li class="<?php echo e(Nav::isRoute('crm.leads.create')); ?>"><a href="<?php echo route('crm.leads.create'); ?>">Add Lead</a></li>
               <li class="<?php echo Nav::isRoute('crm.leads.status'); ?>"><a href="<?php echo route('crm.leads.status'); ?>">Lead Status</a></li>
               <li class="<?php echo Nav::isRoute('crm.leads.sources'); ?>"><a href="<?php echo route('crm.leads.sources'); ?>">Lead Sources</a></li>
            </ul>
         </li>
         <?php if(Wingu::business()->id == 2): ?>
            <li class="has-sub <?php echo Nav::isResource('deals'); ?> <?php echo e(Nav::isResource('pipeline')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-bullseye"></i>
                  <span>Deals</span>
               </a>
               <ul class="sub-menu">
                  <li class="<?php echo Nav::isRoute('crm.deals.index'); ?>"><a href="<?php echo route('crm.deals.index'); ?>">All Deals</a></li>
                  <li class="<?php echo Nav::isRoute('crm.deals.create'); ?>"><a href="<?php echo route('crm.deals.create'); ?>">Add deals</a></li>
                  <li class="<?php echo Nav::isRoute('crm.pipeline.index'); ?> <?php echo e(Nav::isResource('pipeline')); ?>"><a href="<?php echo route('crm.pipeline.index'); ?>">Pipeline</a></li>
               </ul>
            </li>
         <?php endif; ?>
         
         
         
         <?php if(Wingu::business()->id == 2): ?>
            <li class="has-sub <?php echo e(Nav::isResource('social')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-share-alt"></i>
                  <span>Social</span>
               </a>
               <ul class="sub-menu">
                  <li class="<?php echo e(Nav::isRoute('crm.social.dashboard')); ?>">
                     <a href="<?php echo route('crm.social.dashboard'); ?>">
                        Dashboard
                     </a>
                  </li>
                  <li class="has-sub <?php echo e(Nav::isResource('post')); ?>">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Posts
                     </a>
                     <ul class="sub-menu">
                        <li><a href="<?php echo route('crm.social.post.index'); ?>">All Posts</a></li>
                        <li><a href="<?php echo route('crm.social.post.create'); ?>">Add Post</a></li>
                        <li><a href="#">Drafted Post</a></li>
                        <li><a href="#">Schedules</a></li>
                     </ul>
                  </li>
                  <li class="has-sub <?php echo e(Nav::isResource('account')); ?>">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Account
                     </a>
                     <ul class="sub-menu">
                        <li><a href="#">All Accounts</a></li>
                        <li><a href="#">Add Account</a></li>
                     </ul>
                  </li>
                  <li class="has-sub <?php echo e(Nav::isResource('account')); ?>">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Feeds
                     </a>
                     <ul class="sub-menu">
                        <li><a href="#">Twitter Feeds</a></li>
                        <li><a href="#">Instagram Feeds</a></li>
                        <li><a href="#">Facebook Feeds</a></li>
                     </ul>
                  </li>
                  <li class="has-sub <?php echo e(Nav::isResource('account')); ?>">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Queues
                     </a>
                     <ul class="sub-menu">
                        <li><a href="#">All Queues</a></li>
                        <li><a href="#">Add Queues</a></li>
                     </ul>
                  </li>
                  <li class="has-sub <?php echo e(Nav::isResource('account')); ?>">
                     <a href="javascript:;">
                        Calendar
                     </a>
                  </li>
               </ul>
            </li>
         <?php endif; ?>
         
         
         

         
         <li class="has-sub <?php echo Nav::isResource('reports'); ?>">
            <a href="<?php echo route('crm.reports'); ?>">
               <i class="fas fa-chart-pie"></i>
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
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/partials/_menu.blade.php ENDPATH**/ ?>