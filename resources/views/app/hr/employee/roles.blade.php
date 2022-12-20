@extends('layouts.main-template')
{{-- page header --}}
@section('title','Employee Roles')
{{-- page styles --}}
@section('stylesheets')

@endsection

{{-- dashboad menu --}}
@section('main-menu')
	@include('limitless.Human-resource.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div class="content ">
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">				 
					<ul class="breadcrumb">
						<li><a href="#">Forms</a></li>
						<li><a href="#" class="active">Employee Roles</a></li>
					</ul>	
				</div>
			</div>
		</div>
		<div class="container-fluid container-fixed-lg">
			<div class="col-md-12">
            	<!-- employee side -->
				@include('limitless.Human-resource.partials._hr_employee_menu')
            	<!-- employee side -->				
        		{{-- {!! Form::model($employee, ['route' => ['employee.update',$employee->empid], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!} --}}
        			{{ csrf_field() }}
					<div class="col-md-9">
						@include('backend.partials._errors')
		            	<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title"><span class="green">{!! $employee->first_name !!} {!! $employee->last_name !!}</span> - Employee Roles</div>
							</div>
							<div class="panel-body">
								<div class="row">
									@foreach($roles as $role)
										<div class="col-sm-3">
											<div class="checkbox check-success">
												<input type="checkbox" value="1"   id="checkbox4">
												<label for="checkbox2">{!! $role->name !!}</label>
											</div>
										</div>
									@endforeach
								</div>								
								
								<div class="form-group"><br>
									<center><input class="btn btn-success" type="submit" value="Update roles"></center>
								</div>
							</div>
						</div>
			        </div>
		        {{-- {!! Form::close() !!} --}}
            </div>
		</div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection