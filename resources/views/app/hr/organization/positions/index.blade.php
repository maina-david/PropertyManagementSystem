@extends('layouts.app')
{{-- page header --}}
@section('title','Positions')
@section('sidebar')
@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content') 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Organization</li>
         <li class="breadcrumb-item active">Positions</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-briefcase"></i> Positions</h1>
		@include('partials._messages')
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%"> #</th>
                           <th class="text-nowrap">Title</th>
                           <th class="text-nowrap" width="29%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($titles as $title)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $title->name !!}</td>
                              <td>
                                 <a href="{!! route('hrm.positions.edit',$title->id) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                 <a href="{!! route('hrm.positions.destroy',$title->id) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
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
               <div class="card-body">
                  {!! Form::open(array('route' => 'hrm.positions.store','enctype'=>'multipart/form-data', 'method'=>'post' )) !!}
                  @csrf
                     <div class="form-group form-group-default required">
                        {!! Form::label('names', 'Positions', array('class'=>'control-label')) !!}
                        {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter title', 'required' =>'' )) !!}
                     </div>
                     <div class="form-group">
                        {!! Form::label('names', 'Describe Position', array('class'=>'control-label')) !!}
                        {!! Form::textarea('description', null, array('class' => 'form-control ckeditor' )) !!}
                     </div>
                     <div class="form-group mt-4">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
