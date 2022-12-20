<?php $__env->startSection('title'); ?>  <?php echo $property->title; ?> | Credit Notes | Details <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

 
<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
      <li class="breadcrumb-item"><a href="j<?php echo route('property.creditnote.index',$property->id); ?>">Credit Notes</a></li>
      <li class="breadcrumb-item active"><a href="<?php echo route('property.creditnote.show',[$property->id,$show->creditnoteID]); ?>">Details</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Credit Notes | Details </h1>
   <div class="row">
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12"> 
         <div class="row mb-3">
            <span class="col-md-12">
               <?php if($show->paymentID == ""): ?>
                  <?php if (app('laratrust')->isAbleTo('update-invoice')) : ?>
                     <a href="<?php echo route('property.invoice.edit',[$property->id,$show->creditnoteID]); ?>" class="btn btn-sm btn-primary m-b-10 p-l-5">
                        <i class="fas fa-edit"></i> Edit
                     </a>
                  <?php endif; // app('laratrust')->permission ?> 
               <?php endif; ?>
               <?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
                  <a href="<?php echo route('property.invoice.print',[$property->id,$show->creditnoteID]); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                     <i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
                  </a>
               <?php endif; // app('laratrust')->permission ?>
               <?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
                  <a href="<?php echo route('property.invoice.print',[$property->id,$show->creditnoteID]); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                     <i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
                  </a>
               <?php endif; // app('laratrust')->permission ?>
               <a href="#" class="btn btn-sm btn-warning m-b-10 p-l-5">
                  <i class="fal fa-paper-plane"></i> Mail Invoice
               </a>
               <?php if (app('laratrust')->isAbleTo('create-creditnote')) : ?>
                  <?php if($checkOpenInvoices >= 1): ?>
                     <a href="#" data-toggle="modal" data-target="#apply-to-invoice" class="btn btn-sm btn-white m-b-10 p-l-5">
                        Apply To Invoice
                     </a>
                  <?php endif; ?>
               <?php endif; // app('laratrust')->permission ?>
               <a href="<?php echo route('property.invoice.delete',[$property->id,$show->creditnoteID]); ?>" class="btn btn-sm btn-danger delete m-b-10 p-l-5">
                  <i class="fas fa-trash"></i> Delete
               </a>
            </span>
         </div>
      </div>
      <div class="col-md-12">
         <div class="panel panel-inverse">
            <div class="panel-body">
               <?php echo $__env->make('templates.'.$template.'.creditnote.property.preview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
         </div>
      </div>
   </div> 
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app.property.partials._creditnote_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/creditnote/show.blade.php ENDPATH**/ ?>