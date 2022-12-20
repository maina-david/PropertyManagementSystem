@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $role->name !!} @endsection
{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li class="breadcrumb-item"><a href="javascript:;">{!! trans('general.settings') !!}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{!! trans('settings.roles') !!}</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">{!! trans('general.view') !!} {!! trans('settings.roles') !!}  {!! trans('settings.permissions') !!} <a class="btn btn-info " href="{!! url('/settings/roles/'.$role->id.'/edit') !!}"><i class="fa fa-edit" aria-hidden="true"></i> Edit this Role</a></h1>        
        <div class="panel panel-inverse" data-sortable-id="ui-widget-1">         
            <div class="panel-heading">
                <h4 class="panel-title">{!! trans('general.add') !!} {!! trans('settings.roles') !!}</h4>
            </div>
            <div class="row">   
                <div class="panel-body background-white">
                    <div class="content">
                        <h2 class="title">Permissions:</h1>
                        <ul>
                            @foreach ($role->permissions as $r)
                                <li>{{$r->display_name}} <em class="m-l-15">({{$r->description}})</em></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection