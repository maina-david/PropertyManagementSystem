@extends('layouts.main-template')
{{-- page header --}}
@section('title','Exit Details')
{{-- page styles --}}
@section('stylesheet')
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
	<div class="content "> 
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">					 
					<ul class="breadcrumb">
						<li><a href="#">Human Resource</a></li>
						<li><a href="#" class="active">Exit Details</a></li>
					</ul>
				</div>
			</div>
		</div> 
		<div class="container-fluid container-fixed-lg bg-white"> 
			<div class="panel panel-transparent">
				<div class="panel-heading">
					<div class="panel-title">Exit Details</div>
					<a class="btn btn-primary pull-right" href="{{ url('exit-details/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Exit Details</a>
					<div class="pull-right">
						<div class="col-xs-12">
							<input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
						<div>
							<table class="table table-hover demo-table-search table-responsive-block dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
								<thead>
									<tr role="row">
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:10%">Image</th>
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:15%">Name</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 273px;">Gender</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 273px;">Interviewer</th>
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:13%">Separation date</th>										
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 300px;" style="width:15%">Notice Date</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;" style="width:15%">Date Added</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;" style="width:10%">Status</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 230px;">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($employees as $emp)
									<tr role="row" class="odd">
										<td class="v-align-middle semi-bold sorting_1">
											<img width="60" height="60" alt="" class="img-circle FL" src="https://people.zoho.com/people/images/user.png">
										</td>
										<td class="v-align-middle semi-bold sorting_1"><p>{!! $emp->first_name !!} {!! $emp->middle_name !!} {!! $emp->last_name !!}</p></td>
										<td class="v-align-middle"><p>Female</p></td>
										<td class="v-align-middle"><p>Ben Frank</p></td>
										<td class="v-align-middle"><p>21,March 2017</p></td>
										<td class="v-align-middle"><p>22,March 2017</p></td>
										<td class="v-align-middle"><p>24,March 2017</p></td>
										<td class="v-align-middle"><span class="label label-success">Pending</span></td>
										<td class="v-align-middle">
											<div class="btn-group dropdown-default"> 
												<a class="btn dropdown-toggle btn-complete" data-toggle="dropdown" href="#" style="width: 140px;" aria-expanded="false"> Choose Action 
													<span class="caret"></span> 
												</a>
												<ul class="dropdown-menu " style="width: 140px;">
													<li><a href="{{ url('employee/'.$emp->id.'/show') }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
													<li><a href="{{ url('exit-details/'.$emp->id.'/edit') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp; Edit</a></li>
													<li><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp; Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>						
					</div>
				</div>
			</div>
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