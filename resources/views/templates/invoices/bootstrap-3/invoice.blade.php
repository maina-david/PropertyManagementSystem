<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Invoice | {!! Finance::invoice_settings()->prefix !!}00{!! $details->number !!}</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! url('/') !!}/resources/views/templates/bootstrap-3/style.css" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style>
</head>
<body class="login-page" style="background: white">
   <div>
      <div class="row">
         <div class="col-xs-7">
            <h4>From:</h4>
            <strong>{!! Limitless::business(Auth::user()->businessID)->name !!}</strong><br>
            {!! Limitless::business(Auth::user()->businessID)->street !!},{!! Limitless::business(Auth::user()->businessID)->city !!}<br>
            {!! Limitless::business(Auth::user()->businessID)->postal_address !!} - {!! Limitless::business(Auth::user()->businessID)->zip_code !!}<br>
            <b>Phone:</b> {!! Limitless::business(Auth::user()->businessID)->primary_phonenumber !!}<br>
            <b>Email:</b> {!! Limitless::business(Auth::user()->businessID)->primary_email !!}
            <br>
         </div>

         <div class="col-xs-4">
            @if (Limitless::business(Auth::user()->businessID)->logo != "")
               <img src="{!! url('/') !!}/storage/files/business/{!! Limitless::business(Auth::user()->businessID)->primary_email !!}/documents/images/{!! Limitless::business(Auth::user()->businessID)->logo !!}" id="image" alt="logo" style="width:20%">
            @endif
         </div>
      </div>
      <div style="margin-bottom: 0px">&nbsp;</div>
      <div class="row">
         <div class="col-xs-6">
            <h4>To:</h4>
            <address>
               <strong>@if($client->company_name != ""){!! $client->company_name !!}@else{!! $client->client_name !!}@endif</strong><br>
               <span>@if($client->company_name != ""){!! $client->company_name !!}@else{!! $client->client_name !!}@endif</span><br>
               <span>@if($client->bill_attention != "")<strong>ATTN :</strong>{!! $client->bill_attention !!}<br>@endif</span><br>
               <span>@if($client->bill_state != ""){!! $client->bill_state !!},@endif</span>
               <span>@if($client->bill_city != ""){!! $client->bill_city !!},@endif</span>
               <span>@if($client->bill_street != ""){!! $client->bill_street !!}@endif</span><br>
               <span>@if($client->bill_street != "")
                  {!! $client->bill_zip_code !!}<br>
                  {!! Limitless::country($client->bill_country)->name !!}
               @endif</span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <th>Status</th>
                     <td class="text-right">
                        @if($details->statusID == 1)
                           <p style="color:green;font-style: normal;font-weight: bolder;">{!! ucfirst(Limitless::status($details->statusID)->name) !!}</p>
                        @else
                        <p style="color:blue;font-style: normal;font-weight: bolder;">{!! ucfirst(Limitless::status($details->statusID)->name) !!}</p>
                        @endif
                     </td>
                  </tr>
                  <tr>
                     <th>Invoice Date</th>
                     <td class="text-right">{!! date('F j, Y',strtotime($details->invoice_date)) !!}</td>
                  </tr>
                  <tr>
                     <th>Due Date</th>
                     <td class="text-right">{!! date('F j, Y',strtotime($details->invoice_due)) !!}</td>
                  </tr>
               </tbody>
            </table>
            <div style="margin-bottom: 0px">&nbsp;</div>
            <table style="width: 100%; margin-bottom: 20px">
               <tbody>
                  <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><div> Amount Due </div></th>
                        <td style="padding: 5px" class="text-right"><strong> {!! number_format($details->total) !!}.00 {!! Finance::currency($details->currencyID)->code !!} </strong></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="40%">Description</th>
               <th align="center">Previous</th>
               <th align="center">Current</th>
               <th align="center">Consumption</th>
               <th align="center">Rate</th>
               <th align="center">Amount</th>
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
                  <td align="center">{!! $product->previous_units !!}</td>
                  <td align="center">{!! $product->current_units !!}</td>
                  <td align="center">{{ $product->quantity }}</td>
                  <td align="center">
                     {{ number_format($product->selling_price) }} {!! Finance::currency($details->currencyID)->code !!}
                  </td>
                  <td align="right">
                     <span class="price">
                        @php echo number_format($product->quantity * $product->selling_price) @endphp {!! Finance::currency($details->currencyID)->code !!}
                     </span>
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
                     <td style="padding: 5px" class="text-right"><strong>{!! number_format($details->sub_total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}<strong></td>
                  </tr>
                  @if(Finance::invoice_settings()->show_discount_tab == 'Yes')
                     <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><strong>Discount </strong></th>
                        <td style="padding: 5px" class="text-right">
                           <strong>
                              @php echo $details->sub_total * ($details->discount / 100)  @endphp {!! Finance::currency($details->currencyID)->code !!}
                           </strong>
                        </td>
                     </tr>
                  @endif
                  @if(Finance::invoice_settings()->show_tax_tab == 'Yes')
                     <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><strong>Tax - {!! $details->tax !!}%</strong></th>
                        <td style="padding: 5px" class="text-right">
                           <strong>
                              {!! $taxed !!}  {!! Finance::currency($details->currencyID)->code !!}
                           </strong>
                        </td>
                     </tr>
                  @endif
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL </strong></th>
                     <td style="padding: 5px" class="text-right">
                        <strong>
                           {!! number_format($details->total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}
                        </strong>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-8 invbody-terms">
            Thank you for your business. 
            <br><br>
            @if($details->customer_note != "")
               <div class="notice">
                  {!! $details->customer_note !!}
               </div>
            @endif
            @if($details->terms != "")
               <div class="notice">
                  <h4>Terms & Conditions</h4>
                  {!! $details->terms !!}
               </div>
            @endif
         </div>
      </div>
   </div>

</body>
</html>