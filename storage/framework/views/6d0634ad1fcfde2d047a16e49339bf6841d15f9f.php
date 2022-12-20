<?php $__env->startSection('title'); ?> <?php echo $details->asset_name; ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesheet'); ?>
   <style>
      .nav-tabs-custom {
         margin-bottom: 20px;
         background: #fff;
         -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.1);
         box-shadow: 0 1px 1px rgba(0,0,0,.1);
         border-radius: 3px;
      }
      .nav-tabs-custom>.nav-tabs {
         margin: 0;
         border-bottom-color: #f4f4f4;
         border-top-right-radius: 3px;
         border-top-left-radius: 3px;
      }
      .nav-tabs-custom>.nav-tabs>li:first-of-type {
         margin-left: 0;
      }
      .nav-tabs-custom>.nav-tabs>li.active {
         border-top-color: #fb5597;
      }
      .nav-tabs-custom>.nav-tabs>li {
         border-top: 3px solid transparent;
         margin-bottom: -2px;
         margin-right: 5px;
      }
      .nav-tabs>li {
         float: left;
         margin-bottom: -1px;
      }
      .nav-tabs-custom>.nav-tabs>li:first-of-type.active>a {
         border-left-color: transparent;
      }
      .nav-tabs-custom>.nav-tabs>li.active>a {
         border-top-color: transparent;
         border-left-color: #f4f4f4;
         border-right-color: #f4f4f4;
      }
      .nav-tabs-custom>.nav-tabs>li.active:hover>a, .nav-tabs-custom>.nav-tabs>li.active>a {
         background-color: #fff;
         color: #444;
      }
      .nav-tabs-custom>.nav-tabs>li>a, .nav-tabs-custom>.nav-tabs>li>a:hover {
         background: 0 0;
         margin: 0;
      }
      .nav-tabs-custom>.nav-tabs>li>a {
         color: #444;
         border-radius: 0;
      }
      .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
         color: #555;
         background-color: #fff;
         border: 1px solid #ddd;
         border-bottom-color: transparent;
         cursor: default;
      }
      .nav-tabs>li>a {
         margin-right: 2px;
         line-height: 1.42857143;
         border: 1px solid transparent;
         border-radius: 4px 4px 0 0;
      }
      .row-striped {
         vertical-align: top;
         line-height: 2.6;
         padding: 0;
         margin-left: 20px;
         -webkit-box-sizing: border-box;
         box-sizing: border-box;
         display: table;
      }
      .row-striped .row:nth-of-type(odd) div {
         background-color: #f9f9f9;
         border-top: 1px solid #ddd;
         display: table-cell;
      }

      .img-thumbnail {
         padding: 4px;
         line-height: 1.42857143;
         background-color: #fff;
         border: 1px solid #ddd;
         border-radius: 4px;
         -webkit-transition: all .2s ease-in-out;
         transition: all .2s ease-in-out;
         display: inline-block;
         max-width: 100%;
         height: auto;
      }
      .user-image-inline {
         float: left;
         width: 25px;
         height: 25px;
         border-radius: 50%;
         margin-right: 10px;
      }
   </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?> 


