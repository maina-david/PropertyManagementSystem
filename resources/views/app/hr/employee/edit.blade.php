@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Employee ')

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
            <li class="breadcrumb-item active">Details</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header"><i class="fas fa-user-circle"></i> Employement Details</h1>
        <!-- end page-header -->
		<div class="row">
			@include('app.hr.partials._hr_employee_menu')
			<div class="col-md-9">
				@include('partials._messages')
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">{!! $employee->names !!} - Employement Details</div>
					</div>
					<div class="panel-body">
						{!! Form::model($employee, ['route' => ['hrm.employee.update',$employee->id], 'method'=>'post','enctype' => 'multipart/form-data','class' => 'row']) !!}
							@csrf
							<div class="col-sm-6">
								<div class="form-group form-group-default required">
									{!! Form::label('names', 'Employee Names', array('class'=>'control-label text-danger')) !!}
									{!! Form::text('names', null, array('class' => 'form-control', 'placeholder' => 'Employee Names','required' => '')) !!}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									{!! Form::label('Gender', 'Gender', array('class'=>'control-label')) !!}
									{{ Form::select('gender',[''=>'Choose Gender','Male'=>'Male','Female'=>'Female'], null, ['class' => 'form-control']) }}
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
									{{ Form::select('report_to[]',$joinReport, null, ['class' => 'form-control multiple-select2','multiple' => 'multiple']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="">Departments to head</label>
									{{ Form::select('lead_department[]',$joinDepartments, null, ['class' => 'form-control multiple-deps','multiple' => 'multiple']) }}
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
									{!! Form::date('hire_date', null, array('class' => 'form-control')) !!}
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
									{!! Form::date('temporary_exist_date', null, array('class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									{!! Form::label('termination_date', 'Termination date', array('class'=>'control-label')) !!}
									{!! Form::date('termination_date', null, array('class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									{!! Form::label('Employee Image', 'Employeent Image', array('class'=>'control-label')) !!}
									{{ Form::file('image', null, ['class' => 'form-control']) }}
								</div>
								@if ($employee->image != "")
									<a href="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/hr/employee/images/'.$employee->image) !!}" target="_blank">Click here to view image</a>
								@endif
							</div>
							<div class="col-md-12 mt-3">
								<center>
									<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save information</button>
									<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
								</center>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script type="text/javascript">
		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val({!! json_encode($jointLeaders) !!}).trigger('change');
		$(".multiple-deps").select2();
		$(".multiple-deps").select2().val({!! json_encode($jointHeads) !!}).trigger('change');
	</script>
@endsection
