@extends('layouts.app')
{{-- page header --}}
@section('title','Inventory Valuation Summary | Finance Reports')
{{-- page styles --}}
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
         <li class="breadcrumb-item"><a href="#">Inventory</a></li>
         <li class="breadcrumb-item active"><a href="#">Valuation Summary</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-inventory"></i> Inventory Valuation Summary </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-12 mb-3">
            <div class="row">
               <div class="col-md-4">
   
               </div>
               <div class="col-md-4">
   
               </div>
               <div class="col-md-4">
                  <a href="{!! route('finance.report.inventory.valuation.summary.pdf',[$to,$from]) !!}" target="_blank" class="btn btn-pink pull-right"><i class="fas fa-file-pdf"></i> Export in pdf</a>
                  <a href="{!! route('finance.report.inventory.valuation.summary.print',[$to,$from]) !!}" target="_blank" class="btn btn-pink pull-right mr-2"><i class="fas fa-print"></i> Print</a>
                  {{-- <a href="#" data-toggle="modal" data-target="#filter" class="btn btn-pink pull-right mr-2"><i class="fas fa-calendar-day"></i> Filter</a> --}}
               </div>
            </div>         
         </div>
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-body">
                  <h3 class="text-center">Inventory Valuation Summary</h3>
                  <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
                  <table class="table table-striped">
                     <thead>
                        <tr>  
                           <th>Item Name</th>  
                           <th>SKU</th>  
                           <th>Stock in hand</th> 
                           <th>Asset Value</th>
                        </tr>
                     </thead> 
                     <tbody> 
                        @foreach($products as $product)
                           <tr>
                              <td>{!! $product->product_name !!}</td>
                              <td>{!! $product->sku_code !!}</td>                              
                              <td>{!! $product->current_stock !!}</td>
                              <td>{!! $business->code !!} {!! number_format($product->current_stock * $product->price) !!}</td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
    <!-- Modal -->
    <form action="{!! route('finance.report.inventory.valuation.summary') !!}" method="GET" autocomplete="off">
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
                  <button class="btn btn-success" type="submit">Filter date</button>
               </div>
            </div>
         </div>
      </div>
   </form>
@endsection