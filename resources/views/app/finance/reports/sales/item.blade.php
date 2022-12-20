@extends('layouts.app')
{{-- page header --}}
@section('title','Sales by Item report')

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
         <li class="breadcrumb-item active">Sales by Item</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Sales by Item</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
               <a href="{!! route('finance.report.sales.item.pdf',[$to,$from]) !!}" class="btn btn-pink pull-right"><i class="fas fa-file-pdf"></i> Export in pdf</a>
               <a href="{!! route('finance.report.sales.item.print',[$to,$from]) !!}" class="btn btn-pink pull-right mr-2"><i class="fas fa-print"></i> Print</a>
               <a href="#" data-toggle="modal" data-target="#filter" class="btn btn-pink pull-right mr-2"><i class="fas fa-calendar-day"></i> Filter</a>
            </div>
         </div>         
      </div>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <h3 class="text-center">Sales by Item</h3>
               <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
               <table class="table table-striped">
                  <thead>
                     <tr>  
                        <th>Item Name</th>  
                        <th><center>sku</center></th>  
                        <th><center>Quantity sold</center></th> 
                        <th><center>Amount</center></th>  
                     </tr>
                  </thead> 
                  <tbody> 
                     @foreach($products as $product)
                        <tr>
                           <td><a href="#">{!! $product->name !!}</a></td>
                           <td><center>{!! $product->sku !!}</center></td>
                           <td><center>{!! Finance::count_invoice_products($product->productID) !!}</center></td>
                           <td><center><b>{!! number_format($product->total) !!} {!! $product->code !!}</b></center></td>
                        </tr>
                     @endforeach
                     {{-- <tr>
                        <td><b>Total</b></td>
                        <td><center>{!! $countInvoice !!}</center></td>
                        <td><center><b>{!!  number_format($products->sum('total')) !!} {!! Wingu::currency()->code !!}</b></center></td>
                     </tr> --}}
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <form action="{!! route('finance.report.sales.item') !!}" method="GET" autocomplete="off">
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
                     <label for="">From</label>
                     {!! Form::text('from',null,['class'=>'form-control datepicker','placeholder' => 'choose date']) !!}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="">To</label>
                     {!! Form::text('to',null,['class'=>'form-control datepicker','placeholder' => 'choose date']) !!}
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button class="btn btn-success" type="submit">Filter date</button>
               </div>
            </div>
         </div>
      </div>
   </form>
@endsection