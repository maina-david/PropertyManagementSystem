<div class="row">
   <div class="col-md-4">
      @if ($show->logo != "")
         <img src="{!! asset('businesses/'.$show->business_code.'/documents/images/'.$show->logo) !!}" class="logo" alt="{!! $show->businessName !!}" style="width:70%">
      @endif
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong>{!! $show->businessName !!}</strong>
         @if($show->street != "")
         <br>{!! $show->street !!}<br>
         @endif
         @if($show->city != "")
         {!! $show->city !!},
         @endif
         @if($show->postal_address != "" )
         {!! $show->postal_address !!}
         @endif
         @if($show->postal_address != "" && $show->zip_code != "" )
            - {!! $show->zip_code !!}
         @endif
         <br>
         <b>Phone:</b> {!! $show->primary_phonenumber !!}<br>
         <b>Email:</b> {!! $show->primary_email !!}
      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Credit Note</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong>{!! $show->customer_name !!}</strong>
         <span><br>@if($show->bill_state != ""){!! $show->bill_state !!},@endif</span>
         <span>@if($show->bill_city != ""){!! $show->bill_city !!},@endif</span>
         <span>@if($show->bill_street != ""){!! $show->bill_street !!}<br>@endif</span>
         <span>
            @if($show->bill_street != "")
               {!! $show->bill_zip_code !!}<br>
            @endif
            @if($show->bill_country != "")
               {!! Wingu::country($show->bill_country)->name !!}<br>
            @endif
         </span>
         <span><b>Email: </b>@if($show->email != ""){!! $show->email !!}@endif</span>
      </address>
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>Credit Note Number</b></th>
               <td>: {!! $show->prefix !!}{!! $show->creditnote_number !!}</td>
            </tr>
            @if ($show->reference_number != "")
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: {!! $show->reference_number !!}</td>
               </tr>
            @endif
            <tr>
               <th><b>Status</b></th>
               <td>
                  @if($show->statusID == 1)
                     <span style="color:green;font-style: normal;font-weight: bolder;">: {!! ucfirst($show->name) !!}</span>
                  @else
                     <span style="color:blue;font-style: normal;font-weight: bolder;">: {!! ucfirst($show->name) !!}</span>
                  @endif
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: {!! date('F j, Y',strtotime($show->creditnote_date)) !!}</td>
            </tr>
            <tr>
               <th><b>Balance :</b></th>
               <td>: {!! $show->balance !!} {!! $show->code !!}</td>
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
               {{ number_format($product->price) }} {!! $show->code !!}
            </td>
            <td>
               {{ number_format($product->price * $product->quantity) }} {!! $show->code !!}
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
               <td><strong>: {!! number_format($show->sub_total) !!} {!! $show->code !!}<strong></td>
            </tr>
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : {!! number_format($show->total) !!} {!! $show->code !!}
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
      @if($show->customer_note != "")
      <div class="notice">
         <h4><b>Customer Note</b></h4>
         {!! $show->customer_note !!}
      </div>
      @endif
      @if($show->terms != "")
         <div class="notice">
            <h4><b>Terms & Conditions</b></h4>
            {!! $show->terms !!}
         </div>
      @endif
   </div>
</div>