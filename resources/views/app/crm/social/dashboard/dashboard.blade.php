@extends('layouts.app')
{{-- page header --}}
@section('title','Create Post')

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Social</a></li>
         <li class="breadcrumb-item active">Dashboard</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Dashboard</h1>
     
   </div>
@endsection
@section('scripts')
@endsection