@extends('layouts.app')
{{-- page header --}}
@section('title','Branches')
@section('stylesheet')
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<link href="{!! asset('assets/plugins/jstree/dist/themes/default/style.min.css') !!}" rel="stylesheet" />
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
         <li class="breadcrumb-item active">Branches</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-map-marked-alt"></i> Branches</h1>
		@include('partials._messages')
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-12 mb-2">
            <a href="{!! route('hrm.branches.create') !!}" class="float-right btn btn-pink btn-sm"><i class="fas fa-plus"></i> Add Branch</a>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%"> #</th>
                           <th>Branch</th>
                           <th>Country</th>
                           <th>City</th>
                           <th>Address</th>
                           <th>Phone number</th>
                           <th>Email</th>
                           <th width="14%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($branches as $branch)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>
                                 {!! $branch->branch_name !!}
                                 @if($branch->main_branch == 'Yes')
                                    <br><span class="badge badge-primary">{!! $branch->main_branch !!}</span>
                                 @endif
                              </td>
                              <td>
                                 @if($branch->countryID != "")
                                    {!! Wingu::country($branch->countryID)->name !!}
                                 @endif
                              </td>
                              <td>{!! $branch->city !!}</td>
                              <td>{!! $branch->address !!}</td>
                              <td>{!! $branch->phone_number !!}</td>
                              <td>{!! $branch->email !!}</td>
                              <td>
                                 <a href="{!! route('hrm.branches.edit',$branch->branchID) !!}" class="btn btn-sm btn-pink"><i class="fas fa-edit"></i> Edit</a>
                                 <a href="{!! route('hrm.branches.delete',$branch->branchID) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
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
@endsection
@section('scripts')
   <script src="{!! url('backend/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
