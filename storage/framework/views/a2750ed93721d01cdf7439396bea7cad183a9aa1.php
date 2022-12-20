<?php $__env->startSection('title','Add Account'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Bank & Cash</a></li>
         <li class="breadcrumb-item active">Add Account</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-piggy-bank"></i> Bank & Cash</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <form action="<?php echo route('finance.account.store'); ?>" method="post" class="row">
         <?php echo csrf_field(); ?>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Add Account</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'Account Title*', array('class'=>'control-label')); ?>

                     <?php echo e(Form::text('title', null, ['class' => 'form-control', 'required' => '','placeholder' => 'Enter title'])); ?>

                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'Initial Balance', array('class'=>'control-label')); ?>

                     <?php echo e(Form::number('initial_balance', null, ['class' => 'form-control','placeholder' => 'Enter balance'])); ?>

                  </div>
                  <div class="form-group form-group-default ">
                     <?php echo Form::label('title', 'Account Number', array('class'=>'control-label')); ?>

                     <?php echo e(Form::text('account_number', null, ['class' => 'form-control','placeholder' => 'Enter account number'])); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <?php echo Form::label('title', 'Contact Person', array('class'=>'control-label')); ?>

                     <?php echo e(Form::text('contact_person', null, ['class' => 'form-control','placeholder' => 'Enter contact person'])); ?>

                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Add Account</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <?php echo Form::label('title', 'Description', array('class'=>'control-label')); ?>

                     <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'size' => '5x6' ])); ?>

                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'Phone Number', array('class'=>'control-label')); ?>

                     <?php echo e(Form::text('phone_number', null, ['class' => 'form-control','placeholder' => 'Enter phone number'])); ?>

                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('title', 'Internet Banking URL', array('class'=>'control-label')); ?>

                     <?php echo e(Form::text('banking_url', null, ['class' => 'form-control','placeholder' => 'Enter url'])); ?>

                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <center>
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Account</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
            </center>
         </div>
      </form>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/accounts/create.blade.php ENDPATH**/ ?>