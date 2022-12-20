<div class="row">
   <div class="col-md-4">
      @if($salesorder->logo != "")
         <img src="{!! url('/') !!}/public/businesses/{!! $salesorder->business_code !!}/documents/images/{!! $salesorder->logo !!}" class="logo" alt="{!! $salesorder->businessName !!}" style="width:70%">
      @endif
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong>{!! $salesorder->businessName !!}</strong>
         @if($salesorder->street != "")
         <br>{!! $salesorder->street !!}<br>
         @endif
         @if($salesorder->city != "")
         {!! $salesorder->city !!},
         @endif
         @if($salesorder->postal_address != "" )
         {!! $salesorder->postal_address !!}
         @endif
         @if($salesorder->postal_address != "" && $salesorder->zip_code != "" )
            - {!! $salesorder->zip_code !!}
         @endif
         <br>
         <b>Phone:</b> {!! $salesorder->primary_phonenumber !!}<br>
         <b>Email:</b> {!! $salesorder->primary_email !!}
      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Sales Order</h3>
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
               <th><b>Sales Order#</b></th>
               <td>: {!! $salesorder->prefix !!}{!! $salesorder->number !!}</td>
            </tr>
            @if ($salesorder->reference_number != "")
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: {!! $salesorder->reference_number !!}</td>
               </tr>
            @endif
            <tr>
               <th><b>Status</b></th>
               <td>
                  @if($salesorder->statusID == 1)
                     <span style="color:green;font-style: normal;font-weight: bolder;">: {!! ucfirst($salesorder->name) !!}</span>
                  @else
                  <span style="color:blue;font-style: normal;font-weight: bolder;">: {!! ucfirst($salesorder->name) !!}</span>
                  @endif
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: {!! date('F j, Y',strtotime($salesorder->salesorder_date)) !!}</td>
            </tr>
            <tr>
               <th>Due Date</th>
               <td>: {!! date('F j, Y',strtotime($salesorder->salesorder_due_date)) !!}</td>
            </tr>
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
         @if($salesorder->show_discount_tab == 'Yes')
            @if($salesorder->discount != "")
               <th>Discount({!! $salesorder->symbol !!})</th>
            @endif
         @endif
         @if($salesorder->taxconfig != 'Exclusive') 
            @if($salesorder->show_tax_tab == 'Yes')
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
               {!! $salesorder->code !!} {{ number_format($product->selling_price) }} 
            </td>
            @if($salesorder->show_discount_tab == 'Yes')
               @if($salesorder->discount != "")
                  <td>
                     {!! number_format($product->discount) !!} {!! $salesorder->code !!}
                  </td>
               @endif
            @endif
            @if($salesorder->taxconfig != 'Exclusive') 
               @if($salesorder->show_tax_tab == 'Yes')
                  <td>
                     {{ number_format($product->taxrate) }}%
                  </td>
               @endif
            @endif
            <td>
               {!! $salesorder->code !!} {{ number_format($product->total_amount) }}
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
               <td><strong>{!! $salesorder->code !!} {!! number_format($salesorder->main_amount) !!}<strong></td>
            </tr>
            @if($salesorder->show_discount_tab == 'Yes')
               @if($salesorder->discount != "")
                  <tr>
                     <th>Discount</th>
                     <td><strong>: {!! $salesorder->code !!} {!! number_format($salesorder->discount) !!}<strong></td>
                  </tr>
               @endif
            @endif
            <tr>
               <th>Sub Total</th>
               <td><strong>: {!! $salesorder->code !!} {!! number_format($salesorder->sub_total) !!}<strong></td>
            </tr>
            @if($salesorder->taxconfig != 'Exclusive') 
               @if($salesorder->show_tax_tab == 'Yes')
                  <tr>
                     <th><strong>Tax</strong></th>
                     <td>
                        <strong>
                           : {!! $salesorder->code !!} {!! number_format($salesorder->taxvalue) !!}  
                        </strong>
                     </td>
                  </tr>
               @endif
            @endif
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : {!! $salesorder->code !!} {!! number_format($salesorder->total) !!}
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
      @if($salesorder->customer_note != "")
      <div class="notice">
         <h4><b>Customer Note</b></h4>
         {!! $salesorder->customer_note !!}
      </div>
      @endif
      @if($salesorder->terms_conditions != "")
         <div class="notice">
            <h4><b>Terms & Conditions</b></h4>
            {!! $salesorder->terms_conditions !!}
         </div>
      @endif
   </div>
</div>