<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Edit Payments <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.show',$property->id); ?>"><?php echo $property->title; ?></a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.payments',$property->id); ?>">Payments</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | Edit Payments</h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12 mt-3">   
            <?php echo Form::model($payment, ['route' => ['property.payments.update',[$property->id,$payment->paymentID]], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

               <div class="row">
                  <div class="col-md-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4 class="panel-title">Payment Details</h4>
                        </div>
                        <div class="panel-body">
                           <div class="form-group form-group-default">
                              <label class="text-danger">Tenant</label>
                              <input type="text" class="form-control"  value="<?php echo $payment->tenant_name; ?>" readonly>
                              <input type="hidden" value="<?php echo $property->id; ?>" name="propertyID" required>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="form-group form-group-default">
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
                              
                              
                           </div>
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Payment Date', 'Payment Date', array('class'=>'control-label')); ?>

                              <?php echo Form::date('payment_date', null, array('class' => 'form-control')); ?>

                           </div>
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')); ?>

                              <select name="payment_method" class="form-control multiselect">
                                 <?php if(Finance::check_payment_method($payment->payment_method) == 1): ?>
                                    <option value="<?php echo $payment->payment_method; ?>"><?php echo Finance::payment_method($payment->payment_method)->name; ?></option>
                                 <?php else: ?> 
                                    <option value="">Choose payment method</option>
                                 <?php endif; ?>
                                 <?php $__currentLoopData = $mainMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $main->id; ?>"><?php echo $main->name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php $__currentLoopData = $paymentmethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $method->id; ?>"><?php echo $method->name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select> 
                           </div>
                           <div class="form-group form-group-default">
                              <label class="text-danger">Invoice Number</label>
                              <input type="text" class="form-control" value="<?php echo $invoice->invoice_prefix; ?><?php echo $invoice->invoice_number; ?>" readonly>
                           </div>
                           <div class="form-group form-group-default">
                              <label>Reference Number</label>
                              <?php echo Form::text('reference_number', null, array('class' => 'form-control', 'placeholder' => 'Reference Number')); ?>

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
                           <div class="form-group">
                              <label>Upload Payment Documents</label><br>
                              <input type="file" name="files[]" multiple>
                           </div>
                           <div class="form-group mt-4">
                              <?php echo Form::label('Notes (Internal use. Not visible to customer)', 'Notes (Internal use. Not visible to customer)', array('class'=>'control-label')); ?>

                              <?php echo Form::textarea('note',null,['class'=>'form-control my-editor', 'rows' => 9, 'placeholder'=>'content']); ?>

                           </div>
                           
                           <div class="row">
                              <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <div class="col-md-2">
                                    <?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
                                       <img src="<?php echo asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/payments/'.$file->file_name); ?>" alt="" style="width:100%;height:80px">
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
                                       <a href="<?php echo route('property.payments.delete.file',[$property->id,$file->id,$payment->paymentID]); ?>" title="delete" class="delete badge badge-danger badge-sm"><i class="fas fa-trash"></i></a>
                                       <a href="<?php echo asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/payments/'.$file->file_name); ?>" title="download" class="badge badge-primary badge-sm mt-1"><i class="fas fa-download"></i></a>
                                       <a href="<?php echo asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/payments/'.$file->file_name); ?>" title="view" class="badge badge-sm badge-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
                                    </center>
                                 </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="btn-toolbar col-md-12">
                     <button type="submit" id="" class="btn btn-success submit"><i class="fas fa-save"></i> Update Payment</button>
                     <img src="<?php echo url('/'); ?>/public/app/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
                  </div>
               </div>
            <?php echo e(Form::close()); ?>

         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      $('#client_select').on('change',function(e){
         console.log(e);
         var tenantID =  e.target.value;
         var url = "<?php echo e(url('/')); ?>"
         var propertyID = "<?php echo e($property->id); ?>"
         var prefix = "<?php echo $invoiceSetting->prefix; ?>"
         var code = "<?php echo $business->code; ?>"
         //ajax
         $.get(url+'/property/'+propertyID+'/invoice/'+tenantID, function(data){
            //success data
            $('#invoice_no').empty();
            $.each(data, function(invoices, info){
               $('#invoice_no').append('<option value="'+ info.id +'">'+info.invoice_prefix+''+info.invoice_number+' | '+code+''+info.balance+' | '+info.invoice_title+'</option>');
            });
         });
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/payments/edit.blade.php ENDPATH**/ ?>