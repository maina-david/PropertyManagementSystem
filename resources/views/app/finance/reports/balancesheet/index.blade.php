@extends('layouts.app')
{{-- page header --}}
@section('title','Balance Sheet | Report')

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
         <li class="breadcrumb-item active">Balance Sheet</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Balance Sheet</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-4">
            <form action="" method="get">
               @csrf
               <div class="form-group form-group-default">
                  <label for="">From Period</label>
                  <input type="text"  class="form-control datepicker" placeholder="DD-MM-YY">
               </div>
               <div class="form-group form-group-default">
                  <label for="">To Period</label>
                  <input type="text" class="form-control datepicker" placeholder="DD-MM-YY">
               </div>
               <button type="submit" class="btn btn-pink">Get Report</button>
            </form>
         </div>
         <div class="col-md-8">
            <div class="row">
               <div class="col-md-12">
                  <a href="#" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                     <i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
                  </a>
                  <a href="#" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                     <i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
                  </a>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <div class="rep-container"> <div id="ember1858" class="ember-view"><!----></div> <div class="page-header text-center"><h4>Kisia ent</h4> <h3>Balance Sheet</h3> <span data-test-title="report-basis">Basis: Accrual</span> <h5 data-test-title="as-of-date">As of 20 Oct 2019</h5> <div class="tags"> <!----> </div></div> <!----> <div class="reports-table-wrapper fill-container table-container"> <table class="table zi-table financial-comparison table-no-border"><thead><tr class="rep-fin-th"> <th style="" id="ember1859" class="sortable desc text-left ember-view"><div style="position: relative" class="sort-caret"><div class="pull-left over-flow" title="Account">  Account <!---->  </div> <span class="sort hidden-print "><b class="caret up"></b> <b class="caret down"></b></span></div></th> <!----><!----> <th class="text-right over-flow">Total</th></tr></thead> <tbody> <tr> <td class="account-group-name" colspan="3"><span>Assets</span></td> </tr>  <tr>  <td style="padding-top:10px;">Current Assets</td> <td style="padding-top:10px">&nbsp;</td></tr>  <tr>  <td>Cash</td> <td>&nbsp;</td></tr>  <tr class=" balance-tr"><td class="text-left over-flow" style="padding-right:0;"> <!----> <a data-ember-action="" data-ember-action-1865="1865"> Petty Cash </a> </td> <!----> <!----> <td class="text-right"> <a data-ember-action="" data-ember-action-1866="1866"> 5,800.00 </a> </td></tr>  <tr class=" balance-tr"><td class="text-left over-flow" style="padding-right:0;"> <!----> <a data-ember-action="" data-ember-action-1869="1869"> Undeposited Funds </a> </td> <!----> <!----> <td class="text-right"> <a data-ember-action="" data-ember-action-1870="1870"> 10,000.00 </a> </td></tr>  <tr><td>&nbsp;</td> <!----> <!----> <td class="rep-ttl text-right">15,800.00</td></tr> <!---->  <!---->  <!----> <!---->  <tr class=" balance-tr"><td class="text-left over-flow" style="padding-right:0;"> <!----> <a data-ember-action="" data-ember-action-1876="1876"> Accounts Receivable </a> </td> <!----> <!----> <td class="text-right"> <a data-ember-action="" data-ember-action-1877="1877"> 4,000.00 </a> </td></tr>  <!----> <!---->  <!---->  <!---->  <tr class="rep-subttl"><td class="over-flow"><b>Total Current Assets</b></td> <!----> <!----> <td class="text-right"><b>19,800.00</b></td></tr>  <!----> <!----> <!---->  <!----> <!----> <!---->  <tr>  <td class="text-right over-flow">TOTAL ASSETS</td> <!----> <!----> <td class="rep-grandTtl">19,800.00</td></tr><tr> <td class="account-group-name" colspan="3"><span>Liabilities &amp; Equities</span></td> </tr>  <!----> <!----> <!---->  <!----> <!----> <!---->  <!----> <!----> <!---->  <tr>  <td style="padding-top:10px;">Equities</td> <td style="padding-top:10px">&nbsp;</td></tr>  <!---->  <tr class=" balance-tr"><td class="text-left over-flow" style="padding-right:0;"> <!----> <a data-ember-action="" data-ember-action-1889="1889"> Current Year Earnings </a> </td> <!----> <!----> <td class="text-right"> <a data-ember-action="" data-ember-action-1890="1890"> 19,800.00 </a> </td></tr>  <!---->  <tr class="rep-subttl"><td class="over-flow"><b>Total Equities</b></td> <!----> <!----> <td class="text-right"><b>19,800.00</b></td></tr>  <tr>  <td class="text-right over-flow">TOTAL LIABILITIES &amp; EQUITIES</td> <!----> <!----> <td class="rep-grandTtl">19,800.00</td></tr> </tbody></table> <!----> <div> <!----> <p><small>**Amount is displayed in your base currency</small>&nbsp;<span class="label label-success">KES</span></p></div> </div></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
   </div>
@endsection