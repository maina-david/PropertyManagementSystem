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
            font-size: 13px;
            width: 100%;
            font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;
            text-align: left;
            }
            .section
            {
            width: 100%;
            margin-bottom: 20px;
            padding: 0 0;
            border-collapse: collapse;
            border-spacing: 0;
            /*page-break-inside: avoid;*/
            }
            .leftbox, .rightbox
            {
            width: 48%;
            background-color: #F3F3F3;
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
            }
            .print_heading, .ticket_heading, .mycompany_heading
            {
            text-align: left;
            font-weight: bold;
            color: #000000;
            background-color: #CCCCCC;
            border-collapse: collapse;
            border-spacing: 0;
            border-bottom: 0px;
            border-top: 1px solid #CCCCCC;
            border-left: 1px solid #CCCCCC;
            border-right: 1px solid #CCCCCC;
            padding: 3px 3px;
            }
            .customer_body
            {
            padding: 3px 3px;
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
            border: 1px solid #CCCCCC;
            border-collapse: collapse;
            border-spacing: 0;
            padding: 2px 2px;
            }
            .ticket_text, .ticket_text2, .wotext, .wotext_number, .amountdue_text, .asset_text
            {
            text-align: left;
            vertical-align: top;
            color: #000000;
            background-color: #FFFFFF;
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
            }
            .customer_section, .customer_label, .customer_text, .contact_section, .wolabel
            {
            text-align: left;
            background-color: #F3F3F3;
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
            }
            .subtotal_text
            {
            border-bottom: solid 1px #999999;
            text-align: right;
            }
            .signature
            {
            width: 216px;
            page-break-inside: avoid;
            }
            .my_company_logo img
            {
            height: auto;
            width: auto;
            }
            #item td{
            border: none;
            background-color: #f1f1f2;
            }
            #item tr:first-child td{
            background-color: #f1f1f2;
            border:none;
            border-bottom: 1px solid #000000;
            }
            .grey{
            }
            .item_approved {display: none;}
        </style>
        <div class="print_page_container">
        <table class="section">
            <tbody>
                <tr>
                    <td style="width: 5%; text-align: left; vertical-align: middle;"> </td>
                    <td style="width: 28%; text-align: left; vertical-align: middle;">
                    <span style="font-size: 48px;">Estimate</span><br />
                    <span style="font-family: 'Brush Script MT',cursive; color: #1a8bb0;">for</span> <span style="color: #1a8bb0;">_CustomerInfo_</span>
                    </td>
                    <td style="width: 33%; text-align: right;"> </td>
                    <td class="my_company_logo" style="width: 28%; text-align: right; vertical-align: top;">
                    _MyCompanyLogo_ <br />
                    _MyCompanyAddress_<br />
                    _MyCompanyPhone_ <br />
                    <span style="font-size: 18px; color: #1a8bb0;">_MyCompanyWebsite_</span>
                    </td>
                    <td style="width: 5%; text-align: left; vertical-align: middle;"> </td>
                </tr>
            </tbody>
        </table>
        <div style="padding: 15px; background-color: #f1f1f2;">
        <img alt="" style="width: 50px; height: auto; margin-top: -20px; margin-left: 100px; position: absolute;" src="http://i60.tinypic.com/2hhq5xg.png" />
        <br />
        <br />
        <table class="section">
            <tbody>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 90%;" id="item"><strong><span style="font-size: 18px;">Estimate No. _EstimateID_</span></strong> Issued on _EstimateDate_</td>
                    <td style="width: 5%;"> </td>
                </tr>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 90%;"> </td>
                    <td style="width: 5%;"> </td>
                </tr>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 90%;" id="item">_Estimate.Items_</td>
                    <td style="width: 5%;"> </td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <br />
        <table class="section">
            <tbody>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 55%; border-bottom: 1px solid #000000;"> </td>
                    <td style="width: 17%; border-bottom: 1px solid #000000;"> </td>
                    <td style="width: 18%; border-bottom: 1px solid #000000;"> </td>
                    <td style="width: 5%;"> </td>
                </tr>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 55%; vertical-align: top;"> </td>
                    <td style="width: 17%; vertical-align: top; text-align: right;"><strong>tax</strong></td>
                    <td style="width: 18%; vertical-align: top; text-align: right;"><strong>_Estimate.tax_</strong></td>
                    <td style="width: 5%;"> </td>
                </tr>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 55%; vertical-align: top;"> </td>
                    <td style="width: 17%; vertical-align: top; text-align: right;"><strong>estimated total</strong></td>
                    <td style="width: 18%; vertical-align: top; text-align: right;"><strong>_Estimate.total_</strong></td>
                    <td style="width: 5%;"> </td>
                </tr>
            </tbody>
        </table>
        </div>
        <br />
        <br />
        <br />
        <table class="section">
            <tbody>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 90%; border-bottom: 1px solid #000000; padding-bottom: 5px;"><br />
                    </td>
                    <td style="width: 5%;"> </td>
                </tr>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 90%; border-bottom: 1px solid #000000; padding-bottom: 5px; vertical-align: bottom;">
                    <span style="font-size: 42px;"> THANK YOU </span> <span style="font-family: 'Brush Script MT',cursive; color: #1a8bb0;">for</span> <span style="color: #1a8bb0;"><span style="font-size: 12px;">considering </span><span style="font-size: 12px; font-family: Candara, Calibri, Segoe, 'Segoe UI', Optima, Arial, sans-serif;">_MyCompanyName_</span></span></td>
                    <td style="width: 5%;"> </td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <br />
        <table class="section">
            <tbody>
                <tr>
                    <td style="width: 5%;"> </td>
                    <td style="width: 35%; vertical-align: top;">
                    <span style="color: #1a8bb0;"><strong>QUESTIONS? CONTACT US</strong></span>
                    <br />
                    <br />
                    _MyCompanyEmail_ <br />
                    _MyCompanyPhone_
                    <br />
                    <br />
                    <img style="border-width: 0px; border-style: solid; text-align: center;" alt="Image and video hosting by imgur" src="http://i.imgur.com/KCxtQGL.png" height="42" width="111" /><br />
                    </td>
                    <td style="width: 55%; vertical-align: top;">
                    <span style="color: #1a8bb0;"><strong>TERMS &amp; CONDITIONS</strong></span>
                    <br />
                    <br />
                    We accept payment by check, cash and credit. Please send checks to our main address or call with credit card info.
                    <br />
                    <br />
                    <table class="section">
                        <tbody>
                            <tr>
                                <td>
                                NOTE:
                                _EstimateNotes_</td>
                            </tr>
                            <tr>
                                <td>
                                <br />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                    <td style="width: 5%;"> </td>
                </tr>
            </tbody>
        </table>
        </div>
        
                    
   </body>
</html>