@extends('layouts.app')
@section('title','Agents')
@section('sidebar') 
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb --> 
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.agents') !!}">Agents</a></li>
         <li class="breadcrumb-item active"><a href="">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-tie"></i> Agents - List</h1>
      <!-- end breadcrumb -->
      <div class="card card-default">
         <div class="card-body">
            @include('partials._messages')
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="21%">Name</th>
                     <th>Phone Number</th>
                     <th>Email</th>
                     <th>Allocations</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($agents as $agent)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>{!! $agent->names !!}</td>
                        <td>{!! $agent->personal_number !!}</td>
                        <td>{!! $agent->personal_email !!}</td>
                        <td></td>
                        <td></td>
                        <td>
                           <a href="{!! route('property.agents.edit',$agent->agentID) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="{!! route('property.agents.delete',$agent->agentID) !!}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection