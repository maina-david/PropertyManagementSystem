<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Invoice | <?php echo Finance::invoice_settings()->prefix; ?>00<?php echo $details->number; ?></title>
      <link rel="stylesheet" href="<?php echo url('/'); ?>/resources/views/templates/blue/style.css" media="all" />
   </head>
   <body>
      <header class="clearfix">
         <div id="logo">
            <?php if(Limitless::business(Auth::user()->businessID)->logo != ""): ?>
               <img src="<?php echo url('/'); ?>/storage/files/business/<?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?>/documents/images/<?php echo Limitless::business(Auth::user()->businessID)->logo; ?>">
            <?php endif; ?>
         </div>
         <div id="company">
            <h2 class="name"><?php echo Limitless::business(Auth::user()->businessID)->name; ?></h2>
            <div><?php echo Limitless::business(Auth::user()->businessID)->street; ?>,<?php echo Limitless::business(Auth::user()->businessID)->city; ?></div>
            <div> <?php echo Limitless::business(Auth::user()->businessID)->zip_code; ?></div>
            <div>Phone: <?php echo Limitless::business(Auth::user()->businessID)->primary_phonenumber; ?></div>
            <div>Email: <?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?></div>
         </div>
      </header>
      <main>
         <div id="details" class="clearfix">
            <div id="client">
               <div class="to">INVOICE TO:</div>
               <h2 class="name"><?php if($client->company_name != ""): ?><?php echo $client->company_name; ?><?php else: ?><?php echo $client->client_name; ?><?php endif; ?></h2>
               <div class="address">
                  <?php if($client->bill_street != ""): ?><?php echo $client->bill_street; ?><br><?php endif; ?>
                  <?php if($client->bill_country != ""): ?>
                     <?php echo Limitless::country($client->countryID)->name; ?>

                  <?php endif; ?>
               </div>
               <div class="email"><a href="mailto:<?php echo $client->email; ?>"><?php echo $client->email; ?></a></div>
            </div>
            <div id="invoice">
               <h1>INVOICE</h1>
               <?php if($details->status == 1): ?>
                  <a href="#" class="btn btn-success">Paid</a>
               <?php endif; ?>
               <h3>#<?php echo Finance::invoice_settings()->prefix; ?>00<?php echo $details->invoice_number; ?></h3>
               <div class="date"><b>Date of Invoice:</b> <?php echo date('F j, Y',strtotime($details->invoice_date)); ?></div>
               <div class="date"><b>Due Date:</b> <?php echo date('F j, Y',strtotime($details->invoice_due)); ?></div>
            </div>
         </div>
         <table border="0" cellspacing="0" cellpadding="0">
            <thead>
               <tr>
                  <th class="no">#</th>
                  <th class="desc">DESCRIPTION</th>
                  <th class="unit">UNIT PRICE</th>
                  <th class="qty">QUANTITY</th>
                  <th class="total">TOTAL</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td class="no"><?php echo e($count++); ?></td>
                     <td class="desc">

                        <?php if($product->productID == 0): ?>
                           <?php echo e($product->product_name); ?>

                        <?php else: ?>
                           <?php if(Finance::check_product($product->productID) == 1 ): ?>
                              <strong><?php echo Finance::product($product->productID)->product_name; ?></strong>
                           <?php else: ?>
                              <i>Unknown Product</i>
                           <?php endif; ?>
                        <?php endif; ?>
                     </td>
                     <td class="unit"><?php echo e(number_format($product->selling_price)); ?> <?php echo Finance::currency($details->currencyID)->code; ?></td>
                     <td class="qty"><?php echo e($product->quantity); ?></td>
                     <td class="total"><?php echo number_format($product->quantity * $product->selling_price) ?> <?php echo Finance::currency($details->currencyID)->code; ?></td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>Sub Total :</strong></td>
                  <td><?php echo number_format($details->sub_total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?></td>
               </tr>
               <?php if(Finance::invoice_settings()->show_discount_tab == 'Yes'): ?>
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Discount :</strong></td>
                     <td>
                        <?php echo $details->sub_total * ($details->discount / 100)  ?> <?php echo Finance::currency($details->currencyID)->code; ?>

                     </td>
                  </tr>
               <?php endif; ?>
               <?php if(Finance::invoice_settings()->show_tax_tab == 'Yes'): ?>
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Tax - <?php echo $details->tax; ?>% :</strong></td>
                     <td>
                        <?php echo $taxed; ?>  <?php echo Finance::currency($details->currencyID)->code; ?>

                     </td>
                  </tr>
               <?php endif; ?>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>TOTAL :</strong></td>
                  <td><?php echo number_format($details->total); ?>.00 <?php echo Finance::currency($details->currencyID)->code; ?></td>
               </tr>
            </tfoot>
         </table>
         <?php if($details->invoice_note != ""): ?>
            <div class="notice">
               Client Note
               <?php echo $details->invoice_note; ?>

            </div>
         <?php endif; ?>
         <?php if($details->terms != ""): ?>
            <div class="notice">
               <h4>Terms & Conditions</h4>
               <?php echo $details->terms; ?>

            </div>
         <?php endif; ?>
         <div id="thanks">Thank you!</div>
         <center><button class='btn btn-pink no-print'  onClick="window.print();">Click Here to Print or save as print-to-PDF</button></center>
      </main>
   </body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/blue/invoice.blade.php ENDPATH**/ ?>