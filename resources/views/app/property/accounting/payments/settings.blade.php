@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Property Details @endsection
@section('sidebar')
	@include('app.property.partials._menu')
@endsection
{{-- page styles --}}

@section('stylesheets')
   <style>
      .panel-body {
         min-height: 160px;
      }
      .panel-heading {
         min-height: 120px;
      }

      .bank-name {
         font-family: 'Quicksand', sans-serif;
         font-size: 60px;
      }
   </style>
@endsection
{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Payments</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">integration</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Payment integration</h1>
	   @include('app.property.partials._property_menu')
	   <div class="col-md-12 mt-3">
	      <a href="#" class="btn btn-warning" data-toggle="modal" data-target=".gateway"> Add Payment integration</a>
	   </div>
	   <div class="col-md-12 mt-3">
	      <div class="row">
	         @foreach($intergrations as $getway)
	            <div class="col-md-4 col-sm-6 col-xs-12">
	               <div class="panel panel-default">
	                  <div class="panel-heading">
	                     @if($getway->gatewayID == 6 || $getway->gatewayID == 14 || $getway->gatewayID == 15 || $getway->gatewayID == 16 || $getway->gatewayID == 17)
	                     <br>
	                        <h1 class="text-center bank-name">Bank info.</h1>
	                     @else
	                        <center>
	                           <img alt="{!! $getway->gateway_name !!}" src="{!! asset('assets/img/gateways/'.$getway->logo) !!}" class="img-responsive payment-logo">
	                        </center>
	                     @endif
	                  </div>
	                  <div class="panel-body">
	                     {{-- check if bank has logo --}}
	                     @if($getway->gatewayID == 6 || $getway->gatewayID == 14 || $getway->gatewayID == 15 || $getway->gatewayID == 16 || $getway->gatewayID == 17)
	                        @if($getway->bank_name != "")
	                           <h3 class="text-center">{!! $getway->bank_name !!}</h3>
	                        @else
	                           <h3 class="text-center">Bank Info</h3>
	                        @endif
	                     @else
	                        <h3 class="text-center">{!! $getway->gateway_name !!}.</h3>
	                     @endif
	                     <center>
	                        @if($getway->paymentStatus == 15)
	                           <a href="#" class="badge badge-success"><i class="fal fa-check-circle"></i> Active</a>
	                        @else
	                           <a href="#" class="badge badge-warning"><i class="fal fa-times-circle"></i> Closed</a>
	                        @endif
	                     </center>
	                     <div class="row mt-2">
	                        <div class="col-md-12">
	                           <hr>
	                        </div>
	                     </div>
	                     @if($getway->gatewayID == 9)
	                        <a href="{!! route('property.mpesapaybill.integration',[$property->id,$getway->intergrationID]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     @endif
	                     @if($getway->gatewayID == 3)
	                        <a href="{!! route('property.mpesaapi.integration',[$property->id,$getway->intergrationID]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     @endif
	                     @if($getway->gatewayID == 8)
	                        <a href="{!! route('property.mpesatill.integration',[$property->id,$getway->intergrationID]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     @endif
	                     @if($getway->gatewayID == 6)
	                        <a href="{!! route('property.bank1.integration',[$property->id,$getway->intergrationID]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     @endif
	                     @if($getway->gatewayID == 14)
	                        <a href="{!! route('property.bank2.integration',[$property->id,$getway->intergrationID]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     @endif
	                     @if($getway->gatewayID == 15)
	                        <a href="{!! route('property.bank3.integration',[$property->id,$getway->intergrationID]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     @endif
	                     @if($getway->gatewayID == 16)
	                        <a href="{!! route('property.bank4.integration',[$property->id,$getway->intergrationID]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     @endif
	                     @if($getway->gatewayID == 17)
	                        <a href="{!! route('property.bank5.integration',[$property->id,$getway->intergrationID]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit details</a>
	                     @endif
	                     <a href="{!! route('property.payment.integration.settings.delete',[$property->id,$getway->intergrationID]) !!}" class="btn-danger btn-sm btn float-right ml-2 delete"><i class="fas fa-trash"></i> Delete</a>
	                  </div>
	               </div>
	            </div>
	         @endforeach
	      </div>
	   </div>
	   <!-- Modal -->
	   <form action="{!! route('property.payment.integration.settings.activation',$property->id) !!}" method="post">
	      <div class="modal fade gateway" tabindex="-1" role="dialog" aria-labelledby="gatewayTitle" aria-hidden="true">
	         <div class="modal-dialog modal-lg">
	            @csrf
	            <div class="modal-content">
	               <div class="modal-header">
	                  <h5 class="modal-title" id="exampleModalLongTitle">Add Payment Integration</h5>
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                     <span aria-hidden="true">&times;</span>
	                  </button>
	               </div>
	               <div class="modal-body">
	                  <div class="form-group form-group-default">
	                     <label for="">Choose Payment Gateways</label>
	                     {!! Form::select('gateway',$gateways, null,['class' => 'form-control'] ) !!}
	                  </div>
	                  <div class="form-group form-group-default">
	                     <label for="">Choose status</label>
	                     {!! Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control'] ) !!}
	                  </div>
	               </div>
	               <div class="modal-footer">
	                  <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Gateway</button>
	                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
	               </div>
	            </div>
	         </div>
	      </div>
	   </form>
	</div>
@endsection
@section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
