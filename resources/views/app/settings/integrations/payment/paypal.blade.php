
@extends('layouts.app')
{{-- page header --}}
@section('title','Paypal')
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
         <li class="breadcrumb-item active">Paypal</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fab fa-cc-paypal"></i> Paypal Integration</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">
                  Paypal Information
               </div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['settings.integrations.payments.paypal.update',$edit->id], 'method'=>'post']) !!}
                     @csrf
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Paypal Email</label>
                        {!! Form::text('paypal_email',null,['class' => 'form-control','placeholder' => 'Enter paypal email','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Currency Code</label>
                        {!! Form::text('currency_code','USD',['class' => 'form-control','placeholder' => 'Enter currency code']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Status</label>
                        {!! Form::select('live_or_sandbox',['' => 'Choose','Live' => 'Live','Sandbox' => 'Sandbox'],null,['class' => 'form-control']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Conversion Rate</label>
                        {!! Form::text('paypal_conversion_rate',null,['class' => 'form-control','required' => '', 'placeholder' => 'Enter conversion rate']) !!}
                     </div> 
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Redirect URL </label>
                        <input type="text" name="callback_url" class="form-control" value="https://payments.winguplus.com/paypal" readonly>
                     </div>    
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Cancel URL</label>
                        <input type="text" name="	cancel_url" class="form-control" value="https://payments.winguplus.com/paypal/cancel" readonly>
                     </div> 
                     @if(Wingu::check_business_modules(20) == 1)
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Wingu Store Redirect URL </label>
                           <input type="text" name="wingustore_callback_url" class="form-control" value="{!! ecommerce::get_ecommerce_details()->domain !!}/callback/ipay" readonly>
                        </div>  
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Wingu Store Cancel URL</label>
                           <input type="text" name="wingustore_cancel_url" class="form-control" value="{!! ecommerce::get_ecommerce_details()->domain !!}/callback/ipay" readonly>
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
