@extends('layouts.app')
{{-- page header --}}
@section('title','Pipeline')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('crm.dashboard') !!}">CRM</a></li>
         <li class="breadcrumb-item"><a href="{!! route('crm.pipeline.index') !!}">Pipeline</a></li>
         <li class="breadcrumb-item"><a href="{!! route('crm.pipeline.show',$pipeline->id) !!}">Stage</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-stream"></i> {!! $pipeline->title !!}</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Pipeline Stages</div>
               <div class="card-body">
                  <table class="table table-striped mb-0" id="formTable" data-sortable>
                     <thead>
                        <tr>
                           <th width="1%"></th>
                           <th width="1%">#</th>
                           <th>Title</th>
                           <th width="24%">Action</th>
                        </tr>
                     </thead>
                     <tbody id="sortThis">
                        @foreach($stages as $stage)
                           <tr data-index="{{ $stage->id }}" data-position="{{ $stage->position }}">
                              <td><i class="fas fa-grip-vertical"></i></td>
                              <td>{{ $count++ }}</td>
                              <td>{{ $stage->title }}</td>
                              <td>
                                 <a href="{!! route('crm.pipeline.stage.edit',$stage->id) !!}" class="btn btn-primary btn-sm">Edit</a>
                                 <a href="{!! route('crm.pipeline.stage.delete',$stage->id) !!}" class="btn btn-danger btn-sm">Delete</a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Edit Stage</div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['crm.pipeline.stage.update', $edit->id], 'method'=>'post', 'autocomplete' => 'off']) !!}
                     @csrf
                     <div class="form-group form-group-default">
                        <label for="">Title</label>
                        {!! Form::text('title',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter stage title']) !!}
                        <input type="hidden" name="pipelineID" value="{!! $pipeline->id !!}" required>
                     </div>
                     <div class="form-group">
                        <label for="">Description</label>
                        {!! Form::textarea('description',null,['class'=>'form-control','size'=>'8x8','placeholder'=>'Enter stage description']) !!}
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update stage</button>
			               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
