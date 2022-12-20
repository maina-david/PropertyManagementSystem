<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('title'); ?> <?php echo $tenant->tenant_name; ?> | Tenant <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.show', $property->id); ?>"><?php echo $property->title; ?></a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.tenants', $property->id); ?>">Tenants</a></li>
         <li class="breadcrumb-item active"><a href="<?php echo route('property.tenant.lease.show',[$propertyID,$lease->tenantID,$lease->leaseID]); ?>"> Lease Details</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | <?php echo $tenant->tenant_name; ?> | Leases </h1>
      <div class="row">
         <?php echo $__env->make('app.property.property.tenants._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
         <div class="col-md-12 mt-3">
            <?php if($lease->status != 26): ?>
               <a href="#" class="btn btn-danger delete" data-toggle="modal" data-target="#exampleModalCenter"><i class="fal fa-ban"></i> Terminate Lease</a>
            <?php endif; ?>
            <a href="<?php echo route('property.tenant.lease.edit',[$propertyID,$lease->tenantID,$lease->leaseID]); ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
            
            
         </div>
         <div class="col-md-12">
            <div class="panel mt-3">
               <div class="panel-heading"><b>Lease details</b></div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-4">
                        <p>
                           <b>Property Name :</b> <?php echo $property->title; ?><br>
                           <b>Unit # : </b><?php echo $lease->serial; ?><br>
                           <b>Lease # : </b> <?php echo $lease->lease_code; ?> <br>
                           <b>Lease Type : </b> <?php echo $lease->lease_type; ?> <br>
                           <b>Start Date : </b> <?php echo date('d F, Y', strtotime($lease->lease_start_date)); ?> <br>
                           <b>End Date : </b> <?php if($lease->lease_end_date != ""): ?><?php echo date('d F, Y', strtotime($lease->lease_end_date)); ?><?php endif; ?><br>
                           <b>Rent Amount : </b><?php echo $business->code; ?><?php echo number_format($lease->rent_amount); ?> <br>
                           <b>Deposit : </b> <?php echo $business->code; ?><?php echo number_format($lease->deposit); ?> <br>
                                    
                        </p>
                     </div>
                     <div class="col-md-4">
                        <p>    
                           <b>Billing Schedule : </b> 
                           <?php if($lease->billing_schedule == 7): ?> Weekly <?php elseif($lease->billing_schedule == 1): ?> Monthly <?php elseif($lease->billing_schedule == 3): ?> Quarterly <?php elseif($lease->billing_schedule == 6): ?> Half Year <?php elseif($lease->billing_schedule == 12): ?> Yearly <?php endif; ?>
                           <br>
                           <b>First invoice date : </b> <?php if($lease->first_invoice_date != ""): ?><?php echo date('d F, Y', strtotime($lease->first_invoice_date)); ?><?php endif; ?><br>                      
                           <b>Next invoice date : </b> <?php if($lease->lease_termination_date != ""): ?><?php echo date('d F, Y', strtotime($lease->lease_termination_date)); ?><?php endif; ?> <br>
                           <b>Tax rate : </b> <?php echo $lease->tax_rate; ?> <br>
                           <b>Escalation Rate : </b> <?php echo $lease->escalation_rate; ?>%<br>
                           <b>Escalation Period : </b> <?php echo $lease->escalation_period; ?><br>
                           <b>Escalation Items : </b> <?php echo $lease->escalating_items; ?> <br>    
                           <b>Service charge Fee : </b> <?php echo $business->code; ?><?php echo number_format($lease->service_charge); ?> <br>              
                        </p>
                     </div>
                     <div class="col-md-4">
                        <p>                                    
                           <b>Parking fee : </b> <?php echo $business->code; ?><?php echo number_format($lease->parking_price); ?> <br>
                           <b>Allocated parkings : </b> <?php echo $lease->parking_spaces; ?> <br>
                           <b>Add Utilities to tenant : </b> <?php echo $lease->include_utility; ?> <br>
                                            
                        </p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel mt-3">
               <div class="panel-heading"><b>Lease Agreement</b></div>
               <div class="panel-body">
                  <?php echo $lease->agreement; ?>

               </div>
            </div>
         </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <form action="<?php echo route('property.lease.terminate'); ?>" method="post">
                  <?php echo csrf_field(); ?>
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">Terminate Lease</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group">
                        <label for="">Date ended</label>
                        <?php echo Form::date('lease_termination_date',null,['class' => 'form-control','required' => '']); ?>

                        <input type="hidden" name="leaseID" value="<?php echo $lease->leaseID; ?>">
                        
                     </div>
                     <div class="form-group">
                        <label for="">End Note</label>
                        <?php echo Form::textarea('lease_termination_note',null,['class' => 'form-control ckeditor','required' => '']); ?>

                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-success">Submit</button>
                     <img src="<?php echo url('/'); ?>/public/app/img/btn-loader.gif" class="submit-load none float-right" alt="" width="15%">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo url('/'); ?>/public/app/plugins/ckeditor/4/standard/ckeditor.js"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/leases/show.blade.php ENDPATH**/ ?>