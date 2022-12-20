@extends('layouts.app')
{{-- page header --}}
@section('title','Payroll settings')
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Payroll</li>
         <li class="breadcrumb-item active">Payroll settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-cog"></i> Payroll settings </h1>
      @include('partials._messages')
      <div class="row">
         @include('app.hr.payroll.settings._nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.payroll.settings.payday') }}" href="{!! route('hrm.payroll.settings.payday') !!}">
                           Payday information
                        </a>
                     </li> --}}
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.payroll.settings.approval') }}" href="{!! route('hrm.payroll.settings.approval') !!}">
                           Approver setting
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.payroll.settings.deduction') }}" href="{!! route('hrm.payroll.settings.deduction') !!}">
                           Deductions
                        </a>
                     </li>
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.payroll.settings.benefits') }}" href="{!! route('hrm.payroll.settings.benefits') !!}">
                           Benefits
                        </a>
                     </li> --}}
                  </ul>
               </div>
               <div class="card-block">
                  @if(Request::is('hrm/payroll/settings'))
                     @include('app.hr.payroll.settings.payday')
                  @endif
                  @if(Request::is('hrm/payroll/settings/approval'))
                     @include('app.hr.payroll.settings.approval')
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
