@extends('layouts.app')
{{-- page header --}}
@section('title','Work Experience')
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
			<li class="breadcrumb-item active">Work Experience</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fa fa-briefcase" aria-hidden="true"></i> Work Experience</h1>  
		<!-- end page-header -->
		<div class="row">
			<!-- employee side --> 
			@include('app.hr.partials._hr_employee_menu')
			<div class="col-md-9">
				@include('partials._messages')
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title"><span class="green">{!! $employee->names !!}</span> - Work experience</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Previous Work experiences</div>
						<div class="panel-body">
							<div class="row">
								<table class="table table-bordered">
									<tr>
										<th>#</th>
										<th>Company Name</th>
										<th>Job Title</th>
										<th>From Date</th>
										<th>To Date</th>
										<th>Job Description</th>
										<th>Action</th>
									</tr>
									@foreach($experiences as $experience)
										<tr>
											<td>{!! $count++ !!}</td>
											<td>{!! $experience->previous_company_name !!}</td>
											<td>{!! $experience->job_title !!}</td>
											<td>{!! $experience->date_started !!}</td>
											<td>{!! $experience->date_stopped !!}</td>
											<td>{!! $experience->job_description !!}</td>
											<td colspan="" rowspan="" headers="">
												<div class="btn-group sm-m-t-10">
													{{-- <a  data-toggle='modal' data-target="#myModal" class="btn btn-default"><i class="fas fa-edit"></i></a> --}}
													<a class="btn btn-danger delete" href="{{ route('hrm.experience.delete', $experience->id) }}"><i class="fas fa-trash"></i></a>
												</div>
											</td>
										</tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Add Previous Work Experience</div>
						{!! Form::open(array('route' => 'hrm.experience.store','enctype'=>'multipart/form-data','data-parsley-validate' => '', 'method'=>'post' )) !!}
						<div class="panel-body">
							<div class="row">
								{{ csrf_field() }}
								<table class="table table-bordered experience">
									<tr>
										<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
										<th>#</th>
										<th>Company Name</th>
										<th>Job Title</th>
										<th>From Date</th>
										<th>To Date</th>
										<th>Job Description</th>
									</tr>
									<tr>
										<td><input type='checkbox' class='case'/></td>
										<td><span id='snum'>1.</span></td>
										<td><input class="form-control" type='text' id='prev_company' name='prev_company[]' ></td>
										<td><input class="form-control" type='text' id='prev_job_title' name='prev_job_title[]' ></td>
										<td><input class="form-control date-picker" type='date' id='prev_from' name='prev_from[]' ></td>
										<td><input class="form-control date-picker" type='date' id='prev_to' name='prev_to[]' > </td>
										<td><input class="form-control" type='text' id='prev_job_description' name='prev_job_description[]' > </td>
										<td class="d-none">
											<input class="form-control" type='text' id='employee_id' name='employeeID[]' value='{!! $employee->id !!}'>
										</td>
									</tr>
								</table>
								<button type="button" class='btn btn-danger delete_experience'>- Delete</button>
								<button type="button" class='btn btn-success addmore_experience'>+ Add More</button>
							</div>
							<div class="form-group"><br>
								<center>
									<button class="btn btn-primary submit" type="submit"><i class="fas fa-plus"></i> Add Experience </button>
									<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%"></center>
							</div>
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
	<script>

		$(".delete_experience").on('click', function() {
			$('.case:checkbox:checked').parents("tr").remove();
			$('.check_all').prop("checked", false);
			check();
		});

		var i=$('.experience tr').length;
		$(".addmore_experience").on('click',function(){
			count=$('.experience tr').length;
			var data="<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
			data +="<td><input class='form-control' type='text' id='prev_company_"+i+"' name='prev_company[]'/></td><td><input class='form-control' type='text' id='prev_job_title_"+i+"' name='prev_job_title[]'/></td><td><input class='form-control date-picker' type='date' id='prev_from_"+i+"' name='prev_from[]'/></td><td><input class='form-control date-picker' type='date' id='prev_to_"+i+"' name='prev_to[]'/></td><td><input class='form-control' type='text' id='prev_job_description_"+i+"' name='prev_job_description[]'/></td><td style='display:none'><input class='form-control' type='text' id='employee_id' name='employeeID[]' value='{!! $employee->id  !!}' required=''></td></tr>";
			$('.experience').append(data);
		});
	</script>
@endsection
