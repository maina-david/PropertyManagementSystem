<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Invoice | {!! Finance::invoice_settings()->prefix !!}00{!! $details->number !!}</title>
      <link rel="stylesheet" href="{!! url('/') !!}/resources/views/templates/default/style.css" media="all" />
   </head>
   <body>
      <div id="page-wrap">
         <table width="100%">
            <tr>
               <td style="border: 0;  text-align: left" width="62%">
                  @if (Limitless::business(Auth::user()->businessID)->logo != "")
                     <img src="{!! url('/') !!}/storage/files/business/{!! Limitless::business(Auth::user()->businessID)->primary_email !!}/documents/images/{!! Limitless::business(Auth::user()->businessID)->logo !!}" id="image" alt="logo" style="width:20%">
                  @endif
                  <br><br>
                  <span style="font-size: 18px; color: #2f4f4f"><strong>INVOICE: #{!! Finance::invoice_settings()->prefix !!}00{!! $details->number !!}</strong></span>
               </td>
               <td style="border: 0;  text-align: right" width="62%">
                  <div id="logo">
                     <strong>{!! Limitless::business(Auth::user()->businessID)->name !!}</strong> <br>
                     <p>
                        {!! Limitless::business(Auth::user()->businessID)->street !!},{!! Limitless::business(Auth::user()->businessID)->city !!}<br>
                        {!! Limitless::business(Auth::user()->businessID)->postal_address !!} - {!! Limitless::business(Auth::user()->businessID)->zip_code !!}<br>
                        <b>Phone:</b> {!! Limitless::business(Auth::user()->businessID)->primary_phonenumber !!}<br>
                        <b>Email:</b> {!! Limitless::business(Auth::user()->businessID)->primary_email !!}
                     </p>                
                  </div>
               </td>
            </tr>
         </table>
         <hr><br>
         <div style="clear:both"></div>
         <div id="customer">
            <table id="meta">
               <tr>
                  <td rowspan="5" class="clean_sheet">
                     <strong>Invoiced To</strong><br>
                     @if($client->company_name != ""){!! $client->company_name !!}@else{!! $client->client_name !!}@endif<br>
                     @if($client->bill_attention != "")<strong>ATTN :</strong>{!! $client->bill_attention !!}<br>@endif<br>
                     @if($client->bill_state != ""){!! $client->bill_state !!},@endif
                     @if($client->bill_city != ""){!! $client->bill_city !!},@endif
                     @if($client->bill_street != ""){!! $client->bill_street !!}@endif<br>
                     @if($client->bill_street != "")
                        {!! $client->bill_zip_code !!}<br>
                        {!! Limitless::country($client->bill_country)->name !!}
                     @endif
                  </td>
                  <td class="meta-head">INVOICE #</td>
                  <td>{!! Finance::invoice_settings()->prefix !!}00{!! $details->number !!}</td>
               </tr>
               <tr>
                  <td class="meta-head">Status</td>
                  <td>
                     @if($details->statusID == 1)
                        <p style="color:green;font-style: normal;font-weight: bolder;">{!! ucfirst(Limitless::status($details->statusID)->name) !!}</p>
                     @else
                     <p style="color:blue;font-style: normal;font-weight: bolder;">{!! ucfirst(Limitless::status($details->statusID)->name) !!}</p>
                     @endif
                  </td>
               </tr>
               <tr>
                  <td class="meta-head">Invoice Date</td>
                  <td>{!! date('F j, Y',strtotime($details->invoice_date)) !!}</td>
               </tr>
               <tr>
                  <td class="meta-head">Due Date</td>
                  <td>{!! date('F j, Y',strtotime($details->invoice_due)) !!}</td>
               </tr>
               <tr>
                  <td class="meta-head">Amount Due</td>
                  <td><div class="due">{!! number_format($details->total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</div></td>
               </tr>
            </table>
         </div>
         <table id="items">
            <tr>
               <th width="1%">#</th>
               <th width="40%">Description</th>
               <th align="center">Previous</th>
               <th align="center">Current</th>
               <th align="center">Consumption</th>
               <th align="center">Rate</th>
               <th align="center">Amount</th>
            </tr>
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
            <tr>
               <td colspan="3"></td>
               <td colspan="3" align="right"><strong>Sub Total </strong></td>
               <td align="right">{!! number_format($details->sub_total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</td>
            </tr>
            @if(Finance::invoice_settings()->show_discount_tab == 'Yes')
               <tr>
                  <td colspan="3"></td>
                  <td colspan="3" align="right"><strong>Discount </strong></td>
                  <td align="right">
                     @php echo $details->sub_total * ($details->discount / 100)  @endphp {!! Finance::currency($details->currencyID)->code !!}
                  </td>
               </tr>
            @endif
            @if(Finance::invoice_settings()->show_tax_tab == 'Yes')
               <tr>
                  <td colspan="3"></td>
                  <td colspan="3" align="right"><strong>Tax - {!! $details->tax !!}%</strong></td>
                  <td align="right">
                     {!! $taxed !!}  {!! Finance::currency($details->currencyID)->code !!}
                  </td>
               </tr>
            @endif
            <tr>
               <td colspan="3"></td>
               <td colspan="3" align="right"><strong>TOTAL </strong></td>
               <td align="right">{!! number_format($details->total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</td>
            </tr>
         </table>
         {{-- <center><button class='button -dark center no-print'  onClick="window.print();">Click Here to Print or save as print-to-PDF</button></center> --}}
      </div>
   </body>
</html>