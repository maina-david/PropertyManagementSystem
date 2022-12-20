@extends('layouts.app')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page header --}}
@section('title') {!! $tenant->tenant_name !!} | Tenant @endsection

{{-- content section --}}
@section('content')
	<div class="row">
      @include('app.property.property.tenants._nav') 
      @if(request()->route()->getName() == 'property.tenant.lease.show')
         @include('app.property.property.tenants.leases.show')
      @endif 
      {{-- edit lease --}}
      @if(request()->route()->getName() == 'property.tenant.lease.edit')
         @include('app.property.property.tenants.leases.edit')
      @endif 
      @if(request()->route()->getName() == 'tenants.notes')
         @include('app.property.property.tenants.notes')
      @endif  
      @if(request()->route()->getName() == 'tenants.invoice.index')
         @include('app.property.property.tenants.invoices')
      @endif  
	</div> 
@endsection 
@section('scripts')
   <script src="{!! url('/') !!}/public/app/plugins/ckeditor/4/standard/ckeditor.js"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
