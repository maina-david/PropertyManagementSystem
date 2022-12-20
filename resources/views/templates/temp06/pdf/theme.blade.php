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
         body
         {
         margin: 0px 0px 0px 0px;
         padding: 0px 0px 0px 0px;
         }
         .print_page_container
         {
         width: 100%;
         font-family: Arial, Helvetica, sans-serif;
         text-align: left;
         }
         .section
         {
         width: 100%;
         margin-bottom: 20px;
         padding: 0 0;
         font-size: 14px;
         border-collapse: collapse;
         border-spacing: 0;
         /*page-break-inside: avoid;*/
         }
         .leftbox, .rightbox
         {
         width: 48%;
         background-color: #dbe5f1;
         }
         .middlebox
         {
         width: 4%;
         }
         .customer_section, .contact_section
         {
         width: 100%;
         border: 0px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         background-color: #dbe5f1
         }
         .print_heading, .ticket_heading, .mycompany_heading
         {
         text-align: left;
         font-weight: bold;
         font-size: 14;
         color: #FFFFFF;
         background-color: #366092;
         border-collapse: collapse;
         border-spacing: 0;
         border-bottom: 2px solid #366092;
         border-top: 2px solid #dbe5f1;
         border-left: 2px solid #dbe5f1;
         border-right: 2px solid #366092;
         padding: 3px 3px;
         }
         .customer_body
         {
         padding: 3px 3px;
         background-color: #dbe5f1;
         }
         .amountdue_section
         {
         text-align: right;
         border: 2px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         }
         .ticket_section, .item_section, .asset_section, .appointment_section
         {
         width: 100%;
         text-align: left;
         border: 0px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         }
         .customer_label
         {
         display:none;
         text-align: left;
         font-weight: bold;
         color: #000000;
         background-color: #FFFFFF;
         vertical-align: top;
         white-space: nowrap;
         }
         .ticket_label, .ticket_label2, .wolabel, .amountdue_label, .asset_label
         {
         text-align: left;
         vertical-align: top;
         font-weight: bold;
         color: #000000;
         background-color: #FFFFFF;
         white-space: nowrap;
         border: 1px solid #000000;
         border-collapse: collapse;
         border-spacing: 0;
         padding: 2px 2px;
         }
         .ticket_text, .ticket_text2, .wotext, .wotext_number, .amountdue_text, .asset_text
         {
         text-align: left;
         vertical-align: top;
         color: #000000;
         background-color: #dbe5f1;
         border: 1px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         padding: 2px 2px;
         }
         .ticket_label, .ticket_label2
         {
         width: 10%;
         }
         .ticket_text, .ticket_text2
         {
         width: 40%;
         }
         .customer_label
         {
         width: 10%;
         margin-left: 10px;
         }
         .customer_text
         {
         width: 40%;
         }
         .asset_label
         {
         width: 20%;
         }
         .asset_text
         {
         width: 80%;
         }
         .wotext_number
         {
         text-align: right;
         white-space: nowrap;
         }
         .wotext, .wotext_number
         {
         padding-top: 3px;
         padding-bottom: 3px;
         padding-left: 3px;
         padding-right: 3px;
         }
         .my_company_info
         {
         font-weight: bold;
         color: #000000;
         background-color: #FFFFFF;
         font-family: Arial, Helvetica, sans-serif;
         }
         .customer_section, .customer_label, .customer_text, .contact_section, .wolabel
         {
         text-align: left;
         background-color: #dbe5f1;
         font-size: 14px;
         }
         .amountdue_label
         {
         text-align: right;
         }
         .ticket_info
         {
         font-family: "Arial Rounded MT Bold";
         color: #DDDDDD;
         text-align: center;
         }
         .largeHeader
         {
         }
         .subtotal_label
         {
         font-family: Arial;
         font-weight: bold;
         text-align: right;
         white-space: nowrap;
         font-size: 14px;
         }
         .subtotal_text
         {
         border-bottom: solid 1px #999999;
         text-align: right;
         font-size: 14px;
         }
         .signature
         {
         width: 216px;
         page-break-inside: avoid;
         }
         .my_company_logo
         {
         padding-bottom: 20px
         }
         .item_tax {display: none;}
         .item_approved {display: none;}
         </style>
         <div class="print_page_container">
         <table cellspacing="0" cellpadding="0" border="0" class="section">
         <tbody>
         <tr>
         <td>
         <table width="100%" cellspacing="0" cellpadding="0" border="0">
         <tbody>
         <tr>
         <td class="my_company_info" style="width: 50%;">
         <div>&nbsp;</div>
         _MyCompanyAddress_<br />
         _MyCompanyWebsite_<br />
         _MyCompanyPhone_<br />
         _MyCompanyEmail_<br />
         </td>
         <td class="ticket_info" style="width: 50%;">
         <div>
         <span style="font-size: 22px;">
         <div>_MyCompanyLogo_</div>
         <span style="color: #366092;">Invoice #_InvoiceNumber_ </span><br />
         </span></div>
         </td>
         </tr>
         </tbody>
         </table>
         </td>
         </tr>
         </tbody>
         </table>
         <table cellspacing="0" cellpadding="0" border="0" class="section">
         <tbody>
         <tr>
         <td class="leftbox" style="text-align: left; vertical-align: top;">
         <table cellspacing="0" cellpadding="0" border="0" class="customer_section">
         <tbody>
         <tr>
         <td class="print_heading">
         _CustomerHeader_
         </td>
         </tr>
         <tr>
         <td class="customer_body">
         _CustomerInfo_
         </td>
         </tr>
         </tbody>
         </table>
         </td>
         <td class="middlebox">&nbsp;
         </td>
         <td class="rightbox" style="text-align: right; vertical-align: top;">
         <table cellspacing="0" cellpadding="0" border="0" class="contact_section">
         <tbody>
         <tr>
         <td class="print_heading">
         Service Location
         </td>
         </tr>
         <tr>
         <td class="customer_body">
         _ServiceLocationAddress_
         </td>
         </tr>
         </tbody>
         </table>
         </td>
         </tr>
         </tbody>
         </table>
         <!-- Items -->
         <table cellspacing="0" cellpadding="0" border="0" class="section">
         <tbody>
         <tr>
         <td class="print_heading">
         Item(s)
         </td>
         </tr>
         <tr>
         <td>_Invoice.Items_<br />
         </td>
         </tr>
         </tbody>
         </table>
         <!-- Total -->
         <table cellspacing="0" cellpadding="0" border="0" class="section">
         <tbody>
         <tr>
         <td style="width: 60%; vertical-align: top;">&nbsp;
         </td>
         <td style="width: 40%; vertical-align: top;">
         <table width="100%" cellspacing="2" cellpadding="2" border="0" style="float: right;">
         <tbody>
         <tr>
         <td class="subtotal_label">
         Subtotal &nbsp;
         </td>
         <td class="subtotal_text">_Invoice.Subtotal_<br />
         </td>
         </tr>
         <tr>
         <td class="subtotal_label">
         Tax &nbsp;
         </td>
         <td class="subtotal_text">_Invoice.Tax_<br />
         </td>
         </tr>
         <tr>
         <td class="subtotal_label" style="width: 25%; font-weight: bold;">
         Total &nbsp;
         </td>
         <td class="subtotal_text" style="width: 75%;">_Invoice.Total_<br />
         </td>
         </tr>
         </tbody>
         </table>
         </td>
         </tr>
         </tbody>
         </table>
         <!-- Notes -->
         <table cellspacing="0" cellpadding="0" border="0" class="section">
         <tbody>
         <tr>
         <td class="print_heading">
         Notes
         </td>
         </tr>
         <tr>
         <td>_InvoiceNotes_<br />
         </td>
         </tr>
         </tbody>
         </table>
         <!-- Terms -->
         <table cellspacing="0" cellpadding="0" border="0" class="section">
         <tbody>
         <tr>
         <td class="print_heading">
         Terms
         </td>
         </tr>
         <tr>
         <td>
         _Terms_<br />
         </td>
         </tr>
         </tbody>
         </table>
         <!-- Signature -->
         <table cellspacing="0" cellpadding="0" border="0" class="section">
         <tbody>
         <tr>
         <td style="width: 50%;">
         <a href="http://i63.tinypic.com/4fze52.jpg" target="_blank"><img style="border-width: 0px; border-style: solid;" src="http://i63.tinypic.com/4fze52.jpg" alt="Image and video hosting by TinyPic" /></a>
         </td>
         <td style="width: 50%;">
         <table cellspacing="6" cellpadding="2" border="0" style="width: 100%;">
         <tbody>
         <tr>
         <td colspan="2">&nbsp;
         </td>
         </tr>
         <tr>
         <td style="width: 75%; border-bottom: 1px solid #000000;">
         <br />
         _Invoice.Signature_<br />
         </td>
         <td valign="bottom" style="width: 22%; border-bottom: 1px solid #000000;">
         <br />
         _Invoice.SignatureDate_<br />
         </td>
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
         </div>
         
         
</body>
</html>