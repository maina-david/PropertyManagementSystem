<div class="row mt-3">
   <div class="card">
      <div class="card-body">
         <ul class="mail_list list-group list-unstyled">
            <?php $__currentLoopData = $mails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <li class="list-group-item">
                  <div class="media">
                     <div class="pull-left"> 
                        <div class="thumb"> 
                           <?php if($client->image != ""): ?>
                              <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$client->customer_code.'/images/'.$client->image); ?>" alt="" style="width:50px;height:50px" class="rounded-circle">
                           <?php else: ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo $client->customer_name; ?>&rounded=true&size=50 alt="">
                           <?php endif; ?>
                        </div>
                     </div>
                     <div class="media-body">
                        <div class="media-heading">
                           <a href="<?php echo route('finance.customer.mail.details',[$mail->id,$customerID]); ?>" class="m-r-10"><?php echo $mail->names; ?></a>
                           <?php if($mail->status == "Sent"): ?>
                              <span class="badge bg-green">Sent</span>
                           <?php else: ?> 
                           <span class="badge bg-orange">Draft</span>
                           <?php endif; ?>
                           <small class="float-right text-muted">
                              <time class="hidden-sm-down" datetime="2020"><?php echo date('F d, Y @ h:i:s A', strtotime($mail->created_at)); ?></time>
                              <i class="fal fa-paperclip"></i>
                           </small>
                        </div>
                        <p class="msg"><?php echo $mail->subject; ?><br><span class="text-pink">View Date : <?php echo date('F jS, Y',strtotime($mail->date_view)); ?></span> | <span class="text-info">View Count : <?php echo $mail->view_count; ?></span></p>
                     </div>
                  </div>
               </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                        
        </ul>
      </div>
   </div>
</div>
<div class="row mt-2">
   <div class="col-md-12">
      <?php if($mails->lastPage() > 1): ?>
         <nav aria-label="...">
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="<?php echo e($mails->url(1)); ?>">Previous</a>
               </li>
               <?php for($i = 1; $i <= $mails->lastPage(); $i++): ?>
                  <li class="page-item <?php echo e(($mails->currentPage() == $i) ? 'active' : ''); ?>">
                     <a class="page-link" href="<?php echo e($mails->url($i)); ?>">
                           <?php echo e($i); ?>

                        <span class="sr-only">(current)</span>
                     </a>
                  </li>
               <?php endfor; ?>
               <li class="page-item">
                  <a class="page-link" href="<?php echo e($mails->url($mails->currentPage()+1)); ?>">Next</a>
               </li>
            </ul>
         </nav>
      <?php endif; ?>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/contacts/mail/index.blade.php ENDPATH**/ ?>