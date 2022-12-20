@extends('layouts.app')
{{-- page header --}}
@section('title','Social')
{{-- page styles --}}
@section('stylesheet')

@endsection

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
         <li class="breadcrumb-item"><a href="#">Social</a></li>
         <li class="breadcrumb-item active">Post</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullhorn"></i> Posts</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">All Publications</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered">
                  <thead>
                     <th width="1%">#</th>
                     <th>Published on</th>
                     <th>Post Content</th>
                     <th>Interaction</th>
                     <th>Published By</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach($posts as $post)
                        <tr>
                           <td>{!! $count++ !!}</td>
                           <td>{!! $post->created_at !!}</td>
                           <td>{!! $post->post !!}</td>
                           <td>0</td>
                           <td>{!! $post->updated_by !!}</td>
                           <td><a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a></td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
@endsection