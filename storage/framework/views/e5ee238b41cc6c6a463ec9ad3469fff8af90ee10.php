 

<?php $__env->startSection('title'); ?> Tenants List <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb --> 
   <ol class="breadcrumb pull-right">
      
      <a href="<?php echo route('tenants.create'); ?>" class="btn btn-pink mr-2"><i class="fal fa-plus-circle"></i> Add Tenant</a>    
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-users"></i> Tenants - List</h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('property.tenants.index')->html();
} elseif ($_instance->childHasBeenRendered('f8GYcx3')) {
    $componentId = $_instance->getRenderedChildComponentId('f8GYcx3');
    $componentTag = $_instance->getRenderedChildComponentTagName('f8GYcx3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('f8GYcx3');
} else {
    $response = \Livewire\Livewire::mount('property.tenants.index');
    $html = $response->html();
    $_instance->logRenderedChild('f8GYcx3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/tenants/index.blade.php ENDPATH**/ ?>