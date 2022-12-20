<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('title'); ?> <?php echo $tenant->tenant_name; ?> | Tenant <?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="row">
      <?php echo $__env->make('app.property.property.tenants._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
      <?php if(request()->route()->getName() == 'property.tenant.lease.show'): ?>
         <?php echo $__env->make('app.property.property.tenants.leases.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?> 
      
      <?php if(request()->route()->getName() == 'property.tenant.lease.edit'): ?>
         <?php echo $__env->make('app.property.property.tenants.leases.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?> 
      <?php if(request()->route()->getName() == 'tenants.notes'): ?>
         <?php echo $__env->make('app.property.property.tenants.notes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>  
      <?php if(request()->route()->getName() == 'tenants.invoice.index'): ?>
         <?php echo $__env->make('app.property.property.tenants.invoices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>  
	</div> 
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo url('/'); ?>/public/app/plugins/ckeditor/4/standard/ckeditor.js"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/view.blade.php ENDPATH**/ ?>