@extends('layouts.app')
{{-- page header --}}
@section('title','Profit and Loss | Report')
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
         <li class="breadcrumb-item active">Profit and Loss</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-funnel-dollar"></i> Profit and Loss</h1> 
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
                  <a href="{!! route('finance.report.profitandloss.pdf',[$to,$from]) !!}" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
                     <i class="fal fa-file-pdf t-plus-1 fa-fw fa-lg"></i> Export as PDF
                  </a>
                  <a href="{!! route('finance.report.profitandloss.pdf',[$to,$from]) !!}" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
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
                              <h4>Profit and Loss</h4> 
                              <h5><span class="text-primary">From </span>{!! date('F j,Y', strtotime($from) ) !!} <span>To</span> {!! date('F j,Y', strtotime($to) ) !!} </h5> 
                           </div>  
                           <div class="reports-table-wrapper fill-container table-container"> 
                              <table class="table zi-table financial-comparison table-no-border">
                                 <thead>
                                    <tr class="rep-fin-th"> 
                                    <th class="text-left"><h3>Account</h3></th> 
                                    <th class="text-right"><h3>Total</h3></th>  
                                    </tr>
                                 </thead> 
                                 <tbody>  
                                    <tr>
                                       <td class="table-bg" colspan="2"><h4><b>Income</b></h4></td>
                                    </tr>  
                                    @foreach($incomeCategories as $category)
                                       @if(Finance::check_invoice_in_category_by_period($category->id,$from,$to) != 0)
                                          @foreach(Finance::invoices_per_income_category($category->id,$from,$to) as $xx)
                                             <tr class=" balance-tr">
                                                <td>{!! $category->name !!}</td>  
                                                <td class="text-right">{!! $business->symbol !!}{!! number_format(Finance::invoices_per_income_category_sum($category->id,$from,$to),2) !!}</td>  
                                             </tr>
                                          @endforeach
                                       @endif
                                    @endforeach
                                    @foreach($defaultCategories as $default)
                                       @if(Finance::check_invoice_in_category_by_period($default->id,$from,$to) != 0)
                                          @foreach(Finance::invoices_per_income_category($default->id,$from,$to) as $xx)
                                             <tr class=" balance-tr">
                                                <td>{!! $default->name !!}</td>  
                                                <td class="text-right">{!! $business->symbol !!}{!! number_format(Finance::invoices_per_income_category_sum($default->id,$from,$to),2) !!}</td>  
                                             </tr>
                                          @endforeach 
                                       @endif
                                    @endforeach
                                    
                                    @if($unCategorisedInvoicesCount != 0)
                                       <tr class=" balance-tr">
                                          <td>Others</td>  
                                          <td class="text-right">{!! $business->symbol !!}{!! number_format($unCategorisedInvoicesSum + $unCategorisedInvoicesSum2,2) !!}</td>  
                                       </tr>
                                    @endif
                                    <tr>
                                       <td><b>Total Income</b></td>   
                                       <td class="text-right"><b>{!! $business->symbol !!}{!! number_format($income,2) !!}</b></td>  
                                    </tr> 
                                    <tr>
                                       <td class="table-bg" colspan="2"><h4><b>Operating Expenses</b></h4></td>
                                    </tr>
                                    @foreach($expenseCategory as $expCat)
                                       @if(Finance::check_expense_per_category_by_period($expCat->id,$from,$to) != 0)
                                          @foreach(Finance::expense_per_category($expCat->id,$from,$to) as $x)
                                             <tr class=" balance-tr">
                                                <td>{!! $expCat->category_name !!}</td>  
                                                <td class="text-right">{!! $business->symbol !!}{!! number_format(Finance::expense_per_category_sum($expCat->id,$from,$to),2) !!}</td>  
                                             </tr>
                                          @endforeach
                                       @endif
                                    @endforeach
                                    <tr>
                                       <td><b>Total Expenses</b></td>   
                                       <td class="text-right"><b>{!! $business->symbol !!}{!! number_format($expense,2) !!}</b></td>  
                                    </tr> 
                                    <tr>
                                       <td class="table-bg"><h4><b>Net Profit</b></h4></td>
                                       <td class="table-bg text-right"><h4 class="text-pink"><b>{!! $business->symbol !!}{!! number_format($income - $expense,2) !!}</b></h4></td>
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
    <form action="{!! route('finance.report.profitandloss') !!}" method="GET" autocomplete="off">
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
                     {!! Form::date('from',null,['class'=>'form-control','required' => '']) !!}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="">To</label>
                     {!! Form::date('to',null,['class'=>'form-control','required' => '']) !!}
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