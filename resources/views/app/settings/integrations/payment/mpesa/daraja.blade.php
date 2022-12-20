@extends('layouts.app')
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
         <li class="breadcrumb-item active">M-pesa</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-credit-card"></i> M-pesa daraja</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  M-pesa daraja
               </div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['settings.integrations.payments.mpesa.update',$edit->id], 'method'=>'post']) !!}
                     @csrf
                     <div class="form-group form-group-default">
                        <label for="name">Business Name</label>
                        {!! Form::text('title',null,['class' => 'form-control','placeholder' => 'Enter app name','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Consumer key</label>
                        {!! Form::text('merchant_consumer_key',null,['class' => 'form-control','placeholder' => 'Enter Consumer key','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="name">Customer secret</label>
                        {!! Form::text('merchant_consumer_secret',null,['class' => 'form-control','required' => '','placeholder' => 'Enter Consumer secret']) !!}
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Paybill Number</label>
                              {!! Form::text('paybill_number',null,['class' => 'form-control','placeholder' => 'Enter paybill Number']) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Lipa Na Mpesa</label>
                              {!! Form::text('till_number',null,['class' => 'form-control','placeholder' => 'Enter Lipa Na Mpesa Number']) !!}
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name">Payment Confrimation callback URL</label>
                        @if($edit->daraja_url_registered == "")
                           <a class="btn btn-sm btn-primary pull-right" href="{!! route('settings.integrations.daraja.register.urls',Wingu::business()->businessID) !!}">Register URL</a>
                        @endif
                        <input type="text" name="callback_url" value="{!! route('daraja.payment.callback',Wingu::business()->businessID) !!}" class="form-control mt-1" readonly>
                     </div>
                     <div class="form-group">
                        <label for="name">Payment Cancellation callback URL</label>
                        <input type="text" name="cancel_url" value="{!! route('daraja.payment.cancel.callback',Wingu::business()->businessID) !!}" class="form-control" readonly>
                     </div>
                     <div class="row">                        
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Choose status</label>
                              {!! Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control'] ) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Environment</label>
                              {!! Form::select('live_or_sandbox',['' => 'Choose your environment','sandbox' => 'Sandbox', 'live' => 'Live'], null,['class' => 'form-control','required' => ''] ) !!}
                           </div>
                        </div>
                     </div>                     
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="40%">
                     </div>
                     <br>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection

