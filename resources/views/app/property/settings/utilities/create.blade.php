@extends('layouts.app')
{{-- page header --}}
@section('title','Add Utility')
@section('sidebar')
	@include('app.property.partials._menu')
@endsection
{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings | Utilities | Add Utilities</h1>
      <div class="row">
      @include('app.property.settings._settings_nav')
      <div class="col-md-9">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Utility Details</h4>
            </div>
            <div class="panel-body">
               <form action="{!! route('property.utilities.store') !!}" method="post">
                  @csrf
                  <div class="form-group form-group-default required ">
                     {!! Form::label('title', 'Utility Name', array('class'=>'control-label')) !!}
                     {{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'placeholder' => 'Enter name']) }}
                  </div>
                  <div class="form-group">
                     {!! Form::label('title', 'Utility Description', array('class'=>'control-label')) !!}
                     {{ Form::textarea('description', null, ['class' => 'form-control', 'required' => '']) }}
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Utility</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                     </center>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   </div>
@endsection
