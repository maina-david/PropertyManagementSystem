@extends('layouts.app')
{{-- page header --}}
@section('title','Expense Summary | Report')
{{-- page styles --}}
@section('stylesheet')
   <style>
      td.table-bg{
         background-color: #e0e7eb;
         font-weight: 900;
         padding-top: 8px;
         padding-bottom: 0px;
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
         <li class="breadcrumb-item active">Expense Summary</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Expense Summary</h1> 
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <div class="row">
               <div class="col-md-12">
                  <a href="#" data-toggle="modal" data-target="#filter" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
                     <i class="fal fa-search"></i> Filter
                  </a>
                  <a href="{!! route('finance.report.expensesummary.extract',[$to,$from]) !!}" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
                     <i class="fal fa-file-pdf t-plus-1 fa-fw fa-lg"></i> Export as PDF
                  </a>
                  <a href="{!! route('finance.report.expensesummary.extract',[$to,$from]) !!}" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
                     <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
                  </a>                  
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <div class="rep-container"> 
                           <div class="page-header text-center">
                              <h3>{!! $business->name !!}</h3> 
                              <h4>Expense Summary</h4> 
                              <h5><span class="text-primary">From </span>{!! date('F j, Y', strtotime($from) ) !!} <span class="text-primary">To</span> {!! date('F j, Y', strtotime($to) ) !!} </h5> 
                           </div>  
                           <div class="reports-table-wrapper fill-container table-container"> 
                              <table class="table zi-table financial-comparison table-no-border">
                                 <thead>
                                    <tr class="rep-fin-th"> 
                                       <th class="text-left"><h4>Expense</h4></th> 
                                       <th class="text-right"><h4>Total</h4></th>  
                                    </tr>
                                 </thead> 
                                 <tbody>  
                                    @foreach($expenseCategory as $expCat)
                                       @if(Finance::check_expense_per_category_by_period($expCat->id,$from,$to) != 0)
                                          @foreach(Finance::expense_per_category($expCat->id,$from,$to) as $x)
                                             <tr class=" balance-tr">
                                                <td>{!! $expCat->category_name !!}</td>  
                                                <td class="text-right">{!! $business->code !!} {!! number_format(Finance::expense_per_category_sum($expCat->id,$from,$to)) !!}</td>  
                                             </tr>
                                          @endforeach
                                       @endif
                                    @endforeach
                                    <tr>
                                       <td><b>Total Expense</b></td>   
                                       <td class="text-right"><b>{!! $business->code !!} {!! number_format($expense) !!}</b></td>  
                                    </tr> 
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-2"></div>
      </div>
   </div>
    <!-- Modal -->
    <form action="{!! route('finance.report.expensesummary') !!}" method="GET" autocomplete="off">
      <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filter" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Filter by Date</h5>
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
                  <button class="btn btn-success badge-light submit" type="submit">Filter date</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
               </div>
            </div>
         </div>
      </div>
   </form>
@endsection