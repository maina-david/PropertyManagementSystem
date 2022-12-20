@extends('layouts.app')
{{-- page header --}}
@section('title','Finance')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.finance.partials._menu')
@endsection

@section('content')
<!-- begin #content -->
<div id="content" class="content">
   <div class="row">
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-teal">
            <div class="stats-icon stats-icon-lg"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="stats-content">
               <div class="stats-title">Due invoices</div>
               <div class="stats-number">{!! $dueInvoicescount !!}</div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc">Invoice</div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-blue">
            <div class="stats-icon stats-icon-lg"><i class="fas fa-users fa-fw"></i></div>
            <div class="stats-content">
               <div class="stats-title">Total Clients</div>
               <div class="stats-number">{!! $client !!}</div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc">Clients</div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-purple">
            <div class="stats-icon stats-icon-lg"><i class="fab fa-product-hunt fa-fw"></i></div>
            <div class="stats-content">
               <div class="stats-title">Total Products & Services</div>
               <div class="stats-number">{!! $products !!}</div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc">Products</div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-black">
            <div class="stats-icon stats-icon-lg"><i class="fas fa-users-cog fa-fw"></i></div>
            <div class="stats-content">
               <div class="stats-title">Total Suppliers</div>
               <div class="stats-number">{!! $suppliers !!}</div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc">Supplier</div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
   </div>
   <div class="row">
      <div class="col-md-12">
         <!-- begin panel -->
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Income by category </h4>
            </div>
            <div class="panel-body">
               {!! $incomePerCategoryChart->container() !!}
            </div>
         </div>
         <!-- end panel -->
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <!-- begin panel -->
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Income by month </h4>
            </div>
            <div class="panel-body">
               {!! $incomePerMonth->container() !!}
            </div>
         </div>
         <!-- end panel -->
      </div>
   </div>
   {{-- <div class="row">
      <div class="col-md-12">
         <!-- begin panel -->
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Expence by category </h4>
            </div>
            <div class="panel-body">
               {!! $expensePerCategory->container() !!}
            </div>
         </div>
         <!-- end panel -->
      </div>
   </div> --}}
</div>
<!-- end #content -->
@endsection
@section('scripts')
	<script src="{!! asset('assets/plugins/chart.js/2.7.1/Chart.min.js') !!}" charset="utf-8"></script>
	{!! $incomePerMonth->script() !!} 
   {!! $incomePerCategoryChart->script() !!}
   {!! $expensePerCategory->script() !!}
@endsection
