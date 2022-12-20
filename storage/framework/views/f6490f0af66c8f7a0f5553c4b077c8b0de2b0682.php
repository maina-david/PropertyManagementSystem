<ul class="nav nav-tabs">
   <li class="nav-item <?php echo Nav::isRoute('crm.leads.show'); ?>">
      <a class="nav-link <?php echo Nav::isRoute('crm.leads.show'); ?>" href="<?php echo route('crm.leads.show',$customerID); ?>"><i class="fal fa-info-circle"></i> Overview</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isResource('events')); ?>">
      <a class="nav-link <?php echo e(Nav::isResource('events')); ?>" href="<?php echo route('crm.leads.events',$lead->id); ?>"><i class="fal fa-calendar-alt"></i>  Meetings</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.leads.calllog')); ?>">
      <a class="nav-link <?php echo e(Nav::isRoute('crm.leads.calllog')); ?>" href="<?php echo route('crm.leads.calllog',$lead->id); ?>"><i class="fal fa-phone-office"></i>  Call log</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isResource('tasks')); ?>">
      <a class="nav-link <?php echo e(Nav::isResource('tasks')); ?>" href="<?php echo route('crm.leads.tasks',$lead->id); ?>"><i class="fal fa-check-square"></i>  Tasks</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isResource('notes')); ?>">
      <a class="nav-link <?php echo e(Nav::isResource('notes')); ?>" href="<?php echo route('crm.leads.notes',$lead->id); ?>"><i class="fal fa-feather-alt"></i>  Notes</a>
   </li>
   
   <li class="nav-item <?php echo e(Nav::isResource('mail')); ?> <?php echo Nav::isRoute('crm.leads.send'); ?>">
      <a class="nav-link <?php echo e(Nav::isResource('mail')); ?> <?php echo Nav::isRoute('crm.leads.send'); ?>" href="<?php echo route('crm.leads.mail',$lead->id); ?>"><i class="fal fa-paper-plane"></i> Email</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isResource('documents')); ?>">
      <a class="nav-link <?php echo e(Nav::isResource('documents')); ?>" href="<?php echo route('crm.leads.documents',$lead->id); ?>"><i class="fal fa-folder"></i>  Documents</a>
   </li>
</ul><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/leads/_nav.blade.php ENDPATH**/ ?>