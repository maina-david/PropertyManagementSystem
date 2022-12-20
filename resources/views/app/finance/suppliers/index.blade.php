@extends('layouts.app')
{{-- page header --}}
@section('title','Supplier List')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         @if(Finance::count_suppliers() != Wingu::plan()->suppliers && Finance::count_suppliers() < Wingu::plan()->suppliers)
            @permission('create-vendors')
               <a href="{!! route('finance.supplier.create') !!}" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add A Supplier</a>
               <a href="{!! route('supplier.import.index') !!}" class="btn btn-pink"><i class="fal fa-file-upload"></i> Import Supplier</a>
            @endpermission
         @endif
         @permission('export-supplier')
            <a href="{!! route('supplier.export','csv') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Supplier</a>
         @endpermission
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-cog"></i> All Supplier</h1>
		@include('partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Supplier List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th width="15%">Phone number</th>
                     <th width="15%">Date addded</th>
                     <th width="8%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>#</th>
                     <th>Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phone number</th>
                     <th>Date addded</th>
                     <th>Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  @foreach ($suppliers as $supplier)
                     <tr {{-- class="success" --}}>
                        <td>{!! $count++ !!}</td>
                        <td>
                           @if($supplier->image == "")
                              <img src="https://ui-avatars.com/api/?name={!! $supplier->supplier_name !!}&rounded=true&size=32"  class="img-circle"  alt="{!! $supplier->supplier_name !!}" width="40" height="40">
                           @else
                              <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.$supplier->business_code.'/suppliers/'.$supplier->supplierCode.'/images/'.$supplier->image) !!}">
                           @endif
                        </td>
                        <td>{!! $supplier->supplier_name !!}</td>
                        <td>{!! $supplier->email !!}</td>
                        <td>{!! $supplier->primary_phone_number !!}</td>
                        <td>{!! date('d F, Y', strtotime($supplier->created_at)) !!}</td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 {{-- <li><a href="{{ route('finance.supplier.show', $supplier->id) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li> --}}
                                 @permission('update-vendors')
                                    <li><a href="{{ route('finance.supplier.edit', $supplier->supplierID) }}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 @endpermission
                                 @permission('delete-vendors')
                                 <li><a href="{!! route('finance.supplier.delete', $supplier->supplierID) !!}" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                                 @endpermission
                              </ul>
                           </div>
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
@section('script')

@endsection
