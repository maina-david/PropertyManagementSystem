<?php $__env->startSection('title','Expense Create'); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('finance.expense.index'); ?>">Expenses</a></li>
			<li class="breadcrumb-item active">Create</li>
		</ol>
		<h1 class="page-header"><i class="fal fa-money-check-alt"></i> Add Expenses </h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo Form::open(array('route' => 'finance.expense.store', 'enctype'=>'multipart/form-data', 'method' => 'post', 'autocomplete' => 'off')); ?>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Expenses Details</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default">
										<label for="">Bank or Cash Account <a href="" class="pull-right" data-toggle="modal" data-target="#bankandcash">Add Account</a></label>
										<select name="account" id="selectAccount" class="form-control select2"></select>
									</div>
								</div>
							</div>	
							<div class="form-group form-group-default">
								<label for="" class="text-danger">Category <a href="" class="pull-right" data-toggle="modal" data-target="#expenceCategory">Add category</a></label>
								<select name="expense_category" id="selectCategory" class="form-control select2" required></select>
							</div>
							<div class="form-group form-group-default required">
								<?php echo Form::label('Date', 'Date', array('class'=>'control-label text-danger')); ?>

								<?php echo Form::date('date', null, array('class' => 'form-control', 'required' =>'', 'autocomplete' => 'off')); ?>

							</div>
							<div class="form-group form-group-default required">
								<?php echo Form::label('Title', 'Title', array('class'=>'control-label text-danger')); ?>

								<?php echo Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'', 'autocomplete' => 'off' )); ?>

							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default required" aria-required="true">
										<?php echo Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')); ?>

										<?php echo Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'', 'autocomplete' => 'off' )); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<label for="">Chosse Tax Rate <a href="javascript()" class="pull-right" data-toggle="modal" data-target="#taxRate">Add Tax Rate</a></label>
										<select name="tax_rate" id="selectTax" class="form-control select2"></select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Expence Details</h4>
						</div>
						<div class="panel-body">
							<div class="form-group form-group-default">
								<label for="" class="">Supplier <a href="" class="pull-right" data-toggle="modal" data-target="#addSupplier">Add Supplier</a></label>
								<select name="supplier" id="selectSupplier" class="form-control select2"></select>
							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Reference', 'Reference (i.e Payment Code)', array('class'=>'control-label')); ?>

								<?php echo Form::text('refrence_number', null, array('class' => 'form-control', 'placeholder' => 'Reference')); ?>

							</div>
							<div class="form-group form-group-default required">
								<?php echo Form::label('Choose status', 'Choose status', array('class'=>'control-label text-danger')); ?>

								<?php echo e(Form::select('status', [''=>'Choose status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ])); ?>

							</div>
							<div class="form-group form-group-default">
								<label for="" class="text-danger">Method Of Payment</label>
								<select name="payment_method" class="form-control multiselect" required> 
									<option value="">Choose payment method</option>
									<?php $__currentLoopData = $defaultPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentmethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo $paymentmethod->name; ?>"><?php echo $paymentmethod->name; ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php $__currentLoopData = $accountPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo $accayment->name; ?>"><?php echo $accayment->name; ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Expence Files', 'Expense Files', array('class'=>'control-label')); ?><br>
								<input type="file" name="files[]" id="files" multiple>
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
						<button class="btn btn-pink" type="submit"><i class="fas fa-save"></i> Add Expense</button>		
						
					</center>
				</div>
			</div>
		<?php echo e(Form::close()); ?>

	</div>
	<?php echo $__env->make('app.finance.accounts.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
	<?php echo $__env->make('app.finance.expense.category.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('app.finance.taxes.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
	<?php echo $__env->make('app.finance.suppliers.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
	<?php echo $__env->make('app.partials._express_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/expense/expense/create.blade.php ENDPATH**/ ?>