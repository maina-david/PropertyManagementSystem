<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>LPO | <?php echo Finance::lpo()->prefix; ?>00<?php echo $lpo->lpo_number; ?></title>
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
            <div>
               <?php if(Limitless::business(Auth::user()->businessID)->street != ""): ?>
                  <?php echo Limitless::business(Auth::user()->businessID)->street; ?>,
               <?php endif; ?>
               <?php if(Limitless::business(Auth::user()->businessID)->city != ""): ?>
                  <?php echo Limitless::business(Auth::user()->businessID)->city; ?>

               <?php endif; ?>
            </div>
            <div>
               <?php if(Limitless::business(Auth::user()->businessID)->postal_address != ""): ?>
                  <?php echo Limitless::business(Auth::user()->businessID)->postal_address; ?>

                  -
               <?php endif; ?>
               <?php if(Limitless::business(Auth::user()->businessID)->zip_code != ""): ?>
                  <?php echo Limitless::business(Auth::user()->businessID)->zip_code; ?>

               <?php endif; ?>
            </div>
            <?php if(Limitless::business(Auth::user()->businessID)->primary_phonenumber != ""): ?>
               <div>Phone: <?php echo Limitless::business(Auth::user()->businessID)->primary_phonenumber; ?></div>
            <?php endif; ?>
            <?php if(Limitless::business(Auth::user()->businessID)->primary_email != ""): ?>
               <div>Email: <?php echo Limitless::business(Auth::user()->businessID)->primary_email; ?></div>
            <?php endif; ?>
            <?php if(Limitless::business(Auth::user()->businessID)->website != ""): ?>
               <div>Website: <a href="<?php echo Limitless::business(Auth::user()->businessID)->website; ?>" target="_blank"><?php echo Limitless::business(Auth::user()->businessID)->website; ?></a></div>
            <?php endif; ?>
         </div>
      </header>
      <main>
         <div id="details" class="clearfix">
            <div id="client">
               <div class="to">Deliverd to:</div>
               <h2 class="name"><?php if($vendor->company_name != ""): ?><?php echo $vendor->company_name; ?><?php else: ?><?php echo $vendor->client_name; ?><?php endif; ?></h2>
               <div class="address">
                  <?php if($vendor->bill_attention != ""): ?>
                     <strong>ATTN :</strong>
                     <?php echo $vendor->bill_attention; ?><br>
                  <?php endif; ?>
                  <?php if($vendor->bill_state != ""): ?><?php echo $vendor->bill_state; ?>,<?php endif; ?>
                  <?php if($vendor->bill_city != ""): ?><?php echo $vendor->bill_city; ?>,<?php endif; ?>
                  <?php if($vendor->bill_street != ""): ?><?php echo $vendor->bill_street; ?><?php endif; ?>
                  <br>
                  <?php if($vendor->bill_street != ""): ?>
                     <?php echo $vendor->bill_zip_code; ?><br>
                     <?php echo Limitless::country($vendor->bill_country)->name; ?>

                  <?php endif; ?>
               </div>
               <div class="email"><a href="mailto:<?php echo $vendor->email; ?>"><?php echo $vendor->email; ?></a></div>
            </div>
            <div id="invoice">
               <h1>Local purchase order (LPO)</h1>
               <?php if($lpo->status == 14): ?>
                  <a href="#" class="btn btn-success">Deliverd</a>
               <?php endif; ?>
               <h3>#<?php echo Finance::lpo()->prefix; ?>00<?php echo $lpo->lpo_number; ?></h3>
               <div class="date"><b>Date of LPO:</b> <?php echo date('F j, Y',strtotime($lpo->lpo_date)); ?></div>
               <div class="date"><b>Due Date:</b> <?php echo date('F j, Y',strtotime($lpo->lpo_due)); ?></div>
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
                        <?php if(Finance::check_product($product->productID) == 1 ): ?>
                           <strong><?php echo Finance::product($product->productID)->product_name; ?></strong>
                        <?php else: ?>
                           <i>Unknown Product</i>
                        <?php endif; ?>
                     </td>
                     <td class="unit"><?php echo e(number_format($product->price)); ?> <?php echo Finance::currency($lpo->currencyID)->code; ?></td>
                     <td class="qty"><?php echo e($product->quantity); ?></td>
                     <td class="total"><?php echo number_format($product->quantity * $product->price) ?> <?php echo Finance::currency($lpo->currencyID)->code; ?></td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>Sub Total :</strong></td>
                  <td><?php echo number_format($lpo->sub_total); ?>.00 <?php echo Finance::currency($lpo->currencyID)->code; ?></td>
               </tr>
               <?php if(Finance::lpo()->show_discount_tab == 'Yes'): ?>
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Discount :</strong></td>
                     <td>
                        <?php echo $lpo->sub_total * ($lpo->discount / 100)  ?> <?php echo Finance::currency($lpo->currencyID)->code; ?>

                     </td>
                  </tr>
               <?php endif; ?>
               <?php if(Finance::lpo()->show_tax_tab == 'Yes'): ?>
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Tax - <?php echo $lpo->tax; ?>% :</strong></td>
                     <td>
                        <?php echo $taxed; ?>  <?php echo Finance::currency($lpo->currencyID)->code; ?>

                     </td>
                  </tr>
               <?php endif; ?>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>TOTAL :</strong></td>
                  <td><?php echo number_format($lpo->total); ?>.00 <?php echo Finance::currency($lpo->currencyID)->code; ?></td>
               </tr>
            </tfoot>
         </table>

         <?php if($lpo->lpo_note != ""): ?>
            <div class="notice">
               <h4>Client Note</h4>
               <?php echo $lpo->lpo_note; ?>

            </div>
         <?php else: ?>
            <?php if(Finance::lpo()->default_customer_notes != ""): ?>
               <div class="notice">
                  <h4>Client Note</h4>
                  <?php echo Finance::lpo()->default_customer_notes; ?>

               </div>
            <?php endif; ?>
         <?php endif; ?>
         <?php if($lpo->terms != ""): ?>
            <div class="notice">
               <h4>Terms & Conditions</h4>
               <?php echo $lpo->terms; ?>

            </div>
         <?php else: ?>
            <?php if(Finance::lpo()->default_customer_notes != ""): ?>
               <div class="notice">
                  <h4>Terms & Conditions</h4>
                  <?php echo Finance::lpo()->default_terms_conditions; ?>

               </div>
            <?php endif; ?>
         <?php endif; ?>
         <div id="thanks">Thank you!</div>
      </main>
   </body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/blue/stock.blade.php ENDPATH**/ ?>