<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Invoice | {!! $invoice->invoice_prefix !!}{!! $invoice->invoice_number !!}</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! asset('assets/themes/bootstrap-3/style.css') !!}" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style>
</head>
<body class="login-page" style="background: white">
   <div>
      <div class="row">        
         <div class="col-xs-4">
            @if($business->logo != "")
               <img src="{!! asset('businesses/'.$business->businessID.'/documents/images/'.$business->logo) !!}" class="logo" alt="{!! $business->businessName !!}">
            @endif
         </div>
         <div class="col-xs-2"></div>
         <div class="col-xs-6">
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
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 mt-3 mb-3" style="border: 1px solid #ccc!important;font-family: inherit !important">
            <h3 style="text-align: center;font-family: inherit !important">Invoice</h3>
         </div>               
      </div>
      <br>
      <div class="row">
         <div class="col-xs-6">
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
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <th>Invoice Number</th>
                     <td>: {!! $invoice->invoice_prefix !!}{!! $invoice->invoice_number !!}</td>
                  </tr>
                  <tr>
                     <th>Status :</th>
                     <td>
                        @if($invoice->statusID == 1)
                           <span style="color:green;font-style: normal;font-weight: bolder;">: {!! ucfirst($invoice->name) !!}</span>
                        @else
                        <span style="color:blue;font-style: normal;font-weight: bolder;">: {!! ucfirst($invoice->name) !!}</span>
                        @endif
                     </td>
                  </tr>
                  <tr>
                     <th>Issue Date</th>
                     <td>: {!! date('F j, Y',strtotime($invoice->invoice_date)) !!}</td>
                  </tr>
                  <tr>
                     <th>Due Date</th>
                     <td>: {!! date('F j, Y',strtotime($invoice->invoice_due)) !!}</td>
                  </tr>
                  @if($invoice->invoiceStatusID != 1)
                     @if($invoice->invoiceStatusID == 3)
                        <tr>
                           <th>Balance</th>
                           <td><span class="text-right">: {!! $business->code !!} {!! number_format($invoice->balance) !!} </span></td>
                        </tr>
                     @elseif($invoice->invoiceStatusID == 2)
                        <tr>
                           <th>Amount Due </th>
                           <td><span class="text-right">: {!! $business->code !!} {!! number_format($invoice->total) !!} </span></td>
                        </tr>
                     @endif
                  @endif
               </tbody>
            </table>
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="30%">Item</th>
               <th>Quantity</th>
               <th>Price</th>
               @if($invoice->taxvalue != "")  
                  <th>Tax</th>
               @endif
               <th>Total</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($products as $product)
               <tr class="item-row">
                  <td align="center">{{ $count++ }}</td>
                  <td class="description">
                     {{ $product->item_name }}
                  </td>
                  <td>{{ $product->quantity }}</td>
                  <td>
                     {!! $business->code !!} {{ number_format($product->price) }}
                  </td>       
                  @if($invoice->taxvalue != "")        
                     <td>
                        {{ number_format($product->taxrate) }}%
                     </td>
                  @endif
                  <td>
                     {!! $business->code !!} {{ number_format($product->total_amount) }} 
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
      <div class="row">
         <div class="col-xs-6"></div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><div>Sub Total </div></th>
                     <td style="padding: 5px" class="text-right"><strong>: {!! $business->code !!} {!! number_format($invoice->sub_total) !!} <strong></td>
                  </tr>
                  @if($invoice->taxvalue != "")  
                     <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><strong>Tax</strong></th>
                        <td style="padding: 5px" class="text-right">
                           <strong>
                              : {!! $business->code !!} {!! number_format($invoice->taxvalue) !!}  
                           </strong>
                        </td>
                     </tr>
                  @endif
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL </strong></th>
                     <td style="padding: 5px" class="text-right">
                        <strong>
                           : {!! $business->code !!} {!! number_format($invoice->total) !!} 
                        </strong>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      @if($invoice->statusID == 3)
         <div style="margin-bottom: 0px !important">&nbsp;</div>
         <div class="row">
            <div class="col-md-12">
               <h4>Transactions</h4>
               <table class="table table-striped table-bordered">
                  <tr>
                        <th width="20%">Transaction #</th>
                        <th>Mode of payment</th>
                        <th>Date paid</th>
                        <th>Amount paid</th>
                        <th>Balance</th>
                  </tr>
                  <tbody>
                        @foreach ($payments as $payment)
                           <tr>
                              <td>{!! $payment->reference_number !!}</td>
                              <td>
                                 @if($payment->payment_method != "")
                                    {!! Finance::payment_method($payment->payment_method)->name !!}
                                 @endif
                              </td>
                              <td>{!! date('M d, Y', strtotime($payment->payment_date)) !!}</td>
                              <td>{!! number_format($payment->amount) !!} {!! $business->code !!}</td>
                              <td>
                                 @if($payment->balance < 0)
                                    {!! $business->code !!} 0 
                                 @else
                                    {!! $business->code !!} {!! number_format($payment->balance) !!} 
                                 @endif
                              </td>
                           </tr>
                        @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      @endif
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-12 invbody-terms">
            Thank you for your business.
            <br><br>
            @if($invoice->customer_note != "")
               <div class="notice">
                  <h4><b>Customer Note</b></h4>
                  {!! $invoice->customer_note !!}
               </div>
            @endif
            @if($invoice->terms != "")
               <div class="notice">
                  <h4><b>Terms & Conditions</b></h4>
                  {!! $invoice->terms !!}
               </div>
            @endif
         </div>
      </div>
   </div>
</body>
</html>
