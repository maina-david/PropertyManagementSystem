<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Property Details <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('stylesheets'); ?>
   <style>
      .panel-body {
         min-height: 160px;
      }
      .panel-heading {
         min-height: 120px;
      }

      .bank-name {
         font-family: 'Quicksand', sans-serif;
         font-size: 60px;
      }
   </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Payments</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">integration</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Payment integration</h1>
	   <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	   <div class="col-md-12 mt-3">
	      <a href="#" class="btn btn-warning" data-toggle="modal" data-target=".gateway"> Add Payment integration</a>
	   </div>
	   <div class="col-md-12 mt-3">
	      <div class="row">
	         <?php $__currentLoopData = $intergrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	            <div class="col-md-4 col-sm-6 col-xs-12">
	               <div class="panel panel-default">
	                  <div class="panel-heading">
	                     <?php if($getway->gatewayID == 6 || $getway->gatewayID == 14 || $getway->gatewayID == 15 || $getway->gatewayID == 16 || $getway->gatewayID == 17): ?>
	                     <br>
	                        <h1 class="text-center bank-name">Bank info.</h1>
	                     <?php else: ?>
	                        <center>
	                           <img alt="<?php echo $getway->gateway_name; ?>" src="<?php echo asset('assets/img/gateways/'.$getway->logo); ?>" class="img-responsive payment-logo">
	                        </center>
	                     <?php endif; ?>
	                  </div>
	                  <div class="panel-body">
	                     
	                     <?php if($getway->gatewayID == 6 || $getway->gatewayID == 14 || $getway->gatewayID == 15 || $getway->gatewayID == 16 || $getway->gatewayID == 17): ?>
	                        <?php if($getway->bank_name != ""): ?>
	                           <h3 class="text-center"><?php echo $getway->bank_name; ?></h3>
	                        <?php else: ?>
	                           <h3 class="text-center">Bank Info</h3>
	                        <?php endif; ?>
	                     <?php else: ?>
	                        <h3 class="text-center"><?php echo $getway->gateway_name; ?>.</h3>
	                     <?php endif; ?>
	                     <center>
	                        <?php if($getway->paymentStatus == 15): ?>
	                           <a href="#" class="badge badge-success"><i class="fal fa-check-circle"></i> Active</a>
	                        <?php else: ?>
	                           <a href="#" class="badge badge-warning"><i class="fal fa-times-circle"></i> Closed</a>
	                        <?php endif; ?>
	                     </center>
	                     <div class="row mt-2">
	                        <div class="col-md-12">
	                           <hr>
	                        </div>
	                     </div>
	                     <?php if($getway->gatewayID == 9): ?>
	                        <a href="<?php echo route('property.mpesapaybill.integration',[$property->id,$getway->intergrationID]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     <?php endif; ?>
	                     <?php if($getway->gatewayID == 3): ?>
	                        <a href="<?php echo route('property.mpesaapi.integration',[$property->id,$getway->intergrationID]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     <?php endif; ?>
	                     <?php if($getway->gatewayID == 8): ?>
	                        <a href="<?php echo route('property.mpesatill.integration',[$property->id,$getway->intergrationID]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     <?php endif; ?>
	                     <?php if($getway->gatewayID == 6): ?>
	                        <a href="<?php echo route('property.bank1.integration',[$property->id,$getway->intergrationID]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     <?php endif; ?>
	                     <?php if($getway->gatewayID == 14): ?>
	                        <a href="<?php echo route('property.bank2.integration',[$property->id,$getway->intergrationID]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     <?php endif; ?>
	                     <?php if($getway->gatewayID == 15): ?>
	                        <a href="<?php echo route('property.bank3.integration',[$property->id,$getway->intergrationID]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     <?php endif; ?>
	                     <?php if($getway->gatewayID == 16): ?>
	                        <a href="<?php echo route('property.bank4.integration',[$property->id,$getway->intergrationID]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     <?php endif; ?>
	                     <?php if($getway->gatewayID == 17): ?>
	                        <a href="<?php echo route('property.bank5.integration',[$property->id,$getway->intergrationID]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     <?php endif; ?>
	                     <a href="<?php echo route('property.payment.integration.settings.delete',[$property->id,$getway->intergrationID]); ?>" class="btn-danger btn-sm btn float-right ml-2 delete"><i class="fas fa-trash"></i> Delete</a>
	                  </div>
	               </div>
	            </div>
	         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	      </div>
	   </div>
	   <!-- Modal -->
	   <form action="<?php echo route('property.payment.integration.settings.activation',$property->id); ?>" method="post">
	      <div class="modal fade gateway" tabindex="-1" role="dialog" aria-labelledby="gatewayTitle" aria-hidden="true">
	         <div class="modal-dialog modal-lg">
	            <?php echo csrf_field(); ?>
	            <div class="modal-content">
	               <div class="modal-header">
	                  <h5 class="modal-title" id="exampleModalLongTitle">Add Payment Integration</h5>
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                     <span aria-hidden="true">&times;</span>
	                  </button>
	               </div>
	               <div class="modal-body">
	                  <div class="form-group form-group-default">
	                     <label for="">Choose Payment Gateways</label>
	                     <?php echo Form::select('gateway',$gateways, null,['class' => 'form-control'] ); ?>

	                  </div>
	                  <div class="form-group form-group-default">
	                     <label for="">Choose status</label>
	                     <?php echo Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control'] ); ?>

	                  </div>
	               </div>
	               <div class="modal-footer">
	                  <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Gateway</button>
	                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
	               </div>
	            </div>
	         </div>
	      </div>
	   </form>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/payments/settings.blade.php ENDPATH**/ ?>