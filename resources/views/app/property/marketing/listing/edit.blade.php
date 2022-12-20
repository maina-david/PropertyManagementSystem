@extends('layouts.app')
@section('title','Marketing | Edit ')
@section('sidebar')
	@include('app.property.partials._menu')
@endsection
@section('stylesheet')
   <style>
      .map_canvas {
         width: 100%;
         height: 300px;
      }
   </style>
@endsection

@section('content')
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
            {!! Form::model($property, ['route' => ['list.property.update'], 'method'=>'post']) !!}
               @csrf
               <input type="hidden" name="propertyID" value="{!! $property->propertyID !!}">
               <input type="hidden" name="listID" value="{!! $property->listID !!}">
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Listing Name', 'Listing Name', array('class'=>'control-label text-danger')) !!}
                        {!! Form::text('list_title',null, array('class' => 'form-control', 'required' => '')) !!}
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Listing Category', 'Listing Category', array('class'=>'control-label text-danger')) !!}
                        {!! Form::select('category',['For Rent' => 'For Rent','For Sale' => 'For Sale'], null, array('class' => 'form-control multiselect','required' => '')) !!}
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Listing Type', 'Listing Type', array('class'=>'control-label text-danger')) !!}
                        <input type="text" class="form-control" value="{!! $unitType->name !!}" disabled>
                     </div>
                  </div>
                  @if($property->property_type == 11 || $property->property_type == 12) @else
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           {!! Form::label('Year built', 'Year built', array('class'=>'control-label')) !!}
                           <select name="year_built" class="form-control multiselect">
                              @if($property->year_built != "")
                                 <option value="{!! $property->year_built !!}"> {!! $property->year_built !!}</option>
                              @else
                                 <option value=""> Choose Year</option>
                              @endif
                              @php
                                 for($i = date('Y'); $i >= date('Y') - 80; $i--){
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                 }
                              @endphp
                           </select>
                        </div>
                     </div>
                  @endif
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Listing Start Date</label>
                        {!! Form::date('start_date', null,['class' => 'form-control'] ) !!}
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Listing End Date</label>
                        {!! Form::date('end_date', null,['class' => 'form-control'] ) !!}
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
                        {!! Form::label('Lisitng Price', 'Listing Price', array('class'=>'control-label text-danger')) !!}
                        {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount', 'required' => '')) !!}
                     </div>
                  </div>
                  @if($property->property_type == 2 || $property->property_type == 4 || $property->property_type == 5 || $property->property_type == 12)
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           {!! Form::label('Size, sq.ft', 'Size, sq.ft', array('class'=>'control-label')) !!}
                           {!! Form::number('size', null, array('class' => 'form-control', 'placeholder' => 'Enter size')) !!}
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           {!! Form::label('Furnished', 'Furnished', array('class'=>'control-label')) !!}
                           {!! Form::select('furnished', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')) !!}
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           {!! Form::label('Smoking', 'Smoking', array('class'=>'control-label')) !!}
                           {!! Form::select('smoking', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')) !!}
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           {!! Form::label('Parking size', 'Parking size', array('class'=>'control-label')) !!}
                           {!! Form::number('parking_size', null, array('class' => 'form-control')) !!}
                        </div>
                     </div>
                  @endif
                  @if($property->property_type == 2 || $property->property_type == 4 || $property->property_type == 5)
                     <div class="col-md-4 remove-on-commercial">
                        <div class="form-group form-group-default required" id="single">
                           {!! Form::label('Bedrooms', 'Bedrooms', array('class'=>'control-label text-danger')) !!}
                           {!! Form::number('bedrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bedrooms','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-4 remove-on-commercial">
                        <div class="form-group form-group-default" id="single">
                           {!! Form::label('Bathrooms', 'Bathrooms', array('class'=>'control-label text-danger')) !!}
                           {!! Form::number('bathrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bathrooms')) !!}
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           {!! Form::label('Laundry', 'Laundry', array('class'=>'control-label')) !!}
                           {!! Form::select('laundry', ['' => 'Choose', 'None' => 'None', 'In unit' => 'In unit', 'Shared' => 'Shared'], null, array('class' => 'form-control')) !!}
                        </div>
                     </div>
                  @endif
                  @if($property->property_type == 11)
                     <div class="col-md-4">
                        <div class="form-group land form-group-default">
                           {!! Form::label('Land Size', 'Land Size', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('land_size', null, array('class' => 'form-control', 'placeholder' => 'Land Size')) !!}
                        </div>
                     </div>
                  @endif


               </div>
               <div class="row">
                  <div class="col-md-12">
                     <hr>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckAir" value="Air conditioning" @if(strpos($property->features, 'Air conditioning') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckAir">Air conditioning</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckBalcony" value="Balcony, deck, patio" @if(strpos($property->features, 'Balcony, deck, patio') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckBalcony">Balcony, deck, patio</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCable" value="Cable ready" @if(strpos($property->features, 'Cable ready') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckCable">Cable ready</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCarpet" value="Carpet" @if(strpos($property->features, 'Cable ready') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckCarpet">Carpet</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCeiling" value="Ceiling Fans" @if(strpos($property->features, 'Ceiling Fans') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckCeiling">Ceiling Fans</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCentral" value="Central Heating" @if(strpos($property->features, 'Central Heating') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckCentral">Central Heating</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDishwasher" value="Dishwasher" @if(strpos($property->features, 'Dishwasher') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckDishwasher">Dishwasher</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFenced" value="Fenced yard" @if(strpos($property->features, 'Fenced yard') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckFenced">Fenced yard</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFireplace" value="Fireplace" @if(strpos($property->features, 'Fireplace') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckFireplace">Fireplace</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckGarbage" value="Garbage Disposal" @if(strpos($property->features, 'Garbage Disposal') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckGarbage">Garbage Disposal</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckHardwood" value="Hardwood floors" @if(strpos($property->features, 'Hardwood floors') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckHardwood">Hardwood floors</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckInternet" value="Internet" @if(strpos($property->features, 'Internet') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckInternet">Internet</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckMicrowave" value="Microwave" @if(strpos($property->features, 'Microwave') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckMicrowave">Microwave</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckOven" value="Oven/range" @if(strpos($property->features, 'Oven/range') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckOven">Oven/range</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckRefrigerator" value="Refrigerator" @if(strpos($property->features, 'Refrigerator') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckRefrigerator">Refrigerator</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStainless" value="Stainless Steel Appliance" @if(strpos($property->features, 'Stainless Steel Appliance') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckStainless">Stainless Steel Appliance</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage" valu="Storage" @if(strpos($property->features, 'Storage') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckStorage">Storage</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStove" value="Stove" @if(strpos($property->features, 'Stove') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckStove">Stove</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTelephone" value="Telephone" @if(strpos($property->features, 'Telephone') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckTelephone">Telephone</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTile" value="Tile" @if(strpos($property->features, 'Tile') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckTile">Tile</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTowels" value="Towels" @if(strpos($property->features, 'Towels') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckTowels">Towels</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckVacuum" value="Vacuum Cleaner" @if(strpos($property->features, 'Vacuum Cleaner') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckVacuum">Vacuum Cleaner</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckclosets" value="Walk-in closets" @if(strpos($property->features, 'Walk-in closets') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckclosets">Walk-in closets</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDryer" value="Washer/Dryer" @if(strpos($property->features, 'Washer/Dryer') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckDryer">Washer/Dryer</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckWindow" value="Window Coverings" @if(strpos($property->features, 'Window Coverings') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckWindow">Window Coverings</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckYard" value="Yard" @if(strpos($property->features, 'Yard') !== false) checked @endif>
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
                        {!! Form::text('geolocation', null, array('class' => 'form-control', 'id' => 'location', 'placeholder' => 'Nairobi, Kenya')) !!}
                     </div>
                     <div class="form-group">
                        <label for="">Latitude</label>
                        <input type="text" class="form-control" name="lat" value="{!! $property->latitude !!}" data-geo="lat" readonly>
                     </div>
                     <div class="form-group">
                        <label for="">Longitude</label>
                        <input type="text" class="form-control" value="{!! $property->longitude !!}" name="lng" data-geo="lng" readonly>
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
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckClub" value="Club house"  @if(strpos($property->amenities, 'Club house') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckClub">Club house</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckElevator" value="Elevator" @if(strpos($property->amenities, 'Elevator') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckElevator">Elevator</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customChecklaundry" value="In unit laundry" @if(strpos($property->amenities, 'In unit laundry') !== false) checked @endif>
                        <label class="custom-control-label" for="customChecklaundry">In unit laundry</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customPool" value="Pool" @if(strpos($property->amenities, 'Pool') !== false) checked @endif>
                        <label class="custom-control-label" for="customPool">Pool</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customTennis" value="Tennis court" @if(strpos($property->amenities, 'Tennis court') !== false) checked @endif>
                        <label class="custom-control-label" for="customTennis">Tennis court</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customDoor" value="Door attendant" @if(strpos($property->amenities, 'Door attendant') !== false) checked @endif>
                        <label class="custom-control-label" for="customDoor">Door attendant</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckFitness" value="Fitness center" @if(strpos($property->amenities, 'Fitness center') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckFitness">Fitness center</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckParking" value="Off-street Parking" @if(strpos($property->amenities, 'Off-street Parking') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckParking">Off-street Parking</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckStorageAM" value="Storage" @if(strpos($property->amenities, 'Storage') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckStorageAM">Storage</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckWheelchair" value="Wheelchair access" @if(strpos($property->amenities, 'Wheelchair access') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckWheelchair">Wheelchair access</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckRooftop" value="Rooftop patio" @if(strpos($property->amenities, 'Rooftop patio') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckRooftop">Rooftop patio</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckPlayground" value="Playground" @if(strpos($property->amenities, 'Playground') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckPlayground">Playground</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckHot" value="Hot tub" @if(strpos($property->amenities, 'Hot tub') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckHot">Hot tub</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckBbq" value="Bbq area" @if(strpos($property->amenities, 'Bbq area') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckBbq">Bbq area</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckHOA" value="In an HOA" @if(strpos($property->amenities, 'In an HOA') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckHOA">In an HOA</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckDog" value="Dog Park" @if(strpos($property->amenities, 'Dog Park') !== false) checked @endif>
                        <label class="custom-control-label" for="customCheckDog">Dog Park</label>
                     </div>
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckJogging" value="Jogging Trails" @if(strpos($property->amenities, 'Jogging Trails') !== false) checked @endif>
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
                        {!! Form::textarea('description', null, array('class' => 'form-control my-editor')) !!}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Listing</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                  </div>
               </div>
            {!! Form::close() !!}
         </div>
         <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="col-md-12">
               <div class="row mt-2">
                  <div class="col-md-12 mb-3">
                     <a href="" class="btn btn-warning" data-toggle="modal" data-target="#addImage"><i class="fal fa-images"></i> Add Images</a>
                  </div>
                  @foreach ($images as $image)
                     <div class="col-md-3">
                        <div class="card">
                           <div class="card-body image-card">
                              <img alt="image" class="img-responsive" src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$parent->property_code.'/images/'.$image->file_name) !!}">
                           </div>
                           <div class="card-footer">
                              @if(Property::check_cover_property_image($property->id,$image->id) == 1)
                                 <a class="btn btn-sm btn-success" href=""><i class="fal fa-check-circle"></i> Cover Image</a>
                              @else
                                 <a class="btn btn-sm btn-primary delete" href="{!! route('list.property.image.cover',[$property->id,$image->id]) !!}">Make Cover</a>
                              @endif
                              <a href="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$parent->property_code.'/images/'.$image->file_name) !!}" class="btn btn-sm btn-warning" target="_blank"><i class="far fa-eye"></i></a>
                              <a class="btn btn-sm btn-danger delete" href="{!! route('list.property.delete.image',[$property->id,$image->id]) !!}"><i class="fas fa-trash"></i></a>
                           </div>
                        </div>
                     </div>
                  @endforeach
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
                     <form action="{!! route('property.images.upload',$property->propertyID) !!}" class="dropzone" id="my-awesome-dropzone" method="post">
                        @csrf()
                        <input type="hidden" value="{!! $property->propertyID !!}" name="propertyID">
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
@endsection
@section('scripts')
   <script>
      var latitude = "{!! $property->latitude !!}";
      var longitude = "{!! $property->longitude !!}";
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
@endsection
