@extends('layouts.app')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page header --}}
@section('title') {!! $tenant->tenant_name !!} | Tenant Units @endsection

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
         @include('app.property.property.tenants._nav') 
         <div class="col-md-12 mt-3">
            <div class="panel">
               <div class="panel-heading">Tenant Units</div>
               <div class="panel-body">
                  <table id="example5" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>UnitID</th>
                           <th>Unit Type</th>
                           <th>Landlord</th> 
                           <th>Lease ID</th>
                           <th>Rent (p/Mo)</th>
                           <th>Bedrooms</th>
                           <th width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($units as $unit)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $unit->serial !!}</td>                     
                              <td>
                                 @if($unit->property_type != "")
                                    {!! Property::property_type($unit->property_type)->name !!}
                                 @endif
                              </td>
                              <td>
                                 @if(Finance::check_client($unit->landlordID) == 1)
                                    {!! Finance::client($unit->landlordID)->customer_name !!}
                                 @endif                         
                              </td>
                              <td>{!! $unit->lease_code !!}</td>
                              <td>{!! $business->code !!}{!! number_format($unit->rent_amount) !!}</td>
                              <td>{!! $unit->bedrooms !!}</td>
                              <td><a href="{!! route('property.units.edit',[$propertyID,$unit->unitID]) !!}" class="btn btn-primary btn-block"><i class="far fa-edit"></i> Edit</a></td>
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