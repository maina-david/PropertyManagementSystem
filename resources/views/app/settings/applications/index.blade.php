@extends('layouts.app')
{{-- page header --}}
@section('title','Applications')

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('wingu.dashboard') !!}">Settings</a></li>
         <li class="breadcrumb-item"><a href="{!! route('settings.business.index') !!}"> Applications</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-gem"></i> Account Applications.</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         @foreach($applications as $app)
            {{-- @if($app->module_status != 22) --}}
               <div class="col-md-4">
                  <div class="card">
                     <div class="card-body text-center">
                        {!! $app->icon !!}
                        <p class="mt-1">{!! $app->name !!}</p>          
                     </div>
                     <div class="card-footer">
                        <div class="row">
                           <div class="col-md-4">
                              <h4 class="font-weight-bold text-pink">${!! number_format($app->price) !!}/Mo</h4>
                           </div>
                           <div class="col-md-8">
                              @if($app->module_status == 15 && $app->payment_status == 1)
                                 <a href="#" class="float-right ml-1 btn btn-sm btn-success">Active</a>
                              @else 
                                 <a href="{!! route('settings.applications.billing',$app->business_module_id) !!}" class="float-right ml-1 btn btn-sm btn-pink"><i class="fal fa-usd-circle"></i> Make Payment</a>
                                 <a href="{!! route('settings.application.delete',$app->moduleID) !!}" class="float-right ml-1 btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Remove</a>
                              @endif
                           </div>                             
                        </div>                          
                     </div>
                  </div>
               </div>
            {{-- @endif --}}
            @endforeach
      </div>           
   </div>
@endsection
