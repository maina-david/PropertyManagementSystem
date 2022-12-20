<?php $__env->startSection('title','Mail Quote'); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('finance.quotes.show',$quote->quoteID); ?>" class="btn btn-pink"><i class="fas fa-chevron-left"></i> Back to view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Mail Quote To <?php echo $client->customer_name; ?></h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="" action="<?php echo route('finance.quotes.mail.send'); ?>" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="quoteID" value="<?php echo $quote->quoteID; ?>" required>
                     <?php echo csrf_field(); ?>
                     <div class="form-group col-md-12">
                        <label for="">Form</label>
                        <input type="email" name="email_from" value="<?php echo $quote->primary_email; ?>" class="form-control">
                     </div>
                     <div class="form-group col-md-12">
                        <label for="">Send To</label>
                        <input type="text" name="send_to" value="<?php echo $client->email; ?>" class="form-control" required readonly>
                     </div>
                     <div class="form-group col-md-12">
                        <label for="">Cc</label>
                        <select name="email_cc[]" id="" class="form-control multiselect" style="width:100%" multiple>
                           <?php if($client->email_cc != ""): ?>
                              <option value="<?php echo $client->email_cc; ?>"><?php echo $client->email_cc; ?></option>
                           <?php endif; ?>
                           <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo $contact->contact_email; ?>"><?php echo $contact->contact_email; ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                     </div>
                     <div class="form-group col-md-12">
                        <label for="">Subject</label>
                        <input type="text" name="subject" value="<?php echo $quote->businessName; ?> Quote - <?php echo $quote->prefix; ?><?php echo $quote->quote_number; ?>  Has been sent to you" class="form-control" required>
                     </div>
                     <div class="form-group col-md-12">
                        <textarea name="message" cols="30" rows="10" class="ckeditor" required>
                           <span style="font-size: 17pt;">Dear <b><?php echo $client->customer_name; ?></b></span>
                           <br/><br/>
                           <span style="font-size: 12pt;">Please find the attached Quote <strong># <?php echo $quote->prefix; ?><?php echo $quote->quote_number; ?></strong></span>
                           <br/><br/>
                           
                           
                           <span style="font-size: 12pt;">We look forward to your communication.</span>
                           <br/><br/>
                           <span style="font-size: 12pt;">Kind Regards,</span>
                           <br/><br/>
                           <span style="font-size: 12pt;">
                              <b>
                                 <?php echo $quote->businessName; ?>

                              </b>
                           </span>
                        </textarea>
                     </div>
                     <div class="form-group mt-3">
                        <input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-3" checked>
                        <label for="">Attach PDF Quote</label><br>
                        <a href="<?php echo asset('businesses/'.$quote->business_code.'/finance/quotes/'.$quote->prefix.$quote->quote_number); ?>.pdf" target="_blank" class="ml-3"> Preview current Attached Quote</a>
                     </div>
                     <div class="form-group col-md-12">
                        <label for="">Attach Files</label>
                        <select name="attach_files[]" class="form-control multiselect" style="width:100%" multiple>
                           <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo $file->id; ?>"><?php echo $file->file_name; ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                     </div>
                     <div class="form-group mt-5">
                        <center>
                           <button type="submit" name="button" class="btn btn-pink submit"><i class="fas fa-paper-plane"></i> Send Quote</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                        </center>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/quotes/mail.blade.php ENDPATH**/ ?>