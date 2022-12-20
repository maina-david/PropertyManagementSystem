<?php $__env->startSection('title',' Payrolls'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human resource</a></li>
         <li class="breadcrumb-item active">Payrolls</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-history"></i> All Payrolls</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Payroll duration</th>
                        <th>Branch</th>
                        <th>Net Pay</th>
                        <th>Gross pay</th>
                        
                        <th>Deductions</th>
                        <th width="14%">Action</th>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo date('F jS Y', strtotime($payroll->payroll_date)); ?></td>
                              <td><?php echo $payroll->branch; ?></td>
                              <td><?php echo $payroll->symbol; ?><?php echo number_format($payroll->total_net_pay,2); ?> </td>
                              <td><?php echo $payroll->symbol; ?><?php echo number_format($payroll->total_gross_pay,2); ?> </td>
                              
                              <td><?php echo $payroll->symbol; ?><?php echo number_format($payroll->total_deductions,2); ?></td>
                              <td>
                                 <a href="<?php echo route('hrm.payroll.details',$payroll->payroll_code); ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>
                                 <a href="<?php echo route('hrm.payroll.delete',$payroll->payroll_code); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/payroll/index.blade.php ENDPATH**/ ?>