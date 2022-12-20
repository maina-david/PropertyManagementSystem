<?php $__env->startSection('title','Edit Expense'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('finance.expense.index'); ?>">Expenses</a></li>
			<li class="breadcrumb-item active">Edit</li>
		</ol>
      <h1 class="page-header"><i class="fal fa-money-check-alt"></i> Update Expenses </h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::model($expense, ['route' => ['finance.expense.update',$expense->id], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Expense Details</h4>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Account', 'Account', array('class'=>'control-label')); ?>

                              <?php echo e(Form::select('account', $bankAccounts, null, ['class' => 'form-control multiselect', 'autocomplete' => 'off'])); ?>

                           </div>
                        </div>
                     </div>				
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Date', 'Date', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::text('date', null, array('class' => 'form-control datepicker', 'placeholder' => 'YYYY-MM-DD', 'required' =>'', 'autocomplete' => 'off' )); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Expense Title', 'Expense Title', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'', 'autocomplete' => 'off' )); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Expense Category', 'Expense Category', array('class'=>'control-label text-danger')); ?>

                        <?php echo e(Form::select('expense_category', $category, null, ['class' => 'form-control multiselect', 'data-init-plugin' => 'select2','placeholder' => 'Expense Category','required' =>''])); ?>

                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default required" aria-required="true">
                              <?php echo Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::text('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )); ?>

                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Choose Tax Rate', 'Chosse Tax Rate', array('class'=>'control-label')); ?>

                              <?php echo e(Form::select('tax_rate',$tax, null, ['class' => 'form-control multiselect'])); ?>

                           </div>
                        </div>
                     </div>
                     <div class="form-group form-group-default">
                        <?php echo Form::label('Supplier', 'Supplier', array('class'=>'control-label')); ?>

                        <?php echo Form::select('supplierID',$suppliers,null,['class' => 'form-control multiselect']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Expense Details</h4>
                  </div>
                  <div class="panel-body">
                        <div class="form-group form-group-default">
                        <?php echo Form::label('Reference', 'Reference (i.e Payment Code)', array('class'=>'control-label')); ?>

                        <?php echo Form::text('refrence_number', null, array('class' => 'form-control', 'placeholder' => 'Reference')); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Choose expense status', 'Choose expense status', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('statusID', [''=>'Choose expense status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ])); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="" class="text-danger">Method Of Payment <a href="" class="pull-right" data-toggle="modal" data-target="#addpayment">Add Payment Method</a></label>
                        <select name="payment_method" class="form-control multiselect">
                           <?php if($expense->payment_method != ""): ?>
                              <option value="<?php echo $expense->payment_method; ?>">
                                 <?php if(Finance::check_default_payment_method($expense->payment_method) == 1): ?>
                                    <?php echo Finance::default_payment_method($expense->payment_method)->name; ?>

                                 <?php else: ?> 
                                    <?php if(Finance::check_payment_method($expense->payment_method) == 1): ?>
                                       <?php echo Finance::payment_method($expense->payment_method)->name; ?>

                                    <?php endif; ?>
                                 <?php endif; ?>
                              </option>
                           <?php else: ?>
                              <option value="">Choose payment method</option>
                           <?php endif; ?>
                           <?php $__currentLoopData = $defaultPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo $pm->id; ?>"><?php echo $pm->name; ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php $__currentLoopData = $accountPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo $accayment->id; ?>"><?php echo $accayment->name; ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                     </div>
                     <h4 class="mt-4">Files</h4>
                     <div class="form-group form-group-default">
                        <?php echo Form::label('Expense Files', 'Expense Files', array('class'=>'control-label')); ?>

                        <input type="file" name="files[]"  id="files" multiple>
                     </div>
                     <div class="row mt-4">
                        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="col-md-2">
                              <?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
                              <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/'.$file->file_name); ?>" alt="" style="width:100%;height:80px">
                              <?php elseif(stripos($file->file_mime, 'pdf') !== FALSE): ?>
                                 <center><i class="fas fa-file-pdf fa-4x" style="width:100%;height:80px"></i></center>
                              <?php elseif(stripos($file->file_mime, 'octet-stream') !== FALSE): ?>
                                 <center><i class="fas fa-file-alt fa-4x" style="width:100%;height:80px"></i></center>
                              <?php elseif(stripos($file->file_mime, 'officedocument') !== FALSE): ?>
                                 <center><i class="fas fa-file-word fa-4x" style="width:100%;height:80px"></i></center>
                              <?php else: ?>
                                 <center><i class="fas fa-file fa-4x" style="width:100%;height:80px"></i></center>
                              <?php endif; ?>
                              <center>
                                 <?php if (app('laratrust')->isAbleTo('update-expense')) : ?>
                                 <a href="<?php echo route('finance.expense.file.delete', $file->id); ?>" title="delete" class="label label-danger"><i class="fas fa-trash"></i></a>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <a href="<?php echo route('finance.expense.file.download', $file->id); ?>" title="download" class="label label-primary mt-1"><i class="fas fa-download"></i></a>
                                 <a href="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/'.$file->file_name); ?>" title="view" class="label label-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
                              </center>
                           </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Description</h4>
                  </div>
                  <div class="panel-body">
                     <div class="form-group">
                        <?php echo Form::textarea('description',null,['class'=>'form-control ckeditor', 'rows' => 9, 'placeholder'=>'content']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <center>
                  <button class="btn btn-pink submit" type="submit"><i class="fas fa-save"></i> Update Expense</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
               </center>
            </div>
         </div>
      <?php echo e(Form::close()); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app.finance.payments.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
<script type="text/javascript">
   CKEDITOR.replaceClass="ckeditor";
</script>
<?php echo $__env->make('app.partials._express_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/expense/expense/edit.blade.php ENDPATH**/ ?>