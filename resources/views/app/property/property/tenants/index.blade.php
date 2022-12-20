@extends('layouts.app') 
{{-- page header --}}
@section('title') Tenants List | {!! $property->title !!} @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Tenants</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">List</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> {!! $property->title !!} | Tenants </h1>
      <div class="row">
         @include('app.property.partials._property_menu')   
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Tenants List</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th width="5">Image</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Phonenumber</th>
                           <th>Lease</th>
                           <th width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($tenants as $tenant)
                           <tr {{-- class="success" --}}>
                              <td>{!! $count++ !!}</td>
                              <td>
                                 @if($tenant->image == "")
                                    <img src="https://ui-avatars.com/api/?name={!! $tenant->tenant_name !!}&rounded=true&size=40" alt="{!! $tenant->tenant_name !!}"/>
                                 @else
                                    <img width="40" height="40" alt="" class="img-circle" src="{!! url('/') !!}/storage/files/business/{!! Wingu::business(Auth::user()->businessID)->primary_email !!}/property/tenant/{!! $tenant->tenant_code !!}/images/{!! $tenant->image !!}">
                                 @endif
                              </td>
                              <td>
                                 {!! $tenant->tenant_name !!} 
                              </td>
                              <td>{!! $tenant->contact_email !!}</td>
                              <td>{!! $tenant->primary_phone_number !!}</td>
                              <td>{!! Property::count_lease($tenant->tenantID) !!}</td>
                              <td>
                                 <a href="{!! route('property.tenants.show',[$property->id,$tenant->tenantID]) !!}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                 <a href="{!! route('tenants.edit',$tenant->tenantID) !!}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
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
