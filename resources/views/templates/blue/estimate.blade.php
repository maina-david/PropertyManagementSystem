<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Estimate | {!! Finance::estimate()->prefix !!}00{!! $details->number !!}</title>
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
               <div class="to">Estimate To:</div>
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
               <h1>ESTIMATE</h1>
               @if($details->status == 13)
                  <a href="#" class="btn btn-success">Accepted</a>
               @endif
               <h3>#{!! Finance::estimate()->prefix !!}00{!! $details->estimate_number !!}</h3>
               <div class="date"><b>Date of Invoice:</b> {!! date('F j, Y',strtotime($details->estimate_date)) !!}</div>
               <div class="date"><b>Due Date:</b> {!! date('F j, Y',strtotime($details->estimate_due)) !!}</div>
            </div>
         </div>
         <table border="0" cellspacing="0" cellpadding="0">
            <thead>
               <tr>
                  <th class="no">#</th>
                  <th class="desc">DESCRIPTION</th>
                  <th class="unit">UNIT PRICE</th>
                  <th class="qty">QUANTITY</th>
                  <th class="total">TOTAL</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($products as $product)
                  <tr>
                     <td class="no">{{ $count++ }}</td>
                     <td class="desc">
                        @if($product->product_id == 0)
                           <h3>{{ $product->product_name }}</h3>
                        @elseif($details->type == "")
                           <p>{{ Finance::parent_category($product->product_id)->title }}</p>
                           <h3>{{ Finance::product($product->product_id)->product_name }}</h3>
                        @endif
                     </td>
                     <td class="unit">{{ number_format($product->price) }} {!! Finance::currency($details->currencyID)->code !!}</td>
                     <td class="qty">{{ $product->quantity }}</td>
                     <td class="total">@php echo number_format($product->quantity * $product->price) @endphp {!! Finance::currency($details->currencyID)->code !!}</td>
                  </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>Sub Total :</strong></td>
                  <td>{!! number_format($details->sub_total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</td>
               </tr>
               @if(Finance::estimate()->show_discount_tab == 'Yes')
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Discount :</strong></td>
                     <td>
                        @php echo $details->sub_total * ($details->discount / 100)  @endphp {!! Finance::currency($details->currencyID)->code !!}
                     </td>
                  </tr>
               @endif
               @if(Finance::estimate()->show_tax_tab == 'Yes')
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Tax - {!! $details->tax !!}% :</strong></td>
                     <td>
                        {!! $taxed !!}  {!! Finance::currency($details->currencyID)->code !!}
                     </td>
                  </tr>
               @endif
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>TOTAL :</strong></td>
                  <td>{!! number_format($details->total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</td>
               </tr>
            </tfoot>
         </table>
         @if($details->estimate_note != "")
            <div class="notice">
               Client Note
               {!! $details->estimate_note !!}
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