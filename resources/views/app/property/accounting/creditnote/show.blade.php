@extends('layouts.app')
{{-- page header --}}
@section('title')  {!! $property->title !!} | Credit Notes | Details @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 

{{-- content section --}} 
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
      <li class="breadcrumb-item"><a href="j{!! route('property.creditnote.index',$property->id) !!}">Credit Notes</a></li>
      <li class="breadcrumb-item active"><a href="{!! route('property.creditnote.show',[$property->id,$show->creditnoteID]) !!}">Details</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Credit Notes | Details </h1>
   <div class="row">
      @include('app.property.partials._property_menu')
      <div class="col-md-12"> 
         <div class="row mb-3">
            <span class="col-md-12">
               @if($show->paymentID == "")
                  @permission('update-invoice')
                     <a href="{!! route('property.invoice.edit',[$property->id,$show->creditnoteID]) !!}" class="btn btn-sm btn-primary m-b-10 p-l-5">
                        <i class="fas fa-edit"></i> Edit
                     </a>
                  @endpermission 
               @endif
               @permission('read-invoice')
                  <a href="{!! route('property.invoice.print',[$property->id,$show->creditnoteID]) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                     <i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
                  </a>
               @endpermission
               @permission('read-invoice')
                  <a href="{!! route('property.invoice.print',[$property->id,$show->creditnoteID]) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                     <i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
                  </a>
               @endpermission
               <a href="#" class="btn btn-sm btn-warning m-b-10 p-l-5">
                  <i class="fal fa-paper-plane"></i> Mail Invoice
               </a>
               @permission('create-creditnote')
                  @if ($checkOpenInvoices >= 1)
                     <a href="#" data-toggle="modal" data-target="#apply-to-invoice" class="btn btn-sm btn-white m-b-10 p-l-5">
                        Apply To Invoice
                     </a>
                  @endif
               @endpermission
               <a href="{!! route('property.invoice.delete',[$property->id,$show->creditnoteID]) !!}" class="btn btn-sm btn-danger delete m-b-10 p-l-5">
                  <i class="fas fa-trash"></i> Delete
               </a>
            </span>
         </div>
      </div>
      <div class="col-md-12">
         <div class="panel panel-inverse">
            <div class="panel-body">
               @include('templates.'.$template.'.creditnote.property.preview')
            </div>
         </div>
      </div>
   </div> 
</div>
@endsection
@include('app.property.partials._creditnote_scripts')
