<?php $__env->startSection('title','Statement Of Account'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.report'); ?>">Report</a></li>
         <li class="breadcrumb-item active">Statement of account</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Statement Of Account </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">View Statement</h4>
            </div>
            <div class="panel-body">
               <form action="<?php echo route('finance.report.account.statement.process'); ?>" method="post" autocomplete="off">
                  <?php echo csrf_field(); ?>
                  <input autocomplete="false" name="hidden" type="text" style="display:none;">
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'Choose Client', array('class'=>'control-label')); ?>

                     <select name="client" class="form-control multiselect">
                        <option value="">Choose Customer</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $client->id; ?>"><?php echo $client->customer_name; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'From Date', array('class'=>'control-label')); ?>

                     <?php echo e(Form::text('from_date', null, ['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'yyyy-mm-dd'])); ?>

                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'To Date', array('class'=>'control-label')); ?>

                     <?php echo e(Form::text('to_date', null, ['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'yyyy-mm-dd'])); ?>

                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'Transaction type', array('class'=>'control-label')); ?>

                     <?php echo e(Form::select('transaction_type',['All'=>'All Transactions','Credit'=>'Credit','Debit'=>'Debit'], null, ['class' => 'form-control multiselect', 'required' => ''])); ?>

                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit">View statement</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/reports/account_statement/index.blade.php ENDPATH**/ ?>