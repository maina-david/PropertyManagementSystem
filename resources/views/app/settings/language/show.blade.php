@extends('layouts.backend')
{{-- page header --}}
@section('title'){!! ucfirst($section) !!} {{ trans('general.section') }}@endsection
{{-- page styles --}}
@section('stylesheet')
	
@endsection

{{-- dashboad menu --}}
@section('sidebar')
   @include('backend.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">{{ trans('general.settings') }}</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">{{ trans('settings.language') }}</a></li>
			<li class="breadcrumb-item active">{{ trans('general.translate') }} {{ trans('settings.language') }}</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fas fa-language"></i> {{ trans('general.translate') }} {{ trans('settings.language') }}.</h1>
		@include('backend.partials._messages')
		<div class="col-md-12 col-lg-12">
			<h4>{{ trans('settings.language') }} : {{ $language->name }}</h4>
			<h4>{{ trans('general.section') }}  : <span class="uppercase">{!! ucfirst($section) !!}</span></h4>
		</div>		
		<!-- begin row -->
		<div class="row">
			<!-- begin col-8 -->
			<div class="col-lg-8">
				<!-- begin panel -->
				<div class="panel panel-inverse">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">{{ trans('settings.language') }}</h4>
					</div>
					<button class="btn btn-info pull-right mt-2 mb-2 mr-2" data-target="#addlanguage" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('general.add') }} {{ trans('settings.language') }}</button>
					{{ Form::open(array('route' => 'language.translate', 'method'=>'POST', 'role' => 'form')) }}
					<input type="hidden" name="section" value="{!! $section !!}">
						<table id="category-form" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>{{ trans('general.original') }}</th>
									<th>{{ trans('general.translate') }}</th>
								</tr>
							</thead>									
							<tbody>
								@foreach ($original as $k => $v)											
								<tr>
									<td width="50%">
										<p><b>{{ $v['original'] }}</b></p>
									</td>												
									<td>
										<input type="text" name="words[{{ $k }}]" class="form-control required" value="{{ isset($translated[$k]) ? $translated[$k] : $v['translated'] }}">
									</td>
								</tr>
								@endforeach
							</tbody>	
							<tfoot>
								<tr>
									<td colspan="2">
										<input type="hidden" name="languageID" value="{{ $language->id }}" required="">
										<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('general.save') }}</button>
									</td>
								</tr>
							</tfoot>		
						</table>	
					{{ Form::close() }}
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-8 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">					
				<h4 class="m-t-0 m-b-15"><b>{{ trans('general.choose') }} {{ trans('general.translate') }} {{ trans('general.section') }}</b></h4>
				{{ Form::open(array('route' => 'language.translate.section', 'method' => 'post')) }}	
					<input type="hidden" name="languageID" value="{{ $language->id }}" required="">
					<div class="form-group">
						<select name="section" class="form-control required solsoSelect2">				
							<option value="{!! $section !!}">{!! $section !!}</option>
							@foreach($sects as $sect)
								<option value="{!! $sect->directory !!}">{!! $sect->name !!}</option>
							@endforeach
						</select>
					</div>
					<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> {{ trans('general.save') }}</button>	
				{{ Form::close() }}	
			</div>
			<!-- end col-4 -->
		</div>
	</div> 
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
		});
	</script>
@endsection