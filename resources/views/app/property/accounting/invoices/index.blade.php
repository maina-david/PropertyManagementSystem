@extends('layouts.app')
@section('title'){!! $property->title !!} | Billing | Rental Invoices @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.invoice.index',$property->propertyID) !!}">Billing</a></li>
         <li class="breadcrumb-item active"><a href="{!! route('property.invoice.index',$property->propertyID) !!}">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Billing | Rental Invoices</h1>
      
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12 mt-2">
            @if($property->property_type == 13 or $property->property_type == 14)
               <a class="btn btn-primary" href="{!! route('property.invoice.create.bulk',$property->propertyID) !!}"><i class="fal fa-copy"></i> Bulk Billing</a>
            @endif
            <a class="btn btn-warning" href="{!! route('property.invoice.create',$property->propertyID) !!}"><i class="fal fa-file-invoice-dollar"></i> Single Billing</a>
         </div>
         @livewire('property.accounting.invoices.index',['propertyID' => $property->propertyID, 'property' => $property])         
      </div> 
   </div>  
@endsection

 