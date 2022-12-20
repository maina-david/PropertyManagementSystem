@extends('layouts.app')
{{-- page header --}}
@section('title','Digital Marketing Mediums')

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Digital Marketing</a></li>
         <li class="breadcrumb-item active">Mediums</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Edit Mediums</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">All Mediums</h4>
               </div>
               <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Medium Name</th>
                        <th>Created Date</th>
                        <th width="30%">Action</th>
                     </thead>
                     <tbody>
                        @foreach ($mediums as $medium)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $medium->name !!}</td>
                              <td>{!! date('d F, Y', strtotime($medium->created_at)) !!}</td>
                              <td>
                                 <a href="{{ route('crm.medium.edit',$medium->id) }}" class="btn btn-pink"><i class="fas fa-edit"></i> Edit</a>
                                 <a href="{{ route('crm.medium.delete',$medium->id) }}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         {!! Form::model($edit, ['route' => ['crm.medium.update',$edit->id], 'method'=>'post','class' => 'col-md-6']) !!}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Edit Mediums</h4>
               </div>
               <div class="panel-body">
                  @csrf
                  <div class="form-group form-group-default">
                     <label for="">Enter Medium name</label>
                     {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Enter name']) !!}
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Medium</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>  
         {!! Form::close() !!}
      </div>
   </div>
@endsection