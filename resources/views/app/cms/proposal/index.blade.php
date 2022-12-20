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
         <li class="breadcrumb-item"><a href="#">Proposal</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">All Proposals</h1>
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
                              <th>Proposal type</th>
                              <th>proposal Category</th>
                              <th>Publish date</th>
                              <th width="21%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>1</td>
                              <td>Social media Marketing Proposal</td>
                              <td>eDocument</td>
                              <td>Marketing</td>
                              <td>1st July, 2019</td>
                              <td>
                                 <a href="{{ route('cms.proposal.edit', [1]) }}" class="btn btn-primary"><i class="far fa-edit"></i> Edit</a>
                                 <a href="{{ route('cms.proposal.show', [1]) }}" class="btn btn-pink"><i class="fas fa-eye"></i> Show</a>
                                 <a href="{!! route('cms.proposal.delete', [1]) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
