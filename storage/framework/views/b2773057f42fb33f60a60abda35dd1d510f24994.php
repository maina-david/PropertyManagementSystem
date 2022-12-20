<ul class="nav nav-pills mb-4">
   <li class="nav-items <?php echo e(Nav::isRoute('pm.tenants.show')); ?>">
      <a href="<?php echo route('pm.property.tenants.show', $tenantID); ?>">
         <span class="d-sm-none"><i class="fas fa-chart-bar"></i> Overview</span>
         <span class="d-sm-block d-none"><i class="fas fa-chart-bar"></i> Overview</span>
      </a>
   </li>
   
   
   <li class="nav-items <?php echo e(Nav::isRoute('pm.tenants.comments')); ?>">
      <a href="<?php echo route('pm.tenants.comments', $tenantID); ?>">
         <span class="d-sm-none"><i class="fas fa-comment"></i> Comments</span>
         <span class="d-sm-block d-none"><i class="fas fa-comment"></i> Comments</span>
      </a>
   </li>
   <li class="nav-items <?php echo e(Nav::isRoute('pm.tenants.invoices')); ?>">
      <a href="<?php echo route('pm.tenants.invoices', $tenantID); ?>">
         <span class="d-sm-none"><i class="fas fa-file-invoice-dollar"></i> invoices</span>
         <span class="d-sm-block d-none"><i class="fas fa-file-invoice-dollar"></i> invoices</span>
      </a>
   </li>
   
   <li class="nav-items <?php echo e(Nav::isResource('statement')); ?>">
      <a href="<?php echo route('pm.tenants.statement',$tenantID); ?>">
         <span class="d-sm-none"><i class="fas fa-file-invoice"></i> Statements</span>
         <span class="d-sm-block d-none"><i class="fas fa-file-invoice"></i> Statements</span>
      </a>
   </li>
   
   
</ul>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/_hold.blade.php ENDPATH**/ ?>