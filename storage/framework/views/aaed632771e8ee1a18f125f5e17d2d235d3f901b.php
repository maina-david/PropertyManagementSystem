<?php $__env->startSection('title'); ?> <?php echo $employee->employee_name; ?> | Details <?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content content-full-width">
   <div class="profile">
      <div class="profile-header">      
         <div class="profile-header-cover"></div>     
         <div class="profile-header-content">
            <div class="profile-header-img">
               <?php if($employee->image != ""): ?>
                  <img class="rounded-circle" width="114" height="114" alt="<?php echo $employee->employee_name; ?>" src="<?php echo asset('businesses/'.$employee->businessCode.'/hr/employee/images/'.$employee->image); ?>">
               <?php else: ?>
                  <img src="https://ui-avatars.com/api/?name=<?php echo $employee->employee_name; ?>&rounded=false&size=114" alt="">
               <?php endif; ?>
            </div>         
            <div class="profile-header-info">
               <h4 class="mt-0 mb-1"><?php echo $employee->employee_name; ?></h4>
               <p class="mb-2">
                  <?php if($employee->position !=""): ?>
                     <?php if(Hr::check_position($employee->position) == 1): ?>
                        <?php echo Hr::position($employee->position)->name; ?>

                     <?php endif; ?>
                  <?php endif; ?>
               </p>
               <a href="<?php echo e(route('hrm.employee.edit',$employee->employeeID)); ?>" class="btn btn-xs btn-yellow">Edit Profile</a>
            </div>
         </div>
         <ul class="profile-header-tab nav nav-tabs">
            <li class="nav-item"><a href="#" class="nav-link active">Overview</a></li>
            
         </ul>      
      </div>
   </div>
</div>
<div id="content" class="content">
   <div class="row">
      <div class="col-md-3">
         <div class="card">
            <div class="card-body">
               <p>
                  <b>Name :</b> <?php echo $employee->employee_name; ?><br>
                  <b>Gender :</b> <?php echo $employee->gender; ?>

               </p>
               <hr>
               <p>
                  <b>CompanyID :</b> <?php echo $employee->companyID; ?><br>
                  <b>Status :</b> <?php if($employee->statusID != ""): ?><span class="badge <?php echo Wingu::status($employee->statusID)->name; ?>"><?php echo Wingu::status($employee->statusID)->name; ?> </span><?php endif; ?><br>
                  <b>Contract Type :</b> <span class="badge badge-warning"><?php echo $employee->contract_type; ?></span><br>
                  <b>Position :</b> 
                  <?php if($employee->position != ""): ?>
                     <?php if(Hr::check_position($employee->position) == 1): ?>
                        <?php echo Hr::position($employee->position)->name; ?>

                     <?php endif; ?>
                  <?php endif; ?>
                  <br>
               </p>
               <hr>
               <p>
                  <b>Personal Phone Number :</b> <?php echo $employee->personal_number; ?> <br>
                  <b>Office Phone Number :</b> <?php echo $employee->company_phone_number; ?> <br>
               </p>
               <hr>
               <p>
                  <b>Personal Email :</b> <?php echo $employee->personal_email; ?> <br>
                  <b>Office Email :</b> <?php echo $employee->company_email; ?> <br>
               </p>
            </div>
         </div>
         <div class="card">
            <div class="card-body">
               <p>
                  <b>Hire Date :</b> <?php echo date('F jS, Y', strtotime($employee->hire_date)); ?><br>
                  <b>Source of hire :</b> <?php echo $employee->source_of_hire; ?>

               </p>
               <hr>
               <p>
                  <b>Department :</b> 
                  <?php if($employee->department != ""): ?>
                     <?php if(Hr::check_department($employee->department) == 1): ?>
                        <?php echo Hr::department($employee->department)->title; ?>

                     <?php endif; ?>
                  <?php endif; ?>
                  <br>
               </p>
               <?php if(Hr::check_if_has_leader($employee->employeeID) > 0): ?>
               <hr>
                  <p>
                     <b>Reporting to.</b><br>
                     <?php $__currentLoopData = Hr::get_employee_leaders($employee->employeeID); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leader): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge badge-pink"><?php echo $leader->names; ?></span>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                     
                  </p>
               <?php endif; ?>
               <?php if(Hr::check_if_heads_departments($employee->employeeID) > 0): ?>
                  <hr>
                  <p>
                     <b>Department Head to:</b><br>
                     <?php $__currentLoopData = Hr::get_heading_departments($employee->employeeID); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <span class="badge badge-primary"><?php echo $department->title; ?></span>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </p>
               <?php endif; ?>
            </div>
         </div>
      </div>
      <div class="col-md-9">
         <div class="card">
            <div class="card-body">
               
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/show.blade.php ENDPATH**/ ?>