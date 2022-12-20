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
			<div class="col-md-6 col-lg-6">
				<h3>Choose {{ trans('limitless.default_language') }}</h3>	
				{{ Form::open(array('url' => 'setting/defaultLanguage', 'role' => 'form', 'class' => 'solsoForm')) }}	
				<div class="form-group">
					<select name="language" class="form-control required solsoSelect2">				
						@if (isset($cl->name))
							<option value="{{ $cl->id }}" selected> {{ $cl->name }} </option>
							<option value="">{{ trans('limitless.choose') }}</option>
						@else
							<option value="" selected>{{ trans('limitless.choose') }}</option>
						@endif							
						@foreach ($languages as $v)
							<option value="{{ $v->id }}"> {{ $v->name }} </option>
						@endforeach		
					</select>
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('general.save') }}</button>	
				{{ Form::close() }}	
			</div>
			<div class="col-md-6 col-lg-6">
				<div class="container-fluid container-fixed-lg bg-white"> 
					<div class="panel panel-transparent">
						<div class="panel-heading">
							<div class="panel-title">Edit {{ trans('general.language') }}</div>							
						</div>
						<div class="panel-body">
							@include('partials._errors')
							<div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
								<div>
									{!! Form::model($edit, ['route' => ['language.update',$edit->id], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
									{!! csrf_field() !!}
										<div class="form-group form-group-default col-md-12">
											{!! Form::label('Language Name', 'name', array('class'=>'control-label')) !!}
											{!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Language Name', 'required' =>'' )) !!}
										</div><br><br>
										<div class="form-group form-group-default col-md-12">
											{!! Form::label('short', 'Language Code', array('class'=>'control-label')) !!}
											{!! Form::text('short', null, array('class' => 'form-control', 'placeholder' => 'Language Code', 'required' =>'' )) !!}
										</div><br><br>
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('general.save') }} Language </button>	
									{{ Form::close() }}	
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>	
		</div> 
	</div>
	@include('Limitless.Models.Settings.Languages.add-language')
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection