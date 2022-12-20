<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('title'); ?> <?php echo $tenant->tenant_name; ?> | Edit Lease <?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrum'); ?>
   <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
         <div class="welcome-text">
            <h4><i class="fal fa-home"></i> <?php echo $property->title; ?> | <?php echo $tenant->tenant_name; ?> | Edit </h4>
         </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Leases</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
         </ol>
      </div>
   </div>
<?php $__env->stopSection(); ?>
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
   <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | <?php echo $tenant->tenant_name; ?> | Edit </h1>
   <div class="row">
      <?php echo $__env->make('app.property.property.tenants._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
      <div class="col-md-12 mt-3">      
         <?php echo Form::model($lease, ['route' => ['property.tenant.lease.update',$lease->leaseID], 'method'=>'post','class' => 'row','enctype' => 'multipart/form-data']); ?>

            <?php echo csrf_field(); ?>  
            <div class="col-md-12">
               <div class="panel">
                  <div class="panel-heading">Lease Details</div>
                  <div class="panel-body">
                     <div class="row"> 
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Property Name', 'Property Name', array('class'=>'control-label')); ?>

                              <input type="text"  value="<?php echo $property->title; ?>" class="form-control" disabled>
                              <input type="hidden" name="propertyID" value="<?php echo $property->id; ?>">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <?php if($property->property_type == 1 or $property->property_type == 3): ?>
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('Serials', 'Property ID', array('class'=>'control-label')); ?>

                                 <input type="text" name="unitID" value="<?php echo $property->serial; ?>" class="form-control" readonly>
                              </div>
                           <?php else: ?> 
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('Unit', 'Unit', array('class'=>'control-label text-danger')); ?>

                                 <select name="unitID"  class="form-control multiselect" required>
                                    <option value="<?php echo $currentUnit->id; ?>"><?php echo $currentUnit->serial; ?></option>
                                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo $unit->id; ?>"><?php echo $unit->serial; ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                              </div>
                           <?php endif; ?>
                        </div> 
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              <?php echo Form::label('Select Tenant', 'Select Tenant', array('class'=>'control-label')); ?>

                              <select name="tenant" class="form-control multiselect">
                                 <option value="<?php echo $tenant->tenantID; ?>"><?php echo $tenant->tenant_name; ?></option>
                                 <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $owner->id; ?>"><?php echo $owner->tenant_name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              <?php echo Form::label('Lease Type', 'Lease Type', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::select('lease_type', ['' => 'Choose Type','Commercial Lease' => 'Commercial Lease', 'Residential Lease' => 'Residential Lease'], null, array('class' => 'form-control multiselect','required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              <?php echo Form::label('Start Date', 'Start Date', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::date('lease_start_date', null, array('class' => 'form-control', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('End Date', 'End Date', array('class'=>'control-label')); ?>

                              <?php echo Form::date('lease_end_date', null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel">
                  <div class="panel-heading">Recurring Details</div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Deposit', 'Deposit', array('class'=>'control-label')); ?>

                              <?php echo Form::number('deposit', null, array('class' => 'form-control', 'placeholder' => 'Enter Amount')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              <?php echo Form::label('Rent Amount', 'Rent Amount', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::number('rent_amount',null,['class'=>'form-control','required'=>'']); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              <?php echo Form::label('Billing schedule', 'Billing schedule', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::select('billing_schedule', [''=>'Choose',7 => 'Weekly',1 => 'Monthly',3 => 'Quarterly',6 => 'Half Year',12 => 'Yearly'], null, array('class' => 'form-control', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('First invoice date', 'First invoice date', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::date('first_invoice_date', null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('Due Day', 'Due Day', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::select('due_day', ['1' => '1st','2' => '2nd','3' => '3rd','4' => '4th','5' => '5th','6' => '6th','7' => '7 th','8' => '8th','9' => '9th','10' => '10th','11' => '11th','12' => '12th','13' => '13th','14' => '14th','15' => '15th','16' => '16th','17' => '17th','18' => '18th','19' => '19th','20' => '20th','21' => '21st','22' => '22nd','23' => '23rd','24' => '24th','25' => '25th','26' => '26th','27' => '27th','28' => '28th'], null, array('class' => 'form-control multiselect', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Tax rate', 'Tax Rate', array('class'=>'control-label')); ?>

                              <select name="tax_rate" id="" class="form-control multiselect">
                                 <option value="0">Choose tax rate</option>
                                 <option value="0">No Tax</option>
                                 <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $tax->rate; ?>"><?php echo $tax->name; ?> - <?php echo $tax->rate; ?>%</option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel">
                  <div class="panel-heading">Escalation Rate</div>
                  <div class="panel-body">
                     <div class="row">                    
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Escalation Rate', 'Escalation Rate in %', array('class'=>'control-label')); ?>

                              <?php echo Form::number('escalation_rate', null, array('class' => 'form-control','step' => '0.01', 'placeholder' => 'Enter rate')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Escalation Period', 'Escalation Period', array('class'=>'control-label')); ?>

                              <?php echo Form::select('escalation_period', ['Monthly' => 'Monthly', 'quarterly' => 'quarterly', 'Half year' => 'Half year', 'Yearly' => 'Yearly','After 2 Yearly' => 'After 2 Yearly','After 3 Yearly' => 'After 3 Yearly' ], null, array('class' => 'form-control multiselect')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <h5 class="font-weight-bolder">Escalation Items </h5>
                           <div class="row">
                              <div class="col-md-4">
                                 <input type="checkbox" name="escalating_items[]" value="Rent" <?php if(strpos($lease->escalating_items, 'Rent') !== false): ?> checked <?php endif; ?>> Rent
                              </div>
                              <div class="col-md-4">
                                 <input type="checkbox" name="escalating_items[]" value="Service charge" <?php if(strpos($lease->escalating_items, 'Service charge') !== false): ?> checked <?php endif; ?>> Service charge
                              </div>
                              <div class="col-md-4">
                                 <input type="checkbox" name="escalating_items[]" value="Parking fee" <?php if(strpos($lease->escalating_items, 'Parking fee') !== false): ?> checked <?php endif; ?>> Parking fee
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel">
                  <div class="panel-heading">Service charge & Parking</div>
                  <div class="panel-body">
                     <div class="row">  
                        <div class="col-md-6">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Service Charge', 'Service Charge', array('class'=>'control-label')); ?>

                                    <?php echo Form::number('service_charge', null, array('class' => 'form-control', 'placeholder' => 'Enter amount')); ?>

                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Price per parking', 'Price per parking', array('class'=>'control-label')); ?>

                                    <?php echo Form::number('parking_price', null, array('class' => 'form-control', 'placeholder' => 'Enter price')); ?>

                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Allocated parking spaces', 'Allocated parking spaces', array('class'=>'control-label')); ?>

                                    <?php echo Form::number('parking_spaces', null, array('class' => 'form-control', 'placeholder' => 'Enter spaces')); ?>

                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Define what is under service charge</label>
                              <?php echo Form::textarea('define_service_charge',null,['class' => 'form-control']); ?>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel">
                  <div class="panel-heading">Utilities</div>
                  <div class="panel-body">
                     <div class="row">  
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Do you want to include utilities ?', 'Do you want to include utilities ?', array('class'=>'control-label')); ?>

                              <?php echo Form::select('include_utility', ['No' => 'Choose your option', 'Yes' => 'Yes Include utilities to the lease','No' => 'No Dont include utilities to the lease'], null, array('class' => 'form-control multiselect','id' => 'utility')); ?>

                           </div>
                        </div>
                        <?php if($lease->include_utility == 'Yes'): ?>
                           <div class="col-md-12">
                                 <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addutility">Add Utility</a>
                                 <table class="table table-striped table-bordered table-hover mt-3" id="table">
                                    <thead>
                                       <tr>
                                          <th width="1%">#</th>
                                          <th>Utility</th>
                                          <th>Name/No</th>
                                          <th>Initial Reading</th>
                                          <th>Initial Pricing</th>
                                          <th width="10%">Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__currentLoopData = $selected_utility; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $utility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <tr>
                                             <td><?php echo $count++; ?></td>
                                             <td>
                                                <?php echo $utility->name; ?>

                                             </td>
                                             <td>
                                                <?php echo $utility->utility_No; ?>

                                             </td>
                                             <td>
                                                <?php echo $utility->last_reading; ?>

                                             </td>
                                             <td>
                                                <?php echo $business->code; ?><?php echo $utility->initial_price; ?>

                                             </td>
                                             <td>
                                                
                                                <a href="<?php echo route('property.leases.delete.utility',[$lease->leaseID,$utility->leaseUtilityID]); ?>" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i></a>
                                             </td>
                                          </tr>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                 </table>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
               <div class="panel">
                  <div class="panel-heading">Lease Agreement Details</div>
                  <div class="panel-body">
                     <div class="row">  
                        <div class="col-md-12">
                           <?php echo Form::label('Agreement', 'Agreement', array('class'=>'control-label')); ?>

                           <textarea name="agreement" id="" cols="30" rows="10" class="ckeditor"><?php echo $lease->agreement; ?></textarea>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12 mb-5">
               <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Lease</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
            </div>
         <?php echo Form::close(); ?>

      </div>
      <!-- Modal -->
      <div class="modal fade" id="addutility" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <form action="<?php echo route('property.tenant.lease.add.utility'); ?>" method="post">
               <?php echo csrf_field(); ?>
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Add Utility</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <input type="hidden" class="form-control" value="<?php echo $lease->leaseID; ?>" name="leaseID">
                     <input type="hidden" class="form-control" value="<?php echo $property->id; ?>" name="propertyID">
                     <div class="form-group-default form-group required">
                        <label for="">Choose utility</label>
                        <select name="utility" class="form-control">
                           <option value="">Choose Utility</option>
                           <?php $__currentLoopData = $utilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $utility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $utility->id; ?>"><?php echo $utility->name; ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="">Name/No</label>
                        <input type="text" name="utility_No" class="form-control" required>
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="">Last reading</label>
                        <input type="number" name="last_reading" class="form-control" step="0.01" value="0" required>
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="">Unit Price</label>
                        <input type="number" name="unit_price" class="form-control" step="0.01" value="0" required>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-success submit">Add utility</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="25%">
                  </div>
               </div>
            </form>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/tenants/leases/edit.blade.php ENDPATH**/ ?>