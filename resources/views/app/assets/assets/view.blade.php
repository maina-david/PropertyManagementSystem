@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $details->asset_name !!} @endsection
{{-- page styles --}}
@section('stylesheet')
   <style>
       <style>
      .nav-tabs-custom {
         margin-bottom: 20px;
         background: #fff;
         -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.1);
         box-shadow: 0 1px 1px rgba(0,0,0,.1);
         border-radius: 3px;
      }
      .nav-tabs-custom>.nav-tabs {
         margin: 0;
         border-bottom-color: #f4f4f4;
         border-top-right-radius: 3px;
         border-top-left-radius: 3px;
      }
      .nav-tabs-custom>.nav-tabs>li:first-of-type {
         margin-left: 0;
      }
      .nav-tabs-custom>.nav-tabs>li.active {
         border-top-color: #fb5597;
      }
      .nav-tabs-custom>.nav-tabs>li {
         border-top: 3px solid transparent;
         margin-bottom: -2px;
         margin-right: 5px;
      }
      .nav-tabs>li {
         float: left;
         margin-bottom: -1px;
      }
      .nav-tabs-custom>.nav-tabs>li:first-of-type.active>a {
         border-left-color: transparent;
      }
      .nav-tabs-custom>.nav-tabs>li.active>a {
         border-top-color: transparent;
         border-left-color: #f4f4f4;
         border-right-color: #f4f4f4;
      }
      .nav-tabs-custom>.nav-tabs>li.active:hover>a, .nav-tabs-custom>.nav-tabs>li.active>a {
         background-color: #fff;
         color: #444;
      }
      .nav-tabs-custom>.nav-tabs>li>a, .nav-tabs-custom>.nav-tabs>li>a:hover {
         background: 0 0;
         margin: 0;
      }
      .nav-tabs-custom>.nav-tabs>li>a {
         color: #444;
         border-radius: 0;
      }
      .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
         color: #555;
         background-color: #fff;
         border: 1px solid #ddd;
         border-bottom-color: transparent;
         cursor: default;
      }
      .nav-tabs>li>a {
         margin-right: 2px;
         line-height: 1.42857143;
         border: 1px solid transparent;
         border-radius: 4px 4px 0 0;
      }
   </style>
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.assets.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div class="content">
	<div class="pull-right">
      <div class="btn-group">
         <button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"><i class="fal fa-mouse"></i> Actions</button>
         <ul class="dropdown-menu">
            @if($details->status == 38)
               <li><a data-toggle="modal" data-target=".checkin">Check In</a></li>
            @else
               <li><a data-toggle="modal" data-target=".checkout">Check out</a></li>
            @endif

            <li><a data-toggle="modal" data-target=".lease">Lease</a></li>
            {{-- <li><a data-toggle="modal" data-target=".lost">Lost / Missing</a></li>
            <li><a data-toggle="modal" data-target=".repair">Repair</a></li>
            <li class="divider"></li>
            <li><a data-toggle="modal" data-target=".disposed">Dispose</a></li>
            <li><a data-toggle="modal" data-target=".donate">Donate</a></li>
            <li><a data-toggle="modal" data-target=".sell">Sell</a></li> --}}
            {{-- <li class="divider"></li>
            <li><a data-toggle="modal" href="#asset-email"><i class="glyphicon glyphicon-envelope"></i>&nbsp; Email</a></li>
            <li><a data-toggle="modal" href="#asset-copy"><i class="fa fa-copy"></i>&nbsp; Replicate</a></li> --}}
         </ul>
      </div>
      <a href="{!! route('assets.edit',$details->id) !!}" class="btn btn-primary"><i class="fal fa-edit"></i> Edit</a>
      {{-- <a href="#" class="btn btn-warning"><i class="fal fa-print"></i> Print</a> --}}
      <a href="{!! route('assets.delete',$details->id) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
   </div>
   <!-- begin page-header -->

   @if(request()->route()->getName() == 'assets.show' || request()->route()->getName() == 'assets.event.index')
      <h1 class="page-header"><i class="fal fa-barcode-alt"></i> {!! $details->asset_name !!}</h1>
   @endif
   @if(request()->route()->getName() == 'assets.maintenances.index')
      <h1 class="page-header"><i class="fal fa-tools"></i> {!! $details->asset_name !!} | Maintenances</h1>
   @endif
   @if(request()->route()->getName() == 'assets.maintenances.create')
     <h1 class="page-header"><i class="fal fa-tools"></i> {!! $details->asset_name !!} | Add Maintenance</h1>
   @endif
   @if(request()->route()->getName() == 'assets.maintenances.edit')
     <h1 class="page-header"><i class="fal fa-tools"></i> {!! $details->asset_name !!} | Edit Maintenance</h1>
   @endif
   @if(request()->route()->getName() == 'assets.details.vehicle')
     <h1 class="page-header"><i class="fal fa-car"></i> {!! $details->asset_name !!}</h1>
   @endif
	@include('partials._messages')
	<div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-4">
                     @if($details->asset_image == "")
                        <img src="{!! asset('assets/img/product_placeholder.jpg') !!}" class="assetimg img-responsive" style="height: 246px;width: 100%">
                     @else
                        <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/assets/'.$details->asset_image) !!}" alt="" class="assetimg img-responsive">
                     @endif
                  </div>
                  <div class="col-md-4">
                     <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
                        <tbody>
                           <tr><td>Asset Tag ID</td><td><b>{!! $details->asset_tag !!}</b></td></tr>
                           <tr><td>Serial</td><td><b>{!! $details->serial !!}</b></td></tr>
                           <tr>
                              <td>Purchase Date</td>
                              <td><b>@if($details->purchase_date != ""){!! date('F jS, Y', strtotime($details->purchase_date)) !!}@endif</b></td>
                           </tr>
                           <tr><td>Cost</td><td><b>@if($details->purches_cost != ""){!! number_format($details->purches_cost) !!}@endif</b></td></tr>
                           <tr><td>Brand</td><td><b>{!! $details->asset_brand !!}</b></td></tr>
                           <tr><td>Model</td><td><b>{!! $details->asset_model !!}</b></td></tr>
                        </tbody>
                    </table>
                  </div>
                  <div class="col-md-4">
                     <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
                        <tbody>
                           <tr>
                              <td>Branch</td>
                              <td><b>@if(Hr::check_branch($details->company_branch) == 1) {!! Hr::branch($details->company_branch)->branch_name !!}  @endif</b></td>
                           </tr>
                           <tr><td>Location</td><td><b>{!! $details->default_location !!}</b></td></tr>
                           <tr><td>Asset Type</td><td><b>@if(Asset::check_type($details->asset_type) == 1){!! Asset::type($details->asset_type)->name !!}@endif</b></td></tr>
                           <tr><td>Department</td><td><b>@if(Hr::check_department($details->department) == 1) {!! Hr::department($details->department)->title !!}  @endif</td></tr>
                           <tr>
                              <td>Assigned to</td>
                              <td>
                                 @if($details->employee != "")
                                    <b>Employee :</b> {!! Hr::employee($details->employee)->names !!}
                                 @endif
                                 @if($details->customer != "")
                                    <b>Customer :</b> {!! Finance::client($details->customer)->customer_name !!}
                                 @endif
                              </td>
                           </tr>
                           <tr>
                              <td>Status</td>
                              <td class="@if($details->status == 37) success @elseif($details->status == 32) danger @else info @endif">
                                 @if($details->status != "")
                                    {!! Wingu::status($details->status)->name !!}
                                 @endif
                              </td>
                           </tr>
                        </tbody>
                    </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
               <li class="{!! Nav::isRoute('assets.show') !!}">
                  <a href="{!! route('assets.show',$details->id) !!}">
                     <span class="">
                        <i class="fal fa-info-circle"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Details
                     </span>
                  </a>
               </li>
               @if($details->asset_type == 1)
                  <li class="{!! Nav::isRoute('assets.details.vehicle') !!}">
                     <a href="{!! route('assets.details.vehicle',$details->id) !!}">
                        <span class="">
                           <i class="fal fa-car"></i>
                        </span>
                        <span class="hidden-xs hidden-sm">
                           Vehicle details
                        </span>
                     </a>
                  </li>
               @endif
               <li class="{!! Nav::isRoute('assets.maintenances.index') !!} {!! Nav::isRoute('assets.maintenances.create') !!} {!! Nav::isRoute('assets.maintenances.edit') !!}">
                  <a href="{!! route('assets.maintenances.index',$details->id) !!}">
                     <span class="">
                        <i class="fal fa-tools"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Maintenances Log
                     </span>
                  </a>
               </li>
               {{-- <li class="">
                  <a href="#assets" data-toggle="tab" aria-expanded="false">
                     <span class="">
                        <i class="fal fa-folder-upload"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Files/Attachments
                     </span>
                  </a>
               </li>             --}}
               <li class="{!! Nav::isResource('events') !!}">
                  <a href="{!! route('assets.event.index',[$details->id]) !!}">
                     <span class="">
                        <i class="fal fa-calendar-alt"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Events
                     </span>
                  </a>
               </li>
               {{-- <li class="">
                  <a href="#assets" data-toggle="tab" aria-expanded="false">
                     <span class="">
                        <i class="fal fa-map-marker-alt"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Map
                     </span>
                  </a>
               </li>     --}}
            </ul>
            <div class="tab-content">
               @if(request()->route()->getName() == 'assets.show')
                  @include('app.assets.assets.details')
               @endif
               @if(request()->route()->getName() == 'assets.maintenances.index')
                  @include('app.assets.assets.maintenances')
               @endif
               @if(request()->route()->getName() == 'assets.details.vehicle')
                  @include('app.assets.assets.vehicle')
               @endif
               @if(request()->route()->getName() == 'assets.maintenances.create')
                  @include('app.assets.assets.maintenance.create')
               @endif
               @if(request()->route()->getName() == 'assets.maintenances.edit')
                  @include('app.assets.assets.maintenance.edit')
               @endif
               @if(request()->route()->getName() == 'assets.event.index')
                  @include('app.assets.assets.events.index')
               @endif
            </div>
         </div>
      </div>
   </div>
