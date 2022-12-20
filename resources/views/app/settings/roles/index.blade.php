@extends('layouts.app')
{{-- page header --}}
@section('title','Roles')

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">        
         <a href="{!! route('settings.roles.create') !!}" class="btn btn-success"><i class="fal fa-plus-circle"></i> Add Roles</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shield-alt"></i> All Roles </h1>
      <!-- begin row -->
      @include('partials._messages')
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Role Name</th>
                     <th>Description</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Role Name</th>
                     <th>Description</th>
                     <th width="12%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  @foreach ($roles as $role)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>{!! $role->description !!}</td>
                        <td>
                           <a href="{!! route('settings.roles.edit',$role->id) !!}" class="btn btn-primary">Edit</a>
                           @if($role->id != 1)
                              <a href="{!! route('settings.roles.delete',$role->id) !!}" class="btn btn-danger delete">Delete</a>
                           @endif
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection
