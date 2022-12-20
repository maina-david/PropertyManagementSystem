<div class="col-md-12">
   <a href="<?php echo route('property.show',$propertyID); ?>" class="btn btn-warning float-left"><i class="fal fa-arrow-circle-left"></i> Back to property</a>
   <ul class="nav nav-pills pull-right">
      <li class="nav-item <?php echo Nav::isRoute('property.tenants.show'); ?>">
         <a class="nav-link <?php echo Nav::isRoute('property.show'); ?>" href="<?php echo route('property.tenants.show',[$propertyID,$tenantID]); ?>"><i class="fal fa-info-circle"></i> Overview</a>
      </li>
      <li class="nav-item <?php echo Nav::isResource('lease'); ?>">
         <a class="nav-link" href="<?php echo route('property.tenant.lease',[$propertyID,$tenantID]); ?>"><i class="fal fa-file-signature"></i> Leases</a>
      </li>
      <?php if($property->property_type == 13 || $property->property_type == 14): ?>
         <li class="nav-item <?php echo Nav::isResource('units'); ?>">
            <a class="nav-link" href="<?php echo route('tenants.units.index',[$propertyID,$tenantID]); ?>"><i class="fal fa-building"></i> Units</a> 
         </li>
      <?php endif; ?>
      
      
      
      
      
      
      
   </ul>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/_nav.blade.php ENDPATH**/ ?>