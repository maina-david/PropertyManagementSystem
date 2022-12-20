<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Utility Billing | Compose Mail <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="#">Accounting</a></li>
         <li class="breadcrumb-item"><a href="#">Utility Billing</a></li>
         <li class="breadcrumb-item active"><a href="<?php echo route('property.utility.billing.show',[$propertyID,$invoice->invoiceID]); ?>"><?php echo $invoice->invoice_prefix.$invoice->invoice_number; ?></a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Utility Billing | Compose Mail </h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12">
            <div class="col-md-8">
               <div class="panel panel-inverse">
                  <div class="panel-body">
                     <form class="" action="<?php echo route('property.utility.send.mail',$propertyID); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="invoiceID" value="<?php echo $invoice->invoiceID; ?>" required>
                        <?php echo csrf_field(); ?>
                        <div class="form-group col-md-12">
                           <label for="">Form</label>
                           <input type="email" name="email_from" value="<?php echo $invoice->primary_email; ?>" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                           <label for="">Send To</label>
                           <input type="text" name="send_to" value="<?php echo $tenant->contact_email; ?>" class="form-control" required readonly>
                        </div>
                        <div class="form-group col-md-12">
                           <label for="">Cc</label>
                           <select name="email_cc[]" id="" class="form-control multiselect" style="width:100%" multiple>
                              <?php if($tenant->email_cc != ""): ?>
                                 <option value="<?php echo $tenant->email_cc; ?>"><?php echo $tenant->email_cc; ?></option>
                              <?php endif; ?>
                              <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $contact->contact_email; ?>"><?php echo $contact->contact_email; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                        <div class="form-group col-md-12">
                           <label for="">Subject</label>
                           <input type="text" name="subject" value="Invoice - <?php echo $invoice->prefix; ?><?php echo $invoice->invoice_number; ?> from <?php echo $invoice->business_name; ?>" class="form-control" required>
                        </div>
                        <div class="form-group col-md-12">
                           <textarea name="message" cols="30" rows="10" class="my-editor" required>
                              <span>Dear <?php echo $tenant->tenant_name; ?></span><br><br>
                              <span><em><b>Bill Payment.</b></em></span><br>
                              <span>Utility No <b>: <?php echo $invoice->utility_No; ?></b>.</span><br/>
                              <span>Previous Consumption <b>: <?php echo number_format($product->previous_units,2); ?></b>.</span><br/>
                              <span>Current Consumption <b>: <?php echo number_format($product->current_units,2); ?></b>.</span><br/>
                              <span>Consumption <b>: <?php echo number_format($product->current_units - $product->previous_units,2); ?></b>.</span><br/>
                              <span>Price Per Unit <b>: <?php echo $invoice->code; ?><?php echo $product->price; ?></b>.</span><br/>
                              <span>Bill Total <b>: <?php echo $invoice->code; ?><?php echo $invoice->bill_total; ?></b>.</span><br/>
                              <span>Amount Paid <b>: <?php echo $invoice->code; ?><?php echo $invoice->bill_paid; ?></b>.</span><br/>
                              <?php if($balance != 0): ?> 
                                 <span>Account Arrears <b>: <?php echo $invoice->code; ?> <?php echo number_format($balance,2); ?></b>.</span><br/>
                              <?php endif; ?>
                              -----------------------------------------------------------------------------------------------------------------------<br>
                              <span style="font-size: 12pt;">Please contact us for more information.</span><br /><br />
                              <span style="font-size: 12pt;">Kind Regards,</span><br />
                              <span style="font-size: 12pt;"><?php echo $invoice->business_name; ?></span>
                           </textarea>
                        </div>
                        <div class="form-group mt-3">
                           <input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-2" checked>
                           <label for="">Attach Invoice</label><br>
                           <a href="<?php echo asset('businesses/'.$invoice->businessID.'/property/'.$property->property_code.'/utility/'.$invoice->invoice_prefix.$invoice->invoice_number.'.pdf'); ?>" target="_blank" class="ml-3" id="preview"> Preview current Attached Invoice</a>
                        </div>
                        <div class="form-group col-md-12" style="display:none">
                           <label for="">Attach Files</label>
                           <select name="attach_files[]" class="form-control multiselect" style="width:100%" multiple>
                              <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $file->id; ?>"><?php echo $file->file_name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                        <div class="form-group mt-5">
                           <button type="submit" name="button" class="btn btn-success submit"><i class="fas fa-save"></i> Send Invoice</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>    
      </div> 
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script2'); ?>
   <script type="text/javascript">
      $('#attach').click(function(){
         this.checked?$('#preview').show(1000):$('#preview').hide(1000); //time for show
      });
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/utility/compose_mail.blade.php ENDPATH**/ ?>