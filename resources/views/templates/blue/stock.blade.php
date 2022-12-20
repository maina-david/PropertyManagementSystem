<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>LPO | {!! Finance::lpo()->prefix !!}00{!! $lpo->lpo_number !!}</title>
      <link rel="stylesheet" href="{!! url('/') !!}/resources/views/templates/blue/style.css" media="all" />
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
            <div>
               @if(Limitless::business(Auth::user()->businessID)->street != "")
                  {!! Limitless::business(Auth::user()->businessID)->street !!},
               @endif
               @if(Limitless::business(Auth::user()->businessID)->city != "")
                  {!! Limitless::business(Auth::user()->businessID)->city !!}
               @endif
            </div>
            <div>
               @if(Limitless::business(Auth::user()->businessID)->postal_address != "")
                  {!! Limitless::business(Auth::user()->businessID)->postal_address !!}
                  -
               @endif
               @if(Limitless::business(Auth::user()->businessID)->zip_code != "")
                  {!! Limitless::business(Auth::user()->businessID)->zip_code !!}
               @endif
            </div>
            @if(Limitless::business(Auth::user()->businessID)->primary_phonenumber != "")
               <div>Phone: {!! Limitless::business(Auth::user()->businessID)->primary_phonenumber !!}</div>
            @endif
            @if(Limitless::business(Auth::user()->businessID)->primary_email != "")
               <div>Email: {!! Limitless::business(Auth::user()->businessID)->primary_email !!}</div>
            @endif
            @if(Limitless::business(Auth::user()->businessID)->website != "")
               <div>Website: <a href="{!! Limitless::business(Auth::user()->businessID)->website !!}" target="_blank">{!! Limitless::business(Auth::user()->businessID)->website !!}</a></div>
            @endif
         </div>
      </header>
      <main>
         <div id="details" class="clearfix">
            <div id="client">
               <div class="to">Deliverd to:</div>
               <h2 class="name">@if($vendor->company_name != ""){!! $vendor->company_name !!}@else{!! $vendor->client_name !!}@endif</h2>
               <div class="address">
                  @if($vendor->bill_attention != "")
                     <strong>ATTN :</strong>
                     {!! $vendor->bill_attention !!}<br>
                  @endif
                  @if($vendor->bill_state != ""){!! $vendor->bill_state !!},@endif
                  @if($vendor->bill_city != ""){!! $vendor->bill_city !!},@endif
                  @if($vendor->bill_street != ""){!! $vendor->bill_street !!}@endif
                  <br>
                  @if($vendor->bill_street != "")
                     {!! $vendor->bill_zip_code !!}<br>
                     {!! Limitless::country($vendor->bill_country)->name !!}
                  @endif
               </div>
               <div class="email"><a href="mailto:{!! $vendor->email !!}">{!! $vendor->email !!}</a></div>
            </div>
            <div id="invoice">
               <h1>Local purchase order (LPO)</h1>
               @if($lpo->status == 14)
                  <a href="#" class="btn btn-success">Deliverd</a>
               @endif
               <h3>#{!! Finance::lpo()->prefix !!}00{!! $lpo->lpo_number !!}</h3>
               <div class="date"><b>Date of LPO:</b> {!! date('F j, Y',strtotime($lpo->lpo_date)) !!}</div>
               <div class="date"><b>Due Date:</b> {!! date('F j, Y',strtotime($lpo->lpo_due)) !!}</div>
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
                        @if(Finance::check_product($product->productID) == 1 )
                           <strong>{!! Finance::product($product->productID)->product_name !!}</strong>
                        @else
                           <i>Unknown Product</i>
                        @endif
                     </td>
                     <td class="unit">{{ number_format($product->price) }} {!! Finance::currency($lpo->currencyID)->code !!}</td>
                     <td class="qty">{{ $product->quantity }}</td>
                     <td class="total">@php echo number_format($product->quantity * $product->price) @endphp {!! Finance::currency($lpo->currencyID)->code !!}</td>
                  </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>Sub Total :</strong></td>
                  <td>{!! number_format($lpo->sub_total) !!}.00 {!! Finance::currency($lpo->currencyID)->code !!}</td>
               </tr>
               @if(Finance::lpo()->show_discount_tab == 'Yes')
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Discount :</strong></td>
                     <td>
                        @php echo $lpo->sub_total * ($lpo->discount / 100)  @endphp {!! Finance::currency($lpo->currencyID)->code !!}
                     </td>
                  </tr>
               @endif
               @if(Finance::lpo()->show_tax_tab == 'Yes')
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Tax - {!! $lpo->tax !!}% :</strong></td>
                     <td>
                        {!! $taxed !!}  {!! Finance::currency($lpo->currencyID)->code !!}
                     </td>
                  </tr>
               @endif
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>TOTAL :</strong></td>
                  <td>{!! number_format($lpo->total) !!}.00 {!! Finance::currency($lpo->currencyID)->code !!}</td>
               </tr>
            </tfoot>
         </table>

         @if($lpo->lpo_note != "")
            <div class="notice">
               <h4>Client Note</h4>
               {!! $lpo->lpo_note !!}
            </div>
         @else
            @if(Finance::lpo()->default_customer_notes != "")
               <div class="notice">
                  <h4>Client Note</h4>
                  {!! Finance::lpo()->default_customer_notes !!}
               </div>
            @endif
         @endif
         @if($lpo->terms != "")
            <div class="notice">
               <h4>Terms & Conditions</h4>
               {!! $lpo->terms !!}
            </div>
         @else
            @if(Finance::lpo()->default_customer_notes != "")
               <div class="notice">
                  <h4>Terms & Conditions</h4>
                  {!! Finance::lpo()->default_terms_conditions !!}
               </div>
            @endif
         @endif
         <div id="thanks">Thank you!</div>
      </main>
   </body>
</html>
