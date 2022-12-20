@extends('layouts.app')
{{-- page header --}}
@section('title','Add Asset')
{{-- page styles --}}
@section('stylesheet')
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.assets.partials._menu')
@endsection

{{-- content section --}}
@section('content') 
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="{!! route('assets.dashboard') !!}">Assets</a></li>
		<li class="breadcrumb-item"><a href="{!! route('assets.index') !!}">Assets</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-barcode"></i> Add Asset </h1>
	@include('partials._messages')
	{!! Form::open(array('route' => 'assets.store','enctype'=>'multipart/form-data', 'method'=>'post' )) !!}
		{!! csrf_field() !!}
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Details</h4>
					</div>
					<div class="panel-body">						
						<div class="form-group form-group-default required">
							{!! Form::label('title', 'Asset Name', array('class'=>'control-label')) !!}
							{!! Form::text('asset_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name','required' => '')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Asset Type', 'Asset Type', array('class'=>'control-label')) !!}
                     <select name="asset_type" id="type" class="form-control multiselect">
								<option value="">Choose</option>
								<option value="1">Vehicle</option>
								@foreach ($types as $type)
								<option value="{!! $type->id !!}">{!! $type->name !!}</option>
								@endforeach
                     </select>
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Asset Image', 'Asset Image', array('class'=>'control-label')) !!}
                     <input type="file" name="asset_image" accept="image/*" id="file">
                  </div>
						<div class="form-group form-group-default">
							{!! Form::label('Asset Tag', 'Asset Tag', array('class'=>'control-label')) !!}
							{!! Form::text('asset_tag', null, array('class' => 'form-control', 'placeholder' => 'Enter tag')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Serial', 'Serial', array('class'=>'control-label')) !!}
							{!! Form::text('serial', null, array('class' => 'form-control', 'placeholder' => 'Enter serial')) !!}
						</div>
                  <div class="form-group form-group-default">
							{!! Form::label('manufacture', 'Manufacture', array('class'=>'control-label')) !!}
							{!! Form::text('manufacture', null, array('class' => 'form-control', 'placeholder' => 'Enter manufacture')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Asset Model', 'Asset Model', array('class'=>'control-label')) !!}
							{!! Form::text('asset_model', null, array('class' => 'form-control', 'placeholder' => 'Enter model')) !!}
						</div>
						<div class="form-group form-group-default">
							{!! Form::label('Asset Brand', 'Asset Brand', array('class'=>'control-label')) !!}
							{!! Form::text('asset_brand', null, array('class' => 'form-control', 'placeholder' => 'Enter brand')) !!}
						</div>
						<div class="form-group form-group-default">
							{!! Form::label('Supplier', 'supplier', array('class'=>'control-label')) !!}
							{!! Form::select('supplier', $suppliers, null, array('class' => 'form-control multiselect')) !!}
                  </div>						
						<div class="form-group form-group-default">
							{!! Form::label('Order Number', 'Order Number', array('class'=>'control-label')) !!}
							{!! Form::text('order_number', null, array('class' => 'form-control', 'placeholder' => 'Enter number')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Has insurance cover', 'Has insurance cover', array('class'=>'control-label')) !!}
							{!! Form::select('has_inurance_cover',['' => 'choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Insurance expiry date', 'Insurance expiry date', array('class'=>'control-label')) !!}
							{!! Form::text('insurance_expiry_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Last Audit Date and Time', 'Last Audit Date and Time', array('class'=>'control-label')) !!}
							{!! Form::text('last_audit', null, array('class' => 'form-control datetimepicker', 'placeholder' => 'Choose date and time')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('End of life', 'End of life', array('class'=>'control-label')) !!}
							{!! Form::text('end_of_life', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date')) !!}
						</div>
						<div class="form-group form-group-default">
							{!! Form::label('Asset condition', 'Asset condition', array('class'=>'control-label')) !!}
							{!! Form::select('asset_condition',['' => 'Choose','New' => 'New','Used' => 'Used'], null, array('class' => 'form-control multiselect')) !!}
                  </div> 
					</div>
				</div>
         </div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Details</h4>
					</div>
					<div class="panel-body">
                  <div style="display: none" id="vehicle-details">
                     <h4>Vehicle details</h4>
                     <div class="form-group form-group-default">
                        {!! Form::label('Mileage', 'Mileage', array('class'=>'control-label')) !!}
                        {!! Form::text('mileage', null, array('class' => 'form-control', 'placeholder' => 'Enter mileage')) !!}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('Next oil change', 'Next oil change', array('class'=>'control-label')) !!}
                        {!! Form::text('oil_change', null, array('class' => 'form-control datepicker', 'placeholder' => 'Enter date')) !!}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('Licence plate', 'Licence plate', array('class'=>'control-label')) !!}
                        {!! Form::text('licence_plate', null, array('class' => 'form-control', 'placeholder' => 'Enter licence plate')) !!}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('Vehicle Types', 'Vehicle Types', array('class'=>'control-label')) !!}
                        {!! Form::select('vehicle_type',$carTypes, null, array('class' => 'form-control multiselect')) !!}
                     </div>
                     <div class="form-group form-group-default">
								{!! Form::label('Vehicle make', 'Vehicle make', array('class'=>'control-label')) !!}
								{{ Form::select('vehicle_make',$makes, null, ['class' => 'form-control multiselect', 'id'=>'car_make','onchange' => 'get_model()']) }}
							</div>
							<div class="form-group form-group-default">
								<label for="Car Model">Model</label>
								{{ Form::select('vehicle_model',[], null, ['class' => 'form-control multiselect', 'id'=>'model']) }}
							</div>
                     <div class="form-group form-group-default">
                        {!! Form::label('year of manufacture', 'Year of manufacture', array('class'=>'control-label')) !!}
                        {!! Form::select('vehicle_year_of_manufacture',['' => 'choose'], null, array('class' => 'form-control multiselect')) !!}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('Vehicle color', 'Vehicle color', array('class'=>'control-label')) !!}
                        {!! Form::select('vehicle_color',['' => 'choose'], null, array('class' => 'form-control multiselect')) !!}
                     </div>
                     <hr>
						</div>      
						<div class="form-group form-group-default">
							{!! Form::label('Is asset maintainable', 'Is asset maintainable ', array('class'=>'control-label')) !!}
							{!! Form::select('maintained', ['' => 'Choose','Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')) !!}
                  </div>	            
                  <div class="form-group form-group-default">
							{!! Form::label('Accessories', 'Accessories linked to asset', array('class'=>'control-label')) !!}
							{!! Form::text('accessories', null, array('class' => 'form-control', 'placeholder' => 'Enter accessories')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Depreciable assets', 'Depreciable assets', array('class'=>'control-label')) !!}
							{!! Form::select('depreciable_assets',['' => 'Choose','Yes'=>'Yes','No'=>'No'], null, array('class' => 'form-control multiselect')) !!}
                  </div>                  
                  <div class="form-group form-group-default">
							{!! Form::label('Purchase Cost', 'Purchase Cost', array('class'=>'control-label')) !!}
							{!! Form::number('purches_cost', null, array('class' => 'form-control', 'placeholder' => 'Enter Cost','step'=>'0.01')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Purchase date', 'Purchase date', array('class'=>'control-label')) !!}
							{!! Form::text('purchase_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Enter date')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Warranty', 'Warranty (In months)', array('class'=>'control-label')) !!}
							{!! Form::number('warranty', null, array('class' => 'form-control', 'placeholder' => 'Enter warranty')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('warranty expiration', 'warranty expiration', array('class'=>'control-label')) !!}
							{!! Form::text('warranty_expiration', null, array('class' => 'form-control datepicker', 'placeholder' => 'Enter datepicker')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Asset color', 'Asset color', array('class'=>'control-label')) !!}
							{!! Form::select('asset_color',['' => 'Choose','Red' => 'Red','Black' => 'Black','Blue' => 'Blue','Yellow' => 'Yellow','Brown' => 'Brown','Pink' => 'Pink','Purple' => 'Purple','Grey' => 'Grey','White' => 'White','Silver' => 'Silver','Gold' => 'Gold','Nevy Blue' => 'Nevy Blue','Orange' => 'Orange','Green' => 'Green'], null, array('class' => 'form-control multiselect')) !!}
						</div>
						<div class="form-group form-group-default">
							{!! Form::label('Location', 'Location (if located outside business area)', array('class'=>'control-label')) !!}
							{!! Form::text('default_location',null, array('class' => 'form-control', 'placeholder' => 'Enter location')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Requestable', 'Is asset requestable', array('class'=>'control-label')) !!}
							{!! Form::select('requestable',['No' => 'No','Yes' => 'Yes'], null, array('class' => 'form-control multiselect')) !!}
                  </div> 
                  <div class="form-group form-group-default">
							{!! Form::label('Note', 'Note', array('class'=>'control-label')) !!}
							{!! Form::textarea('note', null, array('class' => 'form-control ckeditor')) !!}
						</div>
						{{-- <div class="form-group form-group-default">
							{!! Form::label('Link to expence', 'Link to expence', array('class'=>'control-label')) !!}
							{!! Form::select('link_to_expence',['No' => 'No','Yes' => 'Yes'], null, array('class' => 'form-control multiselect')) !!}
                  </div>  --}}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<center>
					<button type="submit" class="btn btn-pink submit btn-lg"><i class="fas fa-save"></i> Add Asset</button>
					<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
				</center>
			</div>
		</div>
	{!! Form::close() !!}
</div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
	<script> 
		$(document).ready(function() {
			$('#assignedTo').on('change', function() {
				if (this.value == 'Employee') {
					$('#employee').show();
				} else {
					$('#employee').hide();
				}

				if(this.value == 'Customer') {
					$('#customer').show();
				} else {
					$('#customer').hide();
				}
			});
			$('#type').on('change', function() {
				if(this.value == 1) {
					$('#vehicle-details').show();
				} else {
					$('#vehicle-details').hide();
				}
			});
		});
		function get_model() {
			var url = '{!! url('/') !!}';
			var make = document.getElementById("car_make").value;
			$.get(url+'/assets/retrive/model/'+make, function(data){
				//success data
				$('#model').empty();
				$.each(data, function(car_model, carModel){
						$('#model').append('<option value="'+ carModel.id +'">'+ carModel.name +'</option>');
				});
			});
		}
	</script>
@endsection
