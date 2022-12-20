<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Document</title>
</head>
<body>
      <style type="text/css">
         body {
         margin: 0px 0px 0px 0px;
         padding: 0px 0px 0px 0px;
         }
         table {
         width: 100%;
         border­collapse: collapse;
         }
         td {
         vertical­align: top;
         }
         .print_page_container, .section {
         width: 100%;
         text­align: left;
         font-family:Times New Roman;
         }
         .section {
         width: 100%;
         margin­bottom: 36px;
         padding: 0 0;
         border­collapse: collapse;
         border­spacing: 0; /*page­break­inside: avoid;*/
         }
         .leftbox, .rightbox {
         width: 48%;
         background­color: #F3F3F3;
         }
         .middlebox {
         width: 4%;
         }
         .customer_section, .contact_section {
         width: 100%;
         border: 0px solid #CCCCCC;
         border­collapse: collapse;
         border­spacing: 0;
         }
         .print_heading, .ticket_heading, .mycompany_heading {
         text­align: left;
         font­weight: bold;
         color: #1f497d;
         border­collapse: collapse;
         border­spacing: 0;
         border­bottom: 1px solid #CCCCCC;
         background-color: #cccccc;
         
         }
         
         .ticket_heading td{
         padding: 3px;
         }
         .customer_body {
         padding: 3px 3px;
         }
         .amountdue_section {
         text­align: right;
         border: 2px solid #CCCCCC;
         border­collapse: collapse;
         border­spacing: 0;
         }
         .ticket_section, .item_section, .asset_section, .appointment_section {
         width: 100%;
         text­align: left;
         border: 0px solid #CCCCCC;
         border­collapse: collapse;
         border­spacing: 0;
         }
         .customer_label {
         display: none;
         text­align: left;
         font­weight: bold;
         color: #000000;
         background­color: #FFFFFF;
         vertical­align: top;
         white­space: nowrap;
         }
         .ticket_label, .ticket_label2, .wolabel, .amountdue_label, .asset_label {
         text­align: left;
         vertical­align: top;
         font­weight: bold;
         color: #000000;
         background­color: #FFFFFF;
         white­space: nowrap;
         border: 1px solid #CCCCCC;
         border­collapse: collapse;
         border­spacing: 0;
         padding: 2px 2px;
         }
         .ticket_text, .ticket_text2, .wotext, .wotext_number, .amountdue_text, .asset_text {
         text­align: left;
         vertical­align: top;
         color: #000000;
         background­color: #FFFFFF;
         border: 1px solid #CCCCCC;
         border­collapse: collapse;
         border­spacing: 0;
         padding: 2px 2px;
         }
         .ticket_label, .ticket_label2 {
         width: 10%;
         }
         .ticket_text, .ticket_text2 {
         width: 40%;
         }
         .customer_label {
         width: 10%;
         margin­left: 10px;
         }
         .customer_text {
         width: 40%;
         }
         .asset_label {
         width: 20%;
         }
         .asset_text {
         width: 80%;
         }
         .wotext_number {
         text­align: right;
         white­space: nowrap;
         }
         .wotext, .wotext_number {
         padding­top: 3px;
         padding­bottom: 3px;
         padding­left: 3px;
         padding­right: 3px;
         }
         .my_company_info {
         text­align: left;
         color: #000000;
         background­color: #FFFFFF;
         }
         .customer_section, .customer_label, .customer_text, .contact_section, .wolabel {
         text­align: left;
         }
         .amountdue_label {
         text­align: right;
         }
         .ticket_info {
         font­family: &amp;
         quot;
         Arial Rounded MT Bold&amp;
         quot;
         ;
         color: #DDDDDD;
         text­align: center;
         }
         .largeHeader {
         }
         .print$10028.00label {
         white­space: nowrap;
         }
         .print$10028.00text {
         text­align: right;
         }
         .signature {
         width: 216px;
         page­break­inside: avoid;
         }
         .my_company_logo img{
         }
         .dates_and_terms {
         border­collapse: collapse;
         width: 360px;
         font­weight: normal;
         margin­left: auto;
         margin­right: 1px;
         }
         .dates_and_terms td {
         padding: 5px 10px;
         }
         .dates_and_terms_label {
         text­align: left;
         white­space: nowrap;
         }
         .dates_and_terms_text {
         text­align: right;
         white­space: nowrap;
         }
         .balance_due {
         font­weight: bold;
         background­color: #EEE;
         border: 1px solid #CCC;
         }
         .invoice_row .wolabel {
         background­color: #EEE;
         }
         .item_section td {
         padding: 0px 10px;
         font­size: 0.9em;
         }
         .print_subtotal_text {
         }
         #itemlist table{
         table-layout;
         }
         #itemlist td{
         border:1px solid #f0f8ff;
         padding:2px;
         text-align:left;
         }
         #itemlist tr:nth-child(odd){
         background-color: #white;
         }
         #itemlist tr:nth-child(even){
         background-color:#white;
         }
         #itemlist tr:first-child td{
         background-color:#white;
         color:black;
         }
         #itemlist tr td:last-child {
         background-color: #white;
         }
         #itemlist tr:first-child td:last-child{
         background-color:#white;
         color:black;
         }
         .item_tax {display: none;}
         .item_approved {display: none;}
         </style>
         <div class="print_page_container" style="margin: 0px auto; width: 90%; font-size: 11px;">
         <table class="section" style="margin: 0px;">
         <tbody>
         <tr>
         <td style="padding: 5px; text-align: center;" colspan="2">&nbsp;_MyCompanyLogo_</td>
         </tr>
         <tr>
         <td>
         <div class="my_company_logo;"><span style="font-size: 24px;">
         _MyCompanyName_</span></div>
         </td>
         <td style="padding: 5px; text-align: right; color: black;"><span style="font-size: 24px;">
         WORK ORDER FORM
         </span></td>
         </tr>
         </tbody>
         </table>
         <table class="section" style="margin-bottom: 15px;">
         <tbody>
         <tr>
         <td style="width: 70%;">
         _MyCompanyAddress_<br />
         Phone: 888-558-6275<br />
         Email: _CurrentUser.Email_
         </td>
         <td style="width: 15%;"><strong>
         Date:</strong><br />
         <strong>
         Work Order#:</strong><br />
         </td>
         <td style="width: 15%;">_Ticket.CreationDate_<br />
         _Ticket.Number_<br />
         </td>
         </tr>
         </tbody>
         </table>
         <table class="section" style="margin: 0px 0px 10px; width: 100%; font-family: 'Times New Roman';">
         <tbody>
         <tr>
         <td style="width: 15%; vertical-align: top;"><strong>
         Bill To:
         </strong></td>
         <td style="width: 35%; vertical-align: top;">
         _CustomerInfo_
         </td>
         <td style="width: 15%; vertical-align: top;"><strong>&nbsp;Job Site:</strong><br />
         </td>
         <td style="width: 35%; vertical-align: top;">_ServiceLocationName_<br />
         _ServiceLocationAddress_<br />
         </td>
         </tr>
         </tbody>
         </table>
         <table class="section">
         <tbody>
         <tr class="ticket_heading">
         <td>
         Work Order Details
         </td>
         </tr>
         <tr class="ticket_section">
         <td>
         _Ticket.Section_<br />
         _Ticket.CustomFields_
         </td>
         </tr>
         </tbody>
         </table>
         <br />
         <table class="section;">
         <tbody>
         <tr class="ticket_heading">
         <td>Appointment Details
         </td>
         </tr>
         <tr class="ticket_section">
         <td>_Ticket.Appointments_
         </td>
         </tr>
         </tbody>
         </table>
         <br />
         <!-- Signature -->
         <table>
         <tbody>
         <tr>
         <td style="width: 50%; vertical-align: top;">
         <table cellspacing="6" cellpadding="2" border="0" style="width: 100%; margin-bottom: 10px;">
         <tbody>
         <tr>
         <td colspan="2">&nbsp;
         </td>
         </tr>
         <tr>
         <td style="width: 75%; border-bottom: 1px solid #000000;">_Ticket.Signature_<br />
         </td>
         <td valign="bottom" style="width: 22%; border-bottom: 1px solid #000000;">_Ticket.SignatureDate_</td>
         </tr>
         <tr>
         <td>
         Signature
         </td>
         <td>
         Date
         </td>
         </tr>
         </tbody>
         </table>
         </td>
         </tr>
         </tbody>
         </table>
         <table class="section" style="text-align: center; font-family: 'Times New Roman';">
         <tbody>
         <tr>
         <td style="padding: 2px; text-align: center; color: #9acdec;"><span style="font-size: 13px;">
         </span> <br />
         </td>
         </tr>
         <tr>
         <td style="padding: 2px; text-align: center; color: #000000;"><span style="font-size: 13px;">
         Thank you for your business!
         </span></td>
         </tr>
         </tbody>
         </table>
         </div>
         
         
</body>
</html>