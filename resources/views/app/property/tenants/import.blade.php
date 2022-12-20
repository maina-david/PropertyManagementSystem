@extends('layouts.app')
{{-- page header --}}
@section('title','Import Tenant')
@section('sidebar')
@include('app.property.partials._menu')
@endsection

@section('breadcrum')
   <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
         <div class="welcome-text">
            <h4><i class="fal fa-users-medical"></i> Import Tenant </h4>
         </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Tenants</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Import</a></li>
         </ol>
      </div>
   </div>
@endsection

@section('content')
	<div id="content" class="content">
      <div class="row">
         <div class="col-md-12  mb-2">
            <a href="{!! url('/') !!}/public/samples/tenant_import_sample_file.csv" class="btn btn-danger pull-right"><i class="fal fa-file-download"></i> Download Sample</a>
         </div>         
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Upload Details</h4>
               </div>
               <div class="panel-body">
                  <p>Your CSV data should be in the format below. The first line of your CSV file should be the column headers as in the table example. Also make sure that your file is <b>UTF-8</b> to avoid unnecessary <b>encoding problems</b>.</p>
                  <p>If the column <b>you are trying to import is date make sure that is formatted in format Y-m-d (2019-07-05).</b><p>
               </div>
            </div>
         </div>
      </div>
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">CSV Format </h4>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="table-responsive no-dt">
                     <table class="table table-hover table-bordered">
                        <thead>
                           <th>Names</th>
                           <th>Email</th>
                           <th>Phone number</th>
                        </thead>
                        <tbody>
                           <tr>
                              <td>Sample data</td>
                              <td>Sample data</td>
                              <td>Sample data</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
				</div>
         </div>
      </div>
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Upload Tenant</h4>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-4 mtop15">
                  <form action="{!! route('tenants.import') !!}" id="import_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                     @csrf
                     <input type="hidden" name="clients_import" value="true">
                     <div class="form-group mb-2 form-group-default">
                        <label for="file_csv" class="control-label  text-danger">
                           <small class="req text-danger">* </small>Choose CSV File
                        </label>
                        <input type="file" name="upload_import" required/>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Import Tenants</button>
                        <img src="{!! url('/') !!}/public/app/img/btn-loader.gif" class="submit-load none" alt="" width="30%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
