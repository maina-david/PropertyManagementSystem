@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Utility Billing @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 

 
{{-- content section --}} 
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
      <li class="breadcrumb-item"><a href="#">Accounting</a></li>
      <li class="breadcrumb-item active"><a href="#">Utility Billing</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Utility Billing </h1>
   <div class="row">
      @include('app.property.partials._property_menu')
      @livewire('property.utility.index',['propertyID' => $property->id])      
   </div> 
</div>
@endsection
