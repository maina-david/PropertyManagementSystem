<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Property Edit  <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('stylesheet'); ?>
   <style>
      .map_canvas { 
         width: 100%; 
         height: 300px; 
      }
   </style>    
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> Property</h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12">     
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
               <?php echo Form::model($property, ['route' => ['property.update',$property->id],'enctype'=>'multipart/form-data','method'=>'post','autocomplete' => '']); ?>

                  <?php echo csrf_field(); ?>
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title font-weight-bold">Property Information</h4>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('Property Type', 'Property Type', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::select('property_type', $type, null, array('class' => 'form-control multiselect', 'id' => 'type', 'placeholder' => 'Enter Property Name', 'required' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('Property Name', 'Property Name', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter Property Name', 'required' => '')); ?>

                              </div>
                           </div>
                           <?php if($property->property_type == 4 || $property->property_type == 2 || $property->property_type == 5): ?>
                              <div class="col-md-4">
                                 <div class="form-group form-group-default required">
                                    <?php echo Form::label('Landlord', 'Landlord', array('class'=>'control-label text-danger')); ?>

                                    <select name="landlord" class="form-control multiselect">
                                       <?php if($property->landlordID != ""): ?>
                                          <option value="<?php echo $property->landlordID; ?>">
                                             <?php echo Finance::client($property->landlordID)->customer_name; ?>

                                          </option>
                                       <?php else: ?>
                                          <option value="">Choose Landlord</option>
                                       <?php endif; ?>
                                       <?php $__currentLoopData = $landlords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $landlord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo $landlord->id; ?>"><?php echo $landlord->customer_name; ?></option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                 </div>
                              </div>
                           <?php endif; ?>
                           <?php if($property->property_type == 4 || $property->property_type == 2 || $property->property_type == 5): ?>
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Tenant', 'Tenant', array('class'=>'control-label')); ?>

                                    <input type="text" class="form-control" value="<?php if($property->tenantID != ""): ?><?php echo Property::tenant_info($property->tenantID)->tenant_name; ?> <?php else: ?> Vacant <?php endif; ?>" readonly>
                                 </div>
                              </div>
                           <?php endif; ?>
                           <?php if($property->property_type == 11 || $property->property_type == 12): ?> <?php else: ?>
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Year built', 'Year built', array('class'=>'control-label')); ?>

                                    <select name="year_built" class="form-control multiselect">
                                       <?php if($property->year_built != ""): ?>
                                          <option value="<?php echo $property->year_built; ?>"> <?php echo $property->year_built; ?></option>
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
                           <?php endif; ?>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('Street Address', 'Street Address', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::text('street_address', null, array('class' => 'form-control', 'placeholder' => 'Enter Address', 'required' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('City', 'City', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::text('city', null, array('class' => 'form-control', 'placeholder' => 'Enter Address', 'required' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('State/Region', 'State/Region', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::text('state', null, array('class' => 'form-control', 'placeholder' => 'Enter state', 'required' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('zip code', 'zip code', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('zip_code', null, array('class' => 'form-control', 'placeholder' => 'Enter zip code')); ?>

                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('Country', 'Country', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::select('countryID', $country, null, array('class' => 'form-control multiselect', 'required' => '')); ?>

                              </div>
                           </div>
                                          
                              <?php if($property->property_type == 11 || $property->property_type == 13 || $property->property_type == 14): ?> <?php else: ?> 
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                       <?php echo Form::label('Size, sq.ft', 'Size, sq.ft', array('class'=>'control-label')); ?>

                                       <?php echo Form::number('size', null, array('class' => 'form-control','step'=>'0.01', 'placeholder' => 'Enter size')); ?>

                                    </div>
                                 </div>
                              <?php endif; ?>
                              <?php if($property->property_type == 13 || $property->property_type == 14 || $property->property_type == 11): ?> <?php else: ?>
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                       <?php echo Form::label('Parking', 'Parking', array('class'=>'control-label')); ?>

                                       <?php echo Form::number('parking_size', null, array('class' => 'form-control', 'placeholder' => 'Enter parking number')); ?>

                                    </div>
                                 </div>
                              <?php endif; ?>
                              <?php if($property->property_type == 13 || $property->property_type == 14): ?> <?php else: ?>
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                       <?php echo Form::label('Market Price', ' Market Price', array('class'=>'control-label text-danger')); ?>

                                       <?php echo Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount')); ?>

                                    </div>
                                 </div>
                              <?php endif; ?>
                              <?php if($property->property_type == 2 || $property->property_type == 4 || $property->property_type == 5): ?>
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                       <?php echo Form::label('Bedrooms', 'Bedrooms', array('class'=>'control-label')); ?>

                                       <?php echo Form::number('bedrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bedrooms')); ?>

                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                       <?php echo Form::label('Bathrooms', 'Bathrooms', array('class'=>'control-label')); ?>

                                       <?php echo Form::number('bathrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bathrooms')); ?>

                                    </div>
                                 </div>
                              <?php endif; ?>
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Image', 'Property Image', array('class'=>'control-label')); ?>

                                    <input type="file" name="image" id="thumbnail" accept="image/*">
                                    <?php if($property->image != ""): ?>
                                       <a href="<?php echo route('property.remove.image',$property->id); ?>" class="text-danger">Remove image</a>
                                    <?php endif; ?>
                                 </div>
                              </div> 
                              <?php if($property->property_type == 11): ?> 
                                 <div class="col-md-4">
                                    <div class="form-group land form-group-default">
                                       <?php echo Form::label('Land Size', 'Land Size', array('class'=>'control-label text-danger')); ?>

                                       <?php echo Form::text('land_size', null, array('class' => 'form-control', 'placeholder' => 'Land Size')); ?>

                                    </div>
                                 </div>
                              <?php endif; ?>
                           </div>
                        <?php if($property->property_type == 4 || $property->property_type == 2 || $property->property_type == 5 || $property->property_type == 12): ?>
                           <hr>
                           <div class="row">
                              <div class="col-md-12">
                                 <h4>Features</h4>
                              </div>
                              <div class="col-md-3">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckAir" value="Air conditioning" <?php if(strpos($property->features, 'Air conditioning') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckAir">Air conditioning</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckBalcony" value="Balcony, deck, patio" <?php if(strpos($property->features, 'Balcony, deck, patio') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckBalcony">Balcony, deck, patio</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCable" value="Cable ready" <?php if(strpos($property->features, 'Cable ready') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckCable">Cable ready</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCarpet" value="Carpet" <?php if(strpos($property->features, 'Cable ready') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckCarpet">Carpet</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCeiling" value="Ceiling Fans" <?php if(strpos($property->features, 'Ceiling Fans') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckCeiling">Ceiling Fans</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCentral" value="Central Heating" <?php if(strpos($property->features, 'Central Heating') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckCentral">Central Heating</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDishwasher" value="Dishwasher" <?php if(strpos($property->features, 'Dishwasher') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckDishwasher">Dishwasher</label>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFenced" value="Fenced yard" <?php if(strpos($property->features, 'Fenced yard') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckFenced">Fenced yard</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFireplace" value="Fireplace" <?php if(strpos($property->features, 'Fireplace') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckFireplace">Fireplace</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckGarbage" value="Garbage Disposal" <?php if(strpos($property->features, 'Garbage Disposal') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckGarbage">Garbage Disposal</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckHardwood" value="Hardwood floors" <?php if(strpos($property->features, 'Hardwood floors') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckHardwood">Hardwood floors</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckInternet" value="Internet" <?php if(strpos($property->features, 'Internet') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckInternet">Internet</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckMicrowave" value="Microwave" <?php if(strpos($property->features, 'Microwave') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckMicrowave">Microwave</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckOven" value="Oven/range" <?php if(strpos($property->features, 'Oven/range') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckOven">Oven/range</label>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckRefrigerator" value="Refrigerator" <?php if(strpos($property->features, 'Refrigerator') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckRefrigerator">Refrigerator</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStainless" value="Stainless Steel Appliance" <?php if(strpos($property->features, 'Stainless Steel Appliance') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckStainless">Stainless Steel Appliance</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage1" valu="Storage" <?php if(strpos($property->features, 'Storage') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckStorage1">Storage</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStove" value="Stove" <?php if(strpos($property->features, 'Stove') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckStove">Stove</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTelephone" value="Telephone" <?php if(strpos($property->features, 'Telephone') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckTelephone">Telephone</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTile" value="Tile" <?php if(strpos($property->features, 'Tile') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckTile">Tile</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTowels" value="Towels" <?php if(strpos($property->features, 'Towels') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckTowels">Towels</label>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckVacuum" value="Vacuum Cleaner" <?php if(strpos($property->features, 'Vacuum Cleaner') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckVacuum">Vacuum Cleaner</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckclosets" value="Walk-in closets" <?php if(strpos($property->features, 'Walk-in closets') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckclosets">Walk-in closets</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDryer" value="Washer/Dryer" <?php if(strpos($property->features, 'Washer/Dryer') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckDryer">Washer/Dryer</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckWindow" value="Window Coverings" <?php if(strpos($property->features, 'Window Coverings') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckWindow">Window Coverings</label>
                                 </div>
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckYard" value="Yard" <?php if(strpos($property->features, 'Yard') !== false): ?> checked <?php endif; ?>>
                                    <label class="custom-control-label" for="customCheckYard">Yard</label>
                                 </div>
                              </div>
                           </div>
                        <?php endif; ?>
                        <?php if($property->property_type == 1): ?>
                           <hr>
                           <div class="row">
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
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Laundry', 'Laundry', array('class'=>'control-label')); ?>

                                    <?php echo Form::select('laundry', ['' => 'Choose', 'None' => 'None', 'In unit' => 'In unit', 'Shared' => 'Shared'], null, array('class' => 'form-control')); ?>

                                 </div>
                              </div>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>
                  <div class="panel panel-default">
                     <div class="panel-heading">                        
                        <h4 class="panel-title">Property Contact information</h4>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                 <strong>Tip !</strong> This is the information that will be displayed on the billing invoices repated to this property
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('Management name', 'Management name', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::text('management_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name', 'required' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('email', 'Email', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::text('management_email', null, array('class' => 'form-control', 'placeholder' => 'Enter email', 'required' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('phone', 'Phone number', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::text('management_phonenumber', null, array('class' => 'form-control', 'placeholder' => 'Enter phone number', 'required' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('postal address', 'Postal Address', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('management_postaladdress', null, array('class' => 'form-control', 'placeholder' => 'Enter postal address')); ?>

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title font-weight-bold">Property Amenities</h4>
                     </div>
                     <div class="panel-body">               
                        <div class="row">
                           <div class="col-md-3">
                              <div class="custom-control custom-checkbox none">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckClub1" value="Club house2"  <?php if(strpos($property->amenities, 'Club house2') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckClub1">Club house</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckClub" value="Club house"  <?php if(strpos($property->amenities, 'Club house') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckClub">Club house</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckElevator" value="Elevator" <?php if(strpos($property->amenities, 'Elevator') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckElevator">Elevator</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customChecklaundry" value="In unit laundry" <?php if(strpos($property->amenities, 'In unit laundry') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customChecklaundry">In unit laundry</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customPool" value="Pool" <?php if(strpos($property->amenities, 'Pool') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customPool">Pool</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customTennis" value="Tennis court" <?php if(strpos($property->amenities, 'Tennis court') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customTennis">Tennis court</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customDoor" value="Door attendant" <?php if(strpos($property->amenities, 'Door attendant') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customDoor">Door attendant</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckFitness" value="Fitness center" <?php if(strpos($property->amenities, 'Fitness center') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckFitness">Fitness center</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckParking" value="Off-street Parking" <?php if(strpos($property->amenities, 'Off-street Parking') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckParking">Off-street Parking</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckStorage" value="Storage" <?php if(strpos($property->amenities, 'Off-street Parking') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckStorage">Storage</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckWheelchair" value="Wheelchair access" <?php if(strpos($property->amenities, 'Wheelchair access') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckWheelchair">Wheelchair access</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckRooftop" value="Rooftop patio" <?php if(strpos($property->amenities, 'Rooftop patio') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckRooftop">Rooftop patio</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckPlayground" value="Playground" <?php if(strpos($property->amenities, 'Playground') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckPlayground">Playground</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckHot" value="Hot tub" <?php if(strpos($property->amenities, 'Hot tub') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckHot">Hot tub</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckBbq" value="Bbq area" <?php if(strpos($property->amenities, 'Bbq area') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckBbq">Bbq area</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckHOA" value="In an HOA" <?php if(strpos($property->amenities, 'In an HOA') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckHOA">In an HOA</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckDog" value="Dog Park" <?php if(strpos($property->amenities, 'Dog Park') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckDog">Dog Park</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckJogging" value="Jogging Trails" <?php if(strpos($property->amenities, 'Jogging Trails') !== false): ?> checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckJogging">Jogging Trails</label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title font-weight-bold">Property Location</h4>
                     </div>
                     <div class="panel-body">  
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row" id="mapform">
                                 <div class="col-md-6">
                                    <div class="map_canvas" id="map" ></div>
                                 </div>
                                 <div class="col-md-6">                           
                                    <div class="form-group">
                                       <label for="address-autocomplete">Google map location</label>
                                       <?php echo Form::text('geolocation', null, array('class' => 'form-control', 'id' => 'location', 'placeholder' => 'Nairobi, Kenya')); ?>

                                    </div>
                                    <div class="form-group">
                                       <label for="">Latitude</label>
                                       <input type="text" value="<?php echo $property->latitude; ?>" class="form-control" name="lat" data-geo="lat" readonly>
                                    </div>
                                    <div class="form-group">
                                       <label for="">Longitude</label>
                                       <input type="text" value="<?php echo $property->longitude; ?>" class="form-control" name="lng" data-geo="lng" readonly>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title font-weight-bold">Property Description</h4>
                     </div>
                     <div class="panel-body">  
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor')); ?>

                              </div>
                           </div>
                           <div class="col-md-12">
                              <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Property</button>
                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                           </div>
                        </div>
                     </div>         
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script>
      var latitude = "<?php echo $property->latitude; ?>";
      var longitude = "<?php echo $property->longitude; ?>";
      var setloc = new google.maps.LatLng(latitude,longitude);
      
      $('#location').geocomplete({
         map: '#map',
         details: "form",
         location: setloc,
         detailsAttribute:"data-geo",
         mapOptions: {
            zoom: 15
         },
         markerOptions: {
            draggable: true
         }
      });
      $("#location").bind("geocode:dragged", function(event, latLng){
         $("input[name=lat]").val(latLng.lat());
         $("input[name=lng]").val(latLng.lng());
      });
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/edit.blade.php ENDPATH**/ ?>