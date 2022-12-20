<?php $__env->startSection('title','Add Payments'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('finance.payments.received'); ?>">Payments Received</a></li>
      <li class="breadcrumb-item active">Add Payments</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-cash-register"></i> Add Payment</h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php echo Form::open(array('route' => 'finance.payments.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')); ?>

      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Payment Details</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group form-group-default required">
                     <label>Customer Name</label>
                     <select class="form-group form-control multiselect" id="client_select" name="customer" required="">
                        <option value="">Choose Customer</option>
                        <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo e($cli->id); ?>"><?php echo $cli->customer_name; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )); ?>

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
                           <label for="accountID" class="control-label"> Choose Deposit Account</label>
                           <?php echo Form::select('accountID',$accounts, null, array('class' => 'form-control multiselect')); ?>

                        </div>
                     </div>
                  </div>
                  <div class="form-group form-group-default">
                     <?php echo Form::label('Payment Date', 'Payment Date', array('class'=>'control-label')); ?>

                     <?php echo Form::date('payment_date', null, array('class' => 'form-control')); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <?php echo Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')); ?>

                     <select name="payment_method" class="form-control multiselect">
                        <option value="">Choose Method of payment</option>                       
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
                     <select class="form-control multiselect" id="invoice_no" name="invoice" required="">

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
                     <label>Transaction ID</label>
                     <?php echo Form::text('reference_number', null, array('class' => 'form-control', 'placeholder' => 'Transaction ID')); ?>

                  </div>
                  
                  <div class="form-group mt-4">
                     <?php echo Form::label('Notes (Internal use. Not visible to customer)', 'Notes (Internal use. Not visible to customer)', array('class'=>'control-label')); ?>

                     <?php echo Form::textarea('note',null,['class'=>'form-control ckeditor', 'rows' => 9, 'placeholder'=>'content']); ?>

                  </div>
                  
               </div>
            </div>
         </div>
         <div class="btn-toolbar col-md-12">
            <button type="submit" id="" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Payment</button>
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
               $('#invoice_no').append('<option value="'+ info.id +'">'+prefix+''+info.invoice_number+' | '+code+''+info.balance+' | '+info.invoice_title+'</option>');
            });
         });
      });
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/payments/create.blade.php ENDPATH**/ ?>