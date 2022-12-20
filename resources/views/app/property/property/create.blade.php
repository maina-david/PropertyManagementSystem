@extends('layouts.app')
{{-- page header --}}
@section('title') Propery | Add  @endsection
{{-- page styles --}}
@section('stylesheet')
   <style>
      .map_canvas {
         width: 100%;
         height: 300px;
      }
   </style>
@endsection
@section('sidebar')
	@include('app.property.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">Add</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> Propery | Add</h1>
      <div class="row">
         <div class="col-md-12">
            @include('partials._messages')
            {!! Form::open(array('route' => 'property.store','enctype'=>'multipart/form-data','method'=>'post','autocomplete' => '')) !!}
               {!! csrf_field() !!}
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">General Information</h4>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('Property Type', 'Property Type', array('class'=>'control-label text-danger')) !!}
                              <select name="property_type" id="type" class="form-control multiselect" required>
                                 <option value="">Choose</option>
                                 <option value="13">Multiple Commercial Units</option>
                                 <option value="14">Multiple Residential Units</option>
                                 @foreach($types as $type)
                                    <option value="{!! $type->id !!}">{!! $type->name !!}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('Property Name', 'Property Name', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter Property Name', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 single" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Landlord', 'Landlord', array('class'=>'control-label')) !!}
                              <select name="landlord" class="form-control multiselect">
                                 <option value="">Choose Landlord</option>
                                 @foreach ($landlords as $landlord)
                                    <option value="{!! $landlord->customerID !!}">{!! $landlord->customer_name !!}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4 single commercial" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Year built', 'Year built', array('class'=>'control-label')) !!}
                              <select name="year_built" class="form-control multiselect">
                                 <option value=""> Choose Year</option>
                                 @php
                                    for($i = date('Y'); $i >= date('Y') - 80; $i--){
                                       echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                 @endphp
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('Street Address', 'Street Address', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('street_address', null, array('class' => 'form-control', 'placeholder' => 'Enter Address', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('City', 'City', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('city', null, array('class' => 'form-control', 'placeholder' => 'Enter Address', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('State/Region', 'State/Region', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('state', null, array('class' => 'form-control', 'placeholder' => 'Enter state', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('zip code', 'zip code', array('class'=>'control-label')) !!}
                              {!! Form::text('zip_code', null, array('class' => 'form-control', 'placeholder' => 'Enter zip code')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('Country', 'Country', array('class'=>'control-label text-danger')) !!}
                              {!! Form::select('country', $country, null, array('class' => 'form-control multiselect', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Image', 'Property Image', array('class'=>'control-label')) !!}
                              <input type="file" name="image" id="thumbnail" accept="image/*">
                           </div>
                        </div>
                        <div class="col-md-12">
                           <hr>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-4 office single commercial" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Size, sq.ft', 'Size, sq.ft', array('class'=>'control-label')) !!}
                              {!! Form::number('size', null, array('class' => 'form-control', 'step'=>'0.01','placeholder' => 'Enter size')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 office single commercial" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Parking', 'Parking', array('class'=>'control-label')) !!}
                              {!! Form::number('parking_size', null, array('class' => 'form-control', 'placeholder' => 'Enter parking number')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Market Price', 'Market Price', array('class'=>'control-label text-danger')) !!}
                              {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 single" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Bedrooms', 'Bedrooms', array('class'=>'control-label text-danger')) !!}
                              {!! Form::number('bedrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bedrooms')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 single" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Bathrooms', 'Bathrooms', array('class'=>'control-label text-danger')) !!}
                              {!! Form::number('bathrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bathrooms')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 land" style="display:none">
                           <div class="form-group land form-group-default">
                              {!! Form::label('Land Size', 'Land Size', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('land_size', null, array('class' => 'form-control', 'placeholder' => 'Land Size')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 office single" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Furnished', 'Furnished', array('class'=>'control-label')) !!}
                              {!! Form::select('furnished', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 single" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Smoking', 'Smoking', array('class'=>'control-label')) !!}
                              {!! Form::select('smoking', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 single" style="display:none">
                           <div class="form-group form-group-default">
                              {!! Form::label('Laundry', 'Laundry', array('class'=>'control-label')) !!}
                              {!! Form::select('laundry', ['' => 'Choose', 'None' => 'None', 'In unit' => 'In unit', 'Shared' => 'Shared'], null, array('class' => 'form-control')) !!}
                           </div>
                        </div>
                     </div>
                     <div class="row office single" style="display:none">
                        <div class="col-md-12">
                           <hr>
                        </div>
                        <div class="col-md-12">
                           <h5>Features</h5>
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
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCeiling" value="Ceiling Fans">
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
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage1" valu="Storage">
                              <label class="custom-control-label" for="customCheckStorage1">Storage</label>
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
                        <div class="col-md-12">
                           <hr>
                        </div>
                     </div>
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
                              {!! Form::label('Management name', 'Management name', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('management_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('email', 'Email', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('management_email', null, array('class' => 'form-control', 'placeholder' => 'Enter email', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('phone', 'Phone number', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('management_phonenumber', null, array('class' => 'form-control', 'placeholder' => 'Enter phone number', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('postal address', 'Postal Address', array('class'=>'control-label')) !!}
                              {!! Form::text('management_postaladdress', null, array('class' => 'form-control', 'placeholder' => 'Enter postal address')) !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Amenities</h4>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckClub" value="Club house">
                              <label class="custom-control-label" for="customCheckClub">Club house</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckElevator" value="Elevator">
                              <label class="custom-control-label" for="customCheckElevator">Elevator</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customChecklaundry" value="In unit laundry">
                              <label class="custom-control-label" for="customChecklaundry">In unit laundry</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheck4" value="Pool">
                              <label class="custom-control-label" for="customCheck4">Pool</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheck5" value="Tennis court">
                              <label class="custom-control-label" for="customCheck5">Tennis court</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckDoor" value="Door attendant">
                              <label class="custom-control-label" for="customCheckDoor">Door attendant</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckFitness" value="Fitness center">
                              <label class="custom-control-label" for="customCheckFitness">Fitness center</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckParking" value="Off-street Parking">
                              <label class="custom-control-label" for="customCheckParking">Off-street Parking</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckStorage" value="Storage">
                              <label class="custom-control-label" for="customCheckStorage">Storage</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckWheelchair" value="Wheelchair access">
                              <label class="custom-control-label" for="customCheckWheelchair">Wheelchair access</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckRooftop" value="Rooftop patio">
                              <label class="custom-control-label" for="customCheckRooftop">Rooftop patio</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckPlayground" value="Playground">
                              <label class="custom-control-label" for="customCheckPlayground">Playground</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckHot" value="Hot tub">
                              <label class="custom-control-label" for="customCheckHot">Hot tub</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckBbq" value="Bbq area">
                              <label class="custom-control-label" for="customCheckBbq">Bbq area</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckHOA" value="In an HOA">
                              <label class="custom-control-label" for="customCheckHOA">In an HOA</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckDog" value="Dog Park">
                              <label class="custom-control-label" for="customCheckDog">Dog Park</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckJogging" value="Jogging Trails">
                              <label class="custom-control-label" for="customCheckJogging">Jogging Trails</label>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Property Google map Location</h4>
                  </div>
                  <div class="panel-body">
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
                              <input type="text" class="form-control" name="lat" data-geo="lat" readonly>
                           </div>
                           <div class="form-group">
                              <label for="">Longitude</label>
                              <input type="text" class="form-control" name="lng" data-geo="lng" readonly>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Property Description</h4>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              {!! Form::textarea('description', null, array('class' => 'form-control ckeditor')) !!}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Property</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                        </div>
                     </div>
                  </div>
               </div>
            {!! Form::close() !!}
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script>
      var latitude = -1.2806256;
      var longitude = 36.7994581;
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
   <script type="text/javascript">
      $(document).ready(function() {
         $('#type').on('change', function() {
            if (this.value == 4 || this.value == 2 || this.value == 5) {
               $('.single').show();
            }else{
               $('.single').hide();
            }

            if (this.value == 10) {
               $('.commercial').show();
            } else {
               //$('.commercial').hide();
            }

            if (this.value == 12) {
               $('.office').show();
            } else {
            }
            if (this.value == 11) {
               $('.land').show();
            } else {
            }
         });
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
