@extends('layouts.app')
{{-- page header --}}
@section('title','Leave Settings')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item active">Leave</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-calendar-times"></i>  Leave Settings</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.hr.partials._settings_nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.leave.settings.holiday') }}" href="{!! route('hrm.leave.settings.holiday') !!}"><i class="fas fa-calendar-alt"></i> Holidays</a>
                     </li> --}}
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.leave.settings.type') }}" href="{!! route('hrm.leave.settings.type') !!}"><i class="fas fa-user-clock"></i> Leave Types</a>
                     </li>
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.leave.settings.workdays') }}" href="{!! route('hrm.leave.settings.workdays') !!}"><i class="fas fa-history"></i> Hours & Workweek</a>
                     </li> --}}
                  </ul>
               </div>
               <div class="card-block">
                  @if(Request::is('hrm/leave/holiday'))
                     @include('app.hr.leave.settings.holiday')
                  @endif
                  @if(Request::is('hrm/leave/type'))
                     @include('app.hr.leave.settings.type')
                  @endif
                  @if(Request::is('hrm/leave/workdays'))
                     @include('app.hr.leave.settings.workdays')
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection