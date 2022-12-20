<?php $__env->startSection('title','Salary information'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.employee.index'); ?>">Employee</a></li>
         <li class="breadcrumb-item active">Salary</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-money-check-alt"></i> Salary & Bank Information</h1>
      <!-- end page-header -->
		<div class="row">
        	<!-- employee side -->
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col-md-9">
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	        	<!-- employee side -->
	    		<?php echo Form::model($edit, ['route' => ['hrm.employee.salary.update', $edit->salaryID], 'method'=>'post','autocomplete' => 'off']); ?>

	    			<?php echo e(csrf_field()); ?>

		         <div class="panel panel-default">
						<div class="panel-heading">
                     <div class="panel-title"><?php echo $employee->names; ?> - Salary & Bank Information</div>
                     <input type="hidden" value="<?php echo $employee->id; ?>" name="employeeID" required>
						</div>
						<div class="panel-body">
							<div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('type', 'Payment basis', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::select('payment_basis', ['' => 'Choose basis','Monthly' => 'Monthly','Bi-weekly' => 'Bi-weekly','Daily' => 'Daily'], null, array('class' => 'form-control multiselect', )); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('Salary amount', 'Salary amount', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::text('salary_amount', null, array('class' => 'form-control', 'placeholder' => 'Enter Salary Amount')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('payment_method', 'Payment Method', array('class'=>'control-label text-danger')); ?>

                              <select class="form-control multiselect" name="payment_method" id="paymentMethod" required>
                                 <?php if($edit->payment_method != ""): ?>
                                    <?php if(Finance::check_account_payment_method($edit->payment_method) == 1): ?>
                                       <option value="<?php echo $edit->payment_method; ?>"><?php echo Finance::account_payment_method($edit->payment_method)->name; ?></option>
                                    <?php endif; ?>
                                    <?php if(Finance::check_system_payment($edit->payment_method) == 1): ?>
                                       <option value="<?php echo $edit->payment_method; ?>"><?php echo Finance::system_payment($edit->payment_method)->name; ?></option>
                                    <?php endif; ?>
                                 <?php else: ?>
                                    <option value="">Choose payment method</option>
                                 <?php endif; ?>
                                 <?php $__currentLoopData = $mainPaymentType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $main->id; ?>"><?php echo $main->name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $payment->id; ?>"><?php echo $payment->name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                        </div>
                        <?php if($edit->payment_method == 4 || $edit->payment_method == 2): ?>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('account_number', 'BanK Account Number', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('account_number', null, array('class' => 'form-control', 'placeholder' => 'BanK Account Number')); ?>

                              </div>
                           </div>
                        <?php endif; ?>
                        <?php if($edit->payment_method == 4 || $edit->payment_method == 2): ?>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('bank_name', 'BanK Name', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('bank_name', null, array('class' => 'form-control', 'placeholder' => 'BanK Name')); ?>

                              </div>
                           </div>
                        <?php endif; ?>
                        <?php if($edit->payment_method == 4 || $edit->payment_method == 2): ?>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('bank_branch', 'BanK Branch', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('bank_branch', null, array('class' => 'form-control', 'placeholder' => 'BanK Branch')); ?>

                              </div>
                           </div>
                        <?php endif; ?>
                        <?php if($edit->payment_method == 3): ?>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('mpesa_number', 'Mpesa number', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('mpesa_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Mpesa Number')); ?>

                              </div>
                           </div>
                        <?php endif; ?>
                        <div class="col-md-12 mt-3">
                           <div class="form-group">
                              <center>
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information</button>
                                 <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                              </center>
                           </div>
                        </div>
                     </div>
						</div>
					</div>
		      <?php echo Form::close(); ?>

			</div>
      </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script>
      $(document).ready(function() {
         $('#paymentMethod').on('change', function() {
            if(this.value == 4 || this.value == 2) {
               $('.bank').show();
            } else {
               $('.bank').hide();
            }

            if (this.value == 3) {
               $('.mpesa').show();
            } else {
               $('.mpesa').hide();
            }
         });
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/salary.blade.php ENDPATH**/ ?>