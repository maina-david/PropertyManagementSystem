<ul class="nav nav-tabs">
    <li class="<?php echo e(Request::is('crm/contact/'.$contact->id.'/view') ? 'active' : ''); ?>"><a href="<?php echo e(url('crm/contact/'.$contact->id.'/view')); ?>">Description</a></li>
    <?php if($contact->contact_type == 'Organization'): ?>
    	<li class="<?php echo e(Request::is('crm/contact/'.$contact->id.'/contact-persons') ? 'active' : ''); ?>"><a href="<?php echo e(url('crm/contact/'.$contact->id.'/contact-persons')); ?>">Contact persons</a></li>
    <?php endif; ?>    
    <li class="<?php echo e(Request::is('crm/contact/'.$contact->id.'/notes') ? 'active' : ''); ?>"><a href="<?php echo e(url('crm/contact/'.$contact->id.'/notes')); ?>">Notes</a></li>
</ul><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/partials/_contact_menu.blade.php ENDPATH**/ ?>