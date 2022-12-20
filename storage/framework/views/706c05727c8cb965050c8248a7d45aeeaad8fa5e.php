<?php $__env->startSection('title'); ?>Mail To <?php echo $details->customer_name; ?> <?php $__env->stopSection(); ?> 

<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('finance.payments.show',$details->invoicePaymentID); ?>" class="btn btn-pink"><i class="fas fa-chevron-left"></i> Back to view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Mail To <?php echo $details->customer_name; ?></h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="" action="<?php echo route('finance.payments.send'); ?>" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="paymentID" value="<?php echo $details->invoicePaymentID; ?>" required>
                     <?php echo csrf_field(); ?>
                     <div class="form-group col-md-12">
   							<label for="">Form</label>
   							<input type="email" name="email_from" value="<?php echo $details->primary_email; ?>" class="form-control">
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Send To</label>
                        <input type="text" name="send_to" value="<?php echo $details->email; ?>" class="form-control" required readonly>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Cc</label>
                        <select name="email_cc[]" id="" class="form-control multiselect" style="width:100%" multiple>
                           <?php if($details->email_cc != ""): ?>
   								   <option value="<?php echo $details->email_cc; ?>"><?php echo $details->email_cc; ?></option>
                           <?php endif; ?>
   								<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   									<option value="<?php echo $contact->contact_email; ?>"><?php echo $contact->contact_email; ?></option>
   								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   							</select>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Subject</label>
   							<input type="text" name="subject" value="Payment Received by <?php echo $details->businessName; ?>" class="form-control" required>
   						</div>
   						<div class="form-group col-md-12">
   							<textarea name="message" cols="30" rows="10" class="ckeditor" required>
   								<h2><strong>Payment Received</strong></h2>
                           <p>Dear <?php echo $details->customer_name; ?>,<br/><br/>
                           Thank you for your payment. It was a pleasure doing business with you. We look forward to working together again!</p>
                           <div style="background:#fefff1; border:1px solid #e8deb5; padding:3%">
                              <h3>Payment Received</h3>
                              <h2><?php echo $details->code; ?> <?php echo number_format($details->amount); ?></h2>
                              <p>Invoice No : <strong><?php echo $details->prefix; ?><?php echo $details->invoice_number; ?></strong></p>
                              <p>&nbsp;</p>
                              <p>Payment Date<strong><?php echo date('jS F, Y', strtotime($details->payment_date)); ?></strong></p>
                           </div>
   							</textarea>
   						</div>
   						<div class="form-group mt-3">
   							<input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-2" checked>
   							<label for="">Attach Receipt</label><br>
                        <a href="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/'.$details->invoicePaymentID.'payment.pdf'); ?>" target="_blank" class="ml-3" id="preview"> Preview current Attached Receipt</a>
   						</div>
                     <div class="form-group mt-5">
                        <button type="submit" name="button" class="offset-md-10 btn btn-pink submit"><i class="fas fa-paper-plane"></i> Send Receipt</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      $('#attach').click(function(){
         this.checked?$('#preview').show(1000):$('#preview').hide(1000); //time for show
      });
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/payments/mail.blade.php ENDPATH**/ ?>