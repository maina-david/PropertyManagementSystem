<div class="col-md-12 mb-3">
   <ul class="nav nav-pills pull-right">
      <li class="nav-item">
         <a class="nav-link <?php echo Nav::isRoute('property.show'); ?>" href="<?php echo route('property.show', $propertyID); ?>"><i class="fal fa-info-circle"></i> Overview</a>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('property.tenants'); ?>">
         <a class="nav-link <?php echo Nav::isRoute('property.tenants'); ?>" href="<?php echo route('property.tenants', $propertyID); ?>"><i class="fal fa-users"></i> Tenants</a>
      </li>
      <?php if($property->property_type == 13 or $property->property_type == 14): ?>
         <li class="nav-item dropdown <?php echo Nav::isResource('units'); ?>">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-car-building"></i> Units</a>
            <div class="dropdown-menu">
               <a class="dropdown-item <?php echo Nav::isRoute('property.units'); ?>" href="<?php echo route('property.units', $propertyID); ?>">All Units</a>
               <a class="dropdown-item <?php echo Nav::isRoute('property.units.create'); ?>" href="<?php echo route('property.units.create', $propertyID); ?>">Add Units</a>
               <a class="dropdown-item <?php echo Nav::isRoute('property.units.bulk.create'); ?>" href="<?php echo route('property.units.bulk.create', $propertyID); ?>">Add Bulk Units</a>
               <a class="dropdown-item <?php echo Nav::isRoute('property.vacant'); ?>" href="<?php echo route('property.vacant', $propertyID); ?>">Vacant Units</a>
               <a class="dropdown-item <?php echo Nav::isRoute('property.occupied'); ?>" href="<?php echo route('property.occupied', $propertyID); ?>">Occupied Units</a>
            </div>
         </li>
      <?php endif; ?>
      <li class="nav-item dropdown <?php echo Nav::isResource('leases'); ?>">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-file-contract"></i> Leases</a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo route('property.leases',$propertyID); ?>">All Lease</a>
            <a class="dropdown-item" href="<?php echo route('property.leases',$propertyID); ?>">Active Leases</a>
            <?php if($property->property_type == 13 or $property->property_type == 14): ?>
               <a class="dropdown-item" href="<?php echo route('property.leases.create',$propertyID); ?>">Add Lease</a>
            <?php else: ?>
               <?php if($property->leaseID == ""): ?>
                  <a class="dropdown-item" href="<?php echo route('property.leases.create',$propertyID); ?>">Add Lease</a>
               <?php endif; ?>
            <?php endif; ?>
         </div>
      </li>
      <li class="nav-item dropdown <?php echo Nav::isResource('invoices'); ?> <?php echo Nav::isRoute('property.payments'); ?> <?php echo Nav::isRoute('property.payments.create'); ?> <?php echo Nav::isRoute('property.payments.edit'); ?> <?php echo Nav::isRoute('property.payments.show'); ?> <?php echo Nav::isRoute('property.expense'); ?> <?php echo Nav::isRoute('property.expense.create'); ?> <?php echo Nav::isRoute('property.expense.edit'); ?> <?php echo Nav::isResource('creditnote'); ?> <?php echo Nav::isResource('utility'); ?>">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-usd-circle"></i> Accounting</a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo route('property.invoice.index',$propertyID); ?>">Rent Billing</a>
            <a class="dropdown-item" href="<?php echo route('property.utility.billing.index',$propertyID); ?>">Utility Billing</a>
            <a class="dropdown-item <?php echo Nav::isResource('creditnote'); ?>" href="<?php echo route('property.creditnote.index',$propertyID); ?>">
               Credit Note
            </a>
            <a class="dropdown-item <?php echo Nav::isRoute('property.payments'); ?>" href="<?php echo route('property.payments',$propertyID); ?>">
               Payments
            </a>
            <a class="dropdown-item  <?php echo Nav::isRoute('property.expense'); ?>" href="<?php echo route('property.expense',$propertyID); ?>"> Expenses</a>
         </div>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('property.documents'); ?>">
         <a class="nav-link" href="<?php echo route('property.documents',$propertyID); ?>"><i class="fal fa-folder"></i> Documents</a>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('property.images'); ?>">
         <a class="nav-link" href="<?php echo route('property.images',$propertyID); ?>"><i class="fal fa-images"></i> Images</a>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('property.edit'); ?>">
         <a class="nav-link" href="<?php echo route('property.edit',$propertyID); ?>"><i class="fal fa-edit"></i> Edit</a>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('property.reports'); ?>  <?php echo Nav::isResource('reports'); ?> ">
         <a class="nav-link" href="<?php echo route('property.reports',$propertyID); ?>"><i class="far fa-chart-pie"></i> Reports</a>
      </li>
      <li class="nav-item dropdown <?php echo Nav::isResource('settings'); ?>">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-tools"></i> Settings</a>
         <div class="dropdown-menu">
            <a class="dropdown-item <?php echo Nav::isRoute('property.invoice.settings'); ?>" href="<?php echo route('property.invoice.settings',$propertyID); ?>">Invoice</a>
            <a class="dropdown-item <?php echo Nav::isRoute('property.creditnote.settings'); ?>" href="<?php echo route('property.creditnote.settings',$propertyID); ?>">Credit Note</a>
            <a class="dropdown-item <?php echo Nav::isRoute('property.payment.integration.settings'); ?>" href="<?php echo route('property.payment.integration.settings',$propertyID); ?>">Payment details</a>
         </div>
      </li>
   </ul>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/partials/_property_menu.blade.php ENDPATH**/ ?>