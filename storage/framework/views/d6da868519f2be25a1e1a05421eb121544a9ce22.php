<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Property Details <?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('content'); ?>
   <div class="row">
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php if(request()->route()->getName() == 'property.rental.billing.edit'): ?>
         <?php echo $__env->make('app.property.accounting.invoices.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>

      
      <?php if(request()->route()->getName() == 'property.invoice.index'): ?>
         <?php echo $__env->make('app.property.accounting.invoices.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?> 
      <?php if(request()->route()->getName() == 'property.invoice.create'): ?>
         <?php echo $__env->make('app.property.accounting.invoices.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>    
      <?php if(request()->route()->getName() == 'property.invoice.edit'): ?>
         <?php echo $__env->make('app.property.accounting.invoices.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'property.invoice.settings'): ?>
         <?php echo $__env->make('app.property.accounting.invoices.settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>  
      <?php if(request()->route()->getName() == 'property.invoice.create.bulk'): ?>
         <?php echo $__env->make('app.property.accounting.invoices.bulk', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
      <?php endif; ?>   
      
      <?php if(request()->route()->getName() == 'property.mpesaapi.integration'): ?>
         <?php echo $__env->make('app.property.property.integration.payments.mpesaapi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>  
      <?php if(request()->route()->getName() == 'property.mpesatill.integration'): ?>
         <?php echo $__env->make('app.property.property.integration.payments.mpesatill', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>   
      <?php if(request()->route()->getName() == 'property.mpesapaybill.integration'): ?>
         <?php echo $__env->make('app.property.property.integration.payments.paybill', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?> 
      <?php if(request()->route()->getName() == 'property.bank1.integration'): ?>
         <?php echo $__env->make('app.property.property.integration.payments.bank1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'property.bank2.integration'): ?>
         <?php echo $__env->make('app.property.property.integration.payments.bank2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'property.bank3.integration'): ?>
         <?php echo $__env->make('app.property.property.integration.payments.bank3', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'property.bank4.integration'): ?> 
         <?php echo $__env->make('app.property.property.integration.payments.bank4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'property.bank5.integration'): ?>
         <?php echo $__env->make('app.property.property.integration.payments.bank5', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?> 
      <?php if(request()->route()->getName() == 'property.images'): ?>
         <?php echo $__env->make('app.property.property.images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>   
      <?php if(request()->route()->getName() == 'property.tenants.create'): ?>
         <?php echo $__env->make('app.property.tenants.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
      <?php endif; ?> 
      
      <?php if(request()->route()->getName() == 'property.leases'): ?>
         <?php echo $__env->make('app.property.property.lease.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
      <?php endif; ?> 
      <?php if(request()->route()->getName() == 'property.leases.create'): ?>
         <?php echo $__env->make('app.property.property.lease.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
      <?php endif; ?> 
   </div> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/show.blade.php ENDPATH**/ ?>