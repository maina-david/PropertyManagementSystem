@extends('layouts.app')
@section('title','Marketing | Listing ')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Marketing</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Lisitng</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullhorn"></i> Marketing </h1>
      <div class="card card-default">
         <div class="card-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr> 
                     <th width="1%">#</th>
                     <th>Name</th>
                     <th>Type</th>
                     <th>Category</th>
                     <th>Address</th>
                     <th>List Date</th>
                     <th>Expires</th>
                     <th>Price</th>
                     <th>Status</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($properties as $property)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>{!! $property->title !!}</td>
                        <td> 
                           @if($property->type != "")
                              {!! Property::property_type($property->type)->name !!} 
                           @endif
                        </td>
                        <td>{!! $property->category !!}</td>
                        <td>{!! $property->geolocation !!}</td>
                        <td>{!! $property->start_date !!}</td>
                        <td>{!! $property->end_date !!}</td>
                        <td><b>{!! $business->code !!} {!! number_format($property->price) !!}</b></td>
                        <td><span class="badge {!! $property->statusName !!}">{!! $property->statusName !!}</span></td>
                        <td>
                           <a href="{!! route('list.property.edit',$property->listID) !!}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                           <a href="{!! route('list.property.cancel',[$property->propertyID,$property->listID]) !!}" class="btn btn-sm btn-warning delete"><i class="fal fa-ban"></i></a>
                           <a href="{!! route('list.property.delete',$property->listID) !!}" class="btn btn-sm btn-danger"><i class="far fa-trash"></i></a>
                        </td>
                     </tr>
                  @endforeach               
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection