<div id="sidebar" class="sidebar">
   <?php  $module = 'Human Resource' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <?php if (app('laratrust')->isAbleTo('create-employee')) : ?>
            <li class="has-sub <?php echo e(Nav::isRoute('hrm.dashboard')); ?>">
               <a href="<?php echo route('hrm.dashboard'); ?>">
                  <i class="fa fa-th-large"></i>
                  <span>Dashboard</span>
               </a>
            </li>
         <?php endif; // app('laratrust')->permission ?>
         <?php if (app('laratrust')->isAbleTo('read-employee')) : ?>
            <li class="has-sub <?php echo e(Nav::isResource('employee')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-users"></i>
                  <span>Employee</span>
               </a>
               <ul class="sub-menu">
                  <li><a href="<?php echo route('hrm.employee.index'); ?>">All Employee</a></li>
                  <?php if (app('laratrust')->isAbleTo('create-employee')) : ?>
                     <li><a href="<?php echo route('hrm.employee.create'); ?>">Add Employee</a></li>
                  <?php endif; // app('laratrust')->permission ?>
               </ul>
            </li>
         <?php endif; // app('laratrust')->permission ?>
         <li class="has-sub <?php echo e(Nav::isResource('leave')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-calendar-day"></i>
               <span>Leave Request</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo Nav::isRoute('hrm.leave.apply'); ?> <?php echo Nav::isRoute('hrm.leave.apply.edit'); ?>"><a href="<?php echo route('hrm.leave.apply'); ?>">Apply</a></li>
               <li class="<?php echo Nav::isRoute('hrm.leave.apply.index'); ?>"><a href="<?php echo route('hrm.leave.apply.index'); ?>">My Leave List</a></li>
               <?php if (app('laratrust')->isAbleTo('read-leave')) : ?>
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.index')); ?>"><a href="<?php echo route('hrm.leave.index'); ?>">All Requests</a></li>
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.create')); ?> <?php echo Nav::isRoute('hrm.leave.edit'); ?>"><a href="<?php echo route('hrm.leave.create'); ?>">Assign Leave</a></li>
                  
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.calendar')); ?>"><a href="<?php echo route('hrm.leave.calendar'); ?>">Leave Calendar</a></li>
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.settings.type')); ?>"><a href="<?php echo route('hrm.leave.settings.type'); ?>">Leave Types</a></li>
               <?php endif; // app('laratrust')->permission ?>
            </ul>
         </li>
         
         <li class="has-sub <?php echo e(Nav::isResource('payroll')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-money-check-alt"></i>
               <span>Payroll</span>
            </a>
            <ul class="sub-menu">
               <?php if (app('laratrust')->isAbleTo('create-payroll')) : ?>
                  <li class="<?php echo e(Nav::isRoute('hrm.payroll.people')); ?> <?php echo Nav::isRoute('hrm.payroll.people'); ?>"><a href="<?php echo route('hrm.payroll.people'); ?>">People</a></li>
                  <li class="<?php echo Nav::isRoute('hrm.payroll.index'); ?>"><a href="<?php echo route('hrm.payroll.index'); ?>">Payrolls</a></li>
                  <li class="<?php echo e(Nav::isRoute('hrm.payroll.process')); ?>"><a href="<?php echo route('hrm.payroll.process'); ?>">Run payroll</a></li>
                  
               <?php endif; // app('laratrust')->permission ?>
               
            </ul>
         </li>
         

         
         
         <li class="has-sub <?php echo e(Nav::isResource('organization')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-sitemap"></i>
               <span>Organization</span>
            </a>
            <ul class="sub-menu">
               <li class="has-sub <?php echo e(Nav::isResource('positions')); ?>">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Positions
                  </a>
                  <ul class="sub-menu">
                     <li><a href="<?php echo route('hrm.positions'); ?>">All Positions</a></li>
                     <li><a href="<?php echo route('hrm.positions'); ?>">Add Positions</a></li>
                  </ul>
               </li>
               <?php if (app('laratrust')->isAbleTo('read-departments')) : ?>
                  <li class="has-sub <?php echo e(Nav::isResource('departments')); ?>">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Department
                     </a>
                     <ul class="sub-menu">
                        <li class="<?php echo e(Nav::isRoute('hrm.departments')); ?>"><a href="<?php echo route('hrm.departments'); ?>">All Department</a></li>
                        <li class="<?php echo e(Nav::isRoute('hrm.departments.create')); ?>"><a href="<?php echo route('hrm.departments.create'); ?>">Add Department</a></li>
                     </ul>
                  </li>
               <?php endif; // app('laratrust')->permission ?>
               <?php if (app('laratrust')->isAbleTo('read-branches')) : ?>
                  <li class="has-sub <?php echo e(Nav::isResource('branches')); ?>">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Branches
                     </a>
                     <ul class="sub-menu">
                        <li><a href="<?php echo route('hrm.branches'); ?>">All Branches</a></li>
                        <li><a href="<?php echo route('hrm.branches.create'); ?>">Add Branches</a></li>
                     </ul>
                  </li>
               <?php endif; // app('laratrust')->permission ?>
            </ul>
         </li>
         
         <li class="has-sub <?php echo e(Nav::isResource('travel')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-plane"></i>
               <span>Travel</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('hrm.travel.index')); ?>"><a href="<?php echo route('hrm.travel.index'); ?>">Travels</a></li>
               <li class="<?php echo e(Nav::isRoute('hrm.travel.expenses')); ?>"><a href="<?php echo route('hrm.travel.expenses'); ?>">Travel Expenses</a></li>
               <?php if(Auth::user()->employeeID != ""): ?>
                  <li class="<?php echo e(Nav::isRoute('hrm.travel.my')); ?>"><a href="<?php echo route('hrm.travel.my'); ?>">My Travels</a></li>
               <?php endif; ?>
            </ul>
         </li>
         
         
         
         
         
         <li class="has-sub <?php echo e(Nav::isResource('settings')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cogs"></i>
               <span>Settings</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('hrm.payroll.settings.deduction')); ?>"><a href="<?php echo route('hrm.payroll.settings.deduction'); ?>">Payroll Deductions</a></li>
               <li class="<?php echo e(Nav::isRoute('hrm.payroll.settings.approval')); ?>"><a href="<?php echo route('hrm.payroll.settings.approval'); ?>"> Approver setting</a></li>
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
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/partials/_menu.blade.php ENDPATH**/ ?>