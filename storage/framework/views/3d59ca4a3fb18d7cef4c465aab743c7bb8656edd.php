<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Delivery note </title>
      <link rel="stylesheet" href="<?php echo url('/'); ?>/resources/views/templates/invoices/blue/style.css" media="all" />
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
            <div><?php echo Limitless::business(Auth::user()->businessID)->postal_address; ?> - <?php echo Limitless::business(Auth::user()->businessID)->zip_code; ?></div>
            <div>Phone: <?php echo Limitless::business(Auth::user()->businessID)->primary_phonenumber; ?></div>
            <div>Email: <?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?></div>
         </div>
      </header>
      <main>
         <div id="details" class="clearfix">
            <div id="client">
               <div class="to">TO:</div>
               <h2 class="name"><?php if($client->company_name != ""): ?><?php echo $client->company_name; ?><?php else: ?><?php echo $client->client_name; ?><?php endif; ?></h2>
               <div class="address">
                  <?php if($client->bill_attention != ""): ?>
                     <strong>ATTN :</strong>
                     <?php echo $client->bill_attention; ?><br>
                  <?php endif; ?>
                  <?php if($client->bill_state != ""): ?><?php echo $client->bill_state; ?>,<?php endif; ?>
                  <?php if($client->bill_city != ""): ?><?php echo $client->bill_city; ?>,<?php endif; ?>
                  <?php if($client->bill_street != ""): ?><?php echo $client->bill_street; ?><?php endif; ?>
                  <br>
                  <?php if($client->bill_street != ""): ?>
                     <?php echo $client->bill_zip_code; ?><br>
                     <?php echo Limitless::country($client->bill_country)->name; ?>

                  <?php endif; ?>
               </div>
               <div class="email"><a href="mailto:<?php echo $client->email; ?>"><?php echo $client->email; ?></a></div>
            </div>
            <div id="invoice">
               <h1>Delivery note</h1>
               <div class="date"><b>Delivery Note #:</b> 00<?php echo $details->invoice_number; ?></div>
               <div class="date"><b>Delivery Note Date :</b> <?php echo date('F j, Y',strtotime($details->invoice_date)); ?></div>
               <div class="date"><b>Order Number :</b> <?php echo $details->lpo_number; ?></div>
            </div>
         </div>
         <table border="0" cellspacing="0" cellpadding="0">
            <thead>
               <tr>
                  <th class="desc">QUANTITY</th>
                  <th class="desc">DESCRIPTION</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td class="desc"><?php echo e($product->quantity); ?></td>
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
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
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
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/blue/deliverynote.blade.php ENDPATH**/ ?>