@extends('layouts.app')
{{-- page header --}}
@section('title','Departments | Human Resource')
@section('stylesheet')
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<link href="{!! asset('assets/plugins/jstree/dist/themes/default/style.min.css') !!}" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL JS ================== -->
@endsection
@section('sidebar')
@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content') 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Human resource</a></li>
         <li class="breadcrumb-item"><a href="#">Organization</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.departments') !!}">Departments</a></li>
         <li class="breadcrumb-item active"><a href="{!! route('hrm.departments') !!}">All</a></li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-sitemap"></i> Departments</h1>
		@include('partials._messages')
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">Department List</div>
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Head</th>
                        <th width="9%">Action</th>
                     </thead>
                     <tbody>
                        @foreach($departments as $department)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $department->title !!}</td>
                              <td>{!! $department->code !!}</td>
                              <td>
                                 @if(Hr::check_employee($department->head) == 1) 
                                    {!! Hr::employee($department->head)->names !!}
                                 @endif
                              </td>
                              <td>
                                 <a href="{!! route('hrm.departments.edit',$department->id) !!}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                 <a href="{!! route('hrm.departments.delete',$department->id) !!}" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
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
@endsection
@section('scripts')

@endsection
