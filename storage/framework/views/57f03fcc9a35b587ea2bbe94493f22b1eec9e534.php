<?php $__env->startSection('title','Update Payment'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('finance.payments.received'); ?>">Payments Received</a></li>
			<li class="breadcrumb-item active">Update Payments</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Update Payment</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo Form::model($payment, ['route' => ['finance.payments.update',$payment->paymentID], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Payment Details</h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<?php echo Form::label('Customer Name', 'Customer Name', array('class'=>'control-label')); ?>

								<select class="form-group form-control multiselect" id="client_select" name="customer" required="">
									<option value="<?php echo $payment->customerID; ?>"><?php echo $payment->customer_name; ?></option>
									<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($cli->id); ?>"><?php echo $cli->customer_name; ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default required">
										<?php echo Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')); ?>

										<?php echo Form::text('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('Bank Charges (if any)', 'Bank Charges (if any)', array('class'=>'control-label')); ?>

										<?php echo Form::text('bank_charges', null, array('class' => 'form-control', 'placeholder' => 'Bank Charges (if any)')); ?>

									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group form-group-default">
										<label for="account" class="control-label"> Choose Deposit Account </label>
										<?php echo Form::select('accountID',$accounts, null, array('class' => 'form-control multiselect')); ?>

									</div>
								</div>
							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Payment Date', 'Payment Date', array('class'=>'control-label')); ?>

								<?php echo Form::date('payment_date', null, array('class' => 'form-control','required' =>'' )); ?>

							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')); ?>

								<select name="payment_method" class="form-control multiselect">
									<?php if($payment->payment_method == "" || $payment->payment_method == 0): ?>
										<option value="">Choose Method of payment</option>  
									<?php else: ?>
										<option  value="<?php echo $payment->payment_method; ?>">
											<?php if(Finance::check_default_payment_method($payment->payment_method) == 1): ?>
												<?php echo Finance::default_payment_method($payment->payment_method)->name; ?>

											<?php else: ?> 
												<?php if(Finance::check_payment_method($payment->payment_method) == 1): ?>
													<?php echo Finance::payment_method($payment->payment_method)->name; ?>

												<?php endif; ?>
											<?php endif; ?>
										</option>
									<?php endif; ?>                     
									<?php $__currentLoopData = $defaultPaymentMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $defaultmethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo $defaultmethod->id; ?>"><?php echo $defaultmethod->name; ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php $__currentLoopData = $paymentmethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo $method->id; ?>"><?php echo $method->name; ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
							<div class="form-group form-group-default required">
								<label>Invoice Number</label>
								<select class="form-control full-width" data-init-plugin="select2" id="invoice_no" name="invoice" required="">
									<option value="<?php echo $invoice->id; ?>"><?php if($invoice->invoice_prefix == ""): ?><?php echo $settings->prefix; ?><?php else: ?><?php echo $invoice->invoice_prefix; ?><?php endif; ?><?php echo $invoice->invoice_number; ?> | <?php echo $payment->code; ?><?php echo $invoice->balance; ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Payment Details</h4>
						</div>
						<div class="panel-body">
							
							<div class="form-group form-group-default">
								<label>Payment Reference Number</label>
								<?php echo Form::text('reference_number', null, array('class' => 'form-control', 'placeholder' => 'Payment Reference Number')); ?>

							</div>
							<div class="form-group">
								<?php echo Form::label('Notes (Internal use. Not visible to customer)', 'Notes (Internal use. Not visible to customer)', array('class'=>'control-label')); ?>

								<?php echo Form::textarea('note',null,['class'=>'form-control ckeditor', 'rows' => 10, 'placeholder'=>'content']); ?>

							</div>
							
							<div class="row">
                        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="col-md-2">
										<?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
											<img src="<?php echo asset('businesses/'.$payment->businessID.'/finance/payments/'.$file->file_name); ?>" alt="" style="width:100%;height:80px">
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
											<a href="<?php echo route('finance.payment.file.delete', $file->id); ?>" title="delete" class="label label-danger"><i class="fas fa-trash"></i></a>
											<a href="<?php echo route('finance.payment.file.download', $file->id); ?>" title="download" class="label label-primary mt-1"><i class="fas fa-download"></i></a>
											<a href="<?php echo asset('businesses/'.$payment->businessID.'finance/payments'.$file->file_name); ?>" title="view" class="label label-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
										</center>
									</div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<button type="submit" id="" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Payment</button>
					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
				</div>
			</div>
		<?php echo e(Form::close()); ?>

	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		$('#client_select').on('change',function(e){
			console.log(e);
			var client_id =  e.target.value;
			var url = "<?php echo e(url('/')); ?>"
			var code = "<?php echo $settings->code; ?>"
			var prefix = "<?php echo $settings->prefix; ?>"
			//ajax
			$.get(url+'/finance/retrive_client/'+client_id, function(data){
				//success data
				//
				$('#invoice_no').empty();
				$.each(data, function(invoices, info){
					$('#invoice_no').append('<option value="'+ info.id +'">'+prefix+''+info.invoice_number+' | '+code+''+info.balance+'</option>');
				});
			});
		});
	</script>
	<script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/payments/edit.blade.php ENDPATH**/ ?>