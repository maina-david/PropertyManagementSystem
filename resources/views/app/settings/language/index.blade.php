@extends('layouts.backend')
{{-- page header --}}
@section('title','Language')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
   @include('backend.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<!-- begin #content -->
   <div id="content" class="content">		
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">{{ trans('general.settings') }}</a></li>
         <li class="breadcrumb-item"><a href="javascript:;">{{ trans('settings.language') }}</a></li>
         <li class="breadcrumb-item active">{{ trans('general.all') }} {{ trans('settings.language') }}</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">{{ trans('general.all') }} {{ trans('settings.language') }}</h1>
	
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
					<table id="category-form" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>{{ trans('settings.language') }}</th>
								<th>{{ trans('settings.short_name') }}</th>
								<th colspan="3"><center>{{ trans('general.action') }}</center></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($languages as $crt => $v)
								<tr>
									<td class="v-align-middle semi-bold sorting_1">
										{{ $crt+1 }}
									</td>
									<td class="v-align-middle semi-bold sorting_1">
										{{ $v->name }}
									</td>
									<td class="v-align-middle semi-bold sorting_1" style="width:100%">
										{{ $v->short }}
									</td>
									<td class="v-align-middle semi-bold sorting_1">		
										<a class="btn solso-email btn-info" href="{{ route('language.show',[$v->id,'general']) }}">  
											<i class="fa fa-book"></i> {{ trans('general.translate') }}
										</a>
									</td>	
									<td class="v-align-middle semi-bold sorting_1">							
										<a class="btn btn-primary" href="{{ url('settings/language/' . $v->id . '/edit') }}">
											<i class="fa fa-edit"></i> {{ trans('general.edit') }}
										</a>
									</td>	
									<td class="v-align-middle semi-bold sorting_1">							
										<button class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ url('settings/language/' . $v->id) }}">
											<i class="fa fa-trash"></i> {{ trans('general.delete') }}
										</button>		
									</td>
								</tr>					
							@endforeach				
						</tbody>
					</table>	
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-8 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">					
				<h4 class="m-t-0 m-b-15"><b>{{ trans('general.choose') }} {{ trans('settings.language') }}</b></h4>
				{{ Form::open(array('route' => 'language.defaultLanguage', 'method' => 'post')) }}	
					<div class="form-group">
						<select name="language" class="form-control required solsoSelect2">				
							@if (isset($cl->name))
								<option value="{{ $cl->id }}" selected> {{ $cl->name }} </option>
								<option value="">{{ trans('general.choose') }}</option>
							@else
								<option value="" selected>{{ trans('general.choose') }}</option>
							@endif							
							@foreach ($languages as $v)
								<option value="{{ $v->id }}"> {{ $v->name }} </option>
							@endforeach		
						</select>
					</div>
					<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> {{ trans('general.save') }} {{ trans('settings.language') }}</button>	
				{{ Form::close() }}	
			</div>
			<!-- end col-4 -->
		</div>
		<!-- end row -->
	</div>
	<div class="modal fade stick-up" id="addlanguage" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
					<h5>Add Language</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						{{ Form::open(array('url' => 'language/store', 'role' => 'form', 'class' => 'solsoForm')) }}		
							<div class="col-md-12 col-lg-12">
								<div class="form-group">
									<label for="name">{{ trans('limitless.name') }}</label>
									<input type="text" name="name" class="form-control required" autocomplete="off" required="">
								</div>		
							</div>
							<div class="clearfix"></div>						
							<div class="col-md-12 col-lg-12">
								<div class="form-group">
									<label for="short_name">{{ trans('limitless.short_name') }}</label>
									<input type="text" name="short_name" class="form-control required" autocomplete="off" required="">
								</div>		
							</div>
							<div class="clearfix"></div>						
							<div class="form-group col-md-12">
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('limitless.save') }}</button>	
							</div>						
						{{ Form::close() }}	               
					</div>		
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="solsoDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">{{ trans('limitless.delete_dialog') }}</h4>
				</div>
				<div class="modal-body">
						<p>{{ trans('limitless.procedure_is_irreversible') }}</p>
						<p>{{ trans('limitless.want_to_proceed') }}<p>
				</div>
				<div class="modal-footer">				
					{!! Form::open(['route' => ['language.destroy', 1],'method'=>'DELETE']) !!}
						{{ Form::hidden('_method', 'DELETE') }}
						<button type="button" class="btn btn-info" data-dismiss="modal">{{ trans('limitless.no') }}</button>
						<button type="submit" class="btn btn-danger pull-right">{{ trans('limitless.yes') }}</button>						
					{{ Form::close() }}		
				</div>
			</div>
		</div>
	</div>
@endsection
{{-- page scripts --}}
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
	    	$('#category-form').DataTable();
		} );
	</script>
@endsection