<?php $__env->startSection('title','Active Employees'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Payroll</li>
         <li class="breadcrumb-item active">Active Employee</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Active Employee </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr class="table-header">
                     <th width="1%">#</th>
                     <th>Employee</th>
                     <th>Position</th>
                     <th>Department</th>
                     <th>Payment basis</th>
                     <th>Salary</th>
                     <th>Payment</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr class="">
                        <td><?php echo $count++; ?></td>
                        <td>
                           <?php echo $employee->names; ?>

                        </td>
                        <td>
                           <?php if($employee->position != ""): ?>
                              <?php echo Hr::position()->name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($employee->department != ""): ?>
                              <?php echo Hr::department()->title; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php echo $employee->payment_basis; ?>

                        </td>
                        <td>
                           <?php echo number_format($employee->salary_amount); ?> <?php echo $employee->code; ?>

                        </td>
                        <td>
                           <?php if(Finance::check_account_payment_method($employee->payment_method) == 1): ?>
                              <?php echo Finance::account_payment_method($employee->payment_method)->name; ?>

                           <?php endif; ?>
                           <?php if(Finance::check_system_payment($employee->payment_method) == 1): ?>
                              <?php echo Finance::system_payment($employee->payment_method)->name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <a href="<?php echo route('hrm.payroll.people.show',$employee->empID); ?>" class="btn btn-pink btn-sm"><i class="fas fa-eye"></i> Payroll details</a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('tips'); ?>
<div class="theme-panel theme-panel-lg">
   <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fas fa-info-circle"></i></i></a>
   <div class="theme-panel-content">
      <h5 class="m-t-0">Tips</h5>
      <div class="row m-t-10">
         <div class="col-md-12">
            <p>Employee listed on this section have their employment status as <b>Employed</b> and the are allocate <b>Salary</b></p>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/people/index.blade.php ENDPATH**/ ?>