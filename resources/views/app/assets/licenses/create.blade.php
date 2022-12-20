@extends('layouts.app')
{{-- page header --}}
@section('title','Add Licenses')
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
      <li class="breadcrumb-item"><a href="{!! route('assets.index') !!}">License</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fal fa-laptop-code"></i> Add License </h1>
	@include('partials._messages')
	{!! Form::open(array('route' => 'licenses.assets.store','enctype'=>'multipart/form-data', 'method'=>'post', 'autocomplete' => 'off')) !!}
		{!! csrf_field() !!}
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Details</h4>
					</div>
					<div class="panel-body">						
						<div class="form-group form-group-default required">
							{!! Form::label('title', 'Software Name', array('class'=>'control-label')) !!}
							{!! Form::text('asset_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name','required' => '')) !!}
						</div>
						<div class="form-group form-group-default">
							{!! Form::label('Status', 'Status', array('class'=>'control-label')) !!}
							{!! Form::select('status', ['' => 'choose status', '37' => 'Allocated', '29' => 'Ready to deploy', '30' => 'Archived'], null, array('class' => 'form-control multiselect')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Asset Image', 'Asset Image', array('class'=>'control-label')) !!}
                     <input type="file" name="asset_image"><br>
                  </div>
						<div class="form-group form-group-default">
							{!! Form::label('Product Key', 'Product Key', array('class'=>'control-label')) !!}
							{!! Form::text('product_key', null, array('class' => 'form-control', 'placeholder' => 'Enter key')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Seats', 'Seats', array('class'=>'control-label')) !!}
							{!! Form::number('seats', null, array('class' => 'form-control', 'placeholder' => 'Enter Seats')) !!}
						</div>						
						<div class="form-group form-group-default">
							{!! Form::label('ManufacturE', 'Manufacture', array('class'=>'control-label')) !!}
							{!! Form::text('manufacture', null, array('class' => 'form-control')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Licensed to Name', 'Licensed to Name', array('class'=>'control-label')) !!}
							{!! Form::text('licensed_to_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Licensed to Email', 'Licensed to Email', array('class'=>'control-label')) !!}
							{!! Form::email('licensed_to_email', null, array('class' => 'form-control', 'placeholder' => 'Enter model')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Reassignable', 'Reassignable', array('class'=>'control-label')) !!}
							{!! Form::select('reassignable', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')) !!}
                  </div>	
						<div class="form-group form-group-default">
							{!! Form::label('Supplier', 'supplier', array('class'=>'control-label')) !!}
							{!! Form::select('supplier', $suppliers, null, array('class' => 'form-control multiselect')) !!}
                  </div>	
                  {{-- <div class="form-group form-group-default">
							{!! Form::label('Assigned to', 'Assigned to', array('class'=>'control-label')) !!}
							{!! Form::select('assigned_to', ['' => 'Choose','Employee' => 'Employee','Customer' => 'Customer'], null, array('class' => 'form-control multiselect')) !!}
						</div>	 --}}
						{{-- <div class="form-group form-group-default">
							{!! Form::label('Assigned to', 'Employee', array('class'=>'control-label')) !!}
							{!! Form::select('employee', ['' => 'Choose','Employee' => 'Employee','Customer' => 'Customer'], null, array('class' => 'form-control multiselect')) !!}
						</div>				 --}}
					</div>
				</div>
         </div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Details</h4>
					</div>
					<div class="panel-body"> 
						<div class="form-group form-group-default">
							{!! Form::label('Order Number', 'Order Number', array('class'=>'control-label')) !!}
							{!! Form::text('order_number', null, array('class' => 'form-control', 'placeholder' => 'Enter number')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Purchase Cost', 'Purchase Cost', array('class'=>'control-label')) !!}
							{!! Form::text('purches_cost', null, array('class' => 'form-control', 'placeholder' => 'Enter Cost')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Purchase date', 'Purchase date', array('class'=>'control-label')) !!}
							{!! Form::text('purchase_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Chooose date')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Termination Date', 'Termination Date', array('class'=>'control-label')) !!}
							{!! Form::text('end_of_life', null, array('class' => 'form-control datepicker', 'placeholder' => 'Chooose date')) !!}
                  </div>
                  <div class="form-group form-group-default">
							{!! Form::label('Maintained', 'Maintained', array('class'=>'control-label')) !!}
							{!! Form::select('maintained', ['' => 'Choose','Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')) !!}
						</div>
						<div class="form-group form-group-default">
							{!! Form::label('Next maintenance', 'Next maintenance', array('class'=>'control-label')) !!}
							{!! Form::text('next_maintenance', null, array('class' => 'form-control datepicker', 'placeholder' => 'Chooose date')) !!}
                  </div>	
                  <div class="form-group form-group-default">
							{!! Form::label('Note', 'Note', array('class'=>'control-label')) !!}
							{!! Form::textarea('note', null, array('class' => 'form-control ckeditor')) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<center>
					<button type="submit" class="btn btn-pink submit btn-lg"><i class="fas fa-save"></i> Add Asset</button>
					<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
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
@endsection
