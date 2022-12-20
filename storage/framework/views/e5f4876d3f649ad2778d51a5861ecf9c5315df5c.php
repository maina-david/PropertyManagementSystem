<!doctype html>
<html>
   <head>
      <meta name="viewport" content="width=device-width" />
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title><?php echo $subject; ?></title>
      <style>
         img {
         border: none;
         -ms-interpolation-mode: bicubic;
         max-width: 100%;
         }

         body {
         background-color: #f6f6f6;
         font-family: sans-serif;
         -webkit-font-smoothing: antialiased;
         font-size: 14px;
         line-height: 1.4;
         margin: 0;
         padding: 0;
         -ms-text-size-adjust: 100%;
         -webkit-text-size-adjust: 100%;
         }

         table {
         border-collapse: separate;
         mso-table-lspace: 0pt;
         mso-table-rspace: 0pt;
         width: 100%; }
         table td {
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top;
         }

         .body {
         background-color: #f6f6f6;
         width: 100%;
         }

         .container {
         display: block;
         margin: 0 auto !important;
         /* makes it centered */
         max-width: 580px;
         padding: 10px;
         width: 580px;
         }

         .content {
         box-sizing: border-box;
         display: block;
         margin: 0 auto;
         max-width: 580px;
         padding: 10px;
         }

         .main {
         background: #ffffff;
         border-radius: 3px;
         width: 100%;
         }

         .wrapper {
         box-sizing: border-box;
         padding: 20px;
         }

         .content-block {
         padding-bottom: 10px;
         padding-top: 10px;
         }

         .footer {
         clear: both;
         margin-top: 10px;
         text-align: center;
         width: 100%;
         }
         .footer td,
         .footer p,
         .footer span,
         .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center;
         }

         h1,
         h2,
         h3,
         h4 {
         color: #000000;
         font-family: sans-serif;
         font-weight: 400;
         line-height: 1.4;
         margin: 0;
         margin-bottom: 30px;
         }

         h1 {
         font-size: 35px;
         font-weight: 300;
         text-align: center;
         text-transform: capitalize;
         }

         p,
         ul,
         ol {
         font-family: sans-serif;
         font-size: 14px;
         font-weight: normal;
         margin: 0;
         margin-bottom: 15px;
         }
         p li,
         ul li,
         ol li {
            list-style-position: inside;
            margin-left: 5px;
         }

         a {
         color: #3498db;
         text-decoration: underline;
         }

         .btn {
         box-sizing: border-box;
         width: 100%; }
         .btn > tbody > tr > td {
            padding-bottom: 15px; }
         .btn table {
            width: auto;
         }
         .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center;
         }
         .btn a {
            background-color: #ffffff;
            border: solid 1px #3498db;
            border-radius: 5px;
            box-sizing: border-box;
            color: #3498db;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: capitalize;
         }

         .btn-primary table td {
         background-color: #3498db;
         }

         .btn-primary a {
         background-color: #3498db;
         border-color: #3498db;
         color: #ffffff;
         }

         .last {
         margin-bottom: 0;
         }

         .first {
         margin-top: 0;
         }

         .align-center {
         text-align: center;
         }

         .align-right {
         text-align: right;
         }

         .align-left {
         text-align: left;
         }

         .clear {
         clear: both;
         }

         .mt0 {
         margin-top: 0;
         }

         .mb0 {
         margin-bottom: 0;
         }

         .preheader {
         color: transparent;
         display: none;
         height: 0;
         max-height: 0;
         max-width: 0;
         opacity: 0;
         overflow: hidden;
         mso-hide: all;
         visibility: hidden;
         width: 0;
         }

         .powered-by a {
         text-decoration: none;
         }

         hr {
         border: 0;
         border-bottom: 1px solid #f6f6f6;
         margin: 20px 0;
         }
         @media  only screen and (max-width: 620px) {
         table[class=body] h1 {
            font-size: 28px !important;
            margin-bottom: 10px !important;
         }
         table[class=body] p,
         table[class=body] ul,
         table[class=body] ol,
         table[class=body] td,
         table[class=body] span,
         table[class=body] a {
            font-size: 16px !important;
         }
         table[class=body] .wrapper,
         table[class=body] .article {
            padding: 10px !important;
         }
         table[class=body] .content {
            padding: 0 !important;
         }
         table[class=body] .container {
            padding: 0 !important;
            width: 100% !important;
         }
         table[class=body] .main {
            border-left-width: 0 !important;
            border-radius: 0 !important;
            border-right-width: 0 !important;
         }
         table[class=body] .btn table {
            width: 100% !important;
         }
         table[class=body] .btn a {
            width: 100% !important;
         }
         table[class=body] .img-responsive {
            height: auto !important;
            max-width: 100% !important;
            width: auto !important;
         }
         }
         @media  all {
         .ExternalClass {
            width: 100%;
         }
         .ExternalClass,
         .ExternalClass p,
         .ExternalClass span,
         .ExternalClass font,
         .ExternalClass td,
         .ExternalClass div {
            line-height: 100%;
         }
         .apple-link a {
            color: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            text-decoration: none !important;
         }
         .btn-primary table td:hover {
            background-color: #34495e !important;
         }
         .btn-primary a:hover {
            background-color: #34495e !important;
            border-color: #34495e !important;
         }
         }

         sub, sup {
            position: relative;
            font-size: 45%;
            line-height: 0;
            vertical-align: baseline;
         }
         sup {
            top: -1.5em;
         }
      </style>
   </head>
   <body class="">
      <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
         <tr>
            <td>&nbsp;</td>
            <td class="container">
               <div class="content">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                     <tr>
                        <td class="content-block powered-by">
                           <center>
                              <img src="<?php echo asset('assets/img/logo-long.png'); ?>" alt="property wingu" class="img" width="40%">
                           </center>
                        </td>
                     </tr>
                  </table>
                  <!-- START CENTERED WHITE CONTAINER -->
                  <span class="preheader"><?php echo $subject; ?></span>
                  <table role="presentation" class="main">
                     <!-- START MAIN CONTENT AREA -->
                     <tr>
                        <td class="wrapper">
                           <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td>
                                    <center><h2><?php echo $subject; ?></h2></center>
                                    <hr>
                                    <?php echo $content; ?>

                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <!-- END MAIN CONTENT AREA -->
                  </table>
                  <!-- START FOOTER -->
                  <div class="footer">
                     <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                           <td class="content-block">
                              <a href="https://www.facebook.com/propertywingu"><img src="<?php echo asset('assets/img/icons/facebook.png'); ?>" alt="property wingu facebook link" style="width:55px;height:55px"/></a>
                              <a href="https://twitter.com/propertywingu"><img src="<?php echo asset('assets/img/icons/twitter.png'); ?>" alt="property wingu twitter link" style="width:55px;height:55px"/></a>
                              <a href="https://www.linkedin.com/company/propertywingu"><img src="<?php echo asset('assets/img/icons/linkedin.png'); ?>" alt="property wingu linkedin link" style="width:55px;height:55px"/></a>
                              <a href="https://wa.me/254700928867?text=Am interested in Property wingu, i would like to know more" target="_blank"><img src="<?php echo asset('assets/img/icons/whatsapp.png'); ?>" alt="property wingu whatsapp link" style="width:55px;height:55px"/></a>
                           </td>
                        </tr>
                        <tr>
                           <td class="content-block">
                              <span class="apple-link">
                                 Copyright © <?php echo date('Y') ?> <a href="https://propertywingu.com/" target="_blank">Property wingu</a>, All rights reserved.
                              </span>
                           </td>
                        </tr>
                     </table>
                  </div>
                  <!-- END FOOTER -->
                  <!-- END CENTERED WHITE CONTAINER -->
               </div>
            </td>
            <td>&nbsp;</td>
         </tr>
      </table>
   </body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/email/system_mail.blade.php ENDPATH**/ ?>