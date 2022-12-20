<?php $__env->startSection('title','Review Payroll'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human resource</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Payroll</a></li>
         <li class="breadcrumb-item active">Review Payroll</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> Review & Confirm</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <form action="<?php echo route('hrm.payroll.process.run'); ?>" method="post" enctype="multipart/form-data" class="row">
         <?php echo csrf_field(); ?>
         <div class="col-md-12">
            <div class="card">
	            <div class="card-body">
						<div class="col-md-12">
							<h3><b>Date:</b> <?php echo date('F jS, Y', strtotime($payroll_date)); ?></h3>
							<h3><b>Type:</b> <?php echo $type; ?></h3>
							<h3><b>Branch:</b> <?php echo $branch; ?></h3>
						</div>
	               <div class="col-md-12">
	                  <!-- begin panel -->
	                  <table class="table table-striped table-bordered">
	                     <thead>
	                        <th width="1%">#</th>
	                        <th class="text-left" style="width: 20%;">Employee</th>
	                        <th>Basic salary</th>
	                        
	                        <th>Gross pay</th>
	                        <th>Deductions</th>
	                        <th>Net pay</th>
	                        <th>Payment Type</th>
	                     </thead>
	                     <tbody>
	                        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                           <tr>
	                              <td><?php echo $count++; ?></td>
	                              <td>
	                                 <div class="row">
	                                    <?php if($result->avator != ""): ?>
	                                       <img class="rounded-circle" width="40" height="40" alt="" class="rounded-circle col-md-2" src="<?php echo asset('businesses/'.$result->business_code.'/hr/employee/images/'.$result->avator); ?>">
	                                    <?php else: ?>
	                                       <img src="https://ui-avatars.com/api/?name=<?php echo $result->employee_name; ?>&rounded=true&size=32" alt="">
	                                    <?php endif; ?>
	                                    <div class="col-md-10">
	                                       <a href="#"><?php echo $result->employee_name; ?></a> <br> 
														<?php if($result->position != ""): ?><?php echo Hr::position($result->position)->name; ?><?php endif; ?>
	                                    </div>
	                                 </div>
	                                 <input type="hidden" name="people_employeeID[]" value="<?php echo $result->empID; ?>" required>
	                              </td>
	                              <td>
	                                 <b>
	                                    <?php echo $result->symbol; ?><?php echo number_format($result->salary_amount); ?>	                                    
	                                    <input type="hidden" name="people_salary[]" value="<?php echo $result->salary_amount; ?>" required>
	                                 </b>
	                              </td>
	                              
	                              <td>
	                                 <b>
	                                    <?php echo $result->symbol; ?><?php echo number_format($result->total_additions + $result->salary_amount); ?>

	                                    <input type="hidden" value="<?php echo $result->total_additions + $result->salary_amount; ?>" name="people_gross_pay[]">
	                                 </b>
	                              </td>
	                              <td>
	                                 <b>
													<?php echo $result->symbol; ?><?php echo number_format($result->total_deductions); ?>

	                                    <input type="hidden" value="<?php echo $result->total_deductions; ?>" name="people_deduction[]">
	                                 </b>
	                              </td>
	                              <td>
	                                 <b>
	                                    <?php echo $result->symbol; ?><?php echo number_format(($result->salary_amount - $result->total_deductions) + $result->total_additions); ?>

	                                    <input type="hidden" value="<?php echo ($result->salary_amount - $result->total_deductions) + $result->total_additions; ?>" name="people_net_pay[]">
	                                 </b>
	                              </td>
	                              <td>
	                                 <?php echo $result->payment_basis; ?>

	                                 <input type="hidden" name="people_type[]" value="<?php echo $result->payment_basis; ?>">
	                              </td>
	                           </tr>
	                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                     </tbody>
	                     <tfoot>
	                        <th colspan="2" class="text-center">
	                           Grand total
	                           <input type="hidden" value="<?php echo $payroll_date; ?>" name="payroll_date" required>
										<input type="hidden" value="<?php echo $type; ?>" class="form-control"  name="type" required>
										<input type="hidden" value="<?php echo $branch; ?>" class="form-control"  name="branch" required>
	                        </th>
	                        <th>
	                           <?php echo number_format($results->sum('salary_amount')); ?>

	                           <input type="hidden" class="form-control" name="salary_amount" value="<?php echo $results->sum('salary_amount'); ?>" required>
	                        </th>
	                        
	                        <th>
	                           <?php echo number_format($results->sum('total_deductions') + $results->sum('total_additions') + $results->sum('salary_amount')); ?>

	                           <input type="hidden" class="form-control" name="gross_pay" value="<?php echo $results->sum('total_deductions') + $results->sum('total_additions') + $results->sum('salary_amount'); ?>">
	                        </th>
	                        <th>
	                           <?php echo number_format($results->sum('total_deductions')); ?>

	                           <input type="hidden" class="form-control" value="<?php echo $results->sum('total_deductions'); ?>" name="total_deductions">
	                        </th>
	                        <th>
	                           <?php echo number_format(($results->sum('salary_amount') - $results->sum('total_deductions')) + $results->sum('total_additions')); ?>

	                           <input type="hidden" class="form-control" name="net_pay" value="<?php echo ($results->sum('salary_amount') - $results->sum('total_deductions')) + $results->sum('total_additions'); ?>">
	                        </th>
	                        <th colspan="2"></th>
	                     </tfoot>
	                  </table>
	                  <!-- end panel -->
	               </div>
	               <div class="row">
	                  <div class="col-md-8"></div>
	                  <div class="col-md-4">
	                     <button type="submit" class="float-right btn btn-pink btn-block submit"><i class="fas fa-save"></i> Save and process payroll</button>
	                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="45%">
	                  </div>
	               </div>
	            </div>
	         </div>
         </div>
      </form>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/payroll/review.blade.php ENDPATH**/ ?>