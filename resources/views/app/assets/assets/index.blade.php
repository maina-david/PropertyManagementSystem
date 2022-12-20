@extends('layouts.app')
{{-- page header --}}
@section('title','List Asset')

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
	      	<a href="{!! route('assets.create') !!}" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Asset</a>
			@endpermission
		@endif
   </div>
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-barcode"></i> Asset List</h1>
	@include('partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Asset List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="10%">Image</th>
                     <th>Name </th>
                     <th>Type</th>
                     <th>Asset Tag</th>
                     <th>Serial</th>
                     <th>Status</th>
                     <th>Assigned To</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th width="10%">Image</th>
                     <th>Name </th>
                     <th>Type</th>
                     <th>Asset Tag</th>
                     <th>Serial</th>
                     <th>Status</th>
                     <th>Assigned To</th>
                     <th width="12%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
						@foreach ($assets as $asset)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>
                           @if($asset->asset_image == "")
                              <img src="{!! asset('/img/product_placeholder.jpg') !!}" width="80px" height="60px">
                           @else
                              <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/assets/'.$asset->asset_image) !!}" alt="" class="img-responsive">
                           @endif
                        </td>
                        <td>{!! $asset->asset_name !!}</td>
                        <td>
                           @if($asset->asset_type == 1)
                              Vehicle
                           @else
                              @if($asset->asset_type != "")
                                 {!! Asset::type($asset->asset_type)->name !!}
                              @endif
                           @endif
                        </td>
                        <td>{!! $asset->asset_tag !!}</td>
                        <td>{!! $asset->serial !!}</td>
                        <td>
                           @if($asset->status != "")
                              {!! Wingu::status($asset->status)->name !!}
                           @endif
                        </td>
                        <td>
                           @if($asset->employee != "")
                              <b>Employee :</b> {!! Hr::employee($asset->employee)->names !!}
                           @endif
                           @if($asset->customer != "")
                              <b>Customer :</b> {!! Finance::client($asset->customer)->customer_name !!}
                           @endif
                        </td>
                        <td>
									@permission('update-assets')
                           	<a href="{!! route('assets.edit',$asset->id) !!}" class="btn btn-primary btn-sm"><i class="fal fa-edit"></i></a>
									@endpermission
									@permission('read-assets')
                           	<a href="{!! route('assets.show',$asset->id) !!}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
									@endpermission
									@permission('delete-assets')
                           	<a href="{!! route('assets.delete',$asset->id) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
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
