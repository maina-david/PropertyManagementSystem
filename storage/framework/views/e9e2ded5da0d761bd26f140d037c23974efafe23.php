<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Property Overview <?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('property.show',$property->id); ?>"><?php echo $property->title; ?></a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)">Overview</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | Overview</h1>
   <div class="row">
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12">
         <div class="row row-space-10 m-b-20">
            <!-- rent invoice -->
            <div class="col-xl-4 col-lg-6 col-sm-6">
               <div class="widget-stat card">
                  <div class="card-body p-4">
                     <div class="media ai-icon">
                        <span class="mr-3"><i class="fal fa-file-invoice-dollar fa-3x"></i></span>
                        <div class="media-body">
                           <p class="mb-1">Outstanding Rent Invoices</p>
                           <h4 class="mb-0"><?php echo $business->code; ?><?php echo number_format($outstandingInvoices); ?></h4><br>
                           <a href="#" class="pull-right badge badge-success mt-2">view all</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- utility -->
            <div class="col-xl-4 col-lg-6 col-sm-6">
               <div class="widget-stat card">
                  <div class="card-body p-4">
                     <div class="media ai-icon">
                        <span class="mr-3"><i class="fal fa-file-invoice fa-3x"></i></span>
                        <div class="media-body">
                           <p class="mb-1">Outstanding Utility Bills</p> 
                           <h4 class="mb-0"><?php echo $business->code; ?><?php echo number_format($outstandingUtility); ?></h4><br>
                           <a href="#" class="pull-right badge badge-success mt-2">view all</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php if($property->property_type == 13 or $property->property_type == 14): ?>
               <!-- Payed Bills -->
               <div class="col-xl-4 col-lg-6 col-sm-6">
                  <div class="widget-stat card">
                     <div class="card-body p-4">
                        <div class="media ai-icon">
                           <span class="mr-3"><i class="fal fa-dollar-sign fa-3x"></i></span>
                           <div class="media-body">
                              <p class="mb-1">Payed Bills <?php echo date('Y') ?></p>
                              <h4 class="mb-0"><?php echo $business->code; ?><?php echo number_format($payed); ?></h4><br>
                              <a href="#" class="badge badge-primary pull-right">view all</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Total Units -->
               <div class="col-xl-4 col-lg-6 col-sm-6">
                  <div class="widget-stat card">
                     <div class="card-body p-4">
                        <div class="media ai-icon">
                           <span class="mr-3"><i class="fal fa-city fa-3x"></i></span>
                           <div class="media-body">
                              <p class="mb-1">Total Units</p>
                              <h4 class="mb-0"><?php echo number_format($units); ?></h4><br>
                              <a href="#" class="badge badge-primary pull-right">view all</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- total tenants -->
               <div class="col-xl-4 col-lg-6 col-sm-6">
                  <div class="widget-stat card">
                     <div class="card-body p-4">
                        <div class="media ai-icon">
                           <span class="mr-3"><i class="fal fa-users fa-3x"></i></span>
                           <div class="media-body">
                              <p class="mb-1">Total Tenants</p>
                              <h4 class="mb-0"><?php echo number_format($tenants->count()); ?></h4><br>
                              <a href="#" class="badge badge-primary pull-right">view all</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>     

               <!-- total Owners -->
               <div class="col-xl-4 col-lg-6 col-sm-6">
                  <div class="widget-stat card">
                     <div class="card-body p-4">
                        <div class="media ai-icon">
                           <span class="mr-3"><i class="fal fa-users-crown fa-3x"></i></span>
                           <div class="media-body">
                              <p class="mb-1">Total Owners</p>
                              <h4 class="mb-0"><?php echo number_format($owner->count()); ?></h4><br>
                              <a href="#" class="badge badge-primary pull-right">view all</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Vacant Units -->
               <div class="col-xl-4 col-lg-6 col-sm-6">
                  <div class="widget-stat card">
                     <div class="card-body p-4">
                        <div class="media ai-icon">
                           <span class="mr-3"><i class="fal fa-door-open fa-3x"></i></span>
                           <div class="media-body">
                              <p class="mb-1">Vacant Units</p>
                              <h4 class="mb-0"><?php echo number_format($vacant); ?></h4><br>
                              <a href="<?php echo route('property.vacant',$property->id); ?>" class="pull-right badge badge-success mt-2">view all</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               
               <!-- Occupied Units -->
               <div class="col-xl-4 col-lg-6 col-sm-6">
                  <div class="widget-stat card">
                     <div class="card-body p-4">
                        <div class="media ai-icon">
                           <span class="mr-3"><i class="fal fa-door-closed fa-3x"></i></span>
                           <div class="media-body">
                              <p class="mb-1">Occupied Units</p>
                              <h4 class="mb-0"><?php echo number_format($occupied); ?></h4><br>
                              <a href="<?php echo route('property.occupied',$property->id); ?>" class="pull-right badge badge-success mt-2">view all</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- active lease-->
               <div class="col-xl-4 col-lg-6 col-sm-6">
                  <div class="widget-stat card">
                     <div class="card-body p-4">
                        <div class="media ai-icon">
                           <span class="mr-3"><i class="fal fa-file-signature fa-3x"></i></span>
                           <div class="media-body">
                              <p class="mb-1">Active Leases</p>
                              <h4 class="mb-0"><?php echo number_format($activeLease); ?></h4><br>
                              <a href="#" class="badge badge-primary pull-right">view all</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/details.blade.php ENDPATH**/ ?>