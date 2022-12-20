<div class="col-md-3">
   <div class="card">
      <div class="card-body text-center">
         <?php if($lead->image == ""): ?>
            <img alt="<?php echo $lead->names; ?>" src="<?php echo "https://www.gravatar.com/avatar/". md5(strtolower(trim($lead->email))) . "?s=200&d=wavatar"; ?>" class="img-circle" width="80" height="80">
         <?php else: ?>
            <img width="150" height="150" alt="" class="img-circle" src="<?php echo url('/'); ?>/storage/files/business/<?php echo $lead->primary_email; ?>/clients/<?php echo $lead->customer_code; ?>/images/<?php echo $lead->image; ?>">
         <?php endif; ?>
         <h4 class="mb-1 mt-2"><?php echo $lead->customer_name; ?></h4>
         <p class="text-muted">
            <i class="fas fa-at"></i> <?php echo $lead->email; ?><br>
            <i class="fas fa-phone"></i>
            <?php echo $lead->phone_number; ?>


         </p>
         <a href="<?php echo route('crm.customers.edit',$leadID); ?>" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fas fa-user-edit"></i> Edit</a>
         <a href="<?php echo route('crm.leads.mail',$lead->id); ?>" class="btn btn-pink btn-xs waves-effect mb-2 waves-light"><i class="fas fa-paper-plane"></i> Send Mail</a>
      </div>
   </div>
   <div class="panel panel-default" data-sortable-id="ui-widget-1">
      <div class="panel-heading ui-sortable-handle">
         <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
         </div>
         <h4 class="panel-title"><i class="fas fa-info-circle"></i> Lead Information </h4>
      </div>
      <div class="panel-body">
         <p>
            <?php if($lead->company_name != ""): ?>
               <b>Full Names :</b> <?php echo $lead->salutation; ?> <?php echo $lead->lead_name; ?> <br>
            <?php endif; ?>
            <?php if($lead->email != ""): ?>
               <b>Contact email :</b> <?php echo $lead->email; ?> <br>
            <?php endif; ?>
            <?php if($lead->position != ""): ?>
               <b>Position :</b> <?php echo $lead->position; ?> <br>
            <?php endif; ?>
            <?php if($lead->phone_number != ""): ?>
               <b>Phone number :</b>
               <?php if($lead->phone_code != ""): ?>
                  +<?php echo Wingu::country($lead->phone_code)->phonecode; ?>

               <?php endif; ?>
               <?php echo $lead->phone_number; ?><br>
            <?php endif; ?>
         <p>
      </div>
   </div>
   <div class="panel panel-default" data-sortable-id="ui-widget-1">
      <div class="panel-heading ui-sortable-handle">
         <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
         </div>
         <h4 class="panel-title"><i class="fas fa-building"></i> Business Information </h4>
      </div>
      <div class="panel-body">
         <p>
            <?php if($lead->company_name != ""): ?>
               <b>Company :</b> <?php echo $lead->company_name; ?> <br>
            <?php endif; ?>
            <?php if($lead->company_name != ""): ?>
               <b>Industry :</b> <?php echo $lead->company_name; ?> <br>
            <?php endif; ?>
            <?php if($lead->website != ""): ?>
               <b>Website :</b> <?php echo $lead->website; ?> <br>
            <?php endif; ?>
            <?php if($lead->country != ""): ?>
               <b>Country :</b> <?php echo Wingu::country($lead->country)->name; ?> <br>
            <?php endif; ?>
            <?php if($lead->city != ""): ?>
               <b>Town/City :</b> <?php echo $lead->city; ?> <br>
            <?php endif; ?>
            <?php if($lead->state != ""): ?>
               <b>State :</b> <?php echo $lead->state; ?> <br>
            <?php endif; ?>
            <?php if($lead->location != ""): ?>
               <b>Location :</b> <?php echo $lead->location; ?> <br>
            <?php endif; ?>
            <?php if($lead->postal_address != ""): ?>
               <b>Postal address :</b> <?php echo $lead->postal_address; ?>-<?php echo $lead->zip_code; ?> <br>
            <?php endif; ?>
         <p>
      </div>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/leads/_sidebar.blade.php ENDPATH**/ ?>