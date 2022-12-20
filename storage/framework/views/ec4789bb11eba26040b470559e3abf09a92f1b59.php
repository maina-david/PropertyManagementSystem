<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('title'); ?> <?php echo $tenant->tenant_name; ?> | Tenant <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Tenants</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | <?php echo $tenant->tenant_name; ?> |Tenants </h1>
      <div class="row">
         <?php echo $__env->make('app.property.property.tenants._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
         <div class="col-md-12 mt-3">
            
            <div class="row">
               <div class="col-md-12">
                  <div class="panel">
                     <div class="panel-heading">General information</div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-2">
                              <img src="https://ui-avatars.com/api/?name=<?php echo $tenant->tenant_name; ?>&rounded=true&size=180" alt="<?php echo $tenant->tenant_name; ?>"/>
                           </div>
                           <div class="col-md-4">
                              <p>
                                 <b>Tenant Name :</b> <?php echo $tenant->tenant_name; ?><br>
                                 <b>Phone Number :</b> <?php echo $tenant->primary_phone_number; ?><br>
                                 <b>Date Of Birth :</b> <?php echo $tenant->tenant_name; ?><br>
                                 <b>Email :</b> <?php echo $tenant->contact_email; ?><br>
                                 <b>Identification Type :</b> <?php echo $tenant->identification_type; ?><br>
                                 <b>Identification Number :</b> <?php echo $tenant->identification_number; ?><br>
                              </p>
                           </div>
                           <div class="col-md-4">
                              <p>
                                 <b>Gender :</b> <?php echo $tenant->gender; ?><br>
                                 <b>Age :</b> <?php echo $tenant->age; ?><br>
                                 <b>Tax Pin :</b> <?php echo $tenant->tax_pin; ?><br>
                                 <b>Code :</b> <?php echo $tenant->reference_number; ?><br>
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/overview.blade.php ENDPATH**/ ?>