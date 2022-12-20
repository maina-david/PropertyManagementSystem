<?php $__env->startSection('title','Add Units '); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> <?php echo $property->title; ?> | Add Units </h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  Add Unit
               </div>
               <div class="panel-body">
                  <?php echo Form::open(array('route' => 'property.units.store','enctype'=>'multipart/form-data','method'=>'post' )); ?>

                     <?php echo csrf_field(); ?>

                     <input type="hidden" value="<?php echo $property->id; ?>" name="parentID"  required>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('Unit Type', 'Unit Type', array('class'=>'control-label')); ?>

                              <?php echo Form::select('property_type',[2 => 'Flat/Apartment',10 => 'Commercial Properties', 12 => 'Offices'], null, array('class' => 'form-control multiselect', 'id' => 'unit_type', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              <?php echo Form::label('Unit #', 'Unit #', array('class'=>'control-label')); ?>

                              <?php echo Form::text('serial', null, array('class' => 'form-control', 'placeholder' => 'Enter unit number', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Landlord', 'Landlord', array('class'=>'control-label')); ?>

                              <select name="landlord" class="form-control multiselect">
                                 <option value="">Choose Landlord</option>
                                 <?php $__currentLoopData = $landlords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $landlord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $landlord->customerID; ?>"><?php echo $landlord->customer_name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Year built', 'Year built', array('class'=>'control-label')); ?>

                              <select name="year_built" class="form-control multiselect">
                                 <option value=""> Choose Year</option>
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
                              <label for="">Ownership Type</label>
                              <?php echo Form::select('ownwership_type', ['' => 'choose type','single' => 'Single Ownership','multi' => 'multi-ownership'],null,['class' => 'form-control multiselect'] ); ?>

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
                              <?php echo Form::label('Market Price', 'Market Price', array('class'=>'control-label')); ?>

                              <?php echo Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-4 remove-on-commercial">
                           <div class="form-group form-group-default required" id="single">
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
                              <?php echo Form::label('Furnished', 'Furnished', array('class'=>'control-label')); ?>

                              <?php echo Form::select('funished', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Smoking', 'Smoking', array('class'=>'control-label')); ?>

                              <?php echo Form::select('smoking', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                        <div class="col-md-4 remove-on-commercial">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Laundry', 'Laundry', array('class'=>'control-label')); ?>

                              <?php echo Form::select('laundry', ['' => 'Choose', 'None' => 'None', 'In unit' => 'In unit', 'Shared' => 'Shared'], null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <p class="font-weight-bold">Features</p>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckAir" value="Air conditioning">
                              <label class="custom-control-label" for="customCheckAir">Air conditioning</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckBalcony" value="Balcony, deck, patio">
                              <label class="custom-control-label" for="customCheckBalcony">Balcony, deck, patio</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCable" value="Cable ready">
                              <label class="custom-control-label" for="customCheckCable">Cable ready</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCarpet" value="Carpet">
                              <label class="custom-control-label" for="customCheckCarpet">Carpet</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCeiling" value="Ceiling">
                              <label class="custom-control-label" for="customCheckCeiling">Ceiling Fans</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCentral" value="Central Heating">
                              <label class="custom-control-label" for="customCheckCentral">Central Heating</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDishwasher" value="Dishwasher">
                              <label class="custom-control-label" for="customCheckDishwasher">Dishwasher</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFenced" value="Fenced yard">
                              <label class="custom-control-label" for="customCheckFenced">Fenced yard</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFireplace" value="Fireplace">
                              <label class="custom-control-label" for="customCheckFireplace">Fireplace</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckGarbage" value="Garbage Disposal">
                              <label class="custom-control-label" for="customCheckGarbage">Garbage Disposal</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckHardwood" value="Hardwood floors">
                              <label class="custom-control-label" for="customCheckHardwood">Hardwood floors</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckInternet" value="Internet">
                              <label class="custom-control-label" for="customCheckInternet">Internet</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckMicrowave" value="Microwave">
                              <label class="custom-control-label" for="customCheckMicrowave">Microwave</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckOven" value="Oven/range">
                              <label class="custom-control-label" for="customCheckOven">Oven/range</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckRefrigerator" value="Refrigerator">
                              <label class="custom-control-label" for="customCheckRefrigerator">Refrigerator</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStainless" value="Stainless Steel Appliance">
                              <label class="custom-control-label" for="customCheckStainless">Stainless Steel Appliance</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage" valu="Storage">
                              <label class="custom-control-label" for="customCheckStorage">Storage</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStove" value="Stove">
                              <label class="custom-control-label" for="customCheckStove">Stove</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTelephone" value="Telephone">
                              <label class="custom-control-label" for="customCheckTelephone">Telephone</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTile" value="Tile">
                              <label class="custom-control-label" for="customCheckTile">Tile</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTowels" value="Towels">
                              <label class="custom-control-label" for="customCheckTowels">Towels</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckVacuum" value="Vacuum Cleaner">
                              <label class="custom-control-label" for="customCheckVacuum">Vacuum Cleaner</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckclosets" value="Walk-in closets">
                              <label class="custom-control-label" for="customCheckclosets">Walk-in closets</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDryer" value="Washer/Dryer">
                              <label class="custom-control-label" for="customCheckDryer">Washer/Dryer</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckWindow" value="Window Coverings">
                              <label class="custom-control-label" for="customCheckWindow">Window Coverings</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckYard" value="Yard">
                              <label class="custom-control-label" for="customCheckYard">Yard</label>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="col-md-12">
                        <div class="form-group">
                           <?php echo Form::label('Property Description', 'Property Description', array('class'=>'control-label')); ?>

                           <?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor')); ?>

                        </div>
                     </div> 
                     <div class="col-md-12">
                        <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Unit</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      $(document).ready(function() {
         $('#unit_type').on('change', function() {
            if (this.value == 10 || this.value == 12) {
               $('.remove-on-commercial').hide();
            }else{
               $('.remove-on-commercial').show();
            }
         });
      });
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/units/create.blade.php ENDPATH**/ ?>