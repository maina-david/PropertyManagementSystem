@extends('layouts.app')
{{-- page header --}}
@section('title','Mpesa Till Number')
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
         <li class="breadcrumb-item active">M-Pesa Paybill Number</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> M-Pesa Paybill Number</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  M-Pesa Paybill Number
               </div>
               <div class="card-body">
                  {!! Form::model($integration, ['route' => ['settings.payments.integrations.mpesa.paybillnumber.update',$integration->id], 'method'=>'post']) !!}
                     @csrf
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Business Name</label>
                        {!! Form::text('mpesa_name',null,['class' => 'form-control','placeholder' => 'Enter Business Name','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Paybill Number</label>
                        {!! Form::text('paybill_number',null,['class' => 'form-control','placeholder' => 'Enter Paybill Number','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Account Number</label>
                        {!! Form::text('paybill_account_number',null,['class' => 'form-control','required' => '','placeholder' => 'Enter Account Number']) !!}
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Details</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="20%">
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>


@endsection
