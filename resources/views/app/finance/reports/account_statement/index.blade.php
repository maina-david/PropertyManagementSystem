@extends('layouts.app')
{{-- page header --}}
@section('title','Statement Of Account')

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
         <li class="breadcrumb-item active">Statement of account</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Statement Of Account </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">View Statement</h4>
            </div>
            <div class="panel-body">
               <form action="{!! route('finance.report.account.statement.process') !!}" method="post" autocomplete="off">
                  @csrf
                  <input autocomplete="false" name="hidden" type="text" style="display:none;">
                  <div class="form-group form-group-default required ">
                     {!! Form::label('title', 'Choose Client', array('class'=>'control-label')) !!}
                     <select name="client" class="form-control multiselect">
                        <option value="">Choose Customer</option>
                        @foreach($clients as $client)
                           <option value="{!! $client->id !!}">{!! $client->customer_name !!}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group form-group-default required ">
                     {!! Form::label('title', 'From Date', array('class'=>'control-label')) !!}
                     {{ Form::text('from_date', null, ['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'yyyy-mm-dd']) }}
                  </div>
                  <div class="form-group form-group-default required ">
                     {!! Form::label('title', 'To Date', array('class'=>'control-label')) !!}
                     {{ Form::text('to_date', null, ['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'yyyy-mm-dd']) }}
                  </div>
                  <div class="form-group form-group-default required ">
                     {!! Form::label('title', 'Transaction type', array('class'=>'control-label')) !!}
                     {{ Form::select('transaction_type',['All'=>'All Transactions','Credit'=>'Credit','Debit'=>'Debit'], null, ['class' => 'form-control multiselect', 'required' => '']) }}
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit">View statement</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
@endsection