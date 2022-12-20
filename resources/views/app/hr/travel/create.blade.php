@extends('layouts.app')
{{-- page header --}}
@section('title','Add Travel Request | Travel | Human Resource')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="{{ Nav::isRoute('hrm.dashboard') }}">Human resource</a></li>
		<li class="breadcrumb-item"><a href="{!! route('hrm.travel.index') !!}">Travel</a></li>
		<li class="breadcrumb-item active">Add Travel Requests</li>
	</ol>
	<h1 class="page-header"><i class="fal fa-plane"></i> Add Travel Request</h1>
	<!-- end page-header -->
	@include('partials._messages')
	<!-- begin panel -->
	<form action="{!! route('hrm.travel.store') !!}" method="post" class="row">
		@csrf
		<div class="col-md-6"> 
			<div class="panel panel-default">
				<div class="panel-heading">Travel Details</div>
				<div class="panel-body">
					<div class="form-group form-group-default required">
						<label class="text-danger">Employee</label>
						{!! Form::select('employee[]',$employees,null,['class'=>'form-control multiselect','required'=>'','multiple'=>'']) !!}
					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Employee Department</label>
						{!! Form::select('department[]',$departments,null,['class'=>'form-control multiselect','required'=>'','multiple'=>'']) !!}
					</div>
					<div class="form-group form-group-default required"> 
						<label class="text-danger">Expected date of departure</label>
						{!! Form::date('departure_date',null,['class'=>'form-control','required'=>'']) !!}
					</div>	
					<div class="form-group form-group-default required">
						<label class="text-danger">Expected date of arrival</label>
						{!! Form::date('date_of_arrival',null,['class' =>'form-control','required'=>'']) !!}
					</div>	
					<div class="form-group form-group-default required">
						<label class="text-danger">Expected duration in days</label>
						{!! Form::number('duration',null,['class' =>'form-control','placeholder'=>'Enter number','required'=>'']) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6"> 
			<div class="panel panel-default">	
				<div class="panel-heading">Travel Details</div>				
				<div class="panel-body">
					<div class="form-group form-group-default required">
						<label class="text-danger">Purpose of visit</label>
						{!! FORM::text('purpose_of_visit',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter purpose of visit']) !!}
					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Place of visit</label>
						{!! FORM::text('place_of_visit',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter place of visit']) !!}
					</div>	
					<div class="form-group form-group-default required">
						<label class="text-danger">Customer name</label>
						{!! Form::select('customer',$customers,null,['class'=>'form-control multiselect','required'=>'']) !!}
					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Is billable to customer</label>
						{!! Form::select('bill_customer',['' => 'Choose','Yes' => 'Yes','No' => 'No'],null,['class'=>'form-control','required'=>'']) !!}
					</div>	
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Information </button>
			<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
		</div>
	</form>	
</div>
@endsection