<?php $__env->startSection('title','payroll'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human resource</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.payroll.index'); ?>">Payroll</a></li>
         <li class="breadcrumb-item active"> Month end pay</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <?php echo date('F jS Y', strtotime($payroll->payroll_date)); ?> - <?php echo $payroll->payroll_type; ?></h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr class="table-header">
                     <th width="1%">#</th>
                     <th class="text-left" style="width: 25%;">Employee</th>
                     <th>Basic salary</th>
                     
                     <th>Gross Pay</th>
                     <th>Deductions</th>
                     <th>Net Pay</th>
                     <th>Status</th>
                     <th width="15%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $payslips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payslip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr class="">
                        <td><?php echo $count++; ?></td>
                        <td>
                           <?php echo $payslip->names; ?>

                        </td>
                        <td>
                           <?php echo $payslip->symbol; ?><?php echo number_format($payslip->salary); ?> 
                        </td>
                        
                        <td>
                           <?php echo $payslip->symbol; ?><?php echo number_format($payslip->gross_pay); ?> 
                        </td>
                        <td>
                           <?php echo $payslip->symbol; ?><?php echo number_format($payslip->deduction); ?> 
                        </td>
                        <td>
                           <?php echo $payslip->symbol; ?><?php echo number_format($payslip->net_pay); ?> 
                        </td>
                        <td>
                           
                        </td>
                        <td>
                           <a href="<?php echo route('hrm.payroll.payslip',[$payslip->employeeID,$payroll->payroll_code]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>
                           <?php if (app('laratrust')->isAbleTo('delete-payroll')) : ?>
                              <a href="<?php echo route('hrm.payroll.payslip.delete',[$payslip->employeeID,$payroll->payroll_code]); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                           <?php endif; // app('laratrust')->permission ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/payroll/details.blade.php ENDPATH**/ ?>