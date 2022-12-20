<div class="row">
   <div class="col-md-4">
      @if ($lpo->logo != "")
         <img src="{!! asset('businesses/'.$lpo->business_code.'/documents/images/'.$lpo->logo) !!}" class="logo" alt="{!! $lpo->businessName !!}" style="width:70%">
      @endif
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong>{!! $lpo->businessName !!}</strong>
         @if($lpo->street != "")
         <br>{!! $lpo->street !!}<br>
         @endif
         @if($lpo->city != "")
         {!! $lpo->city !!},
         @endif
         @if($lpo->postal_address != "" ) 
         {!! $lpo->postal_address !!}
         @endif
         @if($lpo->postal_address != "" && $lpo->zip_code != "" )
            - {!! $lpo->zip_code !!}
         @endif
         <br>
         <b>Phone:</b> {!! $lpo->primary_phonenumber !!}<br>
         <b>Email:</b> {!! $lpo->primary_email !!}
      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Purchase Order</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong>{!! $supplier->supplierName !!}</strong>
         <span>@if($supplier->bill_state != "")<br>{!! $supplier->bill_state !!},@endif</span>
         <span>@if($supplier->bill_city != "")<br>{!! $supplier->bill_city !!},@endif</span>
         <span>@if($supplier->bill_street != "")<br>{!! $supplier->bill_street !!}<br>@endif</span>
         <span>
            @if($supplier->bill_street != "")
               {!! $supplier->bill_zip_code !!}<br>
            @endif
            @if($supplier->bill_country != "")
               {!! Wingu::country($supplier->bill_country)->name !!}<br>
            @endif
         </span>
         <span><b>Email: </b>@if($supplier->email != ""){!! $supplier->email !!}@endif</span>
      </address> 
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>purchaseorders #</b></th>
               <td>: {!! $lpo->prefix !!}{!! $lpo->number !!}</td>
            </tr>
            @if ($lpo->reference_number != "")
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: {!! $lpo->reference_number !!}</td>
               </tr>
            @endif
            <tr>
               <th><b>Status</b></th>
               <td>
                  @if($lpo->statusID == 1)
                     <span style="color:green;font-style: normal;font-weight: bolder;">: {!! ucfirst($lpo->name) !!}</span>
                  @else
                  <span style="color:blue;font-style: normal;font-weight: bolder;">: {!! ucfirst($lpo->name) !!}</span>
                  @endif
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: {!! date('F j, Y',strtotime($lpo->lpo_date)) !!}</td>
            </tr>
            <tr>
               <th>Expected Delivery Date</th>
               <td>: {!! date('F j, Y',strtotime($lpo->lpo_due)) !!}</td>
            </tr>
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
               {{-- @if($lpo->show_discount_tab == 'Yes')
                  @if($lpo->discount != "") --}}
                     <th>Discount</th>
                  {{-- @endif
               @endif
               @if($lpo->taxconfig != 'Exclusive') 
                  @if($lpo->show_tax_tab == 'Yes') --}}
                     <th>Tax</th>
                  {{-- @endif
               @endif --}}
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
                     {{ number_format($product->selling_price) }} {!! $lpo->code !!}
                  </td>
                  {{-- @if($lpo->show_discount_tab == 'Yes')
                     @if($lpo->discount != "") --}}
                        <td>
                           {!! number_format($product->discount) !!} {!! $lpo->code !!}
                        </td>
                     {{-- @endif
                  @endif
                  @if($lpo->taxconfig != 'Exclusive') 
                     @if($lpo->show_tax_tab == 'Yes') --}}
                        <td>
                           {{ number_format($product->taxrate) }}%
                        </td>
                     {{-- @endif
                  @endif --}}
                  <td>
                     {{ number_format($product->total_amount) }} {!! $lpo->code !!}
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
               <th>Sub Total</th>
               <td><strong>: {!! $lpo->code !!} {!! number_format($lpo->sub_total) !!} <strong></td>
            </tr>
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : {!! $lpo->code !!} {!! number_format($lpo->total) !!} 
                  </strong>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="col-md-12 invbody-terms">
      @if($lpo->customer_note != "")
         <div class="notice">
            <h4><b>Supplier Note</b></h4>
            {!! $lpo->customer_note !!}
         </div>
      @endif
      @if($lpo->terms != "")
         <div class="notice">
               <h4><b>Terms & Conditions</b></h4>
               {!! $lpo->terms !!}
         </div>
      @endif
      <br><br>
      Thank you for your business.
   </div>
</div>