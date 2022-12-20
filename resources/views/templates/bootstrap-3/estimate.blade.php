<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Estimate | {!! $details->prefix !!}{!! $details->number !!}</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! asset('assets/templates/bootstrap-3/style.css') !!}" media="all" />

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
            <h4><b>From:</b></h4>
            <strong>{!! $details->businessName !!}</strong><br>
            @if($details->street != "")
               {!! $details->street !!}<br>
            @endif
            @if($details->city != "")
            {!! $details->city !!}, 
            @endif
            @if($details->postal_address != "" )
            {!! $details->postal_address !!} 
            @endif
            @if($details->postal_address != "" && $details->zip_code != "" )
               - {!! $details->zip_code !!}
            @endif<br>
            <b>Phone:</b> {!! $details->primary_phonenumber !!}<br>
            <b>Email:</b> {!! $details->primary_email !!}
         </div>
         <div class="col-xs-4">
            @if ($details->logo != "")
               <img src="{!! asset('businesses/'.$details->business_code.'/documents/images/'.$details->logo) !!}" class="logo" alt="{!! $details->name !!}">
            @endif
         </div>
      </div>
      <div class="row">
         <div class="col-xs-6">
            <h4><b>To:</b></h4>
            <address>
               <strong>{!! $client->customer_name !!}</strong><br>
               <span>
                  @if($client->bill_attention != "")
                     <strong>ATTN :</strong>{!! $client->bill_attention !!}
                  @endif
               </span><br>
               <span>@if($client->bill_state != ""){!! $client->bill_state !!},@endif</span>
               <span>@if($client->bill_city != ""){!! $client->bill_city !!},@endif</span>
               <span>@if($client->bill_street != ""){!! $client->bill_street !!}@endif</span><br>
               <span>
                  @if($client->bill_street != "")
                     {!! $client->bill_zip_code !!}<br>
                  @endif
                  @if($client->bill_country != "")
                     {!! Wingu::country($client->bill_country)->name !!}
                  @endif
               </span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <td colspan="2" align="center"><b>ESTIMATE</b></td>
                  </tr>
                  <tr>
                     <th>Estimate # :</th>
                     <td class="text-right"><b>{!! $details->prefix !!}{!! $details->number !!}</b></td>
                  </tr>
                  @if ($details->reference_number != "")
                     <tr>
                        <th>Reference # :</th>
                        <td class="text-right text-uppercase"><b>{!! $details->reference_number !!}</b></td>
                     </tr>
                  @endif
                  <tr>
                     <th>Status :</th>
                     <td class="text-right">
                        @if($details->statusID == 1)
                           <p style="color:green;font-style: normal;font-weight: bolder;">{!! ucfirst($details->name) !!}</p>
                        @else
                        <p style="color:blue;font-style: normal;font-weight: bolder;">{!! ucfirst($details->name) !!}</p>
                        @endif
                     </td>
                  </tr>
                  <tr>
                     <th>Date Create :</th>
                     <td class="text-right">{!! date('F j, Y',strtotime($details->estimate_date)) !!}</td>
                  </tr>
                  <tr>
                     <th>Due Date :</th>
                     <td class="text-right">{!! date('F j, Y',strtotime($details->estimate_due)) !!}</td>
                  </tr>
               </tbody>
            </table>
            <div style="margin-bottom: 0px">&nbsp;</div>
            <table style="width: 100%; margin-bottom: 20px">
               <tbody>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><div> Amount </div></th>
                     <td style="padding: 5px" class="text-right"><strong> {!! number_format($details->total) !!} {!! $details->code !!} </strong></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="40%">Items</th>
               <th>Qty</th>
               <th>Price</th>
               <th>Amount</th>
                        
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
                     {{ number_format($product->selling_price) }} {!! $details->code !!}
                  </td>
                  <td>
                     <span class="price">
                        @php echo number_format($product->quantity * $product->selling_price) @endphp {!! $details->code !!}
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
                     <th style="padding: 5px"><div>SUB TOTAL :</div></th>
                     <td style="padding: 5px" class="text-right"><strong>{!! number_format($details->sub_total) !!} {!! $details->code !!}<strong></td>
                  </tr>
                  @if($details->show_discount_tab == 'Yes')
                     @if($details->discount != "")
                        <tr class="well" style="padding: 5px">
                           <th style="padding: 5px"><strong>Discount </strong></th>
                           @if($details->discount_type == 'amount')
                              <td style="padding: 5px" class="text-right">
                                 <strong>
                                    @php echo $details->discount  @endphp {!! $details->code !!}
                                 </strong>
                              </td>
                           @else 
                              <td style="padding: 5px" class="text-right">
                                 <strong>
                                    @php echo $details->sub_total * ($details->discount / 100)  @endphp {!! $details->code !!}
                                 </strong>
                              </td>
                           @endif
                        </tr>
                     @else 
                        <tr class="well" style="padding: 5px">
                           <th style="padding: 5px"><strong>Discount </strong></th>
                           <td style="padding: 5px" class="text-right">
                              <strong>
                                 0.00
                              </strong>
                           </td>
                        </tr>
                     @endif
                  @endif
                  @if($details->show_tax_tab == 'Yes')
                     <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><strong>Tax - {!! $details->tax !!}%</strong></th>
                        <td style="padding: 5px" class="text-right">
                           <strong>
                              {!! $taxed !!}  {!! $details->code !!}
                           </strong>
                        </td>
                     </tr>
                  @endif
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL :</strong></th>
                     <td style="padding: 5px" class="text-right"><strong>{!! number_format($details->total) !!} {!! $details->code !!}</strong></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-8 invbody-terms">
            <h4>Thank you for your business.</h4>
            <br><br>
            @if($details->customer_note != "")
               <div class="notice">
                  <h4>Customer note</h4>
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