@extends('layouts.app')
@section('title','Utilities')
@section('sidebar')
	@include('app.property.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings | Utilities</h1>
   	<div class="row">
         @include('app.property.settings._settings_nav')
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12 mb-2">
                  <a href="{!! route('property.utilities.create') !!}" class="btn btn-danger float-right"><i class="fal fa-plus-circle"></i> Add Utility</a>
               </div>
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">All Utilities</h4>
                     </div>
                     <div class="panel-body">
                        <table id="example5" class="table table-striped table-bordered">
                           <thead>
                              <th width="1%">#</th>
                              <th>Name</th>
                              <th>Description</th>
                              <th width="13%">Action</th>
                           </thead>
                           <tbody>
                              @foreach ($utilities as $utility)
                                 <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>{!! $utility->name !!}</td>
                                    <td>{!! $utility->description !!}</td>
                                    <td>
                                       <a href="{!! route('property.utilities.edit',$utility->id) !!}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                       <a href="{!! route('property.utilities.delete',$utility->id) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i></a>
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
   </div>
@endsection
