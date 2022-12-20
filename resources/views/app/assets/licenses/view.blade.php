@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $details->asset_name !!} @endsection
{{-- page styles --}}
@section('stylesheet')
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
      .row-striped {
         vertical-align: top;
         line-height: 2.6;
         padding: 0;
         margin-left: 20px;
         -webkit-box-sizing: border-box;
         box-sizing: border-box;
         display: table;
      }
      .row-striped .row:nth-of-type(odd) div {
         background-color: #f9f9f9;
         border-top: 1px solid #ddd;
         display: table-cell;
      }

      .img-thumbnail {
         padding: 4px;
         line-height: 1.42857143;
         background-color: #fff;
         border: 1px solid #ddd;
         border-radius: 4px;
         -webkit-transition: all .2s ease-in-out;
         transition: all .2s ease-in-out;
         display: inline-block;
         max-width: 100%;
         height: auto;
      }
      .user-image-inline {
         float: left;
         width: 25px;
         height: 25px;
         border-radius: 50%;
         margin-right: 10px;
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
      {{-- <div class="btn-group">
         <button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"><i class="fas fa-mouse"></i> Actions</button>
         <ul class="dropdown-menu">
            <li><a href="#">Check in</a></li>
            <li><a href="#">Service</a></li>
            <li><a href="#">Reserve</a></li>
            <li><a href="#">Request</a></li>
            <li><a href="#">Report Damage</a></li>
            <li><a href="#">Repair</a></li>
            <li><a href="#">Performance maintainance</a></li>
            <li><a href="#">Dispose</a></li>
            <li><a href="#">Move asset</a></li>
            <li><a href="#">Audit</a></li>
            <li><a href="#">Quick Transfer</a></li>
         </ul>
      </div> --}}
      <a href="{!! route('licenses.assets.edit',$details->id) !!}" class="btn btn-primary"><i class="fal fa-edit"></i> Edit</a>
      {{-- <a href="#" class="btn btn-pink"><i class="fas fa-barcode"></i> Generate Barcode</a> --}}
      <a href="{!! route('licenses.assets.delete',$details->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
      {{-- <a href="#" class="btn btn-pink"><i class="fas fa-trash"></i> Print QR code</a> --}}
   </div>
   <!-- begin page-header -->
  
   @if(request()->route()->getName() == 'licenses.assets.show')
      <h1 class="page-header"><i class="fal fa-laptop-code"></i> {!! $details->asset_name !!}</h1>
   @endif
   @if(request()->route()->getName() == 'licenses.maintenances.index' || request()->route()->getName() == 'licenses.maintenances.create' ||request()->route()->getName() == 'licenses.maintenances.edit') 
      <h1 class="page-header"><i class="fal fa-tools"></i> {!! $details->asset_name !!} | Maintenances</h1>
   @endif    
	@include('partials._messages')
	<div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">   
               <div class="row">
                  <div class="col-md-4">
                     @if($details->asset_image == "")
                        <img src="{!! asset('assets/img/product_placeholder.jpg') !!}" class="assetimg img-responsive" style="height: 369px;width: 100%">
                     @else 
                        <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/assets/'.$details->asset_image) !!}" alt="" class="assetimg img-responsive">
                     @endif
                  </div>
                  <div class="col-md-4">
                     <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
                        <tbody>
                           <tr><td>Product key</td><td><b>{!! $details->product_key !!}</b></td></tr>                           
                           <tr><td>Seats</td><td><b>{!! $details->seats !!}</b></td></tr>
                           <tr><td>Manufacture</td><td><b>{!! $details->manufacture !!}</b></td></tr>
                           <tr><td>Licensed to name</td><td><b>{!! $details->licensed_to_name !!}</b></td></tr>
                           <tr><td>Licensed to email</td><td><b>{!! $details->licensed_to_email !!}</b></td></tr>     
                           <tr><td>Is software Reassignable </td><td><b>{!! $details->reassignable !!}</b></td></tr>
                           <tr>
                              <td>Supplier</td>
                              <td>
                                 @if($details->supplier != "")
                                    @if(Finance::check_supplier($details->supplier) == 1)
                                       <b>{!! Finance::supplier($details->supplier)->supplierName !!}</b>
                                    @endif
                                 @endif
                              </td>
                           </tr>      
                        </tbody>
                    </table>
                  </div>
                  <div class="col-md-4">
                     <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
                        <tbody>                            
                           <tr><td>Order number</td><td><b>{!! $details->order_number !!}</b></td></tr>
                           <tr><td>Purchase Cost</td><td><b>{!! $details->purches_cost !!}</b></td></tr>
                           <tr><td>Purchase date</td><td><b>@if($details->purchase_date != ""){!! date('M jS, Y', strtotime($details->purchase_date)) !!}@endif</b></td></tr>
                           <tr><td>Termination Date</td><td><b>{!! $details->end_of_life !!}</b></td></tr>
                           <tr><td>Is software maintained</td><td><b>{!! $details->maintained !!}</b></td></tr>
                           <tr>
                              <td>Next maintenance</td>
                              <td>
                                 <b>@if($details->next_maintenance != ""){!! date('M jS, Y', strtotime($details->next_maintenance)) !!}</b>@endif
                              </td>
                           </tr>   
                           <tr>
                              <td>Created by</td>
                              <td>
                                 @if(Wingu::check_user($details->created_by) == 1)
                                    <b>{!! Wingu::user($details->created_by)->name !!}</b>
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
               <li class="{!! Nav::isRoute('licenses.assets.show') !!}">
                  <a href="{!! route('licenses.assets.show',$details->id) !!}">
                     <span class="">
                        <i class="fal fa-info-circle"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Details
                     </span>
                  </a>
               </li>
               {{-- <li class="">
                  <a href="#assets" data-toggle="tab" aria-expanded="false">
                     <span class="">
                        <i class="fal fa-folder-upload"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        License Logs
                     </span>
                  </a>
               </li>         --}}
               <li class="{!! Nav::isRoute('licenses.maintenances.index') !!} {!! Nav::isRoute('licenses.maintenances.create') !!} {!! Nav::isRoute('licenses.maintenances.edit') !!}">
                  <a href="{!! route('licenses.maintenances.index',$details->id) !!}">
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
               {{-- <li class="">
                  <a href="#assets" data-toggle="tab" aria-expanded="false">
                     <span class="">
                        <i class="fa fa-barcode" aria-hidden="true"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Depreciation
                     </span>
                  </a>
               </li>     --}}
               {{-- <li class="">
                  <a href="#assets" data-toggle="tab" aria-expanded="false">
                     <span class="">
                        <i class="fal fa-map-marker-alt"></i>
                     </span>
                     <span class="hidden-xs hidden-sm">
                        Location
                     </span>
                  </a>
               </li>     --}}
            </ul>
            <div class="tab-content">
               @if(request()->route()->getName() == 'licenses.assets.show')
                  @include('app.assets.licenses.show.details') 
               @endif
               @if(request()->route()->getName() == 'licenses.maintenances.index')
                  @include('app.assets.licenses.show.maintenances')
               @endif   
               @if(request()->route()->getName() == 'licenses.maintenances.create')
                  @include('app.assets.licenses.maintenance.create')
               @endif 
               @if(request()->route()->getName() == 'licenses.maintenances.edit')
                  @include('app.assets.licenses.maintenance.edit')
               @endif       
            </div>  
         </div>
      </div>
   </div>
</div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