</div>


{{-- checkout --}}
<div class="modal fade checkout" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="{!! route('assets.event.checkout.store') !!}" method="POST" autocomplete="off" id="checkoutForm">
            @csrf
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Check out</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="">Check-out Date</label>
                        {!! Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']) !!}
                        <input type="hidden" name="status" value="38">
                        <input type="hidden" name="assetID" value="{!! $details->id !!}">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Due Date</label>
                        {!! Form::text('due_action_date',null,['class' => 'form-control datepicker', 'placeholder' => 'choose date']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="">Check-out to</label>
                        {!! Form::select('check_out_to',['' => 'Choose','Person' => 'Person','Branch' => 'Branch','Location' => 'Site / Location'],null,['class' => 'form-control', 'required' => '', 'id'=>'checkoutto']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Branch</label>
                        {!! Form::select('branch',$branches,null,['class' => 'form-control']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Person</label>
                        {!! Form::select('allocated_to',$employees,null,['class' => 'form-control']) !!}
                     </div>
                  </div>
                  <div class="col-md-6" id="checkoutLocation" style="display:none">
                     <div class="form-group form-group-default required">
                        <label for="">Site / Location </label>
                        {!! Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Department </label>
                        {!! Form::select('department',$departments,null,['class' => 'form-control']) !!}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitCheckoutForm">Submit check out</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- checkin --}}
<div class="modal fade checkin" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="{!! route('assets.event.checkin.store') !!}" method="POST" autocomplete="off" id="checkinForm">
            @csrf
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Check in</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="">Return Date </label>
                        {!! Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']) !!}
                        <input type="hidden" name="status" value="43">
                        <input type="hidden" name="assetID" value="{!! $details->id !!}">
                     </div>
                  </div>
                  <div class="col-md-6" id="checkoutLocation">
                     <div class="form-group form-group-default required">
                        <label for="">Site / Location </label>
                        {!! Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']) !!}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitCheckinForm">Submit check out</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- Lease --}}
<div class="modal fade lease" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="{!! route('assets.event.lease.store') !!}" method="POST" autocomplete="off" id="leaseForm">
            @csrf
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Lease</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Lease Begins</label>
                        {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                        <input type="hidden" name="status" value="39">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Lease Expires</label>
                        {!! Form::date('due_action_date',null,['class' => 'form-control', 'required' => '']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Leasing Customer </label>
                        {!! Form::select('allocated_to',$customers,null,['class' => 'form-control', 'required' => '']) !!}
                     </div>
                  </div>
                  {{-- <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Send Email</label>
                        {!! Form::select('send_email',['No' => 'No','Yes' => 'Yes'],null,['class' => 'form-control','id'=>'lease_email']) !!}
                     </div>
                  </div>
                  <div class="col-md-6" id="leaseEmail" style="display: none">
                     <div class="form-group form-group-default required">
                        <label for="">Email</label>
                        {!! Form::email('email',null,['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
                     </div>
                  </div> --}}
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitLeaseForm">Submit Lease</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- lost --}}
<div class="modal fade lost" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="lostForm">
            @csrf
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Lost / Missing Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Date Lost </label>
                        {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                        <input type="hidden" name="status" value="32">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitLostForm">Submit Information</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- Repair Asset --}}
<div class="modal fade repair" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="repairForm">
            @csrf
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Repair Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Repair date </label>
                        {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                        <input type="hidden" name="status" value="34">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Assigned to </label>
                        {!! Form::text('action_to',null,['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Date Completed </label>
                        {!! Form::date('due_action_date',null,['class' => 'form-control']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Repair Cost</label>
                        {!! Form::number('cost',null,['class' => 'form-control', 'placeholder' => 'Enter amount']) !!}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitRepairForm">Submit Information</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- Dispose Asset --}}
<div class="modal fade disposed" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="disposedForm">
            @csrf
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Dispose Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Date Disposed </label>
                        {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                        <input type="hidden" name="status" value="40">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Dispose to </label>
                        {!! Form::text('action_to',null,['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitDisposedForm">Submit Information</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

{{--Donate Asset --}}
<div class="modal fade donate" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="donateForm">
            @csrf
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Donate Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Date Donated </label>
                        {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                        <input type="hidden" name="status" value="41">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Dispose to </label>
                        {!! Form::text('action_to',null,['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Donate Value </label>
                        {!! Form::number('cost',null,['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Deductible </label>
                        {!! Form::select('deductible',['No' => 'No', 'Yes' => 'Yes'],null,['class' => 'form-control']) !!}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitDonateForm">Submit Information</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- Sell Asset --}}
<div class="modal fade sell" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="" method="POST" autocomplete="off" id="donateForm">
            @csrf
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Sell Asset</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Sale Date</label>
                        {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                        <input type="hidden" name="status" value="42">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Sold to</label>
                        {!! Form::text('action_to',null,['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Sale amount</label>
                        {!! Form::number('cost',null,['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Note </label>
                        {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitDonateForm">Submit Information</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>

@endsection
{{-- page scripts --}}
@section('scripts')
   <script>
      $(document).ready(function() {
         $('#checkoutto').on('change', function(){
            if(this.value == 'Location') {
               $('#checkoutLocation').show();
            }else {
               $('#checkoutLocation').hide();
            }
         });

         $('#lease_email').on('change', function(){
            if(this.value == 'Yes') {
               $('#leaseEmail').show();
            }else {
               $('#leaseEmail').hide();
            }
         });

         //checkoutForm
         $('#checkoutForm').on('submit', function(e){
            $('.submitCheckoutForm').hide();
            $(".checkout-load").show();
         });

         //checkinForm
         $('#checkinForm').on('submit', function(e){
            $('.submitCheckinForm').hide();
            $(".checkin-load").show();
         });

         //leaseForm
         $('#leaseForm').on('submit', function(e){
            $('.submitLeaseForm').hide();
            $(".lease-load").show();
         });

         //LostForm
         $('#lostForm').on('submit', function(e){
            $('.submitLostForm').hide();
            $(".lost-load").show();
         });

         //repairForm
         $('#repairForm').on('submit', function(e){
            $('.submitRepairForm').hide();
            $(".repair-load").show();
         });

         //disposedForm
         $('#disposedForm').on('submit', function(e){
            $('.submitDisposedForm').hide();
            $(".disposed-load").show();
         });

         //donateForm
         $('#donateForm').on('submit', function(e){
            $('.submitDonateForm').hide();
            $(".donate-load").show();
         });
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
