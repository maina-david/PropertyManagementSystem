<?php $__env->startSection('title'); ?> <?php echo $lead->customer_name; ?> | Lead Details <?php $__env->stopSection(); ?>




<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <div class="row">
         
         <div class="col-md-12">
            <div class="row mb-3">
               <div class="col-md-6"><h3><?php echo $lead->customer_name; ?></h3></div>
               <div class="col-md-6">
                  <div class="float-right">
                     <a href="<?php echo route('crm.leads.edit',$customerID); ?>" class="btn btn-primary"><i class="fas fa-phone-volume"></i> Edit</a>
                     <a href="<?php echo route('crm.leads.send',$customerID); ?>" class="btn btn-white"><i class="fas fa-paper-plane"></i> Send Email</a>
                     <?php if($lead->category != ""): ?>
                        <a href="<?php echo route('crm.leads.convert',$customerID); ?>" class="btn btn-success delete"> Convert to customer</a>
                     <?php endif; ?>
                     <a href="<?php echo route('crm.leads.delete', $customerID); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                  </div>
               </div>
            </div>
            <?php echo $__env->make('app.crm.leads._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/show')): ?>
               <?php echo $__env->make('app.crm.leads.view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/calllog')): ?>
               <?php echo $__env->make('app.crm.leads.calllog.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/notes')): ?>
               <?php echo $__env->make('app.crm.leads.notes.notes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/tasks')): ?>
               <?php echo $__env->make('app.crm.leads.tasks.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/events')): ?>
               <?php echo $__env->make('app.crm.leads.events.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/mail')): ?>
               <?php echo $__env->make('app.crm.leads.mail.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/send')): ?>
               <?php echo $__env->make('app.crm.leads.mail.send', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(Request::route()->getName() == 'crm.leads.details'): ?>
               <?php echo $__env->make('app.crm.leads.mail.details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/sms')): ?>
               <?php echo $__env->make('app.crm.leads.sms.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$customerID.'/documents')): ?>
               <?php echo $__env->make('app.crm.leads.documents.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/leads/show.blade.php ENDPATH**/ ?>