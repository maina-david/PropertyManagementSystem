@extends('layouts.app')
{{-- page header --}}
@section('title','Payment Modes')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.payment.mode') !!}">Payment Modes</a></li>
         <li class="breadcrumb-item active">All Models</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fab fa-amazon-pay"></i>  Payment Modes</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.finance.partials._settings_nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('finance.expense.category.index') }}" href="#"><i class="fab fa-amazon-pay"></i> Payment Modes </a>
                     </li>
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
                     @if(Request::is('finance/settings/payment/modes'))
                        @include('app.finance.payments.settings.list')                        
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection