@extends('layouts.app')
{{-- page header --}}
@section('title','Add Branch')
@section('stylesheet')
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<link href="{!! asset('/assets/plugins/jstree/dist/themes/default/style.min.css') !!}" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL JS ================== -->
@endsection
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
         <li class="breadcrumb-item">Branches</li>
         <li class="breadcrumb-item active">Add</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-map-marked-alt"></i> Add Branches</h1>
		@include('partials._messages')
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header ">
                  Branch details
               </div>
               <div class="card-body">
                  <form action="{!! route('hrm.branches.store') !!}" method="post" class="row">
                     @csrf
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Branch name</label>
                           {!! Form::text('branch_name',null,['class' => 'form-control','placeholder' => 'Enter branch name', 'required' => '' ]) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Country</label>
                           {!! Form::select('countryID',$country,null,['class' => 'form-control multiselect', 'required' => '']) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">City</label>
                           {!! Form::text('city',null,['class' => 'form-control','placeholder' => 'Enter city', 'required' => '']) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Branch Address</label>
                           {!! Form::text('address',null,['class' => 'form-control','placeholder' => 'Enter address']) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Branch phone number</label>
                           {!! Form::text('phone_number',null,['class' => 'form-control','placeholder' => 'Enter phone number']) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Branch email</label>
                           {!! Form::email('email',null,['class' => 'form-control','placeholder' => 'Enter email']) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Is this the main branch ?</label>
                           {!! Form::select('main_branch',['No' => 'No','Yes' => 'Yes'],null,['class' => 'form-control']) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <button type="submit" class="float-right btn btn-pink submit"><i class="fas fa-save"></i> Add Branch</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </div>
                  </form>
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
