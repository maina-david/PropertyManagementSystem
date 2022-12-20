<div class="row">
   <div class="col-md-4">
      @if ($quote->logo != "")
         <img src="{!! asset('businesses/'.$quote->business_code.'/documents/images/'.$quote->logo) !!}" class="logo" alt="{!! $quote->businessName !!}" style="width:70%">
      @endif
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong>{!! $quote->businessName !!}</strong>
         @if($quote->street != "")
         <br>{!! $quote->street !!}<br>
         @endif
         @if($quote->city != "")
         {!! $quote->city !!},
         @endif
         @if($quote->postal_address != "" )
         {!! $quote->postal_address !!}
         @endif
         @if($quote->postal_address != "" && $quote->zip_code != "" )
            - {!! $quote->zip_code !!}
         @endif
         <br>
         <b>Phone:</b> {!! $quote->primary_phonenumber !!}<br>
         <b>Email:</b> {!! $quote->primary_email !!}
      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3 mt-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Quotes</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong>{!! $customer->customer_name !!}</strong>
         <span><br>@if($customer->bill_state != ""){!! $customer->bill_state !!},@endif</span>
         <span>@if($customer->bill_city != ""){!! $customer->bill_city !!},@endif</span>
         <span>@if($customer->bill_street != ""){!! $customer->bill_street !!}<br>@endif</span>
         <span>
            @if($customer->bill_street != "")
               {!! $customer->bill_zip_code !!}<br>
            @endif
            @if($customer->bill_country != "")
               {!! Wingu::country($customer->bill_country)->name !!}<br>
            @endif
         </span>
         <span><b>Email: </b>@if($customer->email != ""){!! $customer->email !!}@endif</span>
      </address>
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>Quotes Number</b></th>
               <td>: {!! $quote->prefix !!}{!! $quote->number !!}</td>
            </tr>
            @if ($quote->reference_number != "")
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: {!! $quote->reference_number !!}</td>
               </tr>
            @endif
            <tr>
               <th>Status</th>
               <td class="text-right">
                  @if($quote->statusID == 1)
                     <p style="color:green;font-style: normal;font-weight: bolder;">{!! ucfirst($quote->name) !!}</p>
                  @else
                  <p style="color:blue;font-style: normal;font-weight: bolder;">{!! ucfirst($quote->name) !!}</p>
                  @endif
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: {!! date('F j, Y',strtotime($quote->quote_date)) !!}</td>
            </tr>
            <tr>
               <th>Closing Date</th>
               <td>: {!! date('F j, Y',strtotime($quote->quote_due)) !!}</td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="col-md-12">
   <h2>{!! $quote->subject !!}</h2>
   </div>
   <div class="col-md-12">
   {!! $quote->description !!}
   </div>
</div>
<table class="table table-striped table-bordered mt-3">
   <thead>
      <tr>
         <th width="1%">#</th>
         <th width="30%">Item</th>
         <th>Quantity</th>
         <th>Price</th>
         @if($quote->show_discount_tab == 'Yes')
            @if($quote->discount != "")
               <th>Discount({!! $quote->symbol !!})</th>
            @endif
         @endif
         @if($quote->taxconfig != 'Exclusive') 
            @if($quote->show_tax_tab == 'Yes')
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
               {!! $quote->symbol !!}{{ number_format($product->price,2) }} 
            </td>
            @if($quote->show_discount_tab == 'Yes')
               @if($quote->discount != "")
                  <td>
                     {!! $quote->symbol !!}{!! number_format($product->discount,2) !!} 
                  </td>
               @endif
            @endif
            @if($quote->taxconfig != 'Exclusive') 
               @if($quote->show_tax_tab == 'Yes')
                  <td>
                     {{ number_format($product->taxrate) }}%
                  </td>
               @endif
            @endif
            <td>
               {!! $quote->symbol !!}{{ number_format($product->total_amount,2) }} 
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
               <td><strong>: {!! $quote->symbol !!}{!! number_format($quote->main_amount,2) !!} <strong></td>
            </tr>
            @if($quote->show_discount_tab == 'Yes')
               @if($quote->discount != "")
                  <tr>
                     <th>Discount</th>
                     <td><strong>: {!! $quote->symbol !!}{!! number_format($quote->discount,2) !!} <strong></td>
                  </tr>
               @endif
            @endif
            <tr>
               <th>Sub Total</th>
               <td><strong>: {!! $quote->symbol !!}{!! number_format($quote->sub_total,2) !!} <strong></td>
            </tr>
            @if($quote->taxconfig != 'Exclusive') 
               @if($quote->show_tax_tab == 'Yes')
                  <tr>
                     <th><strong>Tax</strong></th>
                     <td>
                        <strong>
                           : {!! $quote->symbol !!}{!! number_format($quote->taxvalue,2) !!}  
                        </strong>
                     </td>
                  </tr>
               @endif
            @endif
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : {!! $quote->symbol !!}{!! number_format($quote->total,2) !!} 
                  </strong>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>

<div class="row">
   <div class="col-md-12 invbody-terms">
      Thank you for your business.
      <br><br>
      @if($quote->customer_note != "")
      <div class="notice">
         <h4><b>Customer Note</b></h4>
         {!! $quote->customer_note !!}
      </div>
      @endif
      @if($quote->terms != "")
         <div class="notice">
            <h4><b>Terms & Conditions</b></h4>
            {!! $quote->terms !!}
         </div>
      @endif
   </div>
</div>