<ul class="nav nav-tabs">
   <li class="nav-item <?php echo Nav::isRoute('finance.contact.show'); ?>">
      <a class="nav-link <?php echo Nav::isRoute('finance.contact.show'); ?>" href="<?php echo route('finance.contact.show',$customerID); ?>"><i class="fal fa-info-circle"></i> Overview</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('finance.customers.comments')); ?>">  
      <a href="<?php echo route('finance.customers.comments', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('finance.customers.comments')); ?>">
         <i class="fal fa-comments-alt"></i> Comments
      </a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('finance.customers.invoices')); ?>">
      <a href="<?php echo route('finance.customers.invoices', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('finance.customers.invoices')); ?>"><i class="fal fa-file-invoice-dollar"></i> invoices</span></a>
   </li>
   <?php if(Wingu::business()->plan != 1): ?>
      <li class="nav-item <?php echo e(Nav::isRoute('finance.customers.quotes')); ?>">
         <a href="<?php echo route('finance.customers.quotes', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('finance.customers.quotes')); ?>"><i class="fal fa-file-invoice"></i> Quote</a>
      </li>
      <li class="nav-item <?php echo e(Nav::isRoute('finance.customers.creditnotes')); ?>">
         <a href="<?php echo route('finance.customers.creditnotes', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('finance.customers.creditnotes')); ?>"><i class="fal fa-file-alt"></i> Credits</a>
      </li>
   <?php endif; ?>
   <li class="nav-item <?php echo e(Nav::isRoute('finance.customers.projects')); ?>">
      <a href="<?php echo route('finance.customers.projects', $customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('finance.customers.projects')); ?>"><i class="fal fa-tasks"></i> Projects</a>
   </li>
   <?php if(Wingu::business()->plan != 1): ?>
      <li class="nav-item <?php echo e(Nav::isRoute('finance.customers.statement')); ?> <?php echo e(Nav::isRoute('finance.customers.statement')); ?>">
         <a href="<?php echo route('finance.customers.statement',$customerID); ?>" class="nav-link <?php echo e(Nav::isRoute('finance.customers.statement')); ?> <?php echo e(Nav::isRoute('finance.customers.statement')); ?>"><i class="fal fa-receipt"></i> Statement</a>
      </li>
      
   <?php endif; ?> 
</ul><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/contacts/_nav.blade.php ENDPATH**/ ?>