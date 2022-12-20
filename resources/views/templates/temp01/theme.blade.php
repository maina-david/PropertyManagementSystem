<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <title>{!! Documents::settings('Estimates')->code !!}{!! $edit->number !!}</title>
      <link rel="stylesheet" href="{!! url('/') !!}/resources/views/templates/invoices/temp01/style.css" media="all" />
   </head>
   <body>
      <div class="invoice-box">
         <table cellpadding="0" cellspacing="0">
            <tr class="top">
               <td colspan="2">                  
                  <tr>
                     <td>
                        <img src="https://www.sparksuite.com/images/logo.png" class="logo">
                     </td> 
                     @if($edit->document_type == 'Estimate')
                        <td>
                           <h1>ESTIMATE</h1>
                           #: {!! Documents::settings('Estimates')->code !!}{!! $edit->number !!}<br>
                           Estimate Date: {!! date('F j, Y',strtotime($edit->start_date)) !!}<br>
                           Reference# : {!! $edit->lpo_number !!}
                        </td>
                     @endif
                     @if($edit->document_type == 'Invoice')
                        <td>
                           <h1>Invoice</h1>
                           #: {!! Documents::settings('Estimates')->code !!}{!! $edit->number !!}<br>
                           Created: January 1, 2015<br>
                           Due: February 1, 2015
                        </td>
                     @endif
                  </tr>
               </td>
            </tr>
            <tr class="information">
               <td colspan="2">
                  <tr>
                     <td>
                        <p>
                           @if (Limitless::check_for_setting('company name','profile') == 1)
                              <strong>{!! Limitless::get_specific_setting('company name','profile') !!}</strong>	 
                           @endif	
                           @if (Limitless::check_for_setting('location','profile') == 1)									
                              <br>{!! Limitless::get_specific_setting('location','profile') !!}
                           @endif
                           @if (Limitless::check_for_setting('town','profile') == 1)	
                              <br>{!! Limitless::get_specific_setting('town','profile') !!}
                           @endif, 
                           @if (Limitless::check_for_setting('city','profile') == 1)
                              {!! Limitless::get_specific_setting('city','profile') !!}, 
                           @endif
                           @if (Limitless::check_for_setting('country','profile') == 1)
                              {!! Limitless::get_specific_setting('country','profile') !!}
                           @endif
                           @if (Limitless::check_for_setting('postal address','profile') == 1)
                              <br>{!! Limitless::get_specific_setting('postal address','profile') !!}
                           @endif
                        </p>
                     </td>
                     <td>
                        <p>
                           <strong>@if($client->company_name != ""){!! $client->company_name !!}@else{!! $client->client_name !!}@endif</strong><br>
                           <strong>ATTN :</strong> {!! $client->bill_attention !!}
                           <br>{!! $client->bill_state !!}, {!! $client->bill_city !!}, {!! $client->bill_street !!}<br>
                           {!! $client->bill_zip_code !!}, {!! Limitless::country($client->bill_country)->name !!}
                        </p>
                     </td>
                  </tr>
               </td>
            </tr>
            <tr class="">
               <td>#</td>
               <td>Items</td>
               <td>Qty</td>
               <td>Price</td>
               <td>Amount</td>
            </tr>
            @foreach($products as $product)
               <tr class="item">
                  <td>{!! $count++ !!}</td>										
                  <td>
                     @if($product->product_id != 0 )
                        <strong>{!! Finance::product($product->product_id)->product_name !!}</strong>
                        <small>{!! $product->short_description !!}</small>
                     @else 
                        <strong>{!! $product->product_name !!}</strong>
                     @endif
                  </td>
                  <td>{!! $product->quantity !!}</td>
                  <td>
                     {!! number_format($product->price) !!}.00 {!! Finance::currency($edit->currency_id)->code !!}
                  </td>
                  <td>{!! number_format($product->price) !!}.00 {!! Finance::currency($edit->currency_id)->code !!} </td>
               </tr>
            @endforeach
            <tr class="total">
               <td></td>
               <td><strong>Sub Total :</strong> {!! number_format($edit->amount) !!}.00 {!! Finance::currency($edit->currency_id)->code !!}</td>
            </tr>
            <tr class="total">
               <td></td>
               <td>
                  <strong>Tax - {!! $edit->tax !!}% :</strong> {!! number_format($taxed) !!} {!! Finance::currency($edit->currency_id)->code !!}
               </td>
            </tr>
            <tr class="total">
               <td></td>
               <td>
                  <strong>Discount :</strong> {!! number_format($edit->discount) !!} {!! Finance::currency($edit->currency_id)->code !!}
               </td>
            </tr>
            <tr class="total">
               <td></td>
               <td><strong>TOTAL :</strong> {!! number_format($edit->total_amount) !!}.00 {!! Finance::currency($edit->currency_id)->code !!}</td>
            </tr>
         </table>
      </div>
   </body>
</html>
