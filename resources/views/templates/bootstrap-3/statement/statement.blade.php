<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Statement of Accounts | {!! $client->prefix !!}{!! $client->number !!}</title>

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
            @if($client->logo != "")
            <img src="{!! asset('businesses/'.$client->business_code.'/documents/images/'.$client->logo)!!}" class="logo" alt="{!! $client->businessName !!}">
            @endif
         </div>
         <div class="col-xs-2"></div>
         <div class="col-xs-6">
            <strong>{!! $client->businessName !!}</strong>
            @if($client->street != "")
            <br>{!! $client->street !!}
            @endif
            @if($client->city != "")
            <br>{!! $client->city !!},
            @endif
            @if($client->postal_address != "" )
            <br>{!! $client->postal_address !!}
            @endif
            @if($client->postal_address != "" && $client->zip_code != "" )
                 {!! $client->zip_code !!}
            @endif
            @if($client->primary_phonenumber != "" )         
            <br><b>Phone:</b> {!! $client->primary_phonenumber !!}
            @endif
            @if($client->primary_email != "" )  
            <br><b>Email:</b> {!! $client->primary_email !!}
            @endif
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 mt-3 mb-3" style="border: 1px solid #ccc!important;font-family: inherit !important">
            <h3 style="text-align: center;font-family: inherit !important">Statement of Accounts</h3>
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
                     <th bgcolor="#dcdcdc" colspan="2"><b>Account Summary</b></th>
                  </tr>                  
                  <tr>
                     <th><b>Invoiced Amount :</b></th>
                     <td align="right" colspan="2">{!! $client->symbol !!}{!! number_format($invoicedAmount,2) !!}</td>                
                  </tr>
                  <tr>
                     <th><b>Amount Received :</b></th>
                     <td align="right" colspan="2">{!! $client->symbol !!}{!! number_format($amountReceived,2) !!}</td>                
                  </tr>
                  <tr>
                     <th><b>Balance Due :</b></th>
                     <td align="right" colspan="2">{!! $client->symbol !!}{!! number_format($invoicesBalance,2) !!}</td>               
                  </tr>
               </tbody>
            </table>
         </div><br>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th>Date</th>
               <th>Transactions</th>
               <th>Details</th>
               <th>Amount</th>
               <th>Payments</th>
               <th>Balance</th>
            </tr>
         </thead>
         <tbody>
            @foreach($invoices as $invoice)
               <tr>
                  <td>{!! date('d M Y', strtotime($invoice->invoice_date)) !!}</td>
                  <td>Invoice</td>
                  <td>
                     <span class="text-primary">{!! $invoice->invoice_prefix !!}{!! $invoice->invoice_number !!} - due on {!! date('d M Y', strtotime($invoice->invoice_due)) !!}</span>
                  </td>
                  <td><b>{!! $client->symbol !!}{!! number_format($invoice->main_amount,2) !!}</b></td>
                  <td></td>
                  <td>               
                     @if($invoice->balance < 0)
                        {!! $client->symbol !!}0
                     @else 
                        {!! $client->symbol !!}{!! number_format($invoice->balance,2) !!}
                     @endif
                  </td>
               </tr>
               @foreach(Finance::all_invoice_payments($invoice->id) as $payment)
                  <tr>
                     <td>{!! date('d M Y', strtotime($payment->payment_date)) !!}</td>
                     <td>
                        @if($payment->payment_category == 'Credited')
                           Credited
                        @else
                           Payment Received
                        @endif
                     </td>
                     <td> 
                        <span class="text-info">
                           {!! $client->symbol !!}{!! number_format($payment->amount) !!} for payment of {!! $invoice->invoice_prefix !!}{!! $invoice->invoice_number !!}
                        </span>
                     </td>
                     <td></td>
                     <td><b>{!! $client->symbol !!}{!! number_format($payment->amount,2) !!}</b></td>
                     <td>
                        <b>
                           @if($payment->balance < 0)
                              {!! $client->symbol !!}0
                           @else 
                              {!! $client->symbol !!}{!! number_format($payment->balance,2) !!}
                           @endif  
                        </b>  
                     </td>
                  </tr>
               @endforeach
            @endforeach
         </tbody>
      </table>
   </div>
</body>
</html>
