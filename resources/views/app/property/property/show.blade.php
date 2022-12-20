@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Property Details @endsection
{{-- page styles --}}
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- content section --}}
@section('content')
   <div class="row">
      @include('app.property.partials._property_menu')
      @if(request()->route()->getName() == 'property.rental.billing.edit')
         @include('app.property.accounting.invoices.edit')
      @endif

      {{-- invoices --}}
      @if(request()->route()->getName() == 'property.invoice.index')
         @include('app.property.accounting.invoices.index')
      @endif 
      @if(request()->route()->getName() == 'property.invoice.create')
         @include('app.property.accounting.invoices.create')
      @endif    
      @if(request()->route()->getName() == 'property.invoice.edit')
         @include('app.property.accounting.invoices.edit')
      @endif
      @if(request()->route()->getName() == 'property.invoice.settings')
         @include('app.property.accounting.invoices.settings')
      @endif  
      @if(request()->route()->getName() == 'property.invoice.create.bulk')
         @include('app.property.accounting.invoices.bulk')  
      @endif   
      
      @if(request()->route()->getName() == 'property.mpesaapi.integration')
         @include('app.property.property.integration.payments.mpesaapi')
      @endif  
      @if(request()->route()->getName() == 'property.mpesatill.integration')
         @include('app.property.property.integration.payments.mpesatill')
      @endif   
      @if(request()->route()->getName() == 'property.mpesapaybill.integration')
         @include('app.property.property.integration.payments.paybill')
      @endif 
      @if(request()->route()->getName() == 'property.bank1.integration')
         @include('app.property.property.integration.payments.bank1')
      @endif
      @if(request()->route()->getName() == 'property.bank2.integration')
         @include('app.property.property.integration.payments.bank2')
      @endif
      @if(request()->route()->getName() == 'property.bank3.integration')
         @include('app.property.property.integration.payments.bank3')
      @endif
      @if(request()->route()->getName() == 'property.bank4.integration') 
         @include('app.property.property.integration.payments.bank4')
      @endif
      @if(request()->route()->getName() == 'property.bank5.integration')
         @include('app.property.property.integration.payments.bank5')
      @endif 
      @if(request()->route()->getName() == 'property.images')
         @include('app.property.property.images')
      @endif   
      @if(request()->route()->getName() == 'property.tenants.create')
         @include('app.property.tenants.create')  
      @endif 
      {{-- lease list --}}
      @if(request()->route()->getName() == 'property.leases')
         @include('app.property.property.lease.index')  
      @endif 
      @if(request()->route()->getName() == 'property.leases.create')
         @include('app.property.property.lease.create')  
      @endif 
   </div> 
@endsection
