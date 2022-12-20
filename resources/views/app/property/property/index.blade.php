@extends('layouts.app')
@section('title','Property')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb --> 
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> Property</h1>
      <div class="card card-default">
         <div class="card-body">
            @include('partials._messages')
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="8%"></th>
                     <th width="21%">Name</th>
                     <th>Address</th>
                     <th>Type</th>
                     <th>Units</th>
                     <th>Tenants</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($properties as $property)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td> 
                           <center>
                              @if($property->image != "")
                                 <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/'.$property->image) !!}" alt="{!! $property->title !!}" class="img-circle" width="40" height="40">
                              @else 
                                 <img class="rounded-circle" width="40" height="40" alt="" class="img-circle" src="{!! asset('assets/img/icon.png') !!}">
                              @endif                        
                           </center>
                        </td> 
                        <td>{!! $property->title !!}</td>
                        <td>{!! $property->street_address !!}</td>
                        <td><b>{!! Property::property_type($property->property_type)->name !!}</b></td>
                        <td>
                           @if ($property->property_type == 4)
                              1
                           @else
                              {!! Property::total_units_per_property($property->id) !!}
                           @endif
                        </td>
                        <td>
                           @if($property->property_type == 4 || $property->property_type == 2 || $property->property_type == 5 || $property->property_type == 12 || $property->property_type == 11 || $property->property_type == 10)
                              @if ($property->tenantID != "")
                                 1
                              @else
                                 @if($property->listing_status == 49)
                                    <button class="btn btn-sm btn-success"><i class="fal fa-check-circle"></i> Listed</button>
                                 @else 
                                    <a href="{!! route('list.property',$property->id) !!}" class="btn btn-sm btn-danger"><i class="fal fa-cloud-upload-alt"></i> List Property</a>
                                 @endif
                              @endif
                           @else
                              {!! Property::occupied_units($property->id) !!}
                           @endif
                        </td>
                        <td>
                           <a href="{!! route('property.show',$property->id) !!}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                           <a href="{!! route('property.edit',$property->id) !!}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                           <a href="{!! route('property.delete',$property->id) !!}" class="delete btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div> 
   </div>
@endsection 