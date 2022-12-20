@extends('layouts.app')
{{-- page header --}}
@section('title','Import Customer')
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right"> 
         <a href="{!! route('finance.customer.download.sample.import') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Download Sample</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-file-upload"></i> Import Customer</h1>
		@include('partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Upload Details</h4>
			</div>
			<div class="panel-body">
            <div class="row">
               <ul>
                  <li class="">Your CSV data should be in the format below. The first line of your CSV file should be the column headers as in the table example. Also make sure that your file is <b>UTF-8</b> to avoid unnecessary <b>encoding problems</b>.</li>
                  <li class="">If the column <b>you are trying to import is date make sure that is formatted in format Y-m-d (2019-07-05).</b></li>
               </ul>
            </div>
         </div>
      </div>
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">CSV Format </h4>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="table-responsive no-dt">
						<table class="table table-hover table-bordered">
							<thead>
								<th>Customer name</th>
								<th>email</th>
								<th>Phone number</th>
								<th>Position</th>
								<th>Website</th>
								<th>City</th>
								<th>State</th>
								<th>Postal address</th>
								<th>zip code</th>
							</thead>
							<tbody>
								<tr>
									<td>Sample data</td>
									<td>Sample data</td>
									<td>Sample data</td>
									<td>Sample data</td>
									<td>Sample data</td>
									<td>Sample data</td>
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
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Upload Customer</h4>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-4 mtop15">
                  <form action="{!! route('finance.contact.import.store') !!}" id="import_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                     @csrf
                     <input type="hidden" name="clients_import" value="true">
                     <div class="form-group mb-2 form-group-default">
                        <label for="file_csv" class="control-label  text-danger">
                           <small class="req text-danger">* </small>Choose CSV File
                        </label>
                        <input type="file" name="upload_import" required/>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit">Import</button>
                        
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
