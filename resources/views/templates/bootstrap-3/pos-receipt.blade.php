<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
      <title>Invoice | {!! Finance::invoice_settings()->prefix !!}{!! $details->number !!}</title>
      <link rel="stylesheet" href="{!! asset('assets/templates/bootstrap-3/style.css') !!}" media="all" />
   </head>
   <body>
      <div id="page-wrap">
         <table width="100%" border="0">
            <tr>
               <td style="text-align: center">
                  <strong>{!! Limitless::business(Auth::user()->businessID)->name !!}</strong> <br>                 
                  {!! Limitless::business(Auth::user()->businessID)->street !!},{!! Limitless::business(Auth::user()->businessID)->city !!}<br>
                  {!! Limitless::business(Auth::user()->businessID)->postal_address !!} - {!! Limitless::business(Auth::user()->businessID)->zip_code !!}<br>
                  <b>Phone:</b> {!! Limitless::business(Auth::user()->businessID)->primary_phonenumber !!}<br>
                  <b>Email:</b> {!! Limitless::business(Auth::user()->businessID)->primary_email !!}
               </td>
            </tr>
         </table>
         <div style="clear:both"></div>
         <div id="customer">
            <table id="meta">               
               <tr>
                  <td>Date</td>
                  <td>{!! date('F j, Y',strtotime($details->invoice_date)) !!}</td>
               </tr>
               <tr>
                  <td>Amount Due</td>
                  <td><div class="due">{!! number_format($details->total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</div></td>
               </tr>
            </table>
         </div>
         <table id="">
            <tr>
               <th align="right" width="1%">#</th>
               <th width="55%">Description</th>
               <th align="center">Price</th>
               <th align="center">Qty</th>
               <th align="center">Total</th>
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
                  <td align="center">
                     {{ number_format($product->selling_price) }} {!! Finance::currency($details->currencyID)->code !!}
                  </td>
                  <td align="center">{{ $product->quantity }}</td>
                  <td align="right">
                     <span class="price">
                        @php echo number_format($product->quantity * $product->selling_price) @endphp {!! Finance::currency($details->currencyID)->code !!}
                     </span>
                  </td>
               </tr>
            @endforeach
            <tr>
               <td colspan="2"></td>
               <td colspan="2" align="right"><strong>Sub Total </strong></td>
               <td align="right">{!! number_format($details->sub_total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</td>
            </tr>
            @if(Finance::invoice_settings()->show_discount_tab == 'Yes')
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2" align="right"><strong>Discount </strong></td>
                  <td align="right">
                     @php echo $details->sub_total * ($details->discount / 100)  @endphp {!! Finance::currency($details->currencyID)->code !!}
                  </td>
               </tr>
            @endif
            @if(Finance::invoice_settings()->show_tax_tab == 'Yes')
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2" align="right"><strong>Tax - {!! $details->tax !!}%</strong></td>
                  <td align="right">
                     {{-- {!! $taxed !!}  {!! Finance::currency($details->currencyID)->code !!} --}}
                  </td>
               </tr>
            @endif
            <tr>
               <td colspan="2"></td>
               <td colspan="2" align="right"><strong>TOTAL </strong></td>
               <td align="right">{!! number_format($details->total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</td>
            </tr>
         </table>
         <center><button class='button -dark center no-print'  onClick="window.print();">Click Here to Print</button></center>
      </div>
   </body>
</html>