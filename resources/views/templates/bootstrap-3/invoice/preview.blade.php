<div class="row">
   <div class="col-md-4">
      @if ($invoice->logo != "")
         <img src="{!! asset('businesses/'.$invoice->business_code.'/documents/images/'.$invoice->logo) !!}" class="logo" alt="{!! $invoice->businessName !!}" style="width:70%">
      @endif
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong>{!! $invoice->businessName !!}</strong>
         @if($invoice->street != "")
         <br>{!! $invoice->street !!}<br>
         @endif
         @if($invoice->city != "")
         {!! $invoice->city !!},
         @endif
         @if($invoice->postal_address != "" )
         {!! $invoice->postal_address !!}
         @endif
         @if($invoice->postal_address != "" && $invoice->zip_code != "" )
            - {!! $invoice->zip_code !!}
         @endif
         <br>
         <b>Phone:</b> {!! $invoice->primary_phonenumber !!}<br>
         <b>Email:</b> {!! $invoice->primary_email !!}
      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Invoice</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong>{!! $client->customer_name !!}</strong>
         <span><br>@if($client->bill_state != ""){!! $client->bill_state !!},@endif</span>
         <span>@if($client->bill_city != ""){!! $client->bill_city !!},@endif</span>
         <span>@if($client->bill_street != ""){!! $client->bill_street !!}<br>@endif</span>
         <span>
            @if($client->bill_street != "")
               {!! $client->bill_zip_code !!}<br>
            @endif
            @if($client->bill_country != "")
               {!! Wingu::country($client->bill_country)->name !!}<br>
            @endif
         </span>
         <span><b>Email: </b>@if($client->email != ""){!! $client->email !!}@endif</span>
      </address>
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>Invoice Number</b></th>
               <td>: {!! $invoice->prefix !!}{!! $invoice->number !!}</td>
            </tr>
            @if ($invoice->reference_number != "")
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: {!! $invoice->reference_number !!}</td>
               </tr>
            @endif
            <tr>
               <th><b>Status</b></th>
               <td>
                  @if($invoice->statusID == 1)
                     <span style="color:green;font-style: normal;font-weight: bolder;">: {!! ucfirst($invoice->name) !!}</span>
                  @else
                  <span style="color:blue;font-style: normal;font-weight: bolder;">: {!! ucfirst($invoice->name) !!}</span>
                  @endif
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
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
                     <td><span class="text-right">: {!! $invoice->symbol !!}{!! number_format($invoice->balance,2) !!} </span></td>
                  </tr>
               @elseif($invoice->invoiceStatusID == 2)
                  <tr>
                     <th>Amount Due </th>
                     <td><span class="text-right">: {!! $invoice->symbol !!}{!! number_format($invoice->total,2) !!} </span></td>
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
         <th>Quantity</th>
         <th>Price</th>
         @if($invoice->show_discount_tab == 'Yes')
            @if($invoice->discount != "")
               <th>Discount({!! $invoice->symbol !!})</th>
            @endif
         @endif
         @if($invoice->taxconfig != 'Exclusive') 
            @if($invoice->show_tax_tab == 'Yes')
               <th>Tax</th>
            @endif
         @endif
         <th>Total</th>
      </tr>
   </thead>
   <tbody>
      @foreach ($products as $product)
         <tr class="item-row">
            <td align="center">{{ $count++ }}</td>
            <td class="description">
               @if($product->productID == 0)
                  {{ $product->product_name }}
               @else
                  @if(Finance::check_product($product->productID) == 1 )
                     {!! Finance::product($product->productID)->product_name !!}
                  @else
                     <i>Unknown Product</i>
                  @endif
               @endif
            </td>
            <td>{{ $product->quantity }}</td>
            <td>
               {!! $invoice->symbol !!}{{ number_format($product->selling_price,2) }} 
            </td>
            @if($invoice->show_discount_tab == 'Yes')
               @if($invoice->discount != "")
                  <td>
                     {!! $invoice->symbol !!}{!! number_format($product->discount,2) !!} 
                  </td>
               @endif
            @endif
            @if($invoice->taxconfig != 'Exclusive') 
               @if($invoice->show_tax_tab == 'Yes')
                  <td>
                     {{ number_format($product->taxrate) }}%
                  </td>
               @endif
            @endif
            <td>
               {!! $invoice->symbol !!}{{ number_format($product->total_amount,2) }} 
            </td>
         </tr>
      @endforeach
   </tbody>
</table>
<div class="row">
   <div class="col-md-6"></div>
   <div class="col-md-6">
      <table class="table table-striped">
         <tbody>
            <tr>
               <th>Amount</th>
               <td><strong>{!! $invoice->symbol !!}{!! number_format($invoice->main_amount,2) !!}<strong></td>
            </tr>
            @if($invoice->show_discount_tab == 'Yes')
               @if($invoice->discount != "")
                  <tr>
                     <th>Discount</th>
                     <td><strong>: {!! $invoice->symbol !!}{!! number_format($invoice->discount,2) !!}<strong></td>
                  </tr>
               @endif
            @endif
            <tr>
               <th>Sub Total</th>
               <td><strong>: {!! $invoice->symbol !!}{!! number_format($invoice->sub_total,2) !!}<strong></td>
            </tr>
            @if($invoice->taxconfig != 'Exclusive') 
               @if($invoice->show_tax_tab == 'Yes')
                  <tr>
                     <th><strong>Tax</strong></th>
                     <td>
                        <strong>
                           : {!! $invoice->symbol !!}{!! number_format($invoice->taxvalue,2) !!}  
                        </strong>
                     </td>
                  </tr>
               @endif
            @endif
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : {!! $invoice->symbol !!}{!! number_format($invoice->total,2) !!} 
                  </strong>
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
                  <td>
                     {!! $payment->reference_number !!}
                     @if($payment->credited == 'yes') 
                        Credited
                     @endif
                  </td>
                  <td>
                     @if($payment->payment_method != "")
                        @if(Finance::check_default_payment_method($payment->payment_method) == 1)
                           {!! Finance::default_payment_method($payment->payment_method)->name !!}
                        @else 
                           @if(Finance::check_payment_method($payment->payment_method) == 1)
                              {!! Finance::payment_method($payment->payment_method)->name !!}
                           @endif
                        @endif
                     @endif
                     @if($payment->credited == 'yes') 
                        Credited
                     @endif
                  </td>
                  <td>{!! date('M d, Y', strtotime($payment->payment_date)) !!}</td>
                  <td>{!! $invoice->symbol !!}{!! number_format($payment->amount,2) !!} </td> 
                  <td>
                     @if($payment->balance < 0)

                     @else
                        {!! $invoice->symbol !!}{!! number_format($payment->balance,2) !!} 
                     @endif
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