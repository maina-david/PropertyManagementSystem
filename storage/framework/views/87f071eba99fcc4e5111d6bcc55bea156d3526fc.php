<?php $__env->startSection('title'); ?><?php echo $property->title; ?> | Billing | Rental Invoices <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.invoice.index',$property->propertyID); ?>">Billing</a></li>
         <li class="breadcrumb-item active"><a href="<?php echo route('property.invoice.index',$property->propertyID); ?>">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | Billing | Rental Invoices</h1>
      
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12 mt-2">
            <?php if($property->property_type == 13 or $property->property_type == 14): ?>
               <a class="btn btn-primary" href="<?php echo route('property.invoice.create.bulk',$property->propertyID); ?>"><i class="fal fa-copy"></i> Bulk Billing</a>
            <?php endif; ?>
            <a class="btn btn-warning" href="<?php echo route('property.invoice.create',$property->propertyID); ?>"><i class="fal fa-file-invoice-dollar"></i> Single Billing</a>
         </div>
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('property.accounting.invoices.index',['propertyID' => $property->propertyID, 'property' => $property])->html();
} elseif ($_instance->childHasBeenRendered('ezIxj0P')) {
    $componentId = $_instance->getRenderedChildComponentId('ezIxj0P');
    $componentTag = $_instance->getRenderedChildComponentTagName('ezIxj0P');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ezIxj0P');
} else {
    $response = \Livewire\Livewire::mount('property.accounting.invoices.index',['propertyID' => $property->propertyID, 'property' => $property]);
    $html = $response->html();
    $_instance->logRenderedChild('ezIxj0P', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>         
      </div> 
   </div>  
<?php $__env->stopSection(); ?>

 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/invoices/index.blade.php ENDPATH**/ ?>