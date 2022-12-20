@extends('layouts.backend')
@section('title','Create articles')
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
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Add New Article</h1>
      <!-- end page-header -->
      @include('backend.partials._messages')
      <!-- begin panel -->
      {!! Form::open(array('route' => 'cms.knowledgebase.store','class' => 'row')) !!}
         @csrf
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        {!! Form::label('name', 'Title', array('class'=>'control-label')) !!}
                        {!! Form::text('name', null, array('class' => 'form-control','required' => '')) !!}
                     </div>
                     <div class="form-group">
                        <div class="checkbox checkbox-primary">
                           <input type="checkbox" name="status" value="disabled">
                           <label for="disabled">Disabled</label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        {!! Form::label('title', 'Groups', array('class'=>'control-label')) !!}
                        {{ Form::select('groupID', $groups, null, ['class' => 'form-control multiselect','required' => '']) }}
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
         <div class="panel panel-inverse">
            <div class="panel-body">
               <div class="panel-body">
                  <div class="form-group">
                     {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                     {!! Form::textarea('description', null, array('class' => 'form-control ckeditor')) !!}
                  </div>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Article</button></center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {!! Form::close() !!}
   </div>
@endsection
@section('scripts')
   <script src="{!! url('/') !!}/public/backend/plugins/ckeditor/4/full/ckeditor.js"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection