@extends('layouts.backend')
@section('title','Update articles')
@section('sidebar')
   @include('backend.cms.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Cms</a></li>
         <li class="breadcrumb-item"><a href="{!! route('cms.knowledgebase.index') !!}">Knowledge base</a></li>
         <li class="breadcrumb-item"><a href="{!! route('cms.knowledgebase.index') !!}"> Articles</a></li>
         <li class="breadcrumb-item active">Detail</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">View</h1>
      <!-- end page-header -->
      @include('backend.partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-9">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <h3>{!! $article->name !!}</h3>
                  {!! $article->description !!}
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="panel panel-inverse">
               <div class="panel-body">

               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
