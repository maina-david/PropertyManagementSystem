@extends('layouts.app') 
{{-- page header --}}
@section('title') Tenants List @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb --> 
   <ol class="breadcrumb pull-right">
      {{-- <a href="{!! route('tenants.import.index') !!}" class="btn btn-pink mr-2"><i class="fal fa-file-upload"></i> Import Tenant</a>
      <a href="{!! route('tenants.export') !!}" class="btn btn-pink mr-2"><i class="fal fa-file-download"></i> Export Tenant</a> --}}
      <a href="{!! route('tenants.create') !!}" class="btn btn-pink mr-2"><i class="fal fa-plus-circle"></i> Add Tenant</a>    
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-users"></i> Tenants - List</h1>
   @include('partials._messages')
	@livewire('property.tenants.index')
</div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
