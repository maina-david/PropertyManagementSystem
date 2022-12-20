@extends('layouts.main-template')
{{-- page header --}}
@section('title','Announcements')
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
	<div class="content "> 
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">					 
					<ul class="breadcrumb">
						<li><a href="#">Human Resource</a></li>
						<li><a href="#" class="active">Announcements</a></li>
					</ul>
				</div>
			</div>
		</div> 
		<div class="container-fluid container-fixed-lg bg-white"> 
			<div class="panel panel-transparent">
				<div class="panel-heading">
					<div class="panel-title">Announcements</div>
					<button class="btn btn-primary pull-right" data-target="#addannouncement" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Announcement</button>
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
								<tbody>
									@foreach($employees as $emp)
									<tr role="row" class="odd">
										<td class="v-align-middle semi-bold sorting_1">
											<img width="60" height="60" alt="" class="img-circle FL" src="https://people.zoho.com/people/images/user.png">
										</td>
										<td class="v-align-middle semi-bold sorting_1">
											<p><b>Announcement title</b></p>
											<p>{!! $emp->first_name !!} {!! $emp->middle_name !!} {!! $emp->last_name !!} - 30-Mar-2017 11:03 PM</p>
											<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est,</p>
										</td>										
										<td class="v-align-middle">
											<div class="btn-group dropdown-default"> 
												<a class="btn dropdown-toggle btn-complete" data-toggle="dropdown" href="#" style="width: 140px;" aria-expanded="false"> Choose Action 
													<span class="caret"></span> 
												</a>
												<ul class="dropdown-menu " style="width: 140px;">
													<li><a href="{{ url('announcements/'.$emp->id.'/show') }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
													<li><a data-target="#editleave" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp; Edit</a></li>
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
	@include('Limitless.Models.Announcement.create')
	@include('Limitless.Models.Announcement.edit')
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