@extends('layouts.app')
{{-- page header --}}
@section('title','License List')
{{-- page styles --}}
@section('stylesheet')
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.assets.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div class="content">
	<div class="pull-right">
		@if(Asset::count_assets() != Wingu::plan()->assets && Asset::count_assets() < Wingu::plan()->assets)
			@permission('create-assets')
	      	<a href="{!! route('licenses.assets.create') !!}" class="btn btn-pink"><i class="fas fa-barcode"></i> Add License</a>
			@endpermission
		@endif
   </div>
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-laptop-code"></i> License List</h1>
	@include('partials._messages')
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">License List</h4>
      </div>
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                  <th>#</th>
                  <th>License</th>
                  <th>Product Key</th>
                  <th>Expiration Date</th>
                  <th>Licensed to Email</th>
                  <th>Licensed to Name</th>
                  <th>Manufacturer</th>
                  <th>Avail</th>
                  <th width="12%">Actions</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>#</th>
                  <th>License</th>
                  <th>Product Key</th>
                  <th>Expiration Date</th>
                  <th>Licensed to Email</th>
                  <th>Licensed to Name</th>
                  <th>Manufacturer</th>
                  <th>Avail</th>
                  <th width="12%">Actions</th>
               </tr>
            </tfoot>
            <tbody>
               @foreach ($assets as $asset)
                  <tr>
                     <td>{!! $count++ !!}</td>
                     <td>{!! $asset->asset_name !!}</td>
                     <td>{!! $asset->product_key !!}</td>
                     <td>{!! $asset->end_of_life !!}</td>
                     <td>{!! $asset->licensed_to_email !!}</td>
                     <td>{!! $asset->licensed_to_name !!}</td>
                     <td>{!! $asset->manufacture !!}</td>
                     <td>{!! $asset->seats !!}</td>
                     <td>
								@permission('update-assets')
	                        <a href="{!! route('licenses.assets.edit',$asset->id) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
								@endpermission
								@permission('read-assets')
                        	<a href="{!! route('licenses.assets.show',$asset->id) !!}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
								@endpermission
								@permission('delete-assets')
                        	<a href="{!! route('licenses.assets.delete',$asset->id) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
								@endpermission
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
