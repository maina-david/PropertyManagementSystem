<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
      <title>Invoice | <?php echo Finance::invoice_settings()->prefix; ?>00<?php echo $details->number; ?></title>
      <link rel="stylesheet" href="<?php echo url('/'); ?>/resources/views/templates/invoices/default/style.css" media="all" />
   </head>
   <body>
      <div id="page-wrap">
         <table width="100%">
            <tr>
               <td style="border: 0;  text-align: left" width="62%">
                  <?php if(Limitless::business(Auth::user()->businessID)->logo != ""): ?>
                     <img src="<?php echo url('/'); ?>/storage/files/business/<?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?>/documents/images/<?php echo Limitless::business(Auth::user()->businessID)->logo; ?>" id="image" alt="logo" style="width:20%">
                  <?php endif; ?>
                  <br><br>
                  <span style="font-size: 18px; color: #2f4f4f"><strong>INVOICE: #<?php echo Finance::invoice_settings()->prefix; ?>00<?php echo $details->number; ?></strong></span>
               </td>
               <td style="border: 0;  text-align: right" width="62%">
                  <div id="logo">
                     <strong><?php echo Limitless::business(Auth::user()->businessID)->name; ?></strong> <br>
                     <p>
                        <?php echo Limitless::business(Auth::user()->businessID)->street; ?>,<?php echo Limitless::business(Auth::user()->businessID)->city; ?><br>
                        <?php echo Limitless::business(Auth::user()->businessID)->postal_address; ?> - <?php echo Limitless::business(Auth::user()->businessID)->zip_code; ?><br>
                        <b>Phone:</b> <?php echo Limitless::business(Auth::user()->businessID)->primary_phonenumber; ?><br>
                        <b>Email:</b> <?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?>

                     </p>                
                  </div>
               </td>
            </tr>
         </table>
         <hr><br>
         <div style="clear:both"></div>
         <div id="customer">
            <table id="meta">
               <tr>
                  <td rowspan="5" class="clean_sheet">
                     <strong>Invoiced To</strong><br>
                     <?php if($client->company_name != ""): ?><?php echo $client->company_name; ?><?php else: ?><?php echo $client->client_name; ?><?php endif; ?><br>
                     <?php if($client->bill_attention != ""): ?><strong>ATTN :</strong><?php echo $client->bill_attention; ?><br><?php endif; ?><br>
                     <?php if($client->bill_state != ""): ?><?php echo $client->bill_state; ?>,<?php endif; ?>
                     <?php if($client->bill_city != ""): ?><?php echo $client->bill_city; ?>,<?php endif; ?>
                     <?php if($client->bill_street != ""): ?><?php echo $client->bill_street; ?><?php endif; ?><br>
                     <?php if($client->bill_street != ""): ?>
                        <?php echo $client->bill_zip_code; ?><br>
                        <?php echo Limitless::country($client->bill_country)->name; ?>

                     <?php endif; ?>
                  </td>
                  <td class="meta-head">INVOICE #</td>
                  <td><?php echo Finance::invoice_settings()->prefix; ?>00<?php echo $details->number; ?></td>
               </tr>
               <tr>
                  <td class="meta-head">Status</td>
                  <td>
                     <?php if($details->statusID == 1): ?>
                        <p style="color:green;font-style: normal;font-weight: bolder;"><?php echo ucfirst(Limitless::status($details->statusID)->name); ?></p>
                     <?php else: ?>
                     <p style="color:blue;font-style: normal;font-weight: bolder;"><?php echo ucfirst(Limitless::status($details->statusID)->name); ?></p>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <td class="meta-head">Invoice Date</td>
                  <td><?php echo date('F j, Y',strtotime($details->invoice_date)); ?></td>
               </tr>
               <tr>
                  <td class="meta-head">Due Date</td>
                  <td><?php echo date('F j, Y',strtotime($details->invoice_due)); ?></td>
               </tr>
               <tr>
                  <td class="meta-head">Amount Due</td>
                  <td><div class="due"><?php echo number_format($details->total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?></div></td>
               </tr>
            </table>
         </div>
         <table id="items">
            <tr>
               <th width="1%">#</th>
               <th width="40%">Description</th>
               <th align="center">Previous</th>
               <th align="center">Current</th>
               <th align="center">Consumption</th>
               <th align="center">Rate</th>
               <th align="center">Amount</th>
            </tr>
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
            <tr>
               <td colspan="3"></td>
               <td colspan="3" align="right"><strong>Sub Total </strong></td>
               <td align="right"><?php echo number_format($details->sub_total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?></td>
            </tr>
            <?php if(Finance::invoice_settings()->show_discount_tab == 'Yes'): ?>
               <tr>
                  <td colspan="3"></td>
                  <td colspan="3" align="right"><strong>Discount </strong></td>
                  <td align="right">
                     <?php echo $details->sub_total * ($details->discount / 100)  ?> <?php echo Finance::currency($details->currencyID)->code; ?>

                  </td>
               </tr>
            <?php endif; ?>
            <?php if(Finance::invoice_settings()->show_tax_tab == 'Yes'): ?>
               <tr>
                  <td colspan="3"></td>
                  <td colspan="3" align="right"><strong>Tax - <?php echo $details->tax; ?>%</strong></td>
                  <td align="right">
                     <?php echo $taxed; ?>  <?php echo Finance::currency($details->currencyID)->code; ?>

                  </td>
               </tr>
            <?php endif; ?>
            <tr>
               <td colspan="3"></td>
               <td colspan="3" align="right"><strong>TOTAL </strong></td>
               <td align="right"><?php echo number_format($details->total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?></td>
            </tr>
         </table>
         <center><button class='button -dark center no-print'  onClick="window.print();">Click Here to Print or save as print-to-PDF</button></center>
      </div>
   </body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/default/hold.blade.php ENDPATH**/ ?>