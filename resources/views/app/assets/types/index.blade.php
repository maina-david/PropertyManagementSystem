@extends('layouts.app')
{{-- page header --}}
@section('title','Asset Type')
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
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fab fa-elementor"></i> Asset Type</h1>
	@include('partials._messages')
	<div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">Asset type list</div>
            <div class="card-body">
               <table id="data-table-default" class="table table-striped table-bordered">
                  <thead>
                     <th width="1%">#</th>
                     <th>Name</th>
                     <th width="25%">Action</th>
                  </thead>
                  <tbody>
                     @foreach ($types as $type)
                        <tr>
                           <td>{!! $count++ !!}</td>
                           <td>{!! $type->name !!}</td>
                           <td>
										@permission('update-assettype')
                              	<a href="{!! route('assets.type.edit',$type->id) !!}" class="btn btn-primary edit-type">Edit</a>
										@endpermission
										@permission('delete-assettype')
                              	<a href="{!! route('assets.type.delete',$type->id) !!}" class="btn btn-danger delete">Delete</a>
										@endpermission
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
            <div class="card-header">Add asset type</div>
            <div class="card-body">
               <form action="{!! route('assets.type.store') !!}" method="POST">
                  @csrf
                  <div class="form-group form-group-default">
                     <label for="">Name</label>
                     {!! Form::text('name',null,['class' => 'form-control', 'required' => '','placeholder' => 'Enter name']) !!}
                  </div>
                  <div class="form-group">
                     <button class="btn btn-pink submit"><i class="fas fa-save"></i> Add type</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
{{-- page scripts --}}
@section('scripts')
@endsection
