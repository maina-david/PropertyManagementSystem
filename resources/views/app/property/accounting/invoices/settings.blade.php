@extends('layouts.app')
@section('title') {!! $property->title !!} | Invoices Settings @endsection
@section('sidebar')
	@include('app.property.partials._menu')
@endsection
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
			<li class="breadcrumb-item"><a href="{!! route('property.invoice.index',$property->id) !!}">Settings</a></li>
			<li class="breadcrumb-item active"><a href="{!! route('property.invoice.index',$property->id) !!}">Invoice</a></li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Invoice Settings </h1>
	   <div class="row">
	      @include('app.property.partials._property_menu')
	      <div class="col-md-12">
	         {!! Form::model($settings, ['route' => ['property.invoice.settings.update',$settings->id], 'method'=>'post']) !!}
	            <div class="panel panel-default">
	               <div class="panel-heading">
	                  Invoice Settings
	               </div>
	               <div class="panel-body">
	                  <div class="row row-space-10 m-b-20">
	                     <div class="col-md-4">
	                        <div class="form-group form-group-default required">
	                           {!! Form::label('Invoice number', 'Invoice number', array('class'=>'control-label text-danger')) !!}
	                           {!! Form::number('number', null, array('class' => 'form-control', 'placeholder' => 'Enter Invoice number', 'required' => '')) !!}
	                           <input type="hidden" name="propertyID" value="{!! $property->id !!}">
	                        </div>
	                     </div>
	                     <div class="col-md-4">
	                        <div class="form-group form-group-default required ">
	                           {!! Form::label('Invoice prefix', 'Invoice prefix', array('class'=>'control-label text-danger')) !!}
	                           {!! Form::text('prefix', null, array('class' => 'form-control', 'placeholder' => 'Enter invoice prefix')) !!}
	                        </div>
	                     </div>
	                     <div class="col-md-4">
	                        <div class="form-group form-group-default">
	                           {!! Form::label('Show payment information on unpaid invoices', 'Show payment details on unpaid invoices', array('class'=>'control-label')) !!}
	                           {!! Form::select('show_payment_info', ['Yes'=>'Yes','No'=>'No'],null, array('class' => 'form-control multiselect')) !!}
	                        </div>
	                     </div>
	                     <div class="col-md-12">
	                        <div class="form-group">
	                           <h4 for="">Default Terms & Conditions</h4>
	                           {!! Form::textarea('default_terms_conditions', null, array('class' => 'form-control my-editor')) !!}
	                        </div>
	                     </div>
	                     <div class="col-md-12">
	                        <div class="form-group">
	                           <h4 for="">Default Invoice Footer</h4>
	                           {!! Form::textarea('default_invoice_footer', null, array('class' => 'form-control my-editor')) !!}
	                        </div>
	                     </div>
	                     <div class="col-md-12">
	                        <div class="form-group">
	                           <h4 for="">Customer Notes</h4>
	                           {!! Form::textarea('default_customer_notes', null, array('class' => 'form-control my-editor')) !!}
	                        </div>
	                     </div>
	                     <div class="col-md-12">
	                        <div class="form-group">
	                           <center>
	                              <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
	                               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
	                           </center>
	                        </div>
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

@endsection
