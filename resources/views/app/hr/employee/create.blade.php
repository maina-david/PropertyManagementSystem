@extends('layouts.app')
{{-- page header --}}
@section('title','Add Employee ')

{{-- dashboad menu --}}
@section('sidebar')
@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.employee.index') !!}">Employee</a></li>
         <li class="breadcrumb-item active">Add Employee</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-plus"></i> Add Employee </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
		<div class="row">
         <div class="col-md-3">
         	<div class="panel panel-white">
              	<div class="panel-body">
                  <ul class="nav nav-pills nav-stacked hr-menu">
                     <li class="active">
         					<a href="#"> <i class="fas fa-info-circle"></i> <b>Employment Information</b></a>
         				</li>
                     <li class="mt-2">
                      	<a href="javascript:alert('Please submit the employment information first')">
                      		<i class="fas fa-male"></i> <b>Personal Information</b>
                      	</a>
                     </li>
                     <li>
                        <a href="javascript:alert('Please submit the employment information first')">
         						<i class="fas fa-money-check-alt"></i> <b>Salary & Bank information</b>
         					</a>
                     </li>
                     <li>
                        <a href="javascript:alert('Please submit the employment information first')">
         						<i class="fas fa-minus"></i> <b> Salary Deductions</b>
         					</a>
                     </li>
                     <li>
                        <a href="javascript:alert('Please submit the employment information first')">
         						<i class="fas fa-graduation-cap"></i> <b>Academic training Information</b>
         					</a>
                     </li>
                     <li>
                       	<a href="javascript:alert('Please submit the employment information first')">
         						<i class="fas fa-business-time"></i> <b>Work experience</b>
         					</a>
                     </li>
                     <li>
                        <a href="javascript:alert('Please submit the employment information first')">
                        	<i class="fa fa-users" aria-hidden="true"></i> <b> Family Information / Dependent</b>
                        </a>
                     </li>
                  </ul>
              </div>
          	</div>
         </div>
         <div class="col-md-9">
            {!! Form::open(array('route' => 'hrm.employee.store','enctype'=>'multipart/form-data','method'=>'post','autocomplete' => 'off')) !!}
               @csrf
               <div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">Employement Details</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default required">
										{!! Form::label('names', 'Employee Names', array('class'=>'control-label text-danger')) !!}
										{!! Form::text('names', null, array('class' => 'form-control', 'placeholder' => 'Employee Names', 'required' =>'' )) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('Gender', 'Gender', array('class'=>'control-label')) !!}
										{{ Form::select('gender',[''=>'Choose Gender','Male'=>'Male','Female'=>'Female'], null, ['class' => 'form-control multiselect']) }}
									</div>
								</div>
                        <div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('Leave Days', 'Leave Days', array('class'=>'control-label')) !!}
										{{ Form::number('leave_days',null, ['class' => 'form-control','placeholder'=>'Enter leave days']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label for="">Department</label>
										{{ Form::select('department',$departments, null, ['class' => 'form-control multiselect']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label for="">Position/Job title</label>
										{{ Form::select('position',$positions, null, ['class' => 'form-control multiselect']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label for="">Branch</label>
										{{ Form::select('branch',$branches, null, ['class' => 'form-control multiselect']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label for="">People to report to.</label>
										{{ Form::select('report_to[]',$employees, null, ['class' => 'form-control multiple-select2','multiple' => 'multiple']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label for="">Departments to head</label>
										{{ Form::select('lead_department[]',$departments, null, ['class' => 'form-control multiple-deps','multiple' => 'multiple']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										{!! Form::label('company_id', 'Company ID', array('class'=>'control-label')) !!}
										{!! Form::text('companyID', null, array('class' => 'form-control', 'placeholder' => 'Enter Company ID')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('company_email', 'Company Email', array('class'=>'control-label')) !!}
										{!! Form::email('company_email', null, array('class' => 'form-control', 'placeholder' => 'Enter company email')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('company_phone_number', 'Company Phone Number', array('class'=>'control-label')) !!}
										{!! Form::text('company_phone_number', null, array('class' => 'form-control', 'placeholder' => 'Enter company Phone Number')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('office_phone_extention', 'Office phone extention', array('class'=>'control-label')) !!}
										{!! Form::text('office_phone_extension', null, array('class' => 'form-control', 'placeholder' => 'Enter company phone extention')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('source_of_hire', 'Source of Hire', array('class'=>'control-label')) !!}
										{!! Form::text('source_of_hire', null, array('class' => 'form-control', 'placeholder' => 'Enter source of hire')) !!}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										{!! Form::label('employment_type', 'Contract type', array('class'=>'control-label')) !!}
										{{ Form::select('contract_type',[''=>'Select contract','Permanent'=>'Permanent','On Contract'=>'On Contract','Temporary'=>'Temporary','Trainee'=>'Trainee'], null, ['class' => 'form-control multiselect']) }}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('hire_date', 'Date joined', array('class'=>'control-label')) !!}
										{!! Form::date('hire_date', null, array('class' => 'form-control datepicker')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('employment_status', 'Employment status', array('class'=>'control-label')) !!}
										{{ Form::select('statusID',[''=>'Choose Status','25'=>'Employed','26'=>'Terminated','27'=>'Deceased','28'=>'Resigned'], null, ['class' => 'form-control multiselect']) }}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('temporary_exist_date', 'Date of Exit if Temporary', array('class'=>'control-label')) !!}
										{!! Form::date('temporary_exist_date', null, array('class' => 'form-control datepicker')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('termination_date', 'Termination date', array('class'=>'control-label')) !!}
										{!! Form::date('termination_date', null, array('class' => 'form-control datepicker')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('Employee Image', 'Employeent Image', array('class'=>'control-label')) !!}
										{{ Form::file('image', null, ['class' => 'form-control']) }}
									</div>
								</div>
								<div class="col-md-12 mt-3">
									<center>
										<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save information</button>
										<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
									</center>
								</div>
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
@section('scripts')
   <script type="text/javascript">
		$(".multiple-select2").select2();
		$(".multiple-deps").select2();
	</script>
@endsection