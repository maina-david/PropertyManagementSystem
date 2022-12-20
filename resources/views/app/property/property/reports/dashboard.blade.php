@extends('layouts.app')
{{-- page header --}}
@section('title') Property Report | {!! $property->title !!} @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page styles --}}
@section('stylesheet')
   <style>
      button {
         font-size: 14px;
         border: none;
         background-color: #fff;
         margin-left: -5px;
         color: #007bff;
      }
   </style>  
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Reports</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Property Report </h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         @php
            $lastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
            $firstdate = \Carbon\Carbon::now()->startOfMonth()->toDateString();
         @endphp
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading"><i class="fal fa-chart-pie"></i> Reports</div>
               <div class="panel-body">
                  <div class="row">               
                     <div class="col-md-3">
                        <form action="{!! route('property.reports.profitandloss',$property->id) !!}" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Profit and Loss</button>
                        </form> 
                     </div>
                     <div class="col-md-3">
                        <form action="{!! route('property.reports.expensesummary',$property->id) !!}" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Expense Summary</button>
                        </form> 
                     </div>
                     <div class="col-md-3">
                        <form action="{!! route('property.reports.incomesummary',$property->id) !!}" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Income Summary</button>
                        </form> 
                     </div>
                     {{-- <div class="col-md-3">
                        <form action="#" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Rental debtors</button>
                        </form> 
                     </div> --}}
                     {{-- <div class="col-md-3">
                        <form action="#" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Balance Sheet</button> 
                        </form> 
                     </div> --}}
                     {{-- <div class="col-md-3">
                        <form action="#" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Service charge reconciliation</button> 
                        </form> 
                     </div> --}}
                     {{-- <div class="col-md-3">
                        <form action="#" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Tenants Deposit</button> 
                        </form> 
                     </div> --}}
                     {{-- <div class="col-md-3">
                        <form action="#" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">VAT Summary</button> 
                        </form> 
                     </div> --}}
                     {{-- <div class="col-md-3">
                        <form action="#" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Receipt Listings</button> 
                        </form> 
                     </div> --}}
                     {{-- <div class="col-md-3">
                        <form action="#" method="GET">
                           <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                           <input type="hidden" name="from" value="{!! $firstdate !!}">
                           <button type="submit">Cash flow statement</button> 
                        </form> 
                     </div> --}}
                  </div>
               </div>
            </div>
         </div>
      </div> 
   </div>
@endsection
