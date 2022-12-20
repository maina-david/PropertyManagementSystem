@extends('layouts.backend')
{{-- page header --}}
@section('title','Payment Gateways')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Integrations</li>
         <li class="breadcrumb-item active">pesapal</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-credit-card"></i> Pesapal Integration</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">
                  Pesapal Information
               </div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['settings.integrations.payments.pesapal.update',$edit->id], 'method'=>'post']) !!}
                     @csrf
                     <div class="form-group form-group-default">
                        <label for="name">Customer key</label>
                        {!! Form::text('customer_key',null,['class' => 'form-control','placeholder' => 'Enter customer key','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Customer secret</label>
                        {!! Form::text('customer_secret',null,['class' => 'form-control','required' => '','placeholder' => 'Enter customer secret']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Iframelink</label>
                        {!! Form::text('iframelink',null,['class' => 'form-control','required' => '', 'placeholder' => 'Enter customer iframelink']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Callback url</label>
                        {!! Form::text('callback_url',null,['class' => 'form-control','required' => '', 'placeholder' => 'Enter customer callback url']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Choose status</label>
                        {!! Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control'] ) !!}
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update gateway</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>

  
@endsection

