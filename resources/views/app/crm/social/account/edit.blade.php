@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Account')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu') 
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('crm.dashboard') !!}">CRM</a></li>
         <li class="breadcrumb-item"><a href="{!! route('crm.account.index') !!}">Digital Marketing</a></li>
         <li class="breadcrumb-item active">Edit Account</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-share-alt"></i> Edit Account</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Edit Account</h4>
            </div>
            <div class="panel-body">
               {!! Form::model($edit, ['route' => ['crm.account.update',$edit->accountID], 'method'=>'post']) !!}
                  <div class="form-group">
                     <label for="">Customer</label>
                     <select name="customer" class="form-control multiselect" name="customer" required> 
                        <option value="{!! $edit->customerID !!}">{!! $edit->customer_name !!}</option>  
                        @foreach($clients as $client)
                           <option value="{!! $client->id !!}">{!! $client->customer_name !!}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="">Budget Estimate</label>
                     {!! Form::text('budget', null,['class' => 'form-control','required' => '']) !!}
                  </div>
                  <div class="form-group">
                     <label for="">Description</label>
                     {!! Form::textarea('description', null,['class' => 'form-control ckeditor']) !!}
                  </div>
                  <div class="form-group">
                     <label for="">Account Date</label>
                     {!! Form::text('account_date', null,['class' => 'form-control datepicker','required' => '']) !!}
                  </div>
                  <div class="form-group">
                     <label for="">Status</label>
                     {!! Form::select('status',['' => 'Choose status', '15' => 'Active', '4' => 'Cancelled'],null,['class' => 'form-control','required' => '']) !!}
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Account</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
<script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
<script type="text/javascript">
	CKEDITOR.replaceClass="ckeditor";
</script>
@endsection