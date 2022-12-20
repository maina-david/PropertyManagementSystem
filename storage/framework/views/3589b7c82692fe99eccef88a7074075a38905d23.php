<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Invoice | <?php echo Finance::invoice_settings()->prefix; ?>00<?php echo $details->number; ?></title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="<?php echo url('/'); ?>/resources/views/templates/bootstrap-3/style.css" media="all" />

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
            <h4>From:</h4>
            <strong><?php echo Limitless::business(Auth::user()->businessID)->name; ?></strong><br>
            <?php echo Limitless::business(Auth::user()->businessID)->street; ?>,<?php echo Limitless::business(Auth::user()->businessID)->city; ?><br>
            <?php echo Limitless::business(Auth::user()->businessID)->postal_address; ?> - <?php echo Limitless::business(Auth::user()->businessID)->zip_code; ?><br>
            <b>Phone:</b> <?php echo Limitless::business(Auth::user()->businessID)->primary_phonenumber; ?><br>
            <b>Email:</b> <?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?>

            <br>
         </div>

         <div class="col-xs-4">
            <?php if(Limitless::business(Auth::user()->businessID)->logo != ""): ?>
               <img src="<?php echo url('/'); ?>/storage/files/business/<?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?>/documents/images/<?php echo Limitless::business(Auth::user()->businessID)->logo; ?>" id="image" alt="logo" style="width:20%">
            <?php endif; ?>
         </div>
      </div>
      <div style="margin-bottom: 0px">&nbsp;</div>
      <div class="row">
         <div class="col-xs-6">
            <h4>To:</h4>
            <address>
               <strong><?php if($client->company_name != ""): ?><?php echo $client->company_name; ?><?php else: ?><?php echo $client->client_name; ?><?php endif; ?></strong><br>
               <span><?php if($client->company_name != ""): ?><?php echo $client->company_name; ?><?php else: ?><?php echo $client->client_name; ?><?php endif; ?></span><br>
               <span><?php if($client->bill_attention != ""): ?><strong>ATTN :</strong><?php echo $client->bill_attention; ?><br><?php endif; ?></span><br>
               <span><?php if($client->bill_state != ""): ?><?php echo $client->bill_state; ?>,<?php endif; ?></span>
               <span><?php if($client->bill_city != ""): ?><?php echo $client->bill_city; ?>,<?php endif; ?></span>
               <span><?php if($client->bill_street != ""): ?><?php echo $client->bill_street; ?><?php endif; ?></span><br>
               <span><?php if($client->bill_street != ""): ?>
                  <?php echo $client->bill_zip_code; ?><br>
                  <?php echo Limitless::country($client->bill_country)->name; ?>

               <?php endif; ?></span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <th>Status</th>
                     <td class="text-right">
                        <?php if($details->statusID == 1): ?>
                           <p style="color:green;font-style: normal;font-weight: bolder;"><?php echo ucfirst(Limitless::status($details->statusID)->name); ?></p>
                        <?php else: ?>
                        <p style="color:blue;font-style: normal;font-weight: bolder;"><?php echo ucfirst(Limitless::status($details->statusID)->name); ?></p>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <tr>
                     <th>Invoice Date</th>
                     <td class="text-right"><?php echo date('F j, Y',strtotime($details->invoice_date)); ?></td>
                  </tr>
                  <tr>
                     <th>Due Date</th>
                     <td class="text-right"><?php echo date('F j, Y',strtotime($details->invoice_due)); ?></td>
                  </tr>
               </tbody>
            </table>
            <div style="margin-bottom: 0px">&nbsp;</div>
            <table style="width: 100%; margin-bottom: 20px">
               <tbody>
                  <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><div> Amount Due </div></th>
                        <td style="padding: 5px" class="text-right"><strong> <?php echo number_format($details->total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?> </strong></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="40%">Description</th>
               <th align="center">Previous</th>
               <th align="center">Current</th>
               <th align="center">Consumption</th>
               <th align="center">Rate</th>
               <th align="center">Amount</th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr class="item-row">
                  <td align="center"><?php echo e($count++); ?></td>
                  <td class="description">
                     <?php if($product->productID == 0): ?>
                        <?php echo e($product->product_name); ?>

                     <?php else: ?>
                        <?php if(Finance::check_product($product->productID) == 1 ): ?>
                           <?php echo Finance::product($product->productID)->product_name; ?>

                        <?php else: ?>
                           <i>Unknown Product</i>
                        <?php endif; ?>
                     <?php endif; ?>
                  </td>
                  <td align="center"><?php echo $product->previous_units; ?></td>
                  <td align="center"><?php echo $product->current_units; ?></td>
                  <td align="center"><?php echo e($product->quantity); ?></td>
                  <td align="center">
                     <?php echo e(number_format($product->selling_price)); ?> <?php echo Finance::currency($details->currencyID)->code; ?>

                  </td>
                  <td align="right">
                     <span class="price">
                        <?php echo number_format($product->quantity * $product->selling_price) ?> <?php echo Finance::currency($details->currencyID)->code; ?>

                     </span>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
      <div class="row">
         <div class="col-xs-6"></div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><div>Sub Total </div></th>
                     <td style="padding: 5px" class="text-right"><strong><?php echo number_format($details->sub_total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?><strong></td>
                  </tr>
                  <?php if(Finance::invoice_settings()->show_discount_tab == 'Yes'): ?>
                     <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><strong>Discount </strong></th>
                        <td style="padding: 5px" class="text-right">
                           <strong>
                              <?php echo $details->sub_total * ($details->discount / 100)  ?> <?php echo Finance::currency($details->currencyID)->code; ?>

                           </strong>
                        </td>
                     </tr>
                  <?php endif; ?>
                  <?php if(Finance::invoice_settings()->show_tax_tab == 'Yes'): ?>
                     <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><strong>Tax - <?php echo $details->tax; ?>%</strong></th>
                        <td style="padding: 5px" class="text-right">
                           <strong>
                              <?php echo $taxed; ?>  <?php echo Finance::currency($details->currencyID)->code; ?>

                           </strong>
                        </td>
                     </tr>
                  <?php endif; ?>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL </strong></th>
                     <td style="padding: 5px" class="text-right">
                        <strong>
                           <?php echo number_format($details->total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?>

                        </strong>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-8 invbody-terms">
            Thank you for your business. 
            <br><br>
            <?php if($details->customer_note != ""): ?>
               <div class="notice">
                  <?php echo $details->customer_note; ?>

               </div>
            <?php endif; ?>
            <?php if($details->terms != ""): ?>
               <div class="notice">
                  <h4>Terms & Conditions</h4>
                  <?php echo $details->terms; ?>

               </div>
            <?php endif; ?>
         </div>
      </div>
   </div>

</body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/invoices/bootstrap-3/invoice.blade.php ENDPATH**/ ?>