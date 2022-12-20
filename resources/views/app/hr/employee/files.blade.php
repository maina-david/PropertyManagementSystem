@extends('layouts.app')
{{-- page header --}}
@section('title','Employee Files')
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
			<li class="breadcrumb-item active">Employee Files</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Employee Files</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			@include('app.hr.partials._hr_employee_menu')
				<div class="col-md-9">
						@include('partials._messages')
	            	<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">Employee Files</div>
						</div>
						<div class="panel-body">
							<a  href="#" data-toggle='modal' data-target="#myModal" class="btn btn-pink mb-3 pull-right"><i class="fa fa-upload" aria-hidden="true"></i> Upload Files</a><br>
							<table class="table table-bordered">
								<tr>
									<th>#</th>
									<th>File</th>
									<th>File Name</th>
									<th>File Type</th>
									<th>File Size</th>
									<th>Action</th>
								</tr>
								@foreach($files as $fl)
									<tr>
										<td>{!! $count++ !!}</td>
										<td></td>
										<td>{!! $fl->name !!}</td>
										<td>{!! $fl->file_mime !!}</td>
										<td>{!! $fl->file_size/100000 !!} Mb</td>
										<td colspan="" rowspan="" headers="">
											<div class="btn-group sm-m-t-10">
												<a class="btn btn-danger delete" href="{{ route('hrm.employeefile.delete',$fl->id) }}"><i class="fas fa-trash"></i>
												</a>
											</div>
										</td>
									</tr>
									@endforeach
								</table>
						</div>
					</div>
		        </div>
            </div>
		</div>
	</div>
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body col-md-12">
				{!! Form::open(array('route' => 'hrm.employeefile.post','class'=>'dropzone','method' => 'post')) !!}
						{{ csrf_field() }}
						<input type="hidden" name="employee_id" value="{!! $employee->id !!}">
						{!! Form::close() !!}
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-pink submit" data-dismiss="modal" onClick="window.location.href=window.location.href">Save images</button>
				</div>
			</div>
		</div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
