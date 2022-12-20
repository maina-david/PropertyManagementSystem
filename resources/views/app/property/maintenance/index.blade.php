@extends('layouts.app')
@section('title','Maintenance')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.agents') !!}">Maintenance</a></li>
         <li class="breadcrumb-item active"><a href="">Requests</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> Maintenance </h1>
      <div class="row">
         <div class="col-md-12">
            <a href="{!! route('property.maintenance.create') !!}" class="btn btn-danger float-right mb-2"> <i class="fal fa-plus-circle"></i> Add Maintenance Request</a>
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead>
                        <th width="1%">#</th>
                        <th>RequestID</th>
                        <th>Title</th>
                        <th>Tenant</th>
                        <th>Priority</th>
                        <th>Request Date</th>           
                        <th>Complete Date</th>                     
                        <th width="10%">Action</th>
                     </thead>
                     <tbody>
                        @foreach($requests as $request)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $request->requestID !!}</td>
                              <td>{!! $request->issue_title !!}</td>   
                              <td>{!! $request->tenant_name !!}</td>  
                              <td><span class="badge {!! $request->priority !!}">{!! $request->priority !!}</span></td>  
                              <td>{!! date('F jS, Y', strtotime($request->initiated_date)) !!}</td>   
                              <td>{!! date('F jS, Y', strtotime($request->completed_work_date)) !!}</td>                       
                              <td>
                                 <a href="{!! route('property.maintenance.edit',$request->reqID) !!}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                 <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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