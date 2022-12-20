@extends('layouts.app')
{{-- page header --}}
@section('title','Mpesa Phone Number')
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
         <li class="breadcrumb-item active">M-Pesa Phone Number</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> M-Pesa Phone Number</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  M-Pesa Phone Number
               </div>
               <div class="card-body">
                  {!! Form::model($integration, ['route' => ['settings.payments.integrations.mpesa.phonenumber.update',$integration->id], 'method'=>'post']) !!}
                     @csrf
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Mpesa Phone Number</label>
                        {!! Form::text('mpesa_phone_number',null,['class' => 'form-control','placeholder' => '+254 700 000 000','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Mpesa Name</label>
                        {!! Form::text('mpesa_name',null,['class' => 'form-control','placeholder' => 'Enter Mpesa Name','required' => '']) !!}
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
