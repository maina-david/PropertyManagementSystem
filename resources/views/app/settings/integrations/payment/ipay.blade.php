
@extends('layouts.app')
{{-- page header --}}
@section('title','Integration | Payment | Ipay')
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
         <li class="breadcrumb-item active">Ipay</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> Ipay Integration</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">
                  Ipay Information
               </div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['settings.payments.integrations.ipay.update',$edit->id], 'method'=>'post']) !!}
                     @csrf
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">vendorID</label>
                        {!! Form::text('vendorID',null,['class' => 'form-control','placeholder' => 'Enter vendorID','required' => '']) !!}
                     </div> 
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Secret Key</label>
                        {!! Form::text('secretKey',null,['class' => 'form-control','placeholder' => 'Enter Secret Key','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Phone Number</label>
                        {!! Form::text('phone_number',null,['class' => 'form-control','placeholder' => 'Enter phone number','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Currency Code</label>
                        {!! Form::select('currency_code',['' => 'Choose Currency','USD' => 'USD','KES' => 'KES'],null,['class' => 'form-control']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Status</label>
                        {!! Form::select('live_or_sandbox',['' => 'Choose','Live' => 'Live','Sandbox' => 'Sandbox'],null,['class' => 'form-control']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Redirect URL </label>
                        <input type="text" name="callback_url" class="form-control" value="{!! route('callback.ipay') !!}" readonly>
                     </div>   
                     @if(Wingu::check_business_modules(20) == 1)
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Wingu store Redirect URL </label>
                           <input type="text" name="wingustore_callback_url" class="form-control" value="{!! ecommerce::get_ecommerce_details()->domain !!}/callback/ipay" readonly>
                        </div>  
                     @endif
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Details</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>


@endsection
