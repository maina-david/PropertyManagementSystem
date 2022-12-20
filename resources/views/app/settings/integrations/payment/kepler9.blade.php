
@extends('layouts.app')
{{-- page header --}}
@section('title','kepler9')
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
         <li class="breadcrumb-item active">kepler9</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> kepler9 Integration</h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header">
                  kepler9 Information
               </div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['settings.integrations.payments.kepler9.update',$edit->id], 'method'=>'post']) !!}
                     @csrf
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Client ID	</label>
                        {!! Form::text('clientID',null,['class' => 'form-control','placeholder' => 'Enter Client ID','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Client Secret</label>
                        {!! Form::text('client_secret',null,['class' => 'form-control','placeholder' => 'Enter Client Key','required' => '']) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Payments Notifications URL</label>
                        <input type="text" name="callback_url" class="form-control" value="{!! route('callback.kepler9') !!}" readonly>
                     </div>
                     <div class="form-group form-group-default required">
                        <label for="name" class="text-danger">Redirect URL</label>
                        <input type="text" name="callback_url" class="form-control" value="{!! route('callback.kepler9') !!}" readonly>
                     </div>                     
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
