@extends('layouts.app')
@section('title','CRM | Reports')
@section('stylesheet')
   <style>
      button {
         font-size: 14px;
         border: none;
         background-color: #fff;
         margin-left: -5px;
         color: #007bff;
         font-weight: 900;
      }
   </style>
@endsection
@section('sidebar')
   @include('app.crm.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Customer Relationship Management </a></li>
         <li class="breadcrumb-item active">Reports</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-chart-pie"></i> Reports</h1>
      @php
         $endDate = \Carbon\Carbon::now()->endOfMonth()->toDateString();
         $startDate = \Carbon\Carbon::now()->startOfMonth()->toDateString();
      @endphp
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Lead Reports</div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-4">
                        <form action="{!! route('crm.reports.leads.status.filter') !!}" method="GET">
                           <input type="hidden" name="end" value="{!! $endDate !!}">
                           <input type="hidden" name="start" value="{!! $startDate !!}">
                           <input type="hidden" name="status" value="all">
                           <button type="submit">Leads by Status</button>
                        </form>                         
                     </div>
                     <div class="col-md-4">
                        <form action="{!! route('crm.reports.leads.source.filter') !!}" method="GET">
                           <input type="hidden" name="end" value="{!! $endDate !!}">
                           <input type="hidden" name="start" value="{!! $startDate !!}">
                           <input type="hidden" name="source" value="all">
                           <button type="submit">Leads by Source</button>
                        </form> 
                     </div>
                     <div class="col-md-4">
                        <form action="{!! route('crm.reports.leads.industry.filter') !!}" method="GET">
                           <input type="hidden" name="end" value="{!! $endDate !!}">
                           <input type="hidden" name="start" value="{!! $startDate !!}">
                           <input type="hidden" name="industry" value="all">
                           <button type="submit">Leads by Industry</button>
                        </form> 
                     </div>
                  </div>
               </div>
            </div>
         </div>
         {{-- <div class="col-md-6">
            <div class="card">
               <div class="card-header">Dead Reports</div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-6">

                     </div>
                     <div class="col-md-6">

                     </div>
                  </div>
               </div>
            </div>
         </div> --}}
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
@endsection
