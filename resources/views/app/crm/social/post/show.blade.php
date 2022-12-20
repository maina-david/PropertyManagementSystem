@extends('layouts.app')
{{-- page header --}}
@section('title','Create Post')

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
         <li class="breadcrumb-item"><a href="#">Social Media Marketing</a></li>
         <li class="breadcrumb-item active">View Post</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-bullhorn"></i> View Post</h1>
      <!-- end page-header -->
      @include('partials._messages') 
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Post</h4>
               </div>
               <div class="panel-body"> 
                  <h4>{!! $post->title !!}</h4>
                  <p>{!! $post->post !!}</p>
                  <div class="row">
                     <div class="col-md-6"></div>
                     <div class="col-md-3"> </div>
                     <div class="col-md-3">
                        <a href="{!! route('crm.publications.post.publish',[$post->id,$channel->channelID]) !!}" class="pull-right btn btn-pink">Publish post to {!! Crm::medium($channel->mediumID)->name !!}</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Statistics</h4>
            </div>
            <div class="panel-body"> 
               
            </div>
         </div>
      </div>
   </div>
   </div>
@endsection