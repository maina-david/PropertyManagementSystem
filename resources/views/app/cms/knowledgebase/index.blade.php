@extends('layouts.backend')
@section('title','Knowledge base articles')
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
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">All Articles</h1>
      <!-- end page-header -->
      @include('backend.partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>Title</th>
                              <th>Groups</th>
                              <th width="10">Status</th>
                              <th width="20">Publish date</th>
                              <th width="21%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($articles as $article)
                              <tr>
                                 <td>{!! $count++ !!}</td>
                                 <td>{!! $article->name !!}</td>
                                 <td>
                                    
                                 </td>
                                 <td>
                                    @if($article->status == 'disabled')
                                       <span class="badge badge-danger">{!! $article->status !!}</span>
                                    @else
                                       <span class="badge badge-success">Active</span>
                                    @endif
                                 </td>
                                 <td>{!! date('F d, Y', strtotime($article->created_at)) !!}</td>
                                 <td>
                                    <a href="{{ route('cms.knowledgebase.edit', $article->id) }}" class="btn btn-primary"><i class="far fa-edit"></i> Edit</a>
                                    <a href="{{ route('cms.knowledgebase.show', $article->id) }}" class="btn btn-pink"><i class="fas fa-eye"></i> Show</a>
                                    <a href="{!! route('cms.knowledgebase.delete', $article->id) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
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
@endsection
