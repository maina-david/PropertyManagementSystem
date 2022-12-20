<?php $__env->startSection('title',' My Leave List'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Leave</a></li>
         <li class="breadcrumb-item active">My Leave List </li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fad fa-calendar-check"></i> My Leave List</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="widget-list widget-list-rounded mb-2 col-md-4">
               <!-- begin widget-list-item -->
               <div class="widget-list-item">
                  <div class="widget-list-media">
                     <?php if($leave->statusID == 7): ?>
                        <i class="fas fa-calendar-day fa-4x"></i>
                     <?php endif; ?>
                     <?php if($leave->statusID == 20): ?>
                        <i class="fas fa-calendar-times fa-4x"></i>
                     <?php endif; ?>
                     <?php if($leave->statusID == 19): ?>
                        <i class="fas fa-calendar-check fa-4x"></i>
                     <?php endif; ?>
                  </div>
                  <div class="widget-list-content">
                     <h4 class="widget-list-title font-weight-bold">
                        <?php echo $leave->names; ?>

                     </h4>
                     <p class="widget-list-desc">
                        <i class="text-info">
                           <b>
                              <?php echo $leave->leaveName; ?>

                           </b>
                        </i>
                        <br>
                        From : <b><?php echo date('d F, Y', strtotime($leave->start_date)); ?></b><br>
                        To : <b><?php echo date('d F, Y', strtotime($leave->end_date)); ?></b><br>
                        <b><?php echo Helper::date_difference($leave->end_date,$leave->start_date); ?> days</b>
                        <br>
                        Status : <span class="badge <?php echo $leave->statusName; ?>"><?php echo $leave->statusName; ?></span>
                     </p>
                  </div>
                  <div class="widget-list-action">
                     <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                        <i class="fa fa-ellipsis-h f-s-14"></i>
                     </a>
                     <ul class="dropdown-menu dropdown-menu-right">
                        <?php if($leave->statusID  != 19): ?>
                           <li><a href="<?php echo route('hrm.leave.apply.edit',$leave->leaveID); ?>">Edit</a></li>
                        <?php endif; ?>
                        <?php if($leave->end_date > new DateTime("")): ?>
                           <?php if($leave->statusID  != 19): ?>
                              <li><a href="#">Approve</a></li>
                           <?php endif; ?>
                           <?php if($leave->statusID  != 20): ?>
                              <li><a href="#">Denay</a></li>
                           <?php endif; ?>
                        <?php endif; ?>
                     </ul>
                  </div>
               </div>
               <!-- end widget-list-item -->
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/leave/application/index.blade.php ENDPATH**/ ?>