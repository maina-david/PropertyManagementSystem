@extends('layouts.app')
{{-- page header --}}
@section('title','Africas Talking')
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
         <li class="breadcrumb-item">Telephony</li>
         <li class="breadcrumb-item active">Africas Talking</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-mobile-alt"></i> Africas Talking Integration</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">Africas Talking Information</div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['settings.integrations.telephony.africasTalking.update',$edit->id], 'method'=>'post']) !!}
                     @csrf
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Username</label>
                        {!! Form::text('at_username',null,['class' => 'form-control','placeholder' => 'Enter username','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">API Key</label>
                        {!! Form::text('at_apikey',null,['class' => 'form-control', 'required' => '','placeholder' => 'Enter API key']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">From Number</label>
                        {!! Form::text('sms_from',null,['class' => 'form-control','required' => '', 'placeholder' => 'e.x 254700123456']) !!}
                     </div>  
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Choose status</label>
                        {!! Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control multiselect'] ) !!}
                     </div>   
                     <div class="form-group form-group-default">
                        <label for="">Make default telephony</label>
                        {!! Form::select('default',['' => 'Choose','Yes' => 'Yes'], null,['class' => 'form-control multiselect'] ) !!}
                     </div>                   
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>

  
@endsection

