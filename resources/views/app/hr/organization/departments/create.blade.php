@extends('layouts.app')
{{-- page header --}}
@section('title','Add Department | Human Resource')
@section('sidebar')
@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content') 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Human resource</a></li>
         <li class="breadcrumb-item"><a href="#">Organization</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.departments') !!}">Departments</a></li>
         <li class="breadcrumb-item active"><a href="{!! route('hrm.departments') !!}">Create</a></li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-sitemap"></i> Add Department</h1>
		@include('partials._messages')
      <!-- begin widget-list -->
      <div class="row">
         <form action="{!! route('hrm.departments.store') !!}" method="post" class="col-md-12">
            @csrf
            <div class="card">
               <div class="card-header">Department Details</div>
               <div class="card-body">                  
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group form-group-default required">
                           {!! Form::label('names', 'Department Name', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter name', 'required' =>'' )) !!}
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           {!! Form::label('names', 'Department Code', array('class'=>'control-label')) !!}
                           {!! Form::text('code', null, array('class' => 'form-control', 'placeholder' => 'Enter code')) !!}
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           {!! Form::label('names', 'Choose Parent Department', array('class'=>'control-label')) !!}
                           <select name="parentID" class="form-control multiselect">
                              <option value="">Choose parent department</option>
                              @foreach ($departments as $department)
                                 <option value="{!! $department->id !!}">{!! $department->title !!}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           {!! Form::label('head', 'Choose Department Head', array('class'=>'control-label')) !!}
                           {!! Form::select('head', $employees, null, array('class' => 'form-control multiselect')) !!}
                        </div>
                     </div>
                  </div>                  
                  <div class="form-group">
                     {!! Form::label('names', 'Department details', array('class'=>'control-label')) !!}
                     {!! Form::textarea('description', null, array('class' => 'form-control ckeditor')) !!}
                  </div>
                  <div class="form-group mt-4">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Department</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
@endsection
@section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
