@extends('layouts.main-template')
{{-- page header --}}
@section('title','Edit Exit Details')
{{-- page styles --}}
@section('stylesheets')
	{!!Html::style('resources/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')!!}
	{!!Html::style('resources/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')!!}
	{!!Html::style('resources/assets/plugins/datatables-responsive/css/datatables.responsive.css')!!}
@endsection

{{-- dashboad menu --}}
@section('main-menu')
	@include('Limitless.Human-resource.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div class="content clearfix"> 
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">					 
					<ul class="breadcrumb">
						<li><a href="#">Human Resource</a></li>
						<li><a href="#" class="active">Edit Exit Details</a></li>
					</ul>
				</div>
			</div>
		</div> 
		<br>
		<div class="col-md-6"> 
			<div class="panel panel-default">
				<div class="panel-body">	
					<p><b>Separation</b></p>					
					<form class="" role="form">
						<div class="form-group form-group-default form-group-default-select2">
							<label>Choose Employee</label>
							<select class="full-width" data-init-plugin="select2" id="client_select" name="customer_id" required="">
								<option value="">Choose Employee</option>
								@foreach($employees as $emp)
									<option value="{!! $emp->id !!}"> {!! $emp->first_name !!} {!! $emp->middle_name !!} {!! $emp->last_name !!}</option>
								@endforeach	
							</select>
						</div>
						<div class="form-group form-group-default form-group-default-select2">
							<label>Choose Interviewer</label>
							<select class="full-width" data-init-plugin="select2" id="client_select" name="customer_id" required="">
								<option value="">Choose Interviewer</option>
								@foreach($employees as $emp)
									<option value="{!! $emp->id !!}"> {!! $emp->first_name !!} {!! $emp->middle_name !!} {!! $emp->last_name !!}</option>
								@endforeach	
							</select>
						</div>
						<div class="form-group form-group-default required">
							<label>Separation date</label>
							<input type="text" class="form-control datepicker" placeholder="Separation date" required="">
						</div>
						<div class="form-group form-group-default required">
							<label>Reason for leaving</label>
							<textarea type="text" class="form-control tinymce" placeholder="Separation date"></textarea>
						</div>						
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-6"> 
			<div class="panel panel-default">					
				<div class="panel-body">
					<p><b>Checklist for Exit Interview</b></p>			
					<form class="" role="form">
						<div class="form-group form-group-default required ">
							<label>Company Vehicle handed in</label>
							<input type="email" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required ">
							<label>Exit interview conducted</label>
							<input type="email" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required ">
							<label>Resignation letter submitted</label>
							<input type="email" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required ">
							<label>All library books submitted</label>
							<input type="email" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required">
							<label>Manager/Supervisor clearance</label>
							<input type="password" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required">
							<label>Security</label>
							<input type="password" class="form-control" required="">
						</div>
						<div class="form-group form-group-default required">
							<label>Notice period followed</label>
							<input type="password" class="form-control" required="">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-12"> 
			<div class="panel panel-default">
				<div class="panel-body">	
					<p><b>Questionairre</b></p>					
					<form class="" role="form">
						<div class="form-group form-group-default required">
							<label>Think the organization do to improve staff welfare</label>
							<textarea type="text" class="form-control {{-- tinymce --}}" rows="9" placeholder="Think the organization do to improve staff welfare" style="height: 150px"></textarea>
						</div>
						<div class="form-group form-group-default required">
							<label>What did you like the most of the organization</label>
							<textarea type="text" class="form-control {{-- tinymce --}}" cols="6" placeholder="What did you like the most of the organization" style="height: 150px"></textarea>
						</div>
						<div class="form-group form-group-default required">
							<label>Anything you wish to share with us</label>
							<textarea type="text" class="form-control {{-- tinymce --}}" row="6" placeholder="Anything you wish to share with us" style="height: 150px"></textarea>
						</div>	
					</form>
				</div>
			</div>
			<button type="submit" class="btn btn-info">Save Exit Details</button>
		</div>

	</div>		
<br>
@endsection
{{-- page scripts --}}
@section('scripts')

	<script src="{{ url('/') }}/resources/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="{{ url('/') }}/resources/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
	<script src="{{ url('/') }}/resources/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js" type="text/javascript"></script>
	<script src="{{ url('/') }}/resources/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript" src="{{ url('/') }}/resources/assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/resources/assets/plugins/datatables-responsive/js/lodash.min.js"></script>
	<script src="{{ url('/') }}/resources/assets/pages/js/pages.min.js"></script>
	<script src="{{ url('/') }}/resources/assets/js/datatables.js" type="text/javascript"></script>

@endsection