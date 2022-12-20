@extends('layouts.app')
@section('title') {!! $property->title !!} | Invoice Details @endsection
{{-- page styles --}}
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Billing</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Invoices</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Billing | Invoices</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12"> 
            <div class="row mb-3">
               <span class="col-md-12">
                  @permission('update-invoice')
                     <a href="{!! route('property.invoice.edit',[$propertyID,$invoiceID]) !!}" class="btn btn-sm btn-primary m-b-10 p-l-5">
                        <i class="fas fa-edit"></i> Edit
                     </a>
                  @endpermission 
                  @permission('read-invoice')
                     <a href="{!! route('property.invoice.print',[$propertyID,$invoice->invoiceID]) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                        <i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
                     </a>
                  @endpermission
                  @permission('read-invoice')
                     <a href="{!! route('property.invoice.print',[$propertyID,$invoice->invoiceID]) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                        <i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
                     </a>
                  @endpermission
                  <a href="#" class="btn btn-sm btn-warning m-b-10 p-l-5">
                     <i class="fal fa-paper-plane"></i> Mail Invoice
                  </a>
                  {{-- <a href="#" class="btn btn-sm btn-warning m-b-10 p-l-5">
                     <i class="fal fa-sms"></i> SMS Invoice
                  </a> --}}
                  @if($invoice->statusID != 1)
                     @permission('create-invoice')
                        <a href="#" class="btn btn-success btn-sm m-b-10 p-l-5" data-toggle="modal" data-target="#payment"><i class="fa fa-plus"></i> Add Payments</a>
                     @endpermission
                  @endif
                  <a href="{!! route('property.invoice.delete',[$propertyID,$invoiceID]) !!}" class="btn btn-sm btn-danger delete m-b-10 p-l-5">
                     <i class="fas fa-trash"></i> Delete
                  </a>
               </span>
            </div>
            <div class="panel">
               <div class="panel-body">         
                  @include('templates.'.$business->template_name.'.invoice.property.preview')
               </div>
            </div>
         </div>
         {{-- Invoice payment --}}
         <form action="{!! route('property.invoice.payment',[$propertyID,$invoiceID]) !!}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="modal fade" id="payment">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title">Record Payment for {!! $invoice->invoice_prefix !!}{!! $invoice->invoice_number !!}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
                        <div class="row">
                           {{-- <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 <label for="amount" class="control-label"> Choose deposit account </label>
                                 {!! Form::select('accountID', $accounts, null, array('class' => 'form-control')) !!}
                              </div>
                           </div> --}}
                           {{-- <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 <label for="amount" class="control-label"> Update Bank and cash </label>
                                 {!! Form::select('update',['No'=>'No'], null, array('class' => 'form-control')) !!}
                              </div>
                           </div> --}}
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <label for="amount" class="control-label text-danger"> Amount Received </label>
                                 <input type="text" value="{!! $invoice->balance !!}" name="amount" class="form-control" placeholder="Enter amount" required>
                                 <input type="hidden" name="tenantID" value="{!! $tenant->tenantID !!}" required>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 <label for="transactionID" class="control-label"> Transaction ID </label>
                                 {!! Form::text('transactionID', null, array('class' => 'form-control','placeholder' => 'Enter Transaction NO')) !!}
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group required">
                                 <label class="control-label"> Payment Date </label>
                                 <div class="input-group">
                                    <input type="date" name="payment_date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 <label for="amount" class="control-label"> Payment method </label>
                                 <select name="payment_method" class="form-control multiselect">
                                    <option value="">Choose payment method</option>
                                    @foreach($mainMethods as $main)
                                       <option value="{!! $main->id !!}">{!! $main->name !!}</option>
                                    @endforeach
                                    @foreach($paymentmethod as $method)
                                       <option value="{!! $method->id !!}">{!! $method->name !!}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-gruoup">
                                 <label for="note" class="control-label">Leave a note</label>
                                 {!! Form::textarea('note', null, array('class' => 'form-control', 'placeholder' => 'Add Note', 'spellcheck' => 'true', 'size' => '5x5')) !!}
                              </div>
                           </div>
                           {{-- <div class="col-md-12 mt-3">
                              <div class="form-group mt-2">
                                 <input type="checkbox" name="send_email" value="yes">
                                 <label>Send payment acknowledgment message to client </label>
                              </div>
                           </div> --}}
                        </div>
                        <div class="row">

                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Save</button>
                        <img src="{!! url('/') !!}/public/backend/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
@endsection