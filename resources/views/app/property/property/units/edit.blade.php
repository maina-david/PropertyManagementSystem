@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Units | Property Units')
{{-- page styles --}}

@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.show',$property->id) !!}">{!! $property->title !!}</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.units',$property->id) !!}">Units</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> {!! $property->title !!} | Edit | Units </h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         @include('partials._messages') 
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">Edit Unit</div>
               <div class="panel-body">
                  {!! Form::model($unit, ['route' => ['property.units.update',$unit->id], 'method'=>'post']) !!}
                     @csrf
                     <input type="hidden" value="{!! $property->id !!}" name="parentID"  required>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Unit Type', 'Unit Type', array('class'=>'control-label text-danger')) !!}
                              {!! Form::select('property_type',['' => 'Choose Type',2 => 'Flat/Apartment',10 => 'Commercial Properties', 12 => 'Offices'], null, array('class' => 'form-control multiselect','required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Unit #', 'Unit #', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('serial', null, array('class' => 'form-control', 'placeholder' => 'Enter unit number', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Landlord', 'Landlord', array('class'=>'control-label text-danger')) !!}
                              {!! Form::select('landlordID',$landlords,null,['class'=>'form-control multiselect']) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Tenant', 'Tenant', array('class'=>'control-label')) !!}
                              <select class="form-control multiselect" disabled>
                                 @if($unit->tenantID != "")
                                    @if(Property::check_tenant($unit->tenantID) == 1)
                                    <option value="{!! $unit->tenantID !!}">
                                       {!! Property::tenant_info($unit->tenantID)->tenant_name !!}
                                    </option>
                                    @else 
                                       <option value="">Unknown Tenant</option>
                                    @endif
                                 @else
                                    <option value="">Not Occupied</option>
                                 @endif
                              </select>
                           </div>
                        </div>
                        @if($unit->leaseID != "")
                           <div class="col-md-4">
                              <div class="form-group form-group-default">
                                 {!! Form::label('Lease', 'Lease#', array('class'=>'control-label')) !!}
                                 <input type="text" value="{!! Property::lease($unit->leaseID)->lease_code !!}" class="form-control" disabled>
                              </div>
                           </div>
                        @endif
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Year built', 'Year built', array('class'=>'control-label')) !!}
                              <select name="year_built" class="form-control multiselect">
                                 @if($unit->year_built != "")
                                    <option value="{!! $unit->year_built !!}"> {!! $unit->year_built !!}</option>
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
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <label for="" class="text-danger">Ownership Type</label>
                              {!! Form::select('ownwership_type', ['' => 'choose type','single' => 'Single Ownership','multi' => 'Multi Ownership'],null,['class' => 'form-control multiselect'] ) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Size, sq.ft', 'Size, sq.ft', array('class'=>'control-label')) !!}
                              {!! Form::number('size', null, array('class' => 'form-control', 'placeholder' => 'Enter size')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Market Price', 'Market Price', array('class'=>'control-label text-danger')) !!}
                              {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount', 'required' => '')) !!}
                           </div>
                        </div>
                        @if($unit->property_type != 10)
                           <div class="col-md-4 remove-on-commercial">
                              <div class="form-group form-group-default" id="single">
                                 {!! Form::label('Bedrooms', 'Bedrooms', array('class'=>'control-label')) !!}
                                 {!! Form::number('bedrooms', null, array('class' => 'form-control', 'placeholder' => 'Recored bedrooms')) !!}
                              </div>
                           </div>
                           <div class="col-md-4 remove-on-commercial">
                              <div class="form-group form-group-default" id="single">
                                 {!! Form::label('Bathrooms', 'Bathrooms', array('class'=>'control-label')) !!}
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
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <h5>Features</h5>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckAir" value="Air conditioning" @if(strpos($unit->features, 'Air conditioning') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckAir">Air conditioning</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckBalcony" value="Balcony, deck, patio" @if(strpos($unit->features, 'Balcony, deck, patio') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckBalcony">Balcony, deck, patio</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCable" value="Cable ready" @if(strpos($unit->features, 'Cable ready') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckCable">Cable ready</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCarpet" value="Carpet" @if(strpos($unit->features, 'Cable ready') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckCarpet">Carpet</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCeiling" value="Ceiling Fans" @if(strpos($unit->features, 'Ceiling Fans') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckCeiling">Ceiling Fans</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCentral" value="Central Heating" @if(strpos($unit->features, 'Central Heating') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckCentral">Central Heating</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDishwasher" value="Dishwasher" @if(strpos($unit->features, 'Dishwasher') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckDishwasher">Dishwasher</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFenced" value="Fenced yard" @if(strpos($unit->features, 'Fenced yard') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckFenced">Fenced yard</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFireplace" value="Fireplace" @if(strpos($unit->features, 'Fireplace') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckFireplace">Fireplace</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckGarbage" value="Garbage Disposal" @if(strpos($unit->features, 'Garbage Disposal') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckGarbage">Garbage Disposal</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckHardwood" value="Hardwood floors" @if(strpos($unit->features, 'Hardwood floors') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckHardwood">Hardwood floors</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckInternet" value="Internet" @if(strpos($unit->features, 'Internet') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckInternet">Internet</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckMicrowave" value="Microwave" @if(strpos($unit->features, 'Microwave') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckMicrowave">Microwave</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckOven" value="Oven/range" @if(strpos($unit->features, 'Oven/range') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckOven">Oven/range</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckRefrigerator" value="Refrigerator" @if(strpos($unit->features, 'Refrigerator') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckRefrigerator">Refrigerator</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStainless" value="Stainless Steel Appliance" @if(strpos($unit->features, 'Stainless Steel Appliance') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckStainless">Stainless Steel Appliance</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage" valu="Storage" @if(strpos($unit->features, 'Storage') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckStorage">Storage</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStove" value="Stove" @if(strpos($unit->features, 'Stove') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckStove">Stove</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTelephone" value="Telephone" @if(strpos($unit->features, 'Telephone') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckTelephone">Telephone</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTile" value="Tile" @if(strpos($unit->features, 'Tile') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckTile">Tile</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTowels" value="Towels" @if(strpos($unit->features, 'Towels') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckTowels">Towels</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckVacuum" value="Vacuum Cleaner" @if(strpos($unit->features, 'Vacuum Cleaner') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckVacuum">Vacuum Cleaner</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckclosets" value="Walk-in closets" @if(strpos($unit->features, 'Walk-in closets') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckclosets">Walk-in closets</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDryer" value="Washer/Dryer" @if(strpos($unit->features, 'Washer/Dryer') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckDryer">Washer/Dryer</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckWindow" value="Window Coverings" @if(strpos($unit->features, 'Window Coverings') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckWindow">Window Coverings</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckYard" value="Yard" @if(strpos($unit->features, 'Yard') !== false) checked @endif>
                              <label class="custom-control-label" for="customCheckYard">Yard</label>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              {!! Form::label('Property Description', 'Property Description', array('class'=>'control-label')) !!}
                              {!! Form::textarea('description', null, array('class' => 'form-control ckeditor')) !!}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Unit</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                        </div>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
<script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
