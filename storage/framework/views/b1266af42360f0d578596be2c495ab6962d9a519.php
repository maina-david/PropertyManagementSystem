<?php $__env->startSection('title','Edit Units | Property Units'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.show',$property->id); ?>"><?php echo $property->title; ?></a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.units',$property->id); ?>">Units</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> <?php echo $property->title; ?> | Edit | Units </h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">Edit Unit</div>
               <div class="panel-body">
                  <?php echo Form::model($unit, ['route' => ['property.units.update',$unit->id], 'method'=>'post']); ?>

                     <?php echo csrf_field(); ?>
                     <input type="hidden" value="<?php echo $property->id; ?>" name="parentID"  required>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('Unit Type', 'Unit Type', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::select('property_type',['' => 'Choose Type',2 => 'Flat/Apartment',10 => 'Commercial Properties', 12 => 'Offices'], null, array('class' => 'form-control multiselect','required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('Unit #', 'Unit #', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::text('serial', null, array('class' => 'form-control', 'placeholder' => 'Enter unit number', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('Landlord', 'Landlord', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::select('landlordID',$landlords,null,['class'=>'form-control multiselect']); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Tenant', 'Tenant', array('class'=>'control-label')); ?>

                              <select class="form-control multiselect" disabled>
                                 <?php if($unit->tenantID != ""): ?>
                                    <?php if(Property::check_tenant($unit->tenantID) == 1): ?>
                                    <option value="<?php echo $unit->tenantID; ?>">
                                       <?php echo Property::tenant_info($unit->tenantID)->tenant_name; ?>

                                    </option>
                                    <?php else: ?> 
                                       <option value="">Unknown Tenant</option>
                                    <?php endif; ?>
                                 <?php else: ?>
                                    <option value="">Not Occupied</option>
                                 <?php endif; ?>
                              </select>
                           </div>
                        </div>
                        <?php if($unit->leaseID != ""): ?>
                           <div class="col-md-4">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('Lease', 'Lease#', array('class'=>'control-label')); ?>

                                 <input type="text" value="<?php echo Property::lease($unit->leaseID)->lease_code; ?>" class="form-control" disabled>
                              </div>
                           </div>
                        <?php endif; ?>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Year built', 'Year built', array('class'=>'control-label')); ?>

                              <select name="year_built" class="form-control multiselect">
                                 <?php if($unit->year_built != ""): ?>
                                    <option value="<?php echo $unit->year_built; ?>"> <?php echo $unit->year_built; ?></option>
                                 <?php else: ?>
                                    <option value=""> Choose Year</option>
                                 <?php endif; ?>
                                 <?php
                                    for($i = date('Y'); $i >= date('Y') - 80; $i--){
                                       echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                 ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <label for="" class="text-danger">Ownership Type</label>
                              <?php echo Form::select('ownwership_type', ['' => 'choose type','single' => 'Single Ownership','multi' => 'Multi Ownership'],null,['class' => 'form-control multiselect'] ); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Size, sq.ft', 'Size, sq.ft', array('class'=>'control-label')); ?>

                              <?php echo Form::number('size', null, array('class' => 'form-control', 'placeholder' => 'Enter size')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('Market Price', 'Market Price', array('class'=>'control-label text-danger')); ?>

                              <?php echo Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount', 'required' => '')); ?>

                           </div>
                        </div>
                        <?php if($unit->property_type != 10): ?>
                           <div class="col-md-4 remove-on-commercial">
                              <div class="form-group form-group-default" id="single">
                                 <?php echo Form::label('Bedrooms', 'Bedrooms', array('class'=>'control-label')); ?>

                                 <?php echo Form::number('bedrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bedrooms')); ?>

                              </div>
                           </div>
                           <div class="col-md-4 remove-on-commercial">
                              <div class="form-group form-group-default" id="single">
                                 <?php echo Form::label('Bathrooms', 'Bathrooms', array('class'=>'control-label')); ?>

                                 <?php echo Form::number('bathrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bathrooms')); ?>

                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('Laundry', 'Laundry', array('class'=>'control-label')); ?>

                                 <?php echo Form::select('laundry', ['' => 'Choose', 'None' => 'None', 'In unit' => 'In unit', 'Shared' => 'Shared'], null, array('class' => 'form-control')); ?>

                              </div>
                           </div>
                        <?php endif; ?>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Furnished', 'Furnished', array('class'=>'control-label')); ?>

                              <?php echo Form::select('furnished', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Smoking', 'Smoking', array('class'=>'control-label')); ?>

                              <?php echo Form::select('smoking', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')); ?>

                           </div>
                        </div>                     
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <h5>Features</h5>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckAir" value="Air conditioning" <?php if(strpos($unit->features, 'Air conditioning') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckAir">Air conditioning</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckBalcony" value="Balcony, deck, patio" <?php if(strpos($unit->features, 'Balcony, deck, patio') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckBalcony">Balcony, deck, patio</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCable" value="Cable ready" <?php if(strpos($unit->features, 'Cable ready') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckCable">Cable ready</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCarpet" value="Carpet" <?php if(strpos($unit->features, 'Cable ready') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckCarpet">Carpet</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCeiling" value="Ceiling Fans" <?php if(strpos($unit->features, 'Ceiling Fans') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckCeiling">Ceiling Fans</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCentral" value="Central Heating" <?php if(strpos($unit->features, 'Central Heating') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckCentral">Central Heating</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDishwasher" value="Dishwasher" <?php if(strpos($unit->features, 'Dishwasher') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckDishwasher">Dishwasher</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFenced" value="Fenced yard" <?php if(strpos($unit->features, 'Fenced yard') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckFenced">Fenced yard</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFireplace" value="Fireplace" <?php if(strpos($unit->features, 'Fireplace') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckFireplace">Fireplace</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckGarbage" value="Garbage Disposal" <?php if(strpos($unit->features, 'Garbage Disposal') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckGarbage">Garbage Disposal</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckHardwood" value="Hardwood floors" <?php if(strpos($unit->features, 'Hardwood floors') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckHardwood">Hardwood floors</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckInternet" value="Internet" <?php if(strpos($unit->features, 'Internet') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckInternet">Internet</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckMicrowave" value="Microwave" <?php if(strpos($unit->features, 'Microwave') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckMicrowave">Microwave</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckOven" value="Oven/range" <?php if(strpos($unit->features, 'Oven/range') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckOven">Oven/range</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckRefrigerator" value="Refrigerator" <?php if(strpos($unit->features, 'Refrigerator') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckRefrigerator">Refrigerator</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStainless" value="Stainless Steel Appliance" <?php if(strpos($unit->features, 'Stainless Steel Appliance') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckStainless">Stainless Steel Appliance</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage" valu="Storage" <?php if(strpos($unit->features, 'Storage') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckStorage">Storage</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStove" value="Stove" <?php if(strpos($unit->features, 'Stove') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckStove">Stove</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTelephone" value="Telephone" <?php if(strpos($unit->features, 'Telephone') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckTelephone">Telephone</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTile" value="Tile" <?php if(strpos($unit->features, 'Tile') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckTile">Tile</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTowels" value="Towels" <?php if(strpos($unit->features, 'Towels') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckTowels">Towels</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckVacuum" value="Vacuum Cleaner" <?php if(strpos($unit->features, 'Vacuum Cleaner') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckVacuum">Vacuum Cleaner</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckclosets" value="Walk-in closets" <?php if(strpos($unit->features, 'Walk-in closets') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckclosets">Walk-in closets</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDryer" value="Washer/Dryer" <?php if(strpos($unit->features, 'Washer/Dryer') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckDryer">Washer/Dryer</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckWindow" value="Window Coverings" <?php if(strpos($unit->features, 'Window Coverings') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckWindow">Window Coverings</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckYard" value="Yard" <?php if(strpos($unit->features, 'Yard') !== false): ?> checked <?php endif; ?>>
                              <label class="custom-control-label" for="customCheckYard">Yard</label>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <?php echo Form::label('Property Description', 'Property Description', array('class'=>'control-label')); ?>

                              <?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor')); ?>

                           </div>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Unit</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                        </div>
                     </div>
                  <?php echo Form::close(); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/units/edit.blade.php ENDPATH**/ ?>