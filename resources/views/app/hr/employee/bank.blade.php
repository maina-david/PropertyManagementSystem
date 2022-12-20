@extends('layouts.app')
{{-- page header --}}
@section('title','Bank Information')
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
			<li class="breadcrumb-item active">Update</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Bank Information</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			@include('app.hr.partials._hr_employee_menu')
			<div class="col-md-9">
				@include('partials._messages')
        		{!! Form::model($edit, ['route' => ['hrm.employeebankinformation.update',$employee], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
               {{ csrf_field() }}
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <div class="panel-title"><span class="green">{!! $edit->names !!}</span> - Bank Information</div>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('account_number', 'BanK Account Number', array('class'=>'control-label')) !!}
                              {!! Form::text('account_number', null, array('class' => 'form-control', 'placeholder' => 'BanK Account Number')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('bank_name', 'BanK Name', array('class'=>'control-label')) !!}
                              {!! Form::text('bank_name', null, array('class' => 'form-control', 'placeholder' => 'BanK Name')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('bank_branch', 'BanK Branch', array('class'=>'control-label')) !!}
                              {!! Form::text('bank_branch', null, array('class' => 'form-control', 'placeholder' => 'BanK Branch')) !!}
                           </div>
                        </div>
                     </div>
                     <div class="form-group"><br>
                        <center><input class="btn btn-pink submit" type="submit" value="Update Information"></center>
                     </div>
                  </div>
               </div>
            {!! Form::close() !!}
         </div>
		</div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
