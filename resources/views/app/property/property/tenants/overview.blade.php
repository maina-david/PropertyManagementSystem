@extends('layouts.app')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page header --}}
@section('title') {!! $tenant->tenant_name !!} | Tenant @endsection

@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Tenants</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | {!! $tenant->tenant_name !!} |Tenants </h1>
      <div class="row">
         @include('app.property.property.tenants._nav') 
         <div class="col-md-12 mt-3">
            {{-- <div class="row row-space-10 m-b-20">
               <!-- begin col-4 -->
               <div class="col-lg-4 col-sm-6">
                  <div class="widget widget-stats bg-teal m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Outstanding</div>
                        <div class="stats-number">12</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width: 70.1%;"></div>
                        </div>
                        <div class="stats-desc">Better than last week (70.1%)</div>
                     </div>
                  </div>
               </div>
               <!-- end col-4 -->
               <!-- begin col-4 -->
               <div class="col-lg-4 col-sm-6">
                  <div class="widget widget-stats bg-blue m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Credits</div>
                        <div class="stats-number">33</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width: 70.1%;"></div>
                        </div>
                        <div class="stats-desc">Better than last week (70.1%)</div>
                     </div>
                  </div>
               </div>
               <!-- end col-4 -->
               <!-- begin col-4 -->
               <div class="col-lg-4 col-sm-6">
                  <div class="widget widget-stats bg-indigo m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Expense</div>
                        <div class="stats-number">33</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width: 70.1%;"></div>
                        </div>
                        <div class="stats-desc">Better than last week (70.1%)</div>
                     </div>
                  </div>
               </div>
            </div> --}}
            <div class="row">
               <div class="col-md-12">
                  <div class="panel">
                     <div class="panel-heading">General information</div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-2">
                              <img src="https://ui-avatars.com/api/?name={!! $tenant->tenant_name !!}&rounded=true&size=180" alt="{!! $tenant->tenant_name !!}"/>
                           </div>
                           <div class="col-md-4">
                              <p>
                                 <b>Tenant Name :</b> {!! $tenant->tenant_name !!}<br>
                                 <b>Phone Number :</b> {!! $tenant->primary_phone_number !!}<br>
                                 <b>Date Of Birth :</b> {!! $tenant->tenant_name !!}<br>
                                 <b>Email :</b> {!! $tenant->contact_email !!}<br>
                                 <b>Identification Type :</b> {!! $tenant->identification_type !!}<br>
                                 <b>Identification Number :</b> {!! $tenant->identification_number !!}<br>
                              </p>
                           </div>
                           <div class="col-md-4">
                              <p>
                                 <b>Gender :</b> {!! $tenant->gender !!}<br>
                                 <b>Age :</b> {!! $tenant->age !!}<br>
                                 <b>Tax Pin :</b> {!! $tenant->tax_pin !!}<br>
                                 <b>Code :</b> {!! $tenant->reference_number !!}<br>
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection