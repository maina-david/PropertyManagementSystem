<ul class="nav nav-tabs">
   <li class="nav-item <?php echo Nav::isRoute('crm.customers.show'); ?>">
      <a class="nav-link <?php echo Nav::isRoute('crm.customers.show'); ?>" href="<?php echo route('crm.customers.show',$customerID); ?>"><i class="fal fa-info-circle"></i> Overview</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.comments')); ?>">
      <a href="<?php echo route('crm.customers.comments', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.comments')); ?>">
         <i class="fal fa-comments-alt"></i> Comments
      </a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.invoices')); ?>">
      <a href="<?php echo route('crm.customers.invoices', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.invoices')); ?>"><i class="fal fa-file-invoice-dollar"></i> invoices</span></a>
   </li>
   <?php if(Wingu::business()->plan != 1): ?>
      <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.quotes')); ?>">
         <a href="<?php echo route('crm.customers.quotes', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.quotes')); ?>"><i class="fal fa-file-invoice"></i> Quote</a>
      </li>
      <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.creditnotes')); ?>">
         <a href="<?php echo route('crm.customers.creditnotes', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.creditnotes')); ?>"><i class="fal fa-file-alt"></i> Credits</a>
      </li>
   <?php endif; ?>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.projects')); ?>">
      <a href="<?php echo route('crm.customers.projects', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.projects')); ?>"><i class="fal fa-tasks"></i> Projects</a>
   </li>
   <?php if(Wingu::business()->plan != 1): ?>
      <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.statement')); ?> <?php echo e(Nav::isRoute('crm.customers.statement.mail')); ?>">
         <a href="<?php echo route('crm.customers.statement',$customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.statement.mail')); ?> <?php echo e(Nav::isRoute('crm.customers.statement.mail')); ?>"><i class="fal fa-receipt"></i> Statement</a>
      </li>
      <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.subscriptions')); ?>">
         <a href="<?php echo route('crm.customers.subscriptions',$customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.subscriptions')); ?>""><i class="fal fa-sync-alt"></i> Subscriptions</a>
      </li>
   <?php endif; ?>
</ul>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/customers/_nav.blade.php ENDPATH**/ ?>