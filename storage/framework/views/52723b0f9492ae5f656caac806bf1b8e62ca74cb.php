<?php $__env->startSection('title','Payslip'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human resource</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.payroll.index'); ?>">Payroll</a></li>
         <li class="breadcrumb-item active">Payslip</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-money-check-alt"></i> Payslip</h1>
      <div class="row">
         <div class="col-md-12">
            
            <?php if(Finance::check_business_payment_integrations(3) == 1): ?>
               <a href="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#mpesaPayment"><i class="fal fa-credit-card"></i> Make Payment</a>
            <?php endif; ?>
         </div>
      </div>
      <div class="card mt-2">
         <div class="card-header">Employee payslip</div>
         <div class="card-body">
            <div class="employee-payslip-container">
               <div class="employee-payslip employee-payslip--sg">
                  <table class="employee-payslip__header">
                     <tbody>
                        <tr class="employee-payslip-company-row">
                           <td class="employee-payslip-company-name" colspan="2"><?php echo $person->names; ?></td>
                           <td class="employee-payslip-company-logo" rowspan="3"></td>
                        </tr>
                        <tr class="employee-payslip-employee-row">
                           <td class="employee-payslip-employee-info">
                              <div><label>Name :</label> <?php echo $person->names; ?></div>
                              <div><label>Department :</label> <?php if($person->department != ""): ?><?php echo Hr::department($person->department)->title; ?><?php endif; ?></div>
                              <div><label>Branch :</label> <?php if($person->department != ""): ?><?php echo Hr::department($person->department)->title; ?><?php endif; ?></div>
                              <div><label>Position :</label> <?php if($person->department != ""): ?><?php echo Hr::position($person->position)->name; ?><?php endif; ?></div>
                              <div><label>Pay Period :</label> <?php echo date('F jS Y', strtotime($person->payroll_date)); ?></div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <ul class="employee-payslip__body">
                     <li class="net-income"><div>Net Income</div>
                        <div class="right"><span class="price"><span class="currency-symbol"><?php echo $currency->symbol; ?></span><?php echo number_format($person->net_pay); ?></span></div>
                     </li>
                     <li class="earning first">
                        <div class="name">Earning</div>
                        <div class="right">Amount</div>
                     </li>
                     <li class="earning desc">
                        <div class="name">Salary</div>
                        <div class="right"><span class="price"><span class="currency-symbol"><?php echo $currency->symbol; ?></span><?php echo number_format($person->salary); ?></span></div>
                     </li>
                     <li class="earning total desc">
                        <div class="name">Total</div>
                        <div class="right"><span class="price"><span class="currency-symbol"><?php echo $currency->symbol; ?></span><?php echo number_format($person->salary); ?></span></div>
                     </li>

                     <?php if($check_deductions > 0): ?>
                        <li class="deduction first">
                           <div class="name">Deduction</div>
                           <div class="right">Amount</div>
                        </li>
                        <?php $__currentLoopData = $deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <li class="deduction desc">
                              <div class="name"><?php echo $deduction->item; ?></div>
                              <div class="right"><span class="price"><span class="currency-symbol"><?php echo $currency->symbol; ?></span><?php echo number_format($deduction->amount); ?></span></div>
                           </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li class="deduction total desc">
                           <div class="name">Total</div><div class="right"><span class="price"><span class="currency-symbol"><?php echo $currency->symbol; ?></span><?php echo number_format($deductions->sum('amount')); ?></span></div>
                        </li>
                     <?php endif; ?>

                     <?php if($check_benefits > 0): ?>
                           <li class="employer-contribution first">
                              <div class="name">Deduction</div>
                              <div class="right">Amount</div>
                           </li>
                        <?php $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <li class="employer-contribution desc">
                              <div class="name"><?php echo $benefit->item; ?></div>
                              <div class="right"><span class="price"><span class="currency-symbol"><?php echo $currency->symbol; ?></span><?php echo number_format($benefit->amount); ?></span></div>
                           </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li class="employer-contribution total desc">
                           <div class="name">Total</div>
                           <div class="right">
                              <span class="price"><span class="currency-symbol"><?php echo $currency->symbol; ?></span><?php echo number_format($benefits->sum('amount')); ?></span>
                           </div>
                        </li>
                     <?php endif; ?>
                  </ul>
               </div>
            </div>
         </div>
      </div>
	</div>
   <!-- Modal -->
   <div class="modal fade" id="mpesaPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <form class="modal-content" method="post" action="<?php echo route('hrm.payroll.mpesa.payment'); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Make Payment with Mpesa</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button> 
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Employee</label>
                  <input type="text" class="form-control" value="<?php echo $person->names; ?>" readonly>
               </div>
               <div class="form-group">
                  <label for="">Phone Number</label>
                  <input type="text" class="form-control" name="phone_number" value="<?php echo $person->personal_number; ?>" placeholder="format 2547xxxxxxxx" required>
               </div>
               <div class="form-group">
                  <label for="">Amount</label>
                  <input type="text" name="amount" class="form-control" value="<?php echo $person->balance; ?>" required>
                  <input type="hidden" class="form-control" name="businessID" value="<?php echo Wingu::business()->businessID; ?>">
                  <input type="hidden" class="form-control" value="<?php echo $person->payrollID; ?>" name="payrollID">
                  <input type="hidden" class="form-control" value="<?php echo $person->payroll_code; ?>" name="payroll_code">
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-success btn-sm submit"><i class="fa fa-save"></i> Submit Payment</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="45%">
               </center>
            </div>
         </form>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/payroll/payslip.blade.php ENDPATH**/ ?>