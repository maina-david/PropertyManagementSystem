@extends('layouts.app')
@section('title','Dashboard')
@section('stylesheet')
   <link rel="stylesheet" href="{!! asset('assets/css/dashboard.css') !!}" />
@endsection
@section('content')
   <div class="main">
      <div class="row mt-5">
         <div class="col-md-12 mb-5">
            <h1 class="text-center"><b>What would you like to manage ?</b></h1>
         </div>

         <!--- finance -->
         @if(Wingu::check_business_modules(1) == 1)
            @permission('access-finance')
               @if(Wingu::check_modules(1) == 1)
                  @if(Wingu::modules(1)->status == 15)
                     <div class="col-md-3 mb-3">
                        <div class="green-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 @php
                                    $moduleInfo = Wingu::get_account_module_details(1);
                                 @endphp
                                 @if($moduleInfo->version == 35)
                                    @php
                                       $today = date('Y-m-d');
                                       $timeLeft = Helper::date_difference($moduleInfo->end_date,$today);
                                    @endphp
                                    @if($timeLeft > 0)
                                       <center><span class="text-danger"><b>Free Trial {!! $timeLeft !!} days left</b></span></center>
                                    @endif
                                 @endif
                                 <h2 class="">{!! Wingu::modules(1)->name !!}</h2>
                                 <p class="font-bold text-success">{!! Wingu::modules(1)->caption !!}</p>
                                 <div class="mb-2">{!! Wingu::modules(1)->icon !!}</div>
                                 <p class="small">{!! Wingu::modules(1)->introduction !!}</p>
                                 <a href="{!! route('finance.index') !!}" class="btn btn-success btn-sm">
                                    <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>
                  @endif
               @endif
            @endpermission
         @endif

         <!--- human resource -->
         @if(Wingu::check_business_modules(2) == 1)
            @permission('access-humanresource')
               @if(Wingu::check_modules(2) == 1)
                  @if(Wingu::modules(2)->status == 15)
                     <div class="col-md-3 mb-3">
                        <div class="blue-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 @php
                                    $moduleInfo = Wingu::get_account_module_details(2);
                                 @endphp
                                 @if($moduleInfo->version == 35)
                                    @php
                                       $today = date('Y-m-d');
                                       $timeLeft = Helper::date_difference($moduleInfo->end_date,$today);
                                    @endphp
                                    @if($timeLeft > 0)
                                       <center><span class="text-danger"><b>Free Trial {!! $timeLeft !!} days left</b></span></center>
                                    @endif
                                 @endif
                                 <h2 class="">{!! Wingu::modules(2)->name !!}</h2>
                                 <p class="font-bold text-info">{!! Wingu::modules(2)->caption !!}</p>
                                 <div class="mb-2">{!! Wingu::modules(2)->icon !!}</div>
                                 <p class="small">{!! Wingu::modules(2)->introduction !!}</p>
                                 @php
                                    $property = Wingu::get_account_module_details(2);
                                 @endphp
                                 @if($property->module_status == 15 && $property->payment_status == 1)
                                    <a href="{!! route('hrm.dashboard') !!}" class="btn btn btn-info btn-sm text-white">
                                       <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                                    </a>
                                 @else
                                    <a href="{!! route('settings.applications.billing',$property->id) !!}" class="btn btn-sm btn-pink">
                                       <i class="fal fa-usd-circle"></i> Make Payment
                                    </a>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  @endif
               @endif
            @endpermission
         @endif

         <!-- crm -->
         @if(Wingu::check_business_modules(13) == 1)
            @permission('crm-access')
               @if(Wingu::check_modules(13) == 1)
                  @if(Wingu::modules(13)->status == 15)
                     <div class="col-md-3 mb-3">
                        <div class="black-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 @php
                                    $moduleInfo = Wingu::get_account_module_details(13);
                                 @endphp
                                 @if($moduleInfo->version == 35)
                                    @php
                                       $today = date('Y-m-d');
                                       $timeLeft = Helper::date_difference($moduleInfo->end_date,$today);
                                    @endphp
                                    @if($timeLeft > 0)
                                       <center><span class="text-danger"><b>Free Trial {!! $timeLeft !!} days left</b></span></center>
                                    @endif
                                 @endif
                                 <h2 class="m-b-xs">{!! Wingu::modules(13)->name !!}</h2>
                                 <p class="font-bold">{!! Wingu::modules(13)->caption !!}</p>
                                 <div class="mb-2">
                                    {!! Wingu::modules(13)->icon !!}
                                 </div>
                                 <p class="small">{!! Wingu::modules(13)->introduction !!}</p>
                                 @php
                                    $property = Wingu::get_account_module_details(13);
                                 @endphp
                                 @if($property->module_status == 15 && $property->payment_status == 1)
                                    <a href="{!! route('crm.dashboard') !!}" class="btn btn btn-black btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                                 @else
                                    <a href="{!! route('settings.applications.billing',$property->id) !!}" class="btn btn-sm btn-pink">
                                       <i class="fal fa-usd-circle"></i> Make Payment
                                    </a>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  @endif
               @endif
            @endpermission
         @endif

         <!--- property management -->
         @if(Wingu::check_business_modules(15) == 1)
            {{-- @permission('access-property-management') --}}
               @if(Wingu::check_modules(15) == 1)
                  @if(Wingu::modules(15)->status == 15)
                  @php
                     $property = Wingu::get_account_module_details(15);
                  @endphp
                     <div class="col-md-3 mb-3">
                        <div class="gray-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 @if($property->version == 35)
                                    @php
                                       $today = date('Y-m-d');
                                       $timeLeft = Helper::date_difference($property->end_date,$today);
                                    @endphp
                                    @if($timeLeft > 0)
                                       <center><span class="text-danger"><b>Free Trial {!! $timeLeft !!} days left</b></span></center>
                                    @endif
                                 @endif
                                 <h2 class="m-b-xs">{!! Wingu::modules(15)->name !!}</h2>
                                 <p class="font-bold text-gray">{!! Wingu::modules(15)->caption !!}</p>
                                 <div class="mb-2">{!! Wingu::modules(15)->icon !!}</div>
                                 <p class="small">{!! Wingu::modules(15)->introduction !!}</p>
                                 @if($property->module_status == 15 && $property->payment_status == 1)
                                    <a href="{!! route('dashboard.property') !!}" class="btn btn-gray btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                                 @else
                                    <a href="{!! route('settings.applications.billing',$property->id) !!}" class="btn btn-sm btn-pink">
                                       <i class="fal fa-usd-circle"></i> Make Payment
                                    </a>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  @endif
               @endif
            {{-- @endpermission --}}
         @endif

         <!--- settings -->
         @role('admin')
            <div class="col-md-3">
               <div class="yellow-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="m-b-xs">Settings</h2>
                        <p class="font-bold text-yellow">All Configurations</p>
                        <div class="mb-2">
                           <i class="fal fa-tools fa-5x"></i>
                        </div>
                        <p class="small">
                           User roles,user management,payment integration,Telephony integration,business profile
                        </p>
                        <a href="{!! route('settings.index') !!}" class="btn btn-yellow btn-sm">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         @endrole
      </div>
   </div>
@endsection
