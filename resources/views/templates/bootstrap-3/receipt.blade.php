<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Receipt | {!! $details->transactionID !!}</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! asset('assets/templates/bootstrap-3/style.css') !!}" media="all" />

   <style>
       .text-right {
         text-align: right;
      }
   </style>
</head>
<body class="login-page" style="background: white">
   <div class="row">
      <div style="padding-bottom:35px;border-bottom:1px solid #eee;width:100%;">
         <table>
            <tbody>
            <tr>
               <td style="vertical-align:top;padding-left:30px">
                  <p>
                     <span class="pcs-orgname"><b>{!! $details->businessName !!}</b><br></span>
                     @if( $details->street != "")
                        {!! $details->street !!}<br>
                     @endif
                     @if( $details->city != "")
                        {!! $details->city !!}, {!! $details->postal_address !!} - {!! $details->zip_code !!}<br>
                     @endif
                     @if($details->primary_phonenumber != "")
                        Phone: {!! $details->primary_phonenumber !!}<br>
                     @endif
                     @if($details->primary_email != "")
                        Email: {!! $details->primary_email !!}<br>
                     @endif
                  </p>
               </td>
            </tr>
            </tbody>
         </table>
      </div>                  
      <div style="padding:35px 0 50px;text-align:center">
         <span style="\font-size: 13pt; color: #333333;">PAYMENT RECEIPT</span>
         <hr>
      </div>                       
      <div style="width: 70%;float: left">
         <div style="width: 100%;padding: 11px 0;">
            <div style="width:35%;float:left;" class="pcs-label">Payment Date</div> 
            <div style="width:65%;border-bottom:1px solid #eee;float:right;">
               <b>{!! date('jS F, Y', strtotime($details->payment_date)) !!}</b>
            </div>
            <div style="clear:both;"></div>
         </div>                  <br>
         <div style="width: 100%;padding: 10px 0;">
            <div style="width:35%;float:left;" class="pcs-label">Reference Number</div>
            <div style="width:65%;border-bottom:1px solid #eee;float:right;min-height:22px">
               <b>{!! $details->transactionID !!}</b>
            </div>
            <div style="clear:both;"></div>
         </div><br>                 
         <div style="width: 100%;padding: 11px 0;">
            <div style="width:35%;float:left;" class="pcs-label">Payment Mode</div>
            <div style="width:65%;border-bottom:1px solid #eee;float:right;">
               <b>
                  @if($details->payment_method != "")
                     @if(Finance::check_payment_method($details->payment_method) != 0)
                        {!! Finance::payment_method($details->payment_method)->name !!}
                     @endif
                  @endif
               </b>
            </div>
            <div style="clear:both;"></div>
         </div>
      </div>          <br>        
      <div style="text-align:center;color:#ffffff;float:right;background:#78ae54;width: 25%; padding: 34px 5px;">
         <span> Amount Received</span><br>
         <span  style="font-size: 16pt;color: #ffffff;"">
         {!! $details->code !!} {!! number_format($details->amount) !!}
         </span>
      </div><br>
      <div style="clear:both;"></div>
      <div style="margin-top:50px">
         <table style="width:100%">
            <tbody>
            <tr>
               <td>
                  <div>
                     <p style="font-weight:600;color: #777777;">Bill To</p>
                     <a href="#">{!! $details->customer_name !!}</a><br>
                     @if($details->email != "")
                        {!! $details->email !!}<br>
                     @endif
                     @if($details->primary_phone_number != "")
                        {!! $details->primary_phone_number !!}, {!! $details->bill_city !!}, {!! $details->bill_zip_code !!}<br>
                     @endif
                     @if($details->bill_country != "")
                        {!! Wingu::country($details->bill_country)->name !!}<br>
                     @endif
                  </div>
               </td>
               <td style="text-align: right;vertical-align:top">
               </td>
            </tr>
            </tbody>
         </table>
      </div>
      <hr>         
      <div style="margin-top:50px;page-break-inside: avoid;">
         <h4 class="pcs-payment-details-header" style="margin-bottom:18px;">Payment for</h4>
         <table style="width:100%;table-layout:fixed;">
            <thead>
               <tr style="height:40px;">                       
                  <td style="padding:5px 10px 5px 10px;word-wrap: break-word;" class="pcs-itemtable-header">
                  Invoice Number
                  </td>
                  <td style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                     Invoice Date
                  </td>
                  <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                     Invoice Amount
                  </td>
                  <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                     Payment Amount
                  </td>
                  <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                     Amount Due
                  </td>                     
               </tr>
            </thead>
            <tbody>
               <tr style="border-top:1px solid #ededed">                       
                  <td valign="top" style="padding: 10px 0px 10px 10px;word-wrap: break-word;" class="pcs-item-row">
                     <span id="2024718000000075053"><a href="#/invoices/2024718000000075053">{!! $details->prefix !!}{!! $details->invoice_number !!}</a></span>
                  </td>                       
                  <td valign="top" style="padding: 10px 10px 5px 10px;word-wrap: break-word;" class="pcs-item-row">
                     {!! date('jS F, Y', strtotime($details->invoice_date)) !!}
                  </td>                       
                  <td valign="top" style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;" class="pcs-item-row">
                     {!! $details->code !!} {!! number_format($details->total) !!}
                  </td>
                  <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                     {!! $details->code !!} {!! number_format($details->amount) !!}
                  </td>
                  <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                     {!! $details->code !!} {!! number_format($details->paymentBalance) !!}
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</body>