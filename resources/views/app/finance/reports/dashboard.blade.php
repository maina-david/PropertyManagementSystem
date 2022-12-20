@extends('layouts.app')
{{-- page header --}}
@section('title','Finance Reports')
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
         <li class="breadcrumb-item active"><a href="{!! route('finance.report') !!}">Report</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-chart-pie"></i> Reports</h1>
      <!-- end page-header -->
      @include('partials._messages')
      @php
         $lastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
         $firstdate = \Carbon\Carbon::now()->startOfMonth()->toDateString();
         $currentDate = date('Y-m-d');
      @endphp
      <div class="row">
         <div class="col-md-4">
            <div class="card">
               <div class="card-header"><i class="fal fa-building"></i> Business Overview</div>
               <div class="card-body" style="min-height: 120px;">
                  <form action="{!! route('finance.report.profitandloss') !!}" method="GET">
                     <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                     <input type="hidden" name="from" value="{!! $firstdate !!}">
                     <button type="submit">Profit and Loss</button>
                  </form>
                  <form action="{!! route('finance.report.expensesummary') !!}" method="GET">
                     <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                     <input type="hidden" name="from" value="{!! $firstdate !!}">
                     <button type="submit">Expense Summary</button>
                  </form>
                  <form action="{!! route('finance.report.incomesummary') !!}" method="GET">
                     <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                     <input type="hidden" name="from" value="{!! $firstdate !!}">
                     <button type="submit">Income Summary</button>
                  </form>
               </div>
            </div>
         </div>
         @if(Wingu::business()->plan != 1)
            <div class="col-md-4">
               <div class="card">
                  <div class="card-header"><i class="fal fa-usd-circle"></i> Sales</div>
                  <div class="card-body" style="min-height: 120px;">
                     <form action="{!! route('finance.report.sales.customer') !!}" method="GET">
                        <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                        <input type="hidden" name="from" value="{!! $firstdate !!}">
                        <button type="submit">Sales by Customer</button>
                     </form>
                     <form action="{!! route('finance.report.sales.item') !!}" method="GET">
                        <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                        <input type="hidden" name="from" value="{!! $firstdate !!}">
                        <button type="submit">Sales by Item</button>
                     </form>
                     <form action="{!! route('finance.report.sales.salesperson') !!}" method="GET">
                        <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                        <input type="hidden" name="from" value="{!! $firstdate !!}">
                        <button type="submit">Sales by Sales person</button>
                     </form>
                  </div>
               </div>
            </div>
         @endif
         <div class="col-md-4">
            <div class="card">
               <div class="card-header"><i class="fal fa-money-check-alt"></i> Receivables</div>
               <div class="card-body" style="min-height: 120px;">
                  <form action="{!! route('finance.report.receivables.balance') !!}" method="GET">
                     <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                     <input type="hidden" name="from" value="{!! $firstdate !!}">
                     <button type="submit">Customer Balances</button>
                  </form> 
                  <form action="{!! route('finance.report.receivables.aging') !!}" method="GET">
                     <input type="hidden" name="date" value="{!! $currentDate !!}" required>
                     <button type="submit">Aging Summary</button>
                  </form>
                  {{-- <li><a href="#">Aging Details</a></li>  --}}
                  {{-- <li><a href="#">Invoice Details</a></li> --}}
                  {{-- <li><a href="#">Bad Debts</a></li> --}}
               </div>
            </div>
         </div>
         @if(Wingu::business()->plan != 1)
            <div class="col-md-4">
               <div class="card">
                  <div class="card-header"><i class="fal fa-inventory"></i> Inventory</div>
                  <div class="card-body" style="min-height: 120px;">
                     <form action="{!! route('finance.report.inventory.summary') !!}" method="GET">
                        <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                        <input type="hidden" name="from" value="{!! $firstdate !!}">
                        <button type="submit">Inventory Summary</button>
                     </form>
                     <form action="{!! route('finance.report.inventory.valuation.summary') !!}" method="GET">
                        <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                        <input type="hidden" name="from" value="{!! $firstdate !!}">
                        <button type="submit">Inventory Valuation Summary</button>
                     </form>
                     <form action="{!! route('finance.report.inventory.sale.summary') !!}" method="GET">
                        <input type="hidden" name="to" value="{!! $lastDayofMonth !!}">
                        <input type="hidden" name="from" value="{!! $firstdate !!}">
                        <button type="submit">Product Sales Report</button>
                     </form>
                     {{-- <li><a href="#"></a></li> --}}
                     {{-- <li><a href="#">FIFO Cost Lot Tracking</a></li> --}}
                     {{-- <li><a href="#">Inventory Aging Summary </a></li> --}}
                     {{-- <li><a href="#">Warehouse Report</a></li> --}}
                     {{-- <li><a href="#">Active Purchase Orders Report</a></li> --}}
                     {{-- <li><a href="#">Stock Summary Report</a></li> --}}
                  </div>
               </div>
            </div>
         @endif
      </div>
   </div>
@endsection
