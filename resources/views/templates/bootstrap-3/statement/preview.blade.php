<div class="row">
   <div class="col-md-4">
      @if ($client->logo != "")
         <img src="{!! asset('businesses/'.$client->business_code.'/documents/images/'.$client->logo)!!}" class="logo" alt="{!! $client->businessName !!}">
      @endif
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong>{!! $client->businessName !!}</strong>
         @if($client->street != "")
         <br>{!! $client->street !!}<br>
         @endif
         @if($client->city != "")
         {!! $client->city !!},
         @endif
         @if($client->postal_address != "" )
         {!! $client->postal_address !!}
         @endif
         @if($client->postal_address != "" && $client->zip_code != "" )
            - {!! $client->zip_code !!}
         @endif
         <br>
         <b>Phone:</b> {!! $client->primary_phonenumber !!}<br>
         <b>Email:</b> {!! $client->primary_email !!}
      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Statement of Accounts</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
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
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
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
               <td align="right" colspan="2">
                  @if($invoicesBalance < 0)
                     {!! $client->symbol !!}0
                  @else 
                     {!! $client->symbol !!}{!! number_format($invoicesBalance,2) !!}
                  @endif                  
               </td>               
            </tr>
         </tbody>
      </table>
   </div>
</div>
<table class="table table-striped table-bordered mt-3">
   <thead>
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