@extends('layouts.app')
@section('title','Create Agents')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb --> 
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
      <li class="breadcrumb-item"><a href="{!! route('property.agents') !!}">Agents</a></li>
      <li class="breadcrumb-item active"><a href="">Create</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-user-tie"></i> Agents - Create</h1>
   <!-- end breadcrumb -->
   <div class="card card-default">
      <div class="card-body">
         @include('partials._messages')
         <form class="row" method="post" action="{!! route('property.agents.store') !!}" enctype="multipart/form-data">
            @csrf
            <div class="col-sm-6">
               <div class="form-group form-group-default required">
                  {!! Form::label('names', 'Agent Names', array('class'=>'control-label text-danger')) !!}
                  {!! Form::text('names', null, array('class' => 'form-control', 'placeholder' => 'Enter Names', 'required' =>'' )) !!}
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group form-group-default required">
                  {!! Form::label('Gender', 'Gender', array('class'=>'control-label text-danger')) !!}
                  {{ Form::select('gender',[''=>'Choose Gender','Male'=>'Male','Female'=>'Female'], null, ['class' => 'form-control multiselect','required' =>'']) }}
               </div>
            </div>            
            <div class="col-sm-6">
               <div class="form-group form-group-default required">
                  {!! Form::label('Email', 'Email', array('class'=>'control-label text-danger')) !!}
                  {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Enter email', 'required' => '')) !!}
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group form-group-default required">
                  {!! Form::label('phone_number', 'Phone Number', array('class'=>'control-label text-danger')) !!}
                  {!! Form::text('phone_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Phone Number','required' =>'' )) !!}
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  {!! Form::label('contract type', 'Contract type', array('class'=>'control-label')) !!}
                  {{ Form::select('contract_type',[''=>'Select contract','Permanent'=>'Permanent','On Contract'=>'On Contract','Temporary'=>'Temporary','Trainee'=>'Trainee'], null, ['class' => 'form-control multiselect']) }}
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group form-group-default">
                  {!! Form::label('hire_date', 'Date joined', array('class'=>'control-label')) !!}
                  {!! Form::date('hire_date', null, array('class' => 'form-control', 'placeholder' => 'Date of hire')) !!}
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group form-group-default">
                  {!! Form::label('Agent Image', 'Agent Image', array('class'=>'control-label')) !!}<br>
                  {{ Form::file('image', null, ['class' => 'form-control']) }}
               </div>
            </div>
            <div class="col-md-12 mt-3">
               <center>
                  <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Save information</button>
                  <img src="{!! asset('assets/app/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection