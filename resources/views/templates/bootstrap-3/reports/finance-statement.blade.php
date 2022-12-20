<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Financial Statement</title>

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
            <strong>{!! Wingu::business(Auth::user()->businessID)->name !!}</strong><br>
            {!! Wingu::business(Auth::user()->businessID)->street !!},{!! Wingu::business(Auth::user()->businessID)->city !!}<br>
            {!! Wingu::business(Auth::user()->businessID)->postal_address !!} - {!! Wingu::business(Auth::user()->businessID)->zip_code !!}<br>
            <b>Phone:</b> {!! Wingu::business(Auth::user()->businessID)->primary_phonenumber !!}<br>
            <b>Email:</b> {!! Wingu::business(Auth::user()->businessID)->primary_email !!}<br>
            <b>Tax Pin :</b> {!! Wingu::business(Auth::user()->businessID)->tax_pin !!}
            <br>
         </div>
         <div class="col-xs-4">
            @if (Wingu::business(Auth::user()->businessID)->logo != "")
               <img src="{!! url('/') !!}/businesses/{!! Wingu::business(Auth::user()->businessID)->primary_email !!}/documents/images/{!! Wingu::business(Auth::user()->businessID)->logo) !!}" class="logo" alt="{!! Wingu::business(Auth::user()->businessID)->name !!}">
            @endif
         </div>
      </div>
      <div class="row">
         <div class="col-xs-6">
            <h4><b>To:</b></h4>
            <address>
               <strong>@if($client->company_name != ""){!! $client->company_name !!}@else{!! $client->tenant_name !!}@endif</strong><br>
               <span>
                  @if($client->bill_attention != "")
                     <strong>ATTN :</strong>{!! $client->bill_attention !!}
                  @endif
               </span>
               <span>@if($client->contact_email != ""){!! $client->contact_email !!},<br>@endif</span>
               <span>@if($client->primary_phone_number != ""){!! $client->primary_phone_number !!},<br>@endif</span>
               <span>@if($client->bill_state != ""){!! $client->bill_state !!},<br>@endif</span>
               <span>@if($client->bill_city != ""){!! $client->bill_city !!},<br>@endif</span>
               <span>@if($client->bill_street != ""){!! $client->bill_street !!}@endif</span><br>
               
               @if($client->bill_street != "")
               <span>
                  {!! $client->bill_zip_code !!}<br>
                  {!! Wingu::country($client->bill_country)->name !!}
               </span><br>
               @endif
               @if($client->tax_pin != "")
                  <span>
                     <b>Tax Pin :</b> {!! $client->tax_pin !!}
                  </span>
               @endif
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <td colspan="2" align="center"><b>STATEMENT OF ACCOUNT </b><br></td>
                  </tr>
                  <tr>
                     <th>Period  :</th>
                     <td class="text-right"><b>{!! date('d M Y', strtotime($from)) !!} - {!! date('d M Y', strtotime($to)) !!}</b></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table table-bordered">
         <tr>
            <th>Date</th>
            <th>Reference</th>
            <th>Description</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
         </tr>
         <tbody>
            @foreach ($invoices as $invoice) 
               <tr>
                  <td>{!! date('d/m/Y',strtotime($invoice->created_at)) !!}</td>
                  <td>{!! Finance::invoice_settings()->prefix !!}{!! $invoice->invoice_number !!}</td>
                  <td>Invoice {!! $invoice->description !!}</td>
                  <td>
                     @if ($invoice->transaction_type == "Debit")
                        {!! $business->code !!} {!! number_format($invoice->total) !!}
                     @else
                        0
                     @endif
                  </td>
                  <td>
                     @if ($invoice->transaction_type == "Credit")
                        {!! $business->code !!} {!! number_format($invoice->total) !!}
                     @else
                        0
                     @endif
                  </td>
                  <td>
                     <b>{!! $business->code !!} {!! number_format($invoice->total) !!}</b></b>
                  </td>
               </tr>
               @if ($invoice->paid != "")
                  @foreach (Finance::all_invoice_payments($invoice->id) as $payments)
                     <tr class="table-active">
                        <td>{!! date('d/m/Y',strtotime($payments->created_at)) !!}</td>
                        <td>{!! $payments->reference_number !!}</td>
                        <td>Invoice payment</td>
                        <td>{!! $business->code !!} 0</td>
                        <td>{!! $business->code !!} {!! number_format($payments->amount)!!}</td>
                        <b><td>{!! $business->code !!} {!! number_format($payments->balance) !!}</td></b>
                     </tr>
                  @endforeach
               @endif
               @if($invoice->credited == 'Yes')
                  @foreach(Finance::invoice_creditnote($invoice->id) as $credit)
                     <tr class="table-primary">
                        <td>{!! date('d/m/Y',strtotime($credit->creditnoteinvoicedate)) !!}</td>
                        <td>{!! $creditSettings->prefix !!}{!! $creditSettings->creditnote_number !!}</td>
                        <td>Credit Note</td>
                        <td>{!! $business->code !!} {!! number_format($credit->credited_amount)!!}</td>
                        <td>{!! $business->code !!} 0</td>
                        <b><td>{!! $business->code !!} {!! number_format($credit->invoice_balance) !!}</td></b>
                     </tr>
                  @endforeach
               @endif
            @endforeach
         </tbody>
      </table>
   </div>

</body>
</html>