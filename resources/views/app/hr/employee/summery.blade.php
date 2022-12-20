@extends('layouts.app')
{{-- page header --}}
@section('title','Summary')

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
			<li class="breadcrumb-item active">Summery</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fas fa-address-card"></i> Employee Summery</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			@include('app.hr.partials._hr_employee_menu')
			<div class="col-md-9">
				@include('partials._messages')
        		{!! Form::model($edit, ['route' => ['hrm.employeesummery.update',$edit->empid], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
        			{{ csrf_field() }}
            	<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title"><span class="green">{!! $edit->names !!}</span> - Summery Information</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										{!! Form::label('Job Description', 'Job Description', array('class'=>'control-label')) !!}
										{!! Form::textarea('job_description',null,['class'=>'ck4standard form-control ckeditor', 'rows' => 5, 'placeholder'=>'content']) !!}
									</div>
								</div>
								<div class="col-md-12 mt-5">
									<div class="form-group">
										{!! Form::label('About Employee', 'About Employee', array('class'=>'control-label')) !!}
										{!! Form::textarea('about_me',null,['class'=>'ck4standard form-control ckeditor', 'rows' => 5, 'placeholder'=>'content']) !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<center>
									<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information</button>
									<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
								</center>
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
	<script src="{!! asset('assets/plugins/ckeditor/4/full/ckeditor.js') !!}"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
