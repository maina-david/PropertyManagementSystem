<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Delivery Note | {!! $details->prefix !!}{!! $details->number !!}</title>

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
         <div class="col-xs-4">
            @if ($details->logo != "")
               <img src="{!! asset('businesses/'.$details->business_code.'/documents/images/'.$details->logo)!!}" class="logo" alt="{!! $details->businessName !!}">
            @endif
         </div>
         <div class="col-xs-2"></div>
         <div class="col-xs-6">
            <strong>{!! $details->businessName !!}</strong>
            @if($details->street != "")
            <br>{!! $details->street !!}
            @endif
            @if($details->city != "")
            <br>{!! $details->city !!},
            @endif
            @if($details->postal_address != "" )
            <br>{!! $details->postal_address !!}
            @endif
            @if($details->postal_address != "" && $details->zip_code != "" )
                 {!! $details->zip_code !!}
            @endif
            @if($details->primary_phonenumber != "" )         
            <br><b>Phone:</b> {!! $details->primary_phonenumber !!}
            @endif
            @if($details->primary_email != "" )  
            <br><b>Email:</b> {!! $details->primary_email !!}
            @endif
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
            <h4 style="text-align: center">Delivery Note</h4>
         </div>               
      </div>
      <br>
      <div class="row">
         <div class="col-xs-6">
            <address>
               <strong>{!! $client->customer_name !!}</strong>
               <span><br>@if($client->bill_state != ""){!! $client->bill_state !!},@endif</span>
               <span>@if($client->bill_city != ""){!! $client->bill_city !!},@endif</span>
               <span>@if($client->bill_street != ""){!! $client->bill_street !!}<br>@endif</span>
               <span>
                  @if($client->bill_street != "")
                     {!! $client->bill_zip_code !!}<br>
                  @endif
                  @if($client->bill_country != "")
                     {!! Wingu::country($client->bill_country)->name !!}<br>
                  @endif
               </span>
               <span><b>Email: </b>@if($client->email != ""){!! $client->email !!}@endif</span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <th>Invoice Number</th>
                     <td class="text-right"><b>{!! $details->prefix !!}{!! $details->number !!}</b></td>
                  </tr>
                  @if ($details->reference_number != "")
                     <tr>
                        <th>Reference #</th>
                        <td class="text-right text-uppercase"><b>{!! $details->reference_number !!}</b></td>
                     </tr>
                  @endif
                  <tr>
                     <th>Issue Date</th>
                     <td class="text-right">{!! date('F j, Y',strtotime($details->invoice_date)) !!}</td>
                  </tr>
                  <tr>
                     <th>Due Date</th>
                     <td class="text-right">{!! date('F j, Y',strtotime($details->invoice_due)) !!}</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="85%">Items</th>
               <th>Qty</th>
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
               </tr>
            @endforeach
         </tbody>
      </table>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-8 invbody-terms">
            <p>
               Thank you for your business.<br><br><br><br><br> 
               Received by,<br><br>
               ________________________________________
            </p>
         </div>
      </div>
   </div>

</body>
</html>