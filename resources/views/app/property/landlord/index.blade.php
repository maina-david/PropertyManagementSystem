@extends('layouts.app')
@section('title','Landlords')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb --> 
      <ol class="breadcrumb pull-right">
         {{-- <a href="{!! route('tenants.import.index') !!}" class="btn btn-pink mr-2"><i class="fal fa-file-upload"></i> Import Tenant</a>
         <a href="{!! route('tenants.export') !!}" class="btn btn-pink mr-2"><i class="fal fa-file-download"></i> Export Tenant</a> --}}
         <a href="{!! route('landlord.create') !!}" class="btn btn-pink mr-2"><i class="fal fa-plus-circle"></i> Add Landlord</a>    
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-crown"></i> Landlords</h1>
      <!-- end breadcrumb -->
      <div class="card card-default">
         <div class="card-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phonenumber</th>
                     <th>Properties</th>
                     <th width="9%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($landlords as $landlord)
                     <tr {{-- class="success" --}}>
                        <td>{!! $count++ !!}</td>                    
                        <td>
                           @if($landlord->contact_type == 'Individual') 
                              {!! $landlord->salutation !!} {!! $landlord->customer_name !!}
                           @else 
                              {!! $landlord->customer_name !!}
                           @endif
                        </td>
                        <td>{!! $landlord->email !!}</td>
                        <td>{!! $landlord->primary_phone_number !!}</td>
                        <td>{!! Property::landlord_properties($landlord->propertyID) !!}</td>
                        <td>
                           {{-- <a href="{{ route('finance.contact.show', $landlord->propertyID) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a> --}}
                           <a href="{{ route('landlord.edit', $landlord->propertyID) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="{!! route('landlord.delete', $landlord->propertyID) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash-alt"></i></a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection