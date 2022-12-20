@extends('layouts.app')
{{-- page header --}}
@section('title','Applications Billing')

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
         <li class="breadcrumb-item"><a href="{!! route('wingu.dashboard') !!}">Settings</a></li>
         <li class="breadcrumb-item"><a href="{!! route('settings.business.index') !!}"> Applications</a></li>
         <li class="breadcrumb-item active">Billing</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-usd-circle"></i> Applications Billing</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="container">
         <div class="row justify-content-md-center">
            <div class="col-8">
               <div class="card">
                  <div class="card-body"> 
                     <h4>
                        <b>Application:</b> {!! $module->name !!}<br>
                        @if($location->countryName == 'Kenya')
                           <b>Price:</b> ksh{!! number_format($module->module_price * 100) !!}<br>
                        @else 
                           <b>Price:</b> ${!! $module->module_price !!}<br>
                        @endif
                        <b>Duration:</b> {!! $durations !!} 
                     </h4> 
                     <form action="https://payments.ipayafrica.com/v3/ke">
                        <input name="hsh" type="hidden" value="{!! Wingu::ipay($module->business_module_id) !!}">  
                        <input type="hidden" name="live" value="1" class="form-control">
                        <input type="hidden" name="oid" value="{!! $module->business_module_id !!}" class="form-control">
                        <input type="hidden" name="inv" value="{!! Wingu::business()->businessID !!}" class="form-control">
                        <input type="hidden" name="tel" value="0700000000" class="form-control">
                        <input type="hidden" name="eml" value="{!! Wingu::business()->primary_email !!}" class="form-control">
                        <input type="hidden" name="vid" value="treeb" class="form-control">
                        @if($location->countryName == 'Kenya')
                           <input type="hidden" name="curr" value="KES" class="form-control">
                           <input type="hidden" name="ttl" value="{!! $module->module_price * 100 !!}" class="form-control">
                           <input type="hidden" name="mpesa" value="1" class="form-control">
                           <input type="hidden" name="p3" value="KES" class="form-control">
                        @else 
                           <input type="hidden" name="curr" value="USD" class="form-control">
                           <input type="hidden" name="ttl" value="{!! $module->module_price !!}" class="form-control">
                           <input type="hidden" name="mpesa" value="0" class="form-control">
                           <input type="hidden" name="p3" value="USD" class="form-control">
                        @endif                        
                        <input type="hidden" name="p1" value="Webpayment" class="form-control">
                        <input type="hidden" name="p2" value="{!! Auth::user()->businessID !!}" class="form-control">
                        
                        <input type="hidden" name="p4" value="" class="form-control">
                        <input type="hidden" name="cbk" value="{!! route('wingu.application.payment') !!}" class="form-control">
                        <input type="hidden" name="cst" value="1" class="form-control">
                        <input type="hidden" name="crl" value="0" class="form-control">
                        <center>
                           <button class="btn btn-block btn-success submit" type="submit">Make Payment</button>
                        </center>
                     </form>
                  </div>
               </div>
            </div>
         </div>   
      </div>    
   </div>
@endsection
