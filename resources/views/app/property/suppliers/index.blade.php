@extends('layouts.app') 
{{-- page header --}}
@section('title') Suppliers List @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb --> 
   <ol class="breadcrumb pull-right">
      <a href="{!! route('property.supplier.create') !!}" class="btn btn-pink float-right"><i class="fal fa-plus-circle"></i> Add A Supplier</a>
       {{-- <a href="{!! route('supplier.import.index') !!}" class="btn btn-pink"><i class="fas fa-file-upload"></i> Import Supplier</a>
         <a href="{!! route('supplier.export','csv') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Supplier</a> --}}
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-users-cog"></i> Suppliers - List</h1>
   <!-- end breadcrumb -->
	<div class="row">
      @include('partials._messages')
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Suppliers List</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="5">Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="15%">Phone number</th>
                        <th width="15%">Date addded</th>
                        <th width="9%">Action</th>
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
                                 <img src="https://ui-avatars.com/api/?name={!! $supplier->supplierName !!}&rounded=true&size=32" alt="">
                              @else
                                 <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.$supplier->business_code.'/suppliers/'. $supplier->customer_code.'/images/'.$supplier->image) !!}">
                              @endif
                           </td>
                           <td>{!! $supplier->supplierName !!}</td>
                           <td>{!! $supplier->email !!}</td>
                           <td>{!! $supplier->primary_phone_number !!}</td>
                           <td>{!! date('d F, Y', strtotime($supplier->created_at)) !!}</td>
                           <td>
                              <a href="{{ route('property.supplier.edit', $supplier->supplierID) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                              <a href="{!! route('property.supplier.delete', $supplier->supplierID) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
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
{{-- page scripts --}}
@section('scripts')

@endsection
