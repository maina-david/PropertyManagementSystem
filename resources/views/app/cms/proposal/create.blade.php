@extends('layouts.backend')
@section('title','New Proposal')
@section('sidebar')
   @include('backend.cms.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Cms</a></li>
         <li class="breadcrumb-item"><a href="#">Proposal</a></li>
         <li class="breadcrumb-item active">New</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">New Proposal</h1>
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
                        {!! Form::text('title', null, array('class' => 'form-control','required' => '')) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        {!! Form::label('name', 'Proposal type', array('class'=>'control-label')) !!}
                        {!! Form::select('proposal_type', ['' => 'choose proposal type','edocument' => 'Make e-document','upload-proposal' => 'upload proposal'], null, array('class' => 'form-control','required' => '','id' => 'type')) !!}
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default">
                        {!! Form::label('title', 'proposal Category', array('class'=>'control-label')) !!}
                        {!! Form::text('proposal_category', null, array('class' => 'form-control','placeholder' => 'e.g Marketing proposal')) !!}
                     </div>
                     <div class="form-group form-group-default" id="upload-proposal" style="display:none">
                        {!! Form::label('title', 'Upload Proposal', array('class'=>'control-label')) !!}
                        {!! Form::file('upload', null, array('class' => 'form-control')) !!}
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
               </div>
            </div>
         </div>
         <div class="panel-body">
            <div class="form-group">
               <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Proposal</button></center>
            </div>
         </div>
      {!! Form::close() !!}
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      $(document).ready(function() {
         $('#type').on('change', function() {
            if (this.value == 'upload-proposal') {
               $('#upload-proposal').show();
            } else { 
               $('#upload-proposal').hide();
            }
         });
      });
   </script>
   <script src="{!! url('/') !!}/public/backend/plugins/ckeditor/4/full/ckeditor.js"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
