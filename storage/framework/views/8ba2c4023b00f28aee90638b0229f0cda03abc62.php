<?php $__env->startSection('title','Salary Deduction'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Home</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('hrm.employee.index'); ?>">Employee</a></li>
			<li class="breadcrumb-item active">Salary Deduction</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fas fa-minus"></i> Salary Deduction </h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			<?php echo $__env->make('app.hr.partials._hr_employee_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
               <div class="col-md-12">
                  <a href="#add-deduction" data-toggle="modal" class="float-right btn btn-pink btn-sm mb-2"><i class="fas fa-plus"></i> Add Deduction</a>
               </div>
            </div>
            <div class="card">
               <div class="card-header">
                  <?php echo $employee->names; ?> - Deductions
               </div>
               <div class="card-body">
                  <div class="row">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <tr>
                           <th width="1%">#</th>
                           <th>Dedaction</th>
                           <th>Rate (% of salary)</th>
                           <th>Amount</th>
                           <th width="10%">Action</th>
                        </tr>
                        <tbody>
                           <?php $__currentLoopData = $allocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td><?php echo $count++; ?></td>
                                 <td><?php echo $all->title; ?></td>
                                 <td><?php echo $all->rate; ?>%</td>
                                 <td>
                                    <?php echo number_format($all->amount); ?>

                                    <?php if(Wingu::business()->base_currency != ""): ?>
                                    <?php echo Finance::currency(Wingu::business()->base_currency)->code; ?>

                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <a href="<?php echo route('hrm.employee.deductions.delete.allocate',$all->deductID); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Remove</a>
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
   </div>
   <div class="modal fade" id="add-deduction" tabindex="-1" role="dialog">
      <div class="modal-dialog">
         <?php echo Form::open(array('route' => 'hrm.employee.deductions.allocate','method' =>'post','autocomplete'=>'off')); ?>

            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add Deduction</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <?php echo csrf_field(); ?>
                  <div class="form-group form-group-default required">
                     <?php echo Form::label('names', 'Choose deduction', array('class'=>'control-label')); ?>

                     <?php echo Form::select('deduction', $deductions, null, array('class' => 'form-control', 'required' => '')); ?>

                     <input type="hidden" name="employeeID" value="<?php echo $employee->id; ?>" required>
                  </div>
                  <div class="form-group form-group-default required">
                     <?php echo Form::label('names', 'Choose deduction value type', array('class'=>'control-label')); ?>

                     <?php echo Form::select('type', ['' => 'Choose','Amount' => 'Amount','Percentage' => 'Percentage'], null, array('class' => 'form-control', 'required' => '', 'id' => 'type')); ?>

                  </div>
                  <div class="form-group form-group-default" id="rate" style="display:none">
                     <?php echo Form::label('names', 'Deduction rate in %', array('class'=>'control-label')); ?>

                     <?php echo Form::text('rate',null, array('class' => 'form-control', 'placeholder' => 'Enter deduction in %')); ?>

                  </div>
                  <div class="form-group form-group-default" id="amount" style="display:none">
                     <?php echo Form::label('names', 'Deduction Amount', array('class'=>'control-label')); ?>

                     <?php echo Form::text('amount',null, array('class' => 'form-control', 'placeholder' => 'Enter deduction in amount')); ?>

                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Deduction</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
               </div>
            </div>
         <?php echo Form::close(); ?>

      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
      $(document).ready(function() {
         $('#type').on('change', function() {
            if (this.value == 'Amount') {
               $('#amount').show();
               $('#rate').hide();
            }

            if(this.value == 'Percentage') {
               $('#rate').show();
               $('#amount').hide();
            }
         });
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/deductions.blade.php ENDPATH**/ ?>