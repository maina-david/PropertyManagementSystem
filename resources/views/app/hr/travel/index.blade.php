@extends('layouts.app')
{{-- page header --}}
@section('title','Travel | Human Resource')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         {{-- <a href="#" class="btn btn-white mr-1 active"><i class="fa fa-bars"></i></a>
         <a href="#" class="btn btn-white mr-1"><i class="fa fa-th"></i></a> --}}
         <a href="{!! route('hrm.travel.create') !!}" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Travel</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-plane"></i> All Travel Requests </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-responsive">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>TravelID</th>
                     <th>Place</th>
                     <th>Departure</th>
                     <th>Arrival</th>
                     <th>Duration</th>
                     <th>Customer</th>
                     <th>Purpose</th>
                     <th>Billing</th>
                     <th>Status</th>
                     <th width="8%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($travels as $travel)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>{!! $travel->travel_code !!}</td>
                        <td>{!! $travel->place_of_visit !!}</td>
                        <td>{!! date('M jS, Y', strtotime($travel->departure_date)) !!}</td>
                        <td>{!! date('M jS, Y', strtotime($travel->date_of_arrival)) !!}</td>
                        <td>{!! $travel->duration !!}</td>
                        <td>{!! $travel->customer_name !!}</td>
                        <td>{!! $travel->purpose_of_visit !!}</td>
                        <td>{!! $travel->bill_customer !!}</td>
                        <td><span class="badge {!! $travel->statusName !!}">{!! $travel->statusName !!}</span></td>
                        <td>
                           <a href="{!! route('hrm.travel.edit',$travel->travID) !!}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                           <a href="{!! route('hrm.travel.delete',$travel->travID) !!}" class="delete btn btn-danger btn-sm"><i class="fas fa-trash "></i></a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
@endsection