<?php $__env->startSection('content'); ?>
<div class="content">
	<div class="pull-right">
      
      <a href="<?php echo route('licenses.assets.edit',$details->id); ?>" class="btn btn-primary"><i class="fal fa-edit"></i> Edit</a>
      
      <a href="<?php echo route('licenses.assets.delete',$details->id); ?>" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
      
   </div>
   <!-- begin page-header -->
  
   <?php if(request()->route()->getName() == 'licenses.assets.show'): ?>
      <h1 class="page-header"><i class="fal fa-laptop-code"></i> <?php echo $details->asset_name; ?></h1>
   <?php endif; ?>
   <?php if(request()->route()->getName() == 'licenses.maintenances.index' || request()->route()->getName() == 'licenses.maintenances.create' ||request()->route()->getName() == 'licenses.maintenances.edit'): ?> 
      <h1 class="page-header"><i class="fal fa-tools"></i> <?php echo $details->asset_name; ?> | Maintenances</h1>
   <?php endif; ?>    
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">   
               <div class="row">
                  <div class="col-md-4">
                     <?php if($details->asset_image == ""): ?>
                        <img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>" class="assetimg img-responsive" style="height: 369px;width: 100%">
                     <?php else: ?> 
                        <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/assets/'.$details->asset_image); ?>" alt="" class="assetimg img-responsive">
                     <?php endif; ?>
                  </div>
                  <div class="col-md-4">
                     <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
                        <tbody>
                           <tr><td>Product key</td><td><b><?php echo $details->product_key; ?></b></td></tr>                           
                           <tr><td>Seats</td><td><b><?php echo $details->seats; ?></b></td></tr>
                           <tr><td>Manufacture</td><td><b><?php echo $details->manufacture; ?></b></td></tr>
                           <tr><td>Licensed to name</td><td><b><?php echo $details->licensed_to_name; ?></b></td></tr>
                           <tr><td>Licensed to email</td><td><b><?php echo $details->licensed_to_email; ?></b></td></tr>     
                           <tr><td>Is software Reassignable </td><td><b><?php echo $details->reassignable; ?></b></td></tr>
                           <tr>
                              <td>Supplier</td>
                              <td>
                                 <?php if($details->supplier != ""): ?>
                                    <?php if(Finance::check_supplier($details->supplier) == 1): ?>
                                       <b><?php echo Finance::supplier($details->supplier)->supplierName; ?></b>
                                    <?php endif; ?>
                                 <?php endif; ?>
                              </td>
                           </tr>      
                        </tbody>
                    </table>
                  </div>
                  <div class="col-md-4">
                     <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
                        <tbody>                            
                           <tr><td>Order number</td><td><b><?php echo $details->order_number; ?></b></td></tr>
                           <tr><td>Purchase Cost</td><td><b><?php echo $details->purches_cost; ?></b></td></tr>
                           <tr><td>Purchase date</td><td><b><?php if($details->purchase_date != ""): ?><?php echo date('M jS, Y', strtotime($details->purchase_date)); ?><?php endif; ?></b></td></tr>
                           <tr><td>Termination Date</td><td><b><?php echo $details->end_of_life; ?></b></td></tr>
                           <tr><td>Is software maintained</td><td><b><?php echo $details->maintained; ?></b></td></tr>
                           <tr>
                              <td>Next maintenance</td>
                              <td>
                                 <b><?php if($details->next_maintenance != ""): ?><?php echo date('M jS, Y', strtotime($details->next_maintenance)); ?></b><?php endif; ?>
                              </td>
                           </tr>   
                           <tr>
                              <td>Created by</td>
                              <td>
                                 <?php if(Wingu::check_user($details->created_by) == 1): ?>
                                    <b><?php echo Wingu::user($details->created_by)->name; ?></b>
                                 <?php endif; ?>
                              </td>
                           </tr>                              
                           <tr>
                              <td>Status</td>
                              <td class="<?php if($details->status == 37): ?> success <?php elseif($details->status == 32): ?> danger <?php else: ?> info <?php endif; ?>">
                                 <?php if($details->status != ""): ?>
                                    <?php echo Wingu::status($details->status)->name; ?>

                                 <?php endif; ?>
                              </td>
                           </tr>
                        </tbody>
                    </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
               <li class="<?php echo Nav::isRoute('licenses.assets.show'); ?>">
                  <a href="<?php echo route('licenses.assets.show',$details->id); ?>">
                     <span class="">
                        <i class="fal fa-info-circle"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Details
                     </span>
                  </a>
               </li>
               
               <li class="<?php echo Nav::isRoute('licenses.maintenances.index'); ?> <?php echo Nav::isRoute('licenses.maintenances.create'); ?> <?php echo Nav::isRoute('licenses.maintenances.edit'); ?>">
                  <a href="<?php echo route('licenses.maintenances.index',$details->id); ?>">
                     <span class="">
                        <i class="fal fa-tools"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Maintenances Log
                     </span>
                  </a>
               </li>
               
               
               
            </ul>
            <div class="tab-content">
               <?php if(request()->route()->getName() == 'licenses.assets.show'): ?>
                  <?php echo $__env->make('app.assets.licenses.show.details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
               <?php endif; ?>
               <?php if(request()->route()->getName() == 'licenses.maintenances.index'): ?>
                  <?php echo $__env->make('app.assets.licenses.show.maintenances', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>   
               <?php if(request()->route()->getName() == 'licenses.maintenances.create'): ?>
                  <?php echo $__env->make('app.assets.licenses.maintenance.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?> 
               <?php if(request()->route()->getName() == 'licenses.maintenances.edit'): ?>
                  <?php echo $__env->make('app.assets.licenses.maintenance.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>       
            </div>  
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/licenses/view.blade.php ENDPATH**/ ?>