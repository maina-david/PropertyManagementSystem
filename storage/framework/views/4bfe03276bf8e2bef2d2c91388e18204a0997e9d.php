<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
      <title>Invoice | <?php echo Finance::invoice_settings()->prefix; ?><?php echo $details->number; ?></title>
      <link rel="stylesheet" href="<?php echo asset('assets/templates/bootstrap-3/style.css'); ?>" media="all" />
   </head>
   <body>
      <div id="page-wrap">
         <table width="100%" border="0">
            <tr>
               <td style="text-align: center">
                  <strong><?php echo Limitless::business(Auth::user()->businessID)->name; ?></strong> <br>                 
                  <?php echo Limitless::business(Auth::user()->businessID)->street; ?>,<?php echo Limitless::business(Auth::user()->businessID)->city; ?><br>
                  <?php echo Limitless::business(Auth::user()->businessID)->postal_address; ?> - <?php echo Limitless::business(Auth::user()->businessID)->zip_code; ?><br>
                  <b>Phone:</b> <?php echo Limitless::business(Auth::user()->businessID)->primary_phonenumber; ?><br>
                  <b>Email:</b> <?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?>

               </td>
            </tr>
         </table>
         <div style="clear:both"></div>
         <div id="customer">
            <table id="meta">               
               <tr>
                  <td>Date</td>
                  <td><?php echo date('F j, Y',strtotime($details->invoice_date)); ?></td>
               </tr>
               <tr>
                  <td>Amount Due</td>
                  <td><div class="due"><?php echo number_format($details->total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?></div></td>
               </tr>
            </table>
         </div>
         <table id="">
            <tr>
               <th align="right" width="1%">#</th>
               <th width="55%">Description</th>
               <th align="center">Price</th>
               <th align="center">Qty</th>
               <th align="center">Total</th>
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
                  <td align="center">
                     <?php echo e(number_format($product->selling_price)); ?> <?php echo Finance::currency($details->currencyID)->code; ?>

                  </td>
                  <td align="center"><?php echo e($product->quantity); ?></td>
                  <td align="right">
                     <span class="price">
                        <?php echo number_format($product->quantity * $product->selling_price) ?> <?php echo Finance::currency($details->currencyID)->code; ?>

                     </span>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td colspan="2"></td>
               <td colspan="2" align="right"><strong>Sub Total </strong></td>
               <td align="right"><?php echo number_format($details->sub_total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?></td>
            </tr>
            <?php if(Finance::invoice_settings()->show_discount_tab == 'Yes'): ?>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2" align="right"><strong>Discount </strong></td>
                  <td align="right">
                     <?php echo $details->sub_total * ($details->discount / 100)  ?> <?php echo Finance::currency($details->currencyID)->code; ?>

                  </td>
               </tr>
            <?php endif; ?>
            <?php if(Finance::invoice_settings()->show_tax_tab == 'Yes'): ?>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2" align="right"><strong>Tax - <?php echo $details->tax; ?>%</strong></td>
                  <td align="right">
                     
                  </td>
               </tr>
            <?php endif; ?>
            <tr>
               <td colspan="2"></td>
               <td colspan="2" align="right"><strong>TOTAL </strong></td>
               <td align="right"><?php echo number_format($details->total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?></td>
            </tr>
         </table>
         <center><button class='button -dark center no-print'  onClick="window.print();">Click Here to Print</button></center>
      </div>
   </body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/pos-receipt.blade.php ENDPATH**/ ?>