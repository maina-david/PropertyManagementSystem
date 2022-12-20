@extends('layouts.app')
{{-- page header --}}
@section('title','Lead Settings')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Crm</a></li>
         <li class="breadcrumb-item"><a href="#">Leads</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Lead Settings</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
			@include('app.crm.settings._nav')
			<div class="col-md-9">
				<div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('crm.leads.status') }}" href="{!! route('crm.leads.status') !!}"><i class="fas fa-sort-numeric-up"></i> Lead Status</a>
                     </li>
							<li class="nav-item">
                        <a class="{{ Nav::isRoute('crm.leads.sources') }}" href="{!! route('crm.leads.sources') !!}"><i class="fas fa-sun"></i> Lead Source</a>
                     </li>
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
							@if(Request::is('crm/lead/status'))
                        @include('app.crm.settings.leads.status')
							@endif
                     @if(Request::is('crm/lead/sources'))
                        @include('app.crm.settings.leads.source')
							@endif
                  </div>
               </div>
            </div>
			</div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
