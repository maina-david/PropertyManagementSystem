@extends('layouts.app')
{{-- page header --}}
@section('title') Payments | {!! $property->title !!}  @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.payments',$property->id) !!}">Payments</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Show</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  Payments | {!! $property->title !!} </h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12 mt-3">   
            <div class="row">
               <div class="col-md-12 mb-3">
                  {{-- <a href="#" class="btn btn-warning m-b-10 p-l-5"><i class="fal fa-paper-plane"></i> Send Receipt</a> --}}
                  <a href="{!! route('property.payments.edit',[$property->id,$payment->paymentID]) !!}" class="btn btn-primary m-b-10 p-l-5">
                     <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="#" target="_blank" class="btn btn-white m-b-10 p-l-5"><i class="fal fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
                  </a>
                  <a href="#" target="_blank" class="btn btn-white m-b-10 p-l-5">
                     <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
                  </a>
                  <a href="{!! route('property.payments.delete',[$property->id,$payment->paymentID]) !!}" target="_blank" class="delete btn btn-danger m-b-10 p-l-5">
                     <i class="fa fa-trash t-plus-1 fa-fw fa-lg"></i> Delete
                  </a>
               </div>
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <div class="pcs-template-body">
                           <div style="padding-bottom:35px;border-bottom:1px solid #eee;width:100%;">
                              <div class="row">
                                 <div class="col-md-4">
                                    @if($business->logo != "") 
                                       <img src="{!! url('/') !!}/storage/files/business/{!! $business->primary_email !!}/documents/images/{!! $business->logo !!}" class="logo" alt="{!! $business->businessName !!}" style="width:70%">
                                    @endif
                                 </div>
                                 <div class="col-md-4">
                                 </div>
                                 <div class="col-md-4">
                                    <p>
                                       <strong>{!! $property->management_name !!}</strong><br>
                                       @if($property->management_phonenumber != "")
                                          <b>Phone:</b> {!! $property->management_phonenumber !!}<br>
                                       @endif
                                       @if($property->management_email != "")
                                          <b>Email:</b> {!! $property->management_email !!} <br>
                                       @endif
                                       @if($property->management_postaladdress != "")
                                          <b>Postal Address:</b> {!! $property->management_postaladdress !!} 
                                       @endif
                                    </p>
                                 </div>   
                              </div>              
                           </div>                      
                           <div style="padding:35px 0 50px;text-align:center">
                              <span style="border-bottom:1px solid #eee;font-size: 13pt; color: #333333;">PAYMENT RECEIPT</span>
                           </div>                       
                           <div style="width: 70%;float: left;">
                              <div style="width: 100%;padding: 11px 0;">
                                 <div style="width:35%;float:left;" class="pcs-label">Payment Date</div>
                                 <div style="width:65%;border-bottom:1px solid #eee;float:right;">
                                    <b>{!! date('jS F, Y', strtotime($payment->payment_date)) !!}</b>
                                 </div>
                                 <div style="clear:both;"></div>
                              </div>                  
                              <div style="width: 100%;padding: 10px 0;">
                                 <div style="width:35%;float:left;" class="pcs-label">Reference Number</div>
                                 <div style="width:65%;border-bottom:1px solid #eee;float:right;min-height:22px">
                                    <b>{!! $payment->reference_number !!}</b>
                                 </div>
                                 <div style="clear:both;"></div>
                              </div>                  
                              <div style="width: 100%;padding: 11px 0;">
                                 <div style="width:35%;float:left;" class="pcs-label">Payment Mode</div>
                                 <div style="width:65%;border-bottom:1px solid #eee;float:right;">
                                    <b>
                                       @if(Finance::check_payment_method($payment->payment_method) == 1)
                                          {!! Finance::payment_method($payment->payment_method)->name !!}
                                       @else 
                                          Not defined
                                       @endif
                                    </b>
                                 </div>
                                 <div style="clear:both;"></div>
                              </div>
                           </div>                  
                           <div style="text-align:center;color:#ffffff;float:right;background:#b51606;width: 25%; padding: 34px 5px;">
                              <span> Amount Received</span><br>
                              <span  style="font-size: 16pt;color: #ffffff;">
                              {!! $business->code !!} {!! number_format($payment->amount) !!}
                              </span>
                           </div>
                           <div style="clear:both;"></div>
                           <div style="margin-top:50px">
                              <table style="width:100%">
                                 <tbody>
                                 <tr>
                                    <td>
                                       <address>
                                          <strong>{!! $tenant->tenant_name !!}</strong>
                                          <span><br>@if($tenant->bill_state != ""){!! $tenant->bill_state !!},@endif</span>
                                          <span>@if($tenant->bill_city != ""){!! $tenant->bill_city !!},@endif</span>
                                          <span>@if($tenant->bill_street != ""){!! $tenant->bill_street !!}<br>@endif</span>
                                          <span>
                                             @if($tenant->bill_street != "")
                                                {!! $tenant->bill_zip_code !!}<br>
                                             @endif
                                             @if($tenant->bill_country != "")
                                                {!! Wingu::country($tenant->bill_country)->name !!}<br>
                                             @endif
                                          </span>
                                          <span><b>Email: </b>@if($tenant->contact_email != ""){!! $tenant->contact_email !!}@endif</span>
                                       </address>
                                    </td>
                                    <td style="text-align: right;vertical-align:top">
                                    </td>
                                 </tr>
                                 </tbody>
                              </table>
                           </div>
                           <hr>         
                           <div style="margin-top:50px;page-break-inside: avoid;">
                              <h4 class="pcs-payment-details-header" style="margin-bottom:18px;">Payment for</h4>
                              <table style="width:100%;table-layout:fixed;" class="pcs-itemtable" border="0" cellspacing="0" cellpadding="0">
                                 <thead>
                                    <tr style="height:40px;">                       
                                       <td style="padding:5px 10px 5px 10px;word-wrap: break-word;" class="pcs-itemtable-header">
                                       Invoice Number
                                       </td>
                                       <td style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                                          Invoice Date
                                       </td>
                                       <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                                          Invoice Amount
                                       </td>
                                       <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                                          Payment Amount
                                       </td>
                                       <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                                          Amount Due
                                       </td>                     
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr style="border-top:1px solid #ededed">                       
                                       <td valign="top" style="padding: 10px 0px 10px 10px;word-wrap: break-word;" class="pcs-item-row">
                                          <span><a href="#">{!! $payment->invoice_prefix !!}{!! $payment->invoice_number !!}</a></span>
                                       </td>                       
                                       <td valign="top" style="padding: 10px 10px 5px 10px;word-wrap: break-word;" class="pcs-item-row">
                                          {!! date('jS F, Y', strtotime($payment->invoice_date)) !!}
                                       </td>                       
                                       <td valign="top" style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;" class="pcs-item-row">
                                          {!! $business->code !!} {!! number_format($payment->total) !!}
                                       </td>
                                       <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                                          {!! $business->code !!} {!! number_format($payment->amount) !!}
                                       </td>
                                       <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                                          {!! $business->code !!} {!! number_format($payment->paymentBalance) !!}
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection