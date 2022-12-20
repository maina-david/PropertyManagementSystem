<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Delivery note </title>
      <link rel="stylesheet" href="{!! url('/') !!}/resources/views/templates/invoices/blue/style.css" media="all" />
   </head>
   <body>
      <header class="clearfix">
         <div id="logo">
            @if (Limitless::business(Auth::user()->businessID)->logo != "")
               <img src="{!! url('/') !!}/storage/files/business/{!! Limitless::business(Auth::user()->businessID)->primary_email !!}/documents/images/{!! Limitless::business(Auth::user()->businessID)->logo !!}">
            @endif
         </div>
         <div id="company">
            <h2 class="name">{!! Limitless::business(Auth::user()->businessID)->name !!}</h2>
            <div>{!! Limitless::business(Auth::user()->businessID)->street !!},{!! Limitless::business(Auth::user()->businessID)->city !!}</div>
            <div>{!! Limitless::business(Auth::user()->businessID)->postal_address !!} - {!! Limitless::business(Auth::user()->businessID)->zip_code !!}</div>
            <div>Phone: {!! Limitless::business(Auth::user()->businessID)->primary_phonenumber !!}</div>
            <div>Email: {!! Limitless::business(Auth::user()->businessID)->primary_email !!}</div>
         </div>
      </header>
      <main>
         <div id="details" class="clearfix">
            <div id="client">
               <div class="to">TO:</div>
               <h2 class="name">@if($client->company_name != ""){!! $client->company_name !!}@else{!! $client->client_name !!}@endif</h2>
               <div class="address">
                  @if($client->bill_attention != "")
                     <strong>ATTN :</strong>
                     {!! $client->bill_attention !!}<br>
                  @endif
                  @if($client->bill_state != ""){!! $client->bill_state !!},@endif
                  @if($client->bill_city != ""){!! $client->bill_city !!},@endif
                  @if($client->bill_street != ""){!! $client->bill_street !!}@endif
                  <br>
                  @if($client->bill_street != "")
                     {!! $client->bill_zip_code !!}<br>
                     {!! Limitless::country($client->bill_country)->name !!}
                  @endif
               </div>
               <div class="email"><a href="mailto:{!! $client->email !!}">{!! $client->email !!}</a></div>
            </div>
            <div id="invoice">
               <h1>Delivery note</h1>
               <div class="date"><b>Delivery Note #:</b> 00{!! $details->invoice_number !!}</div>
               <div class="date"><b>Delivery Note Date :</b> {!! date('F j, Y',strtotime($details->invoice_date)) !!}</div>
               <div class="date"><b>Order Number :</b> {!! $details->lpo_number !!}</div>
            </div>
         </div>
         <table border="0" cellspacing="0" cellpadding="0">
            <thead>
               <tr>
                  <th class="desc">QUANTITY</th>
                  <th class="desc">DESCRIPTION</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($products as $product)
                  <tr>
                     <td class="desc">{{ $product->quantity }}</td>
                     <td class="desc">

                        @if($product->productID == 0)
                           {{ $product->product_name }}
                        @else
                           @if(Finance::check_product($product->productID) == 1 )
                              <strong>{!! Finance::product($product->productID)->product_name !!}</strong>
                           @else
                              <i>Unknown Product</i>
                           @endif
                        @endif
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
         @if($details->invoice_note != "")
            <div class="notice">
               Client Note
               {!! $details->invoice_note !!}
            </div>
         @endif
         @if($details->terms != "")
            <div class="notice">
               <h4>Terms & Conditions</h4>
               {!! $details->terms !!}
            </div>
         @endif
         <div id="thanks">Thank you!</div>
         <center><button class='btn btn-pink no-print'  onClick="window.print();">Click Here to Print or save as print-to-PDF</button></center>
      </main>
   </body>
</html>
