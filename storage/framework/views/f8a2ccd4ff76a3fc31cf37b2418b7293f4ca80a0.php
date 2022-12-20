<?php $__env->startSection('title','Marketing | Edit '); ?>
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
         <li class="breadcrumb-item"><a href="javascript:void(0)">Marketing</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Lisitng</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullhorn"></i> Marketing - Edit Listing </h1>
      <ul class="nav nav-pills">
         <li class="nav-items">
            <a href="#nav-home" data-toggle="tab" class="nav-link active">
               <span class="d-sm-none"><i class="fal fa-info-circle"></i> Property Information</span>
               <span class="d-sm-block d-none"><i class="fal fa-info-circle"></i> Property Information</span>
            </a>
         </li>
         <li class="nav-items">
            <a href="#nav-profile" data-toggle="tab" class="nav-link">
               <span class="d-sm-none"><i class="fal fa-images"></i> Property Images</span>
               <span class="d-sm-block d-none"><i class="fal fa-images"></i> Property Images</span>
            </a>
         </li>
      </ul>
      <div class="tab-content" id="nav-tabContent">
         <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <?php echo Form::model($property, ['route' => ['list.property.update'], 'method'=>'post']); ?>

               <?php echo csrf_field(); ?>
               <input type="hidden" name="propertyID" value="<?php echo $property->propertyID; ?>">
               <input type="hidden" name="listID" value="<?php echo $property->listID; ?>">
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Listing Name', 'Listing Name', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::text('list_title',null, array('class' => 'form-control', 'required' => '')); ?>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Listing Category', 'Listing Category', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::select('category',['For Rent' => 'For Rent','For Sale' => 'For Sale'], null, array('class' => 'form-control multiselect','required' => '')); ?>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Listing Type', 'Listing Type', array('class'=>'control-label text-danger')); ?>

                        <input type="text" class="form-control" value="<?php echo $unitType->name; ?>" disabled>
                     </div>
                  </div>
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
                        <label for="" class="text-danger">Listing Start Date</label>
                        <?php echo Form::date('start_date', null,['class' => 'form-control'] ); ?>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Listing End Date</label>
                        <?php echo Form::date('end_date', null,['class' => 'form-control'] ); ?>

                     </div>
                  </div>

               </div>
               <div class="row">
                  <div class="col-md-12">
                     <hr>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Lisitng Price', 'Listing Price', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount', 'required' => '')); ?>

                     </div>
                  </div>
                  <?php if($property->property_type == 2 || $property->property_type == 4 || $property->property_type == 5 || $property->property_type == 12): ?>
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Size, sq.ft', 'Size, sq.ft', array('class'=>'control-label')); ?>

                           <?php echo Form::number('size', null, array('class' => 'form-control', 'placeholder' => 'Enter size')); ?>

                        </div>
                     </div>
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
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Parking size', 'Parking size', array('class'=>'control-label')); ?>

                           <?php echo Form::number('parking_size', null, array('class' => 'form-control')); ?>

                        </div>
                     </div>
                  <?php endif; ?>
                  <?php if($property->property_type == 2 || $property->property_type == 4 || $property->property_type == 5): ?>
                     <div class="col-md-4 remove-on-commercial">
                        <div class="form-group form-group-default required" id="single">
                           <?php echo Form::label('Bedrooms', 'Bedrooms', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::number('bedrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bedrooms','required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-4 remove-on-commercial">
                        <div class="form-group form-group-default" id="single">
                           <?php echo Form::label('Bathrooms', 'Bathrooms', array('class'=>'control-label text-danger')); ?>

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
                  <?php if($property->property_type == 11): ?>
                     <div class="col-md-4">
                        <div class="form-group land form-group-default">
                           <?php echo Form::label('Land Size', 'Land Size', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('land_size', null, array('class' => 'form-control', 'placeholder' => 'Land Size')); ?>

                        </div>
                     </div>
                  <?php endif; ?>


               </div>
               <div class="row">
                  <div class="col-md-12">
                     <hr>
                  </div>
               </div>
               <div class="row">
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
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage" valu="Storage" <?php if(strpos($property->features, 'Storage') !== false): ?> checked <?php endif; ?>>
                        <label class="custom-control-label" for="customCheckStorage">Storage</label>
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
               <div class="row">
                  <div class="col-md-12">
                     <hr>
                  </div>
               </div>
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
                        <input type="text" class="form-control" name="lat" value="<?php echo $property->latitude; ?>" data-geo="lat" readonly>
                     </div>
                     <div class="form-group">
                        <label for="">Longitude</label>
                        <input type="text" class="form-control" value="<?php echo $property->longitude; ?>" name="lng" data-geo="lng" readonly>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <hr>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
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
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckStorageAM" value="Storage" <?php if(strpos($property->amenities, 'Storage') !== false): ?> checked <?php endif; ?>>
                        <label class="custom-control-label" for="customCheckStorageAM">Storage</label>
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
               <div class="row">
                  <div class="col-md-12">
                     <hr>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <?php echo Form::textarea('description', null, array('class' => 'form-control my-editor')); ?>

                     </div>
                  </div>
                  <div class="col-md-12">
                     <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Listing</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                  </div>
               </div>
            <?php echo Form::close(); ?>

         </div>
         <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="col-md-12">
               <div class="row mt-2">
                  <div class="col-md-12 mb-3">
                     <a href="" class="btn btn-warning" data-toggle="modal" data-target="#addImage"><i class="fal fa-images"></i> Add Images</a>
                  </div>
                  <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <div class="col-md-3">
                        <div class="card">
                           <div class="card-body image-card">
                              <img alt="image" class="img-responsive" src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$parent->property_code.'/images/'.$image->file_name); ?>">
                           </div>
                           <div class="card-footer">
                              <?php if(Property::check_cover_property_image($property->id,$image->id) == 1): ?>
                                 <a class="btn btn-sm btn-success" href=""><i class="fal fa-check-circle"></i> Cover Image</a>
                              <?php else: ?>
                                 <a class="btn btn-sm btn-primary delete" href="<?php echo route('list.property.image.cover',[$property->id,$image->id]); ?>">Make Cover</a>
                              <?php endif; ?>
                              <a href="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$parent->property_code.'/images/'.$image->file_name); ?>" class="btn btn-sm btn-warning" target="_blank"><i class="far fa-eye"></i></a>
                              <a class="btn btn-sm btn-danger delete" href="<?php echo route('list.property.delete.image',[$property->id,$image->id]); ?>"><i class="fas fa-trash"></i></a>
                           </div>
                        </div>
                     </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Upload Images</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form action="<?php echo route('property.images.upload',$property->propertyID); ?>" class="dropzone" id="my-awesome-dropzone" method="post">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" value="<?php echo $property->propertyID; ?>" name="propertyID">
                     </form>
                  </div>
                  <div class="modal-footer">
                     <a onClick="window.location.reload()" href="#" class="btn btn-success" onClick="refreshPage()">Save Images</a>
                  </div>
               </div>
               </div>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/marketing/listing/edit.blade.php ENDPATH**/ ?>