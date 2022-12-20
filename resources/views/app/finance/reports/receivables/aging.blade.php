@extends('layouts.app')
{{-- page header --}}
@section('title','Aging report')

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
         <li class="breadcrumb-item"><a href="{!! route('finance.report') !!}">Report</a></li>
         <li class="breadcrumb-item active">Aging report</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Aging report</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
               <a href="#" class="btn btn-pink pull-right"><i class="fas fa-file-pdf"></i> Export in pdf</a>
               {{-- <a href="#" class="btn btn-pink pull-right mr-2"><i class="fas fa-print"></i> Print</a>
               <a href="#" data-toggle="modal" data-target="#filter" class="btn btn-pink pull-right mr-2"><i class="fas fa-calendar-day"></i> Filter</a> --}}
            </div>
         </div>         
      </div>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <h3 class="text-center">A/R Aging Report</h3>
               <h5 class="text-center mt-3 mb-3">As of {!! $date !!} </h5>
               <table class="table table-striped">
                  <thead>
                     <tr>  
                        <th>Customer Name</th>  
                        <th>Current</th>
                        <th>31 - 60 Days</th>
                        <th>61 - 90 Days</th>
                        <th>91 - 120 Days</th>
                        <th>121 - 150 Days</th>
                        <th>151 - 180 Days</th>
                     </tr>
                  </thead> 
                  <tbody> 
                     @foreach($ages as $age)
                        <tr>
                           <td><a href="#">{!! $age->customer_name !!}</a></td>
                           <td>{!! $currency->symbol !!}{!! number_format($age->age130,2) !!}</td>
                           <td>{!! $currency->symbol !!}{!! number_format($age->age3160,2) !!}</td>
                           <td>{!! $currency->symbol !!}{!! number_format($age->age6190,2) !!}</td>
                           <td>{!! $currency->symbol !!}{!! number_format($age->age91120,2) !!}</td>
                           <td>{!! $currency->symbol !!}{!! number_format($age->age121150,2) !!}</td>
                           <td>{!! $currency->symbol !!}{!! number_format($age->age151180,2) !!}</td>
                        </tr>
                     @endforeach
                     <tr>
                        <th>Total</th>
                        <th>{!! $currency->symbol !!}{!! number_format($ages->sum('age130'),2) !!}</th>
                        <th>{!! $currency->symbol !!}{!! number_format($ages->sum('age3160'),2) !!}</th>
                        <th>{!! $currency->symbol !!}{!! number_format($ages->sum('age6190'),2) !!}</th>
                        <th>{!! $currency->symbol !!}{!! number_format($ages->sum('age91120'),2) !!}</th>
                        <th>{!! $currency->symbol !!}{!! number_format($ages->sum('age121150'),2) !!}</th>
                        <th>{!! $currency->symbol !!}{!! number_format($ages->sum('age151180'),2) !!}</th>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <form action="{!! route('finance.report.receivables.aging') !!}" method="GET" autocomplete="off">
      <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filter" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Filter Date</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">                  
                  <div class="form-group form-group-default">
                     <label for="">Choose Date</label>
                     <input type="date" name="date" class="form-control" required>
                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-success" type="submit">Submit date</button>
               </div>
            </div>
         </div>
      </div>
   </form>
@endsection