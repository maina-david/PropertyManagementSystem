@extends('layouts.app')
{{-- page header --}}
@section('title','Sales Orders')
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.salesorders.create') !!}" class="btn btn-pink"><i class="fas fa-plus"></i> New Sales Orders</a>
         {{-- <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle pull-right"><i class="fas fa-sliders-h"></i></button>
            <ul class="dropdown-menu">
               <li class="fltheader font-weight-bold"><center>Sort by</center></li>
               <li><a href="#">Created Time</a></li>
               <li><a href="">Last Modified Time</a></li>
               <li><a href="">Date</a></li>
               <li><a href="">Estimate Number</a></li>
               <li><a href="">Customer Name</a></li>
               <li><a href="">Amount</a></li>
               <li class="divider"></li>
               <li><a href=""><i class="fas fa-file-upload"></i> Import Estimates</a></li>
               <li><a href=""><i class="fas fa-file-download"></i> Export Estimates</a></li>
            </ul>
         </div> --}}
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-cart-arrow-down"></i> All Sales Orders</h1>
		@include('partials._messages')
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Customer</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Invoiced</th>
                     {{-- <th>Payment</th> --}}
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Customer</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Invoiced</th>
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  @foreach ($salesOrders as $crt => $v)
                     <tr role="row" class="odd">
                        <td>{{ $crt+1 }}</td>
                        <td>
                           <b>{!! $v->prefix !!}{!! $v->salesorder_number !!}</b>
                        </td>
                        <td>
                           {!! $v->customer_name !!}
                        </td>
                        <td class="text-uppercase font-weight-bold">
                           {!! $v->reference_number !!}
                        </td>
                        <td>{!! $v->symbol !!} {!! number_format($v->balance) !!} </td>
                        <td><span class="badge {!! $v->name !!}">{!! ucfirst($v->name) !!}</span></td>
                        <td>
                           @if($v->invoiceID != "") 
                              <span class="badge badge-green">Yes</span>
                           @endif
                        </td>
                        <td>
                           {!! date('F j, Y',strtotime($v->createDate)) !!}
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <li><a href="{{ route('finance.salesorders.show', $v->salesID) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="{!! route('finance.salesorders.edit', $v->salesID) !!}"><i class="fas fa-edit"></i> Edit</a></li>
                                 <li><a href="{!! route('finance.salesorders.delete', $v->salesID) !!}"><i class="fas fa-trash-alt"></i> Delete</a></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection