@extends('layouts.app')
{{-- page header --}}
@section('title','Personal Information ')
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
			<li class="breadcrumb-item active">Personal Information</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fas fa-male"></i> Personal Information</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			@include('app.hr.partials._hr_employee_menu')
			<div class="col-md-9">
				@include('partials._messages')
        		{!! Form::model($edit, ['route' => ['hrm.personalinfo.update',$edit->empid], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data','autocomplete' => 'off']) !!}
        			{{ csrf_field() }}
            	<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title"><span class="green">{!! $employee->names !!} </span> - Personal Information</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('personal_email', 'Personal Email', array('class'=>'control-label')) !!}
										{!! Form::email('personal_email', null, array('class' => 'form-control', 'placeholder' => 'Enter Personal Email')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('personal_number', 'Personal Number', array('class'=>'control-label')) !!}
										{!! Form::text('personal_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Personal Number')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										{!! Form::label('id_number', 'ID Number', array('class'=>'control-label')) !!}
										{!! Form::text('nationalID', null, array('class' => 'form-control', 'placeholder' => 'Enter ID Number')) !!}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										{!! Form::label('marital_status', 'Marital status', array('class'=>'control-label')) !!}
										{{ Form::select('marital_status',[''=>'Choose Marital multiselect','Single'=>'Single','Married'=>'Married'], null, ['class' => 'form-control']) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										{!! Form::label('passport_number', 'Passport Number', array('class'=>'control-label')) !!}
										{!! Form::text('passport_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Passport Number')) !!}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										{!! Form::label('nationality', 'Nationality', array('class'=>'control-label')) !!}
										{{ Form::text('nationality', null, ['class' => 'form-control', 'placeholder' => 'Enter nationality']) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('dob', 'Date of Birth', array('class'=>'control-label')) !!}
										{!! Form::text('dob', null, array('class' => 'form-control datepicker', 'placeholder' => 'Enter Date of Birth')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('home_address', 'Home Address', array('class'=>'control-label')) !!}
										{!! Form::text('home_address', null, array('class' => 'form-control', 'placeholder' => 'Enter Home Address')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('current home location', 'Current Home Location', array('class'=>'control-label')) !!}
										{!! Form::text('current_home_location', null, array('class' => 'form-control', 'placeholder' => 'Enter Current Home Location')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('region_of_birth', 'Region of Birth', array('class'=>'control-label')) !!}
										{!! Form::text('region_of_birth', null, array('class' => 'form-control', 'placeholder' => 'Enter Region of Birth')) !!}
									</div>
								</div>
							</div>
							{{-- <div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('nssf_number', 'NSSF Number', array('class'=>'control-label')) !!}
										{!! Form::text('nssf_number', null, array('class' => 'form-control', 'placeholder' => 'Enter NSSF Number')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('nhif_number', 'NHIF Number', array('class'=>'control-label')) !!}
										{!! Form::text('nhif_number', null, array('class' => 'form-control', 'placeholder' => 'Enter NHIF Number')) !!}
									</div>
								</div>
							</div> --}}
							<div class="row">
								{{-- <div class="col-sm-6">
									<div class="form-group form-group-default required">
										{!! Form::label('helb_loan_amount', 'Helb Loan Amount', array('class'=>'control-label')) !!}
										{!! Form::number('helb_loan_amount', null, array('class' => 'form-control', 'placeholder' => 'Enter Helb Loan Amount')) !!}
									</div>
								</div> --}}
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('religion', 'Religion', array('class'=>'control-label')) !!}
										{!! Form::select('religion', ['' => 'Choose Religion','Christian' => 'Christian','Islam' => 'Islam','Nonreligious' => 'Nonreligious','Hinduism' => 'Hinduism','Buddhism' => 'Buddhism'], null , array('class' => 'form-control multiselect')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('hospital_of_choice', 'Hospital of choice', array('class'=>'control-label')) !!}
										{!! Form::text('hospital_of_choice', null, array('class' => 'form-control', 'placeholder' => 'Enter Hospital of choice')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">

								</div>
							</div>
							<div class="form-group"><br>
								<center><input class="btn btn-pink submit" type="submit" value="Update Information"></center>
								<center><img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%"></center>
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
