<div class="row mt-3">
   <div class="col-md-12">
      <!-- begin widget-chat -->
      <div class="widget-chat widget-chat-rounded">
         <!-- begin widget-chat-header -->
         <div class="widget-chat-header">
            <div class="widget-chat-header-icon">
               <?php if($client->image == ""): ?>
                  <img src="https://ui-avatars.com/api/?name=<?php echo $client->customer_name; ?>&rounded=true&size=32" alt="">
               <?php else: ?>
               <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$client->customer_code.'/images/'.$client->image); ?>" alt="" style="width:40px;height:40px" class="rounded-circle">
               <?php endif; ?>
            </div>
            <div class="widget-chat-header-content">
               <h4 class="widget-chat-header-title"><?php echo $client->customer_name; ?></h4>
               <p class="widget-chat-header-desc"><?php echo $client->primary_phone_number; ?></p>
            </div>
         </div>
         <!-- end widget-chat-header -->
         
         <!-- begin widget-chat-body -->
         <div class="widget-chat-body" data-scrollbar="true" data-height="535px">
            
            
               
            <?php $__currentLoopData = $smses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="widget-chat-item right">
                  <div class="widget-chat-info">
                     <div class="widget-chat-info-container">
                        <div class="widget-chat-message"><?php echo $sms->message; ?></div><br>
                        <div class="widget-chat-time"><?php echo date("F jS, Y @ h:i:sa", strtotime($sms->created_at)); ?></div>
                     </div>
                  </div>
               </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>            
         </div>
         <!-- end widget-chat-body -->
         
         <!-- begin widget-input -->
         <div class="widget-input widget-input-rounded">
            <form action="<?php echo route('finance.customer.sms.send'); ?>" method="POST" class="row">
               <?php echo csrf_field(); ?>
               <div class="col-md-12">
                  <div class="form-group">
                     <textarea name="message" id="" cols="10" rows="5" class="form-control" placeholder="Type message.........." maxlength="255" required></textarea>                     
                  </div>
                  <div class="form-group">
                     <label for="">
                        Phone number 
                        <span data-toggle="tooltip" data-placement="top" title="If you need to change the phone number you can change it on the lead edit section. Make sure the number starts with the country code">
                           <i class="fas fa-info-circle"></i>
                        </span>
                     </label>
                     <input type="text" name="to" class="form-control" value="<?php echo $client->primary_phone_number; ?>" readonly>
                     <input type="hidden" name="customerID" value="<?php echo $customerID; ?>" readonly>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group mb-3">
                           <?php if(Wingu::business()->telephonyID != ""): ?>
                           <button class="btn btn-primary pull-right submit"><i class="fal fa-paper-plane"></i> Send sms </button>
                           <?php else: ?> 
                           <spam class="badge badge-warning">You need to integrate your account with an sms sending platform in the settings section</spam>
                           <?php endif; ?>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none pull-right" alt="" width="15%">
                        </div>
                     </div>
                  </div>                  
               </div>               
            </form>
         </div>
         <!-- end widget-input -->
      </div>
      <!-- end widget-chat -->
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/contacts/sms.blade.php ENDPATH**/ ?>