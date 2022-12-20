@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Property Edit  @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page styles --}}
@section('stylesheet')
   <style>
      .map_canvas { 
         width: 100%; 
         height: 300px; 
      }
   </style>    
@endsection

{{-- content section --}}
@section('content')
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
         @include('app.property.partials._property_menu')
         <div class="col-md-12">     
            @include('partials._messages') 
               {!! Form::model($property, ['route' => ['property.update',$property->id],'enctype'=>'multipart/form-data','method'=>'post','autocomplete' => '']) !!}
                  @csrf
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title font-weight-bold">Property Information</h4>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('Property Type', 'Property Type', array('class'=>'control-label text-danger')) !!}
                                 {!! Form::select('property_type', $type, null, array('class' => 'form-control multiselect', 'id' => 'type', 'placeholder' => 'Enter Property Name', 'required' => '')) !!}
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 {!! Form::label('Property Name', 'Property Name', array('class'=>'control-label text-danger')) !!}
                                 {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter Property Name', 'required' => '')) !!}
                              </div>
                           </div>
                           @if($property->property_type == 4 || $property->property_type == 2 || $property->property_type == 5)
                              <div class="col-md-4">
                                 <div class="form-group form-group-default required">
                                    {!! Form::label('Landlord', 'Landlord', array('class'=>'control-label text-danger')) !!}
                                    <select name="landlord" class="form-control multiselect">
                                       @if($property->landlordID != "")
                                          <option value="{!! $property->landlordID !!}">
                                             {!! Finance::client($property->landlordID)->customer_name !!}
                                          </option>
                                       @else
                                          <option value="">Choose Landlord</option>
                                       @endif
                                       @foreach ($landlords as $landlord)
                                          <option value="{!! $landlord->id !!}">{!! $landlord->customer_name !!}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           @endif
                           @if($property->property_type == 4 || $property->property_type == 2 || $property->property_type == 5)
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Tenant', 'Tenant', array('class'=>'control-label')) !!}
                                    <input type="text" class="form-control" value="@if($property->tenantID != ""){!! Property::tenant_info($property->tenantID)->tenant_name !!} @else Vacant @endif" readonly>
                                 </div>
                              </div>
                           @endif
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
                                 {!! Form::select('countryID', $country, null, array('class' => 'form-control multiselect', 'required' => '')) !!}
                              </div>
                           </div>
                                          
                              @if($property->property_type == 11 || $property->property_type == 13 || $property->property_type == 14) @else 
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                       {!! Form::label('Size, sq.ft', 'Size, sq.ft', array('class'=>'control-label')) !!}
                                       {!! Form::number('size', null, array('class' => 'form-control','step'=>'0.01', 'placeholder' => 'Enter size')) !!}
                                    </div>
                                 </div>
                              @endif
                              @if($property->property_type == 13 || $property->property_type == 14 || $property->property_type == 11) @else
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                       {!! Form::label('Parking', 'Parking', array('class'=>'control-label')) !!}
                                       {!! Form::number('parking_size', null, array('class' => 'form-control', 'placeholder' => 'Enter parking number')) !!}
                                    </div>
                                 </div>
                              @endif
                              @if($property->property_type == 13 || $property->property_type == 14) @else
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                       {!! Form::label('Market Price', ' Market Price', array('class'=>'control-label text-danger')) !!}
                                       {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount')) !!}
                                    </div>
                                 </div>
                              @endif
                              @if($property->property_type == 2 || $property->property_type == 4 || $property->property_type == 5)
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                       {!! Form::label('Bedrooms', 'Bedrooms', array('class'=>'control-label')) !!}
                                       {!! Form::number('bedrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bedrooms')) !!}
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                       {!! Form::label('Bathrooms', 'Bathrooms', array('class'=>'control-label')) !!}
                                       {!! Form::number('bathrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bathrooms')) !!}
                                    </div>
                                 </div>
                              @endif
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Image', 'Property Image', array('class'=>'control-label')) !!}
                                    <input type="file" name="image" id="thumbnail" accept="image/*">
                                    @if($property->image != "")
                                       <a href="{!! route('property.remove.image',$property->id) !!}" class="text-danger">Remove image</a>
                                    @endif
                                 </div>
                              </div> 
                              @if($property->property_type == 11) 
                                 <div class="col-md-4">
                                    <div class="form-group land form-group-default">
                                       {!! Form::label('Land Size', 'Land Size', array('class'=>'control-label text-danger')) !!}
                                       {!! Form::text('land_size', null, array('class' => 'form-control', 'placeholder' => 'Land Size')) !!}
                                    </div>
                                 </div>
                              @endif
                           </div>
                        @if($property->property_type == 4 || $property->property_type == 2 || $property->property_type == 5 || $property->property_type == 12)
                           <hr>
                           <div class="row">
                              <div class="col-md-12">
                                 <h4>Features</h4>
                              </div>
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
                                    <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage1" valu="Storage" @if(strpos($property->features, 'Storage') !== false) checked @endif>
                                    <label class="custom-control-label" for="customCheckStorage1">Storage</label>
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
                        @endif
                        @if ($property->property_type == 1)
                           <hr>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Furnished', 'Furnished', array('class'=>'control-label')) !!}
                                    {!! Form::select('funished', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')) !!}
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
                                    {!! Form::label('Laundry', 'Laundry', array('class'=>'control-label')) !!}
                                    {!! Form::select('laundry', ['' => 'Choose', 'None' => 'None', 'In unit' => 'In unit', 'Shared' => 'Shared'], null, array('class' => 'form-control')) !!}
                                 </div>
                              </div>
                           </div>
                        @endif
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
                        <h4 class="panel-title font-weight-bold">Property Amenities</h4>
                     </div>
                     <div class="panel-body">               
                        <div class="row">
                           <div class="col-md-3">
                              <div class="custom-control custom-checkbox none">
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckClub1" value="Club house2"  @if(strpos($property->amenities, 'Club house2') !== false) checked @endif>
                                 <label class="custom-control-label" for="customCheckClub1">Club house</label>
                              </div>
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
                                 <input type="checkbox" name="amenities[]" class="custom-control-input" id="customCheckStorage" value="Storage" @if(strpos($property->amenities, 'Off-street Parking') !== false) checked @endif>
                                 <label class="custom-control-label" for="customCheckStorage">Storage</label>
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
                                       {!! Form::text('geolocation', null, array('class' => 'form-control', 'id' => 'location', 'placeholder' => 'Nairobi, Kenya')) !!}
                                    </div>
                                    <div class="form-group">
                                       <label for="">Latitude</label>
                                       <input type="text" value="{!! $property->latitude !!}" class="form-control" name="lat" data-geo="lat" readonly>
                                    </div>
                                    <div class="form-group">
                                       <label for="">Longitude</label>
                                       <input type="text" value="{!! $property->longitude !!}" class="form-control" name="lng" data-geo="lng" readonly>
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
                                 {!! Form::textarea('description', null, array('class' => 'form-control ckeditor')) !!}
                              </div>
                           </div>
                           <div class="col-md-12">
                              <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Property</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                           </div>
                        </div>
                     </div>         
                  </div>
               {!! Form::close() !!}
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
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
