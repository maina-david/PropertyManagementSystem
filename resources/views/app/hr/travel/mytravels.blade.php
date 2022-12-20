@extends('layouts.app')
{{-- page header --}}
@section('title','My Travels | Human Resource')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{{ Nav::isRoute('hrm.dashboard') }}">Human resource</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.travel.index') !!}">Travel</a></li>
         <li class="breadcrumb-item active">My Travel</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-plane"></i> All My Travel Requests </h1>
      <!-- end page-header -->
      @include('backend.partials._messages')
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-responsive">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Employee</th>
                     <th>Place</th>
                     <th>Arrival</th>
                     <th>Duration</th>
                     <th>Customer</th>
                     <th>Purpose</th>
                     <th>Billing</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($travels as $travel)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>{!! $travel->names !!}</td>
                        <td>{!! $travel->place_of_visit !!}</td>
                        <td>{!! date('M jS, Y', strtotime($travel->departure_date)) !!}</td>
                        <td>{!! date('M jS, Y', strtotime($travel->date_of_arrival)) !!}</td>
                        <td>{!! $travel->duration !!}</td>
                        <td>{!! $travel->customer_name !!}</td>
                        <td>{!! $travel->purpose_of_visit !!}</td>
                        <td>{!! $travel->bill_customer !!}</td>
                        <td><span class="badge {!! $travel->statusName !!}">{!! $travel->statusName !!}</span></td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
@endsection
