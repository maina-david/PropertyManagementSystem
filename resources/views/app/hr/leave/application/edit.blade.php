@extends('layouts.app')
@section('title','Update Leave application')
@section('sidebar')
@include('app.hr.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Leave</a></li>
         <li class="breadcrumb-item active">Apply</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fad fa-calendar-check"></i> Update Leave Application</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Leave Form
               </div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['hrm.leave.apply.update',$edit->id], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                     @csrf
                     <div class="form-group form-group-default required">
                        <label for="">Leave Type</label>
                        {!! Form::select('leave_type', $types, null, array('class' => 'form-control multiselect', 'required' => '','id' => 'type')) !!}
                     </div>
                     <div class="row">
      						<div class="col-sm-6">
      							<div class="form-group form-group-default required">
      								{!! Form::label('names', 'Start', array('class'=>'control-label')) !!}
      								{!! Form::text('start_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date', 'required' => '')) !!}
      							</div>
      						</div>
      						<div class="col-sm-6">
      							<div class="form-group form-group-default">
      								{!! Form::label('Time', 'End', array('class'=>'control-label')) !!}
      								{!! Form::text('end_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date','required' => '')) !!}
      							</div>
      						</div>
      					</div>
                     <div class="form-group">
      						{!! Form::label('Description', 'Reason', array('class'=>'control-label')) !!}
      						{{ Form::textarea('reason', null, ['class' => 'form-control','size' => '3x4']) }}
      					</div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Application</button>
            					<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
