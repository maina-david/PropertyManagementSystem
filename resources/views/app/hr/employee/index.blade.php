@extends('layouts.app')
{{-- page header --}}
@section('title','All employees')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         {{-- <a href="#" class="btn btn-white mr-1 active"><i class="fa fa-bars"></i></a>
         <a href="#" class="btn btn-white mr-1"><i class="fa fa-th"></i></a> --}}
         @permission('create-employee')
            <a href="{!! route('hrm.employee.create') !!}" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add employee</a>
         @endpermission
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All employee </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      {{-- <div class="row mt-4 mb-4">
         <div class="col-sm-6 col-md-3">
               <div class="form-group form-focus">
               <input type="text" class="form-control floating" placeholder="employee ID">
               </div>
         </div>
         <div class="col-sm-6 col-md-3">
               <div class="form-group form-focus">
               <input type="text" class="form-control floating" placeholder="employee Name">
               </div>
         </div>
         <div class="col-sm-6 col-md-3">
               <div class="form-group">
               <select class="form-control multiselect">
                  <option>Select Designation</option>
                  <option>Web Developer</option>
                  <option>Web Designer</option>
                  <option>Android Developer</option>
                  <option>Ios Developer</option>
               </select>
               </div>
         </div>
         <div class="col-sm-6 col-md-3">
               <a href="#" class="btn btn-success btn-block"> Search </a>
         </div>
      </div> --}}
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5%"></th>
                     <th class="text-nowrap">Name</th>
                     <th class="text-nowrap">Employee ID</th>
                     <th class="text-nowrap">Email</th>
                     <th class="text-nowrap">Leave Days</th>
                     <th class="text-nowrap"width="7%">Employment status</th>
                     <th class="text-nowrap" width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($employees as $employee)
                     <tr role="row" class="odd"> 
                        <td>{!! $count++ !!}</td>
                        <td>
                           @if ($employee->image != "")
                              <img class="rounded-circle" width="32" height="32" alt="{!! $employee->names !!}" src="{!! asset('businesses/'.$employee->businessCode.'/hr/employee/images/'.$employee->image) !!}">
                           @else
                              <img src="https://ui-avatars.com/api/?name={!! $employee->names !!}&rounded=true&size=32" alt="">
                           @endif
                        </td>
                        <td>{!! $employee->names !!}</td>
                        <td>{!! $employee->companyID !!}</td>
                        <td>{!! $employee->company_email !!}</td>
                        <td>{!! $employee->leave_days !!}</td>
                        <td><span class="badge {!! $employee->statusName !!}">{!! $employee->statusName !!}</span></td>
                        <td>
                           @permission('update-employee')
                              <a href="{{ route('hrm.employee.edit',$employee->employeeID) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                           @endpermission
                           @permission('read-employee')
                              <a href="{!! route('hrm.employee.show',$employee->employeeID) !!}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                           @endpermission
                           @permission('delete-employee')
                              <a href="#" class="delete btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                           @endpermission
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
@endsection
