<?php $__env->startSection('title'); ?> <?php echo $details->asset_name; ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesheet'); ?>
   <style>
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
   </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="content">
	<div class="pull-right">
      <div class="btn-group">
         <button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"><i class="fal fa-mouse"></i> Actions</button>
         <ul class="dropdown-menu">
            <?php if($details->status == 38): ?>
               <li><a data-toggle="modal" data-target=".checkin">Check In</a></li>
            <?php else: ?>
               <li><a data-toggle="modal" data-target=".checkout">Check out</a></li>
            <?php endif; ?>

            <li><a data-toggle="modal" data-target=".lease">Lease</a></li>
            
            
         </ul>
      </div>
      <a href="<?php echo route('assets.edit',$details->id); ?>" class="btn btn-primary"><i class="fal fa-edit"></i> Edit</a>
      
      <a href="<?php echo route('assets.delete',$details->id); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
   </div>
   <!-- begin page-header -->

   <?php if(request()->route()->getName() == 'assets.show' || request()->route()->getName() == 'assets.event.index'): ?>
      <h1 class="page-header"><i class="fal fa-barcode-alt"></i> <?php echo $details->asset_name; ?></h1>
   <?php endif; ?>
   <?php if(request()->route()->getName() == 'assets.maintenances.index'): ?>
      <h1 class="page-header"><i class="fal fa-tools"></i> <?php echo $details->asset_name; ?> | Maintenances</h1>
   <?php endif; ?>
   <?php if(request()->route()->getName() == 'assets.maintenances.create'): ?>
     <h1 class="page-header"><i class="fal fa-tools"></i> <?php echo $details->asset_name; ?> | Add Maintenance</h1>
   <?php endif; ?>
   <?php if(request()->route()->getName() == 'assets.maintenances.edit'): ?>
     <h1 class="page-header"><i class="fal fa-tools"></i> <?php echo $details->asset_name; ?> | Edit Maintenance</h1>
   <?php endif; ?>
   <?php if(request()->route()->getName() == 'assets.details.vehicle'): ?>
     <h1 class="page-header"><i class="fal fa-car"></i> <?php echo $details->asset_name; ?></h1>
   <?php endif; ?>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-4">
                     <?php if($details->asset_image == ""): ?>
                        <img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>" class="assetimg img-responsive" style="height: 246px;width: 100%">
                     <?php else: ?>
                        <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/assets/'.$details->asset_image); ?>" alt="" class="assetimg img-responsive">
                     <?php endif; ?>
                  </div>
                  <div class="col-md-4">
                     <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
                        <tbody>
                           <tr><td>Asset Tag ID</td><td><b><?php echo $details->asset_tag; ?></b></td></tr>
                           <tr><td>Serial</td><td><b><?php echo $details->serial; ?></b></td></tr>
                           <tr>
                              <td>Purchase Date</td>
                              <td><b><?php if($details->purchase_date != ""): ?><?php echo date('F jS, Y', strtotime($details->purchase_date)); ?><?php endif; ?></b></td>
                           </tr>
                           <tr><td>Cost</td><td><b><?php if($details->purches_cost != ""): ?><?php echo number_format($details->purches_cost); ?><?php endif; ?></b></td></tr>
                           <tr><td>Brand</td><td><b><?php echo $details->asset_brand; ?></b></td></tr>
                           <tr><td>Model</td><td><b><?php echo $details->asset_model; ?></b></td></tr>
                        </tbody>
                    </table>
                  </div>
                  <div class="col-md-4">
                     <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
                        <tbody>
                           <tr>
                              <td>Branch</td>
                              <td><b><?php if(Hr::check_branch($details->company_branch) == 1): ?> <?php echo Hr::branch($details->company_branch)->branch_name; ?>  <?php endif; ?></b></td>
                           </tr>
                           <tr><td>Location</td><td><b><?php echo $details->default_location; ?></b></td></tr>
                           <tr><td>Asset Type</td><td><b><?php if(Asset::check_type($details->asset_type) == 1): ?><?php echo Asset::type($details->asset_type)->name; ?><?php endif; ?></b></td></tr>
                           <tr><td>Department</td><td><b><?php if(Hr::check_department($details->department) == 1): ?> <?php echo Hr::department($details->department)->title; ?>  <?php endif; ?></td></tr>
                           <tr>
                              <td>Assigned to</td>
                              <td>
                                 <?php if($details->employee != ""): ?>
                                    <b>Employee :</b> <?php echo Hr::employee($details->employee)->names; ?>

                                 <?php endif; ?>
                                 <?php if($details->customer != ""): ?>
                                    <b>Customer :</b> <?php echo Finance::client($details->customer)->customer_name; ?>

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
               <li class="<?php echo Nav::isRoute('assets.show'); ?>">
                  <a href="<?php echo route('assets.show',$details->id); ?>">
                     <span class="">
                        <i class="fal fa-info-circle"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Details
                     </span>
                  </a>
               </li>
               <?php if($details->asset_type == 1): ?>
                  <li class="<?php echo Nav::isRoute('assets.details.vehicle'); ?>">
                     <a href="<?php echo route('assets.details.vehicle',$details->id); ?>">
                        <span class="">
                           <i class="fal fa-car"></i>
                        </span>
                        <span class="hidden-xs hidden-sm">
                           Vehicle details
                        </span>
                     </a>
                  </li>
               <?php endif; ?>
               <li class="<?php echo Nav::isRoute('assets.maintenances.index'); ?> <?php echo Nav::isRoute('assets.maintenances.create'); ?> <?php echo Nav::isRoute('assets.maintenances.edit'); ?>">
                  <a href="<?php echo route('assets.maintenances.index',$details->id); ?>">
                     <span class="">
                        <i class="fal fa-tools"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Maintenances Log
                     </span>
                  </a>
               </li>
               
               <li class="<?php echo Nav::isResource('events'); ?>">
                  <a href="<?php echo route('assets.event.index',[$details->id]); ?>">
                     <span class="">
                        <i class="fal fa-calendar-alt"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Events
                     </span>
                  </a>
               </li>
               
            </ul>
            <div class="tab-content">
               <?php if(request()->route()->getName() == 'assets.show'): ?>
                  <?php echo $__env->make('app.assets.assets.details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>
               <?php if(request()->route()->getName() == 'assets.maintenances.index'): ?>
                  <?php echo $__env->make('app.assets.assets.maintenances', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>
               <?php if(request()->route()->getName() == 'assets.details.vehicle'): ?>
                  <?php echo $__env->make('app.assets.assets.vehicle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>
               <?php if(request()->route()->getName() == 'assets.maintenances.create'): ?>
                  <?php echo $__env->make('app.assets.assets.maintenance.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>
               <?php if(request()->route()->getName() == 'assets.maintenances.edit'): ?>
                  <?php echo $__env->make('app.assets.assets.maintenance.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>
               <?php if(request()->route()->getName() == 'assets.event.index'): ?>
                  <?php echo $__env->make('app.assets.assets.events.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>



<div class="modal fade checkout" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="<?php echo route('assets.event.checkout.store'); ?>" method="POST" autocomplete="off" id="checkoutForm">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Check out</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="">Check-out Date</label>
                        <?php echo Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']); ?>

                        <input type="hidden" name="status" value="38">
                        <input type="hidden" name="assetID" value="<?php echo $details->id; ?>">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Due Date</label>
                        <?php echo Form::text('due_action_date',null,['class' => 'form-control datepicker', 'placeholder' => 'choose date']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="">Check-out to</label>
                        <?php echo Form::select('check_out_to',['' => 'Choose','Person' => 'Person','Branch' => 'Branch','Location' => 'Site / Location'],null,['class' => 'form-control', 'required' => '', 'id'=>'checkoutto']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Branch</label>
                        <?php echo Form::select('branch',$branches,null,['class' => 'form-control']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Person</label>
                        <?php echo Form::select('allocated_to',$employees,null,['class' => 'form-control']); ?>

                     </div>
                  </div>
                  <div class="col-md-6" id="checkoutLocation" style="display:none">
                     <div class="form-group form-group-default required">
                        <label for="">Site / Location </label>
                        <?php echo Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Department </label>
                        <?php echo Form::select('department',$departments,null,['class' => 'form-control']); ?>

                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitCheckoutForm">Submit check out</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade checkin" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="<?php echo route('assets.event.checkin.store'); ?>" method="POST" autocomplete="off" id="checkinForm">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Check in</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="">Return Date </label>
                        <?php echo Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']); ?>

                        <input type="hidden" name="status" value="43">
                        <input type="hidden" name="assetID" value="<?php echo $details->id; ?>">
                     </div>
                  </div>
                  <div class="col-md-6" id="checkoutLocation">
                     <div class="form-group form-group-default required">
                        <label for="">Site / Location </label>
                        <?php echo Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']); ?>

                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitCheckinForm">Submit check out</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade lease" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="<?php echo route('assets.event.lease.store'); ?>" method="POST" autocomplete="off" id="leaseForm">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Lease</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Lease Begins</label>
                        <?php echo Form::date('action_date',null,['class' => 'form-control', 'required' => '']); ?>

                        <input type="hidden" name="status" value="39">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Lease Expires</label>
                        <?php echo Form::date('due_action_date',null,['class' => 'form-control', 'required' => '']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Leasing Customer </label>
                        <?php echo Form::select('allocated_to',$customers,null,['class' => 'form-control', 'required' => '']); ?>

                     </div>
                  </div>
                  
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitLeaseForm">Submit Lease</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade lost" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="lostForm">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Lost / Missing Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Date Lost </label>
                        <?php echo Form::date('action_date',null,['class' => 'form-control', 'required' => '']); ?>

                        <input type="hidden" name="status" value="32">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitLostForm">Submit Information</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade repair" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="repairForm">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Repair Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Repair date </label>
                        <?php echo Form::date('action_date',null,['class' => 'form-control', 'required' => '']); ?>

                        <input type="hidden" name="status" value="34">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Assigned to </label>
                        <?php echo Form::text('action_to',null,['class' => 'form-control', 'placeholder' => 'Enter name']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Date Completed </label>
                        <?php echo Form::date('due_action_date',null,['class' => 'form-control']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Repair Cost</label>
                        <?php echo Form::number('cost',null,['class' => 'form-control', 'placeholder' => 'Enter amount']); ?>

                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitRepairForm">Submit Information</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade disposed" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="disposedForm">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Dispose Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Date Disposed </label>
                        <?php echo Form::date('action_date',null,['class' => 'form-control', 'required' => '']); ?>

                        <input type="hidden" name="status" value="40">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Dispose to </label>
                        <?php echo Form::text('action_to',null,['class' => 'form-control', 'placeholder' => 'Enter name']); ?>

                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitDisposedForm">Submit Information</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade donate" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="donateForm">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Donate Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Date Donated </label>
                        <?php echo Form::date('action_date',null,['class' => 'form-control', 'required' => '']); ?>

                        <input type="hidden" name="status" value="41">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Dispose to </label>
                        <?php echo Form::text('action_to',null,['class' => 'form-control', 'placeholder' => 'Enter name']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Donate Value </label>
                        <?php echo Form::number('cost',null,['class' => 'form-control', 'placeholder' => 'Enter value']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Deductible </label>
                        <?php echo Form::select('deductible',['No' => 'No', 'Yes' => 'Yes'],null,['class' => 'form-control']); ?>

                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitDonateForm">Submit Information</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade sell" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="donateForm">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Sell Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Sale Date</label>
                        <?php echo Form::date('action_date',null,['class' => 'form-control', 'required' => '']); ?>

                        <input type="hidden" name="status" value="42">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Sold to</label>
                        <?php echo Form::text('action_to',null,['class' => 'form-control', 'placeholder' => 'Enter name']); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Sale amount</label>
                        <?php echo Form::number('cost',null,['class' => 'form-control', 'placeholder' => 'Enter value']); ?>

                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitDonateForm">Submit Information</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script>
      $(document).ready(function() {
         $('#checkoutto').on('change', function(){
            if(this.value == 'Location') {
               $('#checkoutLocation').show();
            }else {
               $('#checkoutLocation').hide();
            }
         });

         $('#lease_email').on('change', function(){
            if(this.value == 'Yes') {
               $('#leaseEmail').show();
            }else {
               $('#leaseEmail').hide();
            }
         });

         //checkoutForm
         $('#checkoutForm').on('submit', function(e){
            $('.submitCheckoutForm').hide();
            $(".checkout-load").show();
         });

         //checkinForm
         $('#checkinForm').on('submit', function(e){
            $('.submitCheckinForm').hide();
            $(".checkin-load").show();
         });

         //leaseForm
         $('#leaseForm').on('submit', function(e){
            $('.submitLeaseForm').hide();
            $(".lease-load").show();
         });

         //LostForm
         $('#lostForm').on('submit', function(e){
            $('.submitLostForm').hide();
            $(".lost-load").show();
         });

         //repairForm
         $('#repairForm').on('submit', function(e){
            $('.submitRepairForm').hide();
            $(".repair-load").show();
         });

         //disposedForm
         $('#disposedForm').on('submit', function(e){
            $('.submitDisposedForm').hide();
            $(".disposed-load").show();
         });

         //donateForm
         $('#donateForm').on('submit', function(e){
            $('.submitDonateForm').hide();
            $(".donate-load").show();
         });
      });
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/assets/view.blade.php ENDPATH**/ ?>