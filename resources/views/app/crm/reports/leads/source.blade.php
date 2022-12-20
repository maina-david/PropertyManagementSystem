@extends('layouts.app')
@section('title','CRM | Reports | Source')
@section('stylesheet')
@endsection
@section('sidebar')
   @include('app.crm.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('crm.dashboard') !!}">CRM </a></li>
         <li class="breadcrumb-item">Reports</li>
         <li class="breadcrumb-item active">Leads by source</li>
      </ol>

      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-search"></i> Leads by source | {!!$sourceRequest !!} | {!!  date('F j, Y', strtotime($start)) !!} to {!!  date('F j, Y', strtotime($end)) !!}</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <form action="{!! route('crm.reports.leads.source.filter') !!}" method="GET" class="row" autocomplete="off">
               <div class="col-md-3">
                  <div class="form-group">
                     {!! Form::select('source',$sources,null,['class'=>'form-control multiselect']) !!}
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     {!! Form::text('start',null,['class'=>'form-control datepicker','placeholder'=>'Start date','required' => '']) !!}
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     {!! Form::text('end',null,['class'=>'form-control datepicker','placeholder'=>'End date','required' => '']) !!}
                  </div>
               </div>               
               <div class="col-md-3">
                  <div class="form-group">
                     <button class="btn btn-primary" type="submit">Apply Filter</button>
                  </div>
               </div>      
            </form>
         </div>
         <div class="col-md-4">
            <a href="{!! route('crm.reports.leads.source.export',[$sourceValue,$start,$end]) !!}" class="float-right btn btn-pink"><i class="fal fa-file-excel"></i> Export to csv</a>
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <th>Full Name</th>
                        <th>Phone number</th>
                        <th>Email</th>  
                        <th>Lead Owner</th>
                        <th>Industry</th>
                        <th>Status</th>
                        <th>Street</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>  
                        <th>Date added</th>                                     
                     </thead>
                     <tbody>
                        @foreach ($leads as $lead)
                           <tr>
                              <td>{!! $lead->customer_name !!}</td>
                              <td>{!! $lead->primary_phone_number !!}</td>
                              <td>{!! $lead->email !!}</td>
                              <td>
                                 @if($lead->assignedID != 0)
                                    {!! Hr::employee($lead->assignedID)->names !!}
                                 @endif
                              </td>
                              <td>
                                 @if($lead->industryID != "")
                                    {!! Wingu::industry($lead->industryID)->name !!}
                                 @endif
                              </td>
                              <td>
                                 @if($lead->statusID != 0)
                                    @if(Crm::check_lead_status($lead->statusID) != 0)
                                       {!! Crm::lead_status($lead->statusID)->name !!}
                                    @endif                                    
                                 @endif
                              </td>
                              <td>{!! $lead->bill_street !!}</td>
                              <td>{!! $lead->bill_city !!}</td>
                              <td>{!! $lead->bill_state !!}</td>
                              <td>
                                 @if($lead->bill_country != "")
                                    {!! Wingu::country($lead->bill_country)->name !!}
                                 @endif
                              </td>
                              <td>{!!  date('F j, Y', strtotime($lead->date)) !!}</td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
@endsection
