@extends('layouts.main-template')
{{-- page header --}}
@section('title','Language')
{{-- page styles --}}
@section('stylesheet')
	
@endsection

{{-- dashboad menu --}}
@section('main-menu')
	@include('Limitless.Settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div class="content sm-gutter"> 
		<div class="container-fluid padding-25 sm-padding-10"> 
			@include('partials._errors')
			<div class="col-md-12 col-lg-12">
				<h1><i class="fa fa-plus"></i> {{ trans('limitless.translate_language') }}</h1>
				<h3><b>Language :</b> {!! $name !!}</h3>
			</div>		
			
			<div class="col-md-12 col-lg-12">
				<div class="panel panel-transparent">
					<div class="panel-heading">
						<button class="btn btn-primary pull-right" data-target="#addlanguage" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add {{ trans('limitless.languages') }}</button>
						
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">
						{{ Form::open(array('url' => 'translate/store', 'method'=>'POST', 'role' => 'form')) }}
						<div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
							<div>
								<table id="category-form" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>{{ trans('limitless.original_language') }}</th>
											<th>{{ trans('limitless.translate_language') }}</th>
										</tr>
									</thead>									
									<tbody>
										@foreach ($original as $k => $v)											
										<tr>
											<td width="50%">
												<p><b>{{ $v['original'] }}</b></p>
											</td>												
											<td>
												<input type="text" name="words[{{ $k }}]" class="form-control required col-md-6" value="{{ isset($translated[$k]) ? $translated[$k] : $v['translated'] }}" style="width:100%">
											</td>
										</tr>
										@endforeach
									</tbody>	
									<tfoot>
										<tr>
											<td colspan="2">
												<input type="hidden" name="languageID" value="{{ Request::segment(2) }}" required="">
												<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('limitless.save') }}</button>
											</td>
										</tr>
									</tfoot>									
								</table>
							</div>
						</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>	
			
		</div> 
	</div>
	@include('Limitless.Models.Settings.Languages.add-language')
@endsection
{{-- page scripts --}}
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
	    $('#category-form').DataTable( {
	        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [ [1000000,10], [1000000,10, "All"] ],
	        buttons: [
                {extend: 'copy',className: 'btn-sm'},
                {extend: 'csv',title: 'Finance Contact list', className: 'btn-sm'},
                {extend: 'pdf', title: 'Finance Contact list', className: 'btn-sm'},
                {extend: 'print',className: 'btn-sm'}
            ]
		    } );
		} );
	</script>
@endsection