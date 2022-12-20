@extends('layouts.app')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page header --}}
@section('title') {!! $property->title !!} | Leases @endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)">Leases</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)">All</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-building"></i> {!! $property->title !!} | Leases</h1>
   <div class="row">
      @include('app.property.partials._property_menu') 
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Leases List</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered table-hover">
                  <thead>            
                     <tr>
                        <th width="1%">#</th>
                        <th>Tenant</th>
                        <th>Unit#</th>
                        <th>Type</th>
                        <th>Billing schedule</th>
                        <th>Start Date</th>
                        <th>Expiry</th>
                        <th width="10%">Status</th>    
                        <th width="12%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($leases as $lease)
                        <tr>
                           <td>{!! $count++ !!}</td>
                           <td>{!! $lease->tenant_name !!}</td>
                           <td>
                              {!! Property::property_info($lease->unitID)->serial !!}<br>
                              <span class="badge badge-info">{!! $lease->code !!}</span>
                           </td>
                           <td>{!! $lease->type !!}</td>
                           <td>
                              @if($lease->billing_schedule == 7)
                                 Weekly
                              @elseif($lease->billing_schedule == 1)
                                 Monthly
                              @elseif($lease->billing_schedule == 3)
                                 Quarterly
                              @elseif($lease->billing_schedule == 6)
                                 Half Year
                              @elseif($lease->billing_schedule == 12)
                                 Yearly
                              @endif
                           </td>  
                           <td>
                              @if($lease->lease_start_date != "")
                                 {!! date('F jS, Y', strtotime($lease->lease_start_date)) !!}
                              @endif 
                           </td>            
                           <td>
                              @if($lease->lease_end_date != "")
                                 {!! date('M jS, Y', strtotime($lease->lease_end_date)) !!}
                              @endif       
                           </td>
                           <td>
                              {{-- <a href="" class="btn btn-sm pink"><i class="fal fa-sync-alt"></i> Make Bill</a> --}}
                              @if($lease->status != "")
                                 <center><span class="badge {!! Wingu::status($lease->status)->name !!}">{!! Wingu::status($lease->status)->name !!}</span></center>
                              @endif
                           </td>   
                           <td>
                              <a href="{!! route('property.tenant.lease.show',[$propertyID,$lease->tenantID,$lease->leaseID]) !!}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                              <a href="{!! route('property.tenant.lease.edit',[$propertyID,$lease->tenantID,$lease->leaseID]) !!}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a> 
                              <a href="{!! route('property.tenant.lease.delete',[$lease->leaseID]) !!}" class="btn btn-danger btn-sm delete"><i class="far fa-trash"></i></a>
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
@section('script')

@endsection
