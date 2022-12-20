@extends('layouts.app')
{{-- page header --}}
@section('title','Family Information')
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
			<li class="breadcrumb-item active">Family Information</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Family Information</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			@include('app.hr.partials._hr_employee_menu')	
				<div class="col-md-9">
					@include('partials._messages')
	            <div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title"> Family Information</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">All Family Information</div>
							<div class="panel-body">
								<div class="row">
									<table class="table table-bordered">
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Relationship</th>
											<th>Date of birth</th>
											<th>Contact (Where Needed)</th>
											<th>Action</th>
										</tr>
										@foreach($family as $fam)
											<tr>
												<td>{!! $count++ !!}</td>
												<td>
													{!! $fam->family_name !!}<br>
													@if($fam->contact_type == 'S')
														<b>Secondary</b>
													@elseif($fam->contact_type == 'P')
														<b>Primary</b>
													@endif
												</td>
												<td>{!! $fam->relationship !!}</td>
												<td>{!! $fam->family_dob !!}</td>
												<td>{!! $fam->family_contact !!}</td>
												<td>
													<a class="btn btn-danger delete" href="{{ url('hrm/delete-family-information/'.$fam->id) }}">
														<i class="fas fa-trash"></i>
													</a>
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
							<div class="panel-title">Add Information</div>
							{!! Form::open(array('url' => 'hrm/family-information-post','enctype'=>'multipart/form-data','data-parsley-validate' => '', 'method'=>'post' )) !!}
							<div class="panel-body">
								<div class="row">
    								{{ csrf_field() }}
									<table class="table table-bordered family">
										<tr>
											<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
											<th>#</th>
											<th>Name</th>
											<th>Relationship</th>
											<th>Date of birth</th>
											<th>Contact (Where Needed)</th>
										</tr>
										<tr>
											<td><input type='checkbox' class='case'/></td>
											<td><span id='snum'>1.</span></td>
											<td><input class="form-control" type='text' id='family_name' name='family_name[]' required></td>
											<td><select class="form-control" id='relationship' name='relationship[]' required><option value="">Select</option><option>Father</option><option>Mother</option><option>Brother</option><option>Sister</option><option>Husband</option><option>Wife</option><option>Child</option></select></td>
											<td><input class="form-control" type='date' id='family_dob' name='family_dob[]' required></td>
											<td>
												<input class="form-control" type='text' id='family_contact' name='family_contact[]'> 
												<select name="contact_type" class="form-control" id="contact_type">
													<option value="">Choose contact type</option>
													<option>Primary</option>
													<option>Secondary</option>
												</select>
											</td>
											<td style='display:none'>
												<input class='form-control' type='text' id='employee_id' name='employee_id[]' value='{!! $employee->id !!}' required=''></td>
										</tr>
									</table>
									<button type="button" class='btn btn-danger delete_family'>- Delete</button>
				               <button type="button" class='btn btn-success addmore_family'>+ Add More</button>
								</div>
								<div class="form-group"><br>
									<center><input class="btn btn-pink submit" type="submit" value="Add Family information">
										<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%"></center>
								</div>
							</div>
							{!! Form::close() !!}
						</div>
		        	</div>
        		</div>
			</div>
		</div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>

	    $(".delete_family").on('click', function() {
	        $('.case:checkbox:checked').parents("tr").remove();
	        $('.check_all').prop("checked", false);
	        check();
        });

	    var i=$('.family tr').length;
	    $(".addmore_family").on('click',function(){
		    count=$('.family tr').length;
		    var data="<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
		    data +="<td><input class='form-control' type='text' id='family_name_"+i+"' name='family_name[]'/></td><td><select class='form-control' id='relationship_' name='relationship[]' required><option value=''>Select</option><option>Father</option><option>Mother</option><option>Brother</option><option>Sister</option><option>Husband</option><option>Wife</option><option>Child</option></select></td><td><input class='form-control' type='date' id='family_dob_"+i+"' name='family_dob[]' required/></td><td><input class='form-control' type='text' id='family_contact_"+i+"' name='family_contact[]' required/><select name='contact_type' class='form-control' id='contact_type_"+i+"'><option value=''>Choose contact type</option><option>Primary</option><option>Secondary</option></select></td><td style='display:none'><input class='form-control' type='text' id='employee_id' name='employee_id[]' value='{!! $employee->id !!}' required=''></td></tr>";
		    $('.family').append(data);
	    });
    </script>
@endsection
