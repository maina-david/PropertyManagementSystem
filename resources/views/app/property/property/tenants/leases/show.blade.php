@extends('layouts.app')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page header --}}
@section('title') {!! $tenant->tenant_name !!} | Tenant @endsection

@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.show', $property->id) !!}">{!! $property->title !!}</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.tenants', $property->id) !!}">Tenants</a></li>
         <li class="breadcrumb-item active"><a href="{!! route('property.tenant.lease.show',[$propertyID,$lease->tenantID,$lease->leaseID]) !!}"> Lease Details</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | {!! $tenant->tenant_name !!} | Leases </h1>
      <div class="row">
         @include('app.property.property.tenants._nav') 
         <div class="col-md-12 mt-3">
            @if($lease->status != 26)
               <a href="#" class="btn btn-danger delete" data-toggle="modal" data-target="#exampleModalCenter"><i class="fal fa-ban"></i> Terminate Lease</a>
            @endif
            <a href="{!! route('property.tenant.lease.edit',[$propertyID,$lease->tenantID,$lease->leaseID]) !!}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
            {{-- <a href="" class="btn btn-primary"><i class="fal fa-sync-alt"></i> Renew / Extend Lease</a> --}}
            {{-- <a href="" class="btn btn-white"><i class="fal fa-print"></i> Print</a> --}}
         </div>
         <div class="col-md-12">
            <div class="panel mt-3">
               <div class="panel-heading"><b>Lease details</b></div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-4">
                        <p>
                           <b>Property Name :</b> {!! $property->title !!}<br>
                           <b>Unit # : </b>{!! $lease->serial !!}<br>
                           <b>Lease # : </b> {!! $lease->lease_code !!} <br>
                           <b>Lease Type : </b> {!! $lease->lease_type !!} <br>
                           <b>Start Date : </b> {!! date('d F, Y', strtotime($lease->lease_start_date)) !!} <br>
                           <b>End Date : </b> @if($lease->lease_end_date != ""){!! date('d F, Y', strtotime($lease->lease_end_date)) !!}@endif<br>
                           <b>Rent Amount : </b>{!! $business->code !!}{!! number_format($lease->rent_amount) !!} <br>
                           <b>Deposit : </b> {!! $business->code !!}{!! number_format($lease->deposit) !!} <br>
                                    
                        </p>
                     </div>
                     <div class="col-md-4">
                        <p>    
                           <b>Billing Schedule : </b> 
                           @if($lease->billing_schedule == 7) Weekly @elseif($lease->billing_schedule == 1) Monthly @elseif($lease->billing_schedule == 3) Quarterly @elseif($lease->billing_schedule == 6) Half Year @elseif($lease->billing_schedule == 12) Yearly @endif
                           <br>
                           <b>First invoice date : </b> @if($lease->first_invoice_date != ""){!!  date('d F, Y', strtotime($lease->first_invoice_date)) !!}@endif<br>                      
                           <b>Next invoice date : </b> @if($lease->lease_termination_date != ""){!! date('d F, Y', strtotime($lease->lease_termination_date)) !!}@endif <br>
                           <b>Tax rate : </b> {!! $lease->tax_rate !!} <br>
                           <b>Escalation Rate : </b> {!! $lease->escalation_rate !!}%<br>
                           <b>Escalation Period : </b> {!! $lease->escalation_period !!}<br>
                           <b>Escalation Items : </b> {!! $lease->escalating_items !!} <br>    
                           <b>Service charge Fee : </b> {!! $business->code !!}{!! number_format($lease->service_charge) !!} <br>              
                        </p>
                     </div>
                     <div class="col-md-4">
                        <p>                                    
                           <b>Parking fee : </b> {!! $business->code !!}{!! number_format($lease->parking_price) !!} <br>
                           <b>Allocated parkings : </b> {!! $lease->parking_spaces !!} <br>
                           <b>Add Utilities to tenant : </b> {!! $lease->include_utility !!} <br>
                           {{-- <b>Utilities included : </b> {!! $lease->include_utility !!} <br> --}}                 
                        </p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel mt-3">
               <div class="panel-heading"><b>Lease Agreement</b></div>
               <div class="panel-body">
                  {!! $lease->agreement !!}
               </div>
            </div>
         </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <form action="{!! route('property.lease.terminate') !!}" method="post">
                  @csrf
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">Terminate Lease</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group">
                        <label for="">Date ended</label>
                        {!! Form::date('lease_termination_date',null,['class' => 'form-control','required' => '']) !!}
                        <input type="hidden" name="leaseID" value="{!! $lease->leaseID !!}">
                        
                     </div>
                     <div class="form-group">
                        <label for="">End Note</label>
                        {!! Form::textarea('lease_termination_note',null,['class' => 'form-control ckeditor','required' => '']) !!}
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-success">Submit</button>
                     <img src="{!! url('/') !!}/public/app/img/btn-loader.gif" class="submit-load none float-right" alt="" width="15%">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script src="{!! url('/') !!}/public/app/plugins/ckeditor/4/standard/ckeditor.js"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection