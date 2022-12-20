<div class="col-md-12">
   <div class="row">
      <div class="col-md-4">
         <img src="{!! asset('businesses/'.$business->businessID.'/documents/images/'.$business->logo) !!}" class="logo" alt="{!! $business->businessName !!}" style="width:80%">
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
   <div class="row">
      <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
         <h3 style="text-align: center">Utility Bill</h3>
      </div>               
   </div>
   <div class="row">
      <div class="col-md-4">
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
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <table style="float:left">
            <tbody>
               <tr>
                  <th>Utility Name/No </th>
                  <td>: {!! $invoice->utility_No !!}</td>
               </tr>
               <tr>
                  <th>Bill Number</th>
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
               @if($invoice->invoiceStatusID != 1)
                  @if($invoice->invoiceStatusID == 3)
                     <tr>
                        <th>Balance</th>
                        <td><span class="text-right">: {!! $business->code !!} {!! number_format($invoice->invoice_balance) !!} </span></td>
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
   <table class="table table-striped table-bordered mt-3">
      <thead>
         <tr>
            <th width="1%">#</th>
            <th width="30%">Item</th>
            <th>Prev Reading</th>
            <th>Current Reading</th>
            <th>Consumption</th>
            <th>Rate</th>
            <th>Total</th>
         </tr>
      </thead>
      <tbody>
         <tr class="item-row">
            <td align="center">{{ $count++ }}</td>
            <td class="description">
               {{ $product->item_name }}
            </td>
            <td>{{ $product->previous_units }}</td>
            <td>{{ $product->current_units }}</td>
            <td>{{ $product->quantity }}</td>
            <td>
               {!! $business->code !!} {{ number_format($product->price) }}
            </td>  
            <td>
               {!! $business->code !!} {{ number_format($product->total_amount) }} 
            </td>
         </tr>  
         @if($invoice->amount_paid != "" || $invoice->amount_paid != 0)
            @if($balance != 0)
               <tr>
                  <td></td>
                  <td colspan="5">Account Arrears</td>
                  <td>{!! $business->code !!} {!! number_format($balance) !!}</td>
               </tr>
            @endif
         @endif
      </tbody>
   </table>
   <div class="row">
      <div class="col-md-6"></div>
      <div class="col-md-6">
         <table class="table table-striped">
            <tbody> 
               <tr>
                  <th>Total Amount</th>
                  <td>
                     <strong>: {!! $business->code !!} @if($balance != 0) {!! number_format($balance) !!} @else {!! number_format($invoice->total) !!} @endif</strong>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
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
                     <td>{!! $business->code !!} {!! number_format($payment->amount) !!} </td>
                     <td>
                        {!! $business->code !!} {!! number_format($payment->balance) !!} 
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12 invbody-terms">
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