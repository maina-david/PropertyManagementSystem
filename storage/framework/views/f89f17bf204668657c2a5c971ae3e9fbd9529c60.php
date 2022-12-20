<div class="row">
   <div class="col-md-4">
      <?php if($quote->logo != ""): ?>
         <img src="<?php echo asset('businesses/'.$quote->business_code.'/documents/images/'.$quote->logo); ?>" class="logo" alt="<?php echo $quote->businessName; ?>" style="width:70%">
      <?php endif; ?>
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong><?php echo $quote->businessName; ?></strong>
         <?php if($quote->street != ""): ?>
         <br><?php echo $quote->street; ?><br>
         <?php endif; ?>
         <?php if($quote->city != ""): ?>
         <?php echo $quote->city; ?>,
         <?php endif; ?>
         <?php if($quote->postal_address != "" ): ?>
         <?php echo $quote->postal_address; ?>

         <?php endif; ?>
         <?php if($quote->postal_address != "" && $quote->zip_code != "" ): ?>
            - <?php echo $quote->zip_code; ?>

         <?php endif; ?>
         <br>
         <b>Phone:</b> <?php echo $quote->primary_phonenumber; ?><br>
         <b>Email:</b> <?php echo $quote->primary_email; ?>

      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3 mt-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Quotes</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong><?php echo $customer->customer_name; ?></strong>
         <span><br><?php if($customer->bill_state != ""): ?><?php echo $customer->bill_state; ?>,<?php endif; ?></span>
         <span><?php if($customer->bill_city != ""): ?><?php echo $customer->bill_city; ?>,<?php endif; ?></span>
         <span><?php if($customer->bill_street != ""): ?><?php echo $customer->bill_street; ?><br><?php endif; ?></span>
         <span>
            <?php if($customer->bill_street != ""): ?>
               <?php echo $customer->bill_zip_code; ?><br>
            <?php endif; ?>
            <?php if($customer->bill_country != ""): ?>
               <?php echo Wingu::country($customer->bill_country)->name; ?><br>
            <?php endif; ?>
         </span>
         <span><b>Email: </b><?php if($customer->email != ""): ?><?php echo $customer->email; ?><?php endif; ?></span>
      </address>
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>Quotes Number</b></th>
               <td>: <?php echo $quote->prefix; ?><?php echo $quote->number; ?></td>
            </tr>
            <?php if($quote->reference_number != ""): ?>
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: <?php echo $quote->reference_number; ?></td>
               </tr>
            <?php endif; ?>
            <tr>
               <th>Status</th>
               <td class="text-right">
                  <?php if($quote->statusID == 1): ?>
                     <p style="color:green;font-style: normal;font-weight: bolder;"><?php echo ucfirst($quote->name); ?></p>
                  <?php else: ?>
                  <p style="color:blue;font-style: normal;font-weight: bolder;"><?php echo ucfirst($quote->name); ?></p>
                  <?php endif; ?>
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: <?php echo date('F j, Y',strtotime($quote->quote_date)); ?></td>
            </tr>
            <tr>
               <th>Closing Date</th>
               <td>: <?php echo date('F j, Y',strtotime($quote->quote_due)); ?></td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="col-md-12">
   <h2><?php echo $quote->subject; ?></h2>
   </div>
   <div class="col-md-12">
   <?php echo $quote->description; ?>

   </div>
</div>
<table class="table table-striped table-bordered mt-3">
   <thead>
      <tr>
         <th width="1%">#</th>
         <th width="30%">Item</th>
         <th>Quantity</th>
         <th>Price</th>
         <?php if($quote->show_discount_tab == 'Yes'): ?>
            <?php if($quote->discount != ""): ?>
               <th>Discount(<?php echo $quote->symbol; ?>)</th>
            <?php endif; ?>
         <?php endif; ?>
         <?php if($quote->taxconfig != 'Exclusive'): ?> 
            <?php if($quote->show_tax_tab == 'Yes'): ?>
               <th>Tax</th>
            <?php endif; ?>
         <?php endif; ?>
         <th>Total</th>
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
            <td><?php echo e($product->quantity); ?></td>
            <td>
               <?php echo $quote->symbol; ?><?php echo e(number_format($product->price,2)); ?> 
            </td>
            <?php if($quote->show_discount_tab == 'Yes'): ?>
               <?php if($quote->discount != ""): ?>
                  <td>
                     <?php echo $quote->symbol; ?><?php echo number_format($product->discount,2); ?> 
                  </td>
               <?php endif; ?>
            <?php endif; ?>
            <?php if($quote->taxconfig != 'Exclusive'): ?> 
               <?php if($quote->show_tax_tab == 'Yes'): ?>
                  <td>
                     <?php echo e(number_format($product->taxrate)); ?>%
                  </td>
               <?php endif; ?>
            <?php endif; ?>
            <td>
               <?php echo $quote->symbol; ?><?php echo e(number_format($product->total_amount,2)); ?> 
            </td>
         </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </tbody>
</table>
<div class="row">
   <div class="col-md-6"></div>
   <div class="col-md-6">
      <table class="table table-striped">
         <tbody>
            <tr>
               <th>Amount</th>
               <td><strong>: <?php echo $quote->symbol; ?><?php echo number_format($quote->main_amount,2); ?> <strong></td>
            </tr>
            <?php if($quote->show_discount_tab == 'Yes'): ?>
               <?php if($quote->discount != ""): ?>
                  <tr>
                     <th>Discount</th>
                     <td><strong>: <?php echo $quote->symbol; ?><?php echo number_format($quote->discount,2); ?> <strong></td>
                  </tr>
               <?php endif; ?>
            <?php endif; ?>
            <tr>
               <th>Sub Total</th>
               <td><strong>: <?php echo $quote->symbol; ?><?php echo number_format($quote->sub_total,2); ?> <strong></td>
            </tr>
            <?php if($quote->taxconfig != 'Exclusive'): ?> 
               <?php if($quote->show_tax_tab == 'Yes'): ?>
                  <tr>
                     <th><strong>Tax</strong></th>
                     <td>
                        <strong>
                           : <?php echo $quote->symbol; ?><?php echo number_format($quote->taxvalue,2); ?>  
                        </strong>
                     </td>
                  </tr>
               <?php endif; ?>
            <?php endif; ?>
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : <?php echo $quote->symbol; ?><?php echo number_format($quote->total,2); ?> 
                  </strong>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>

<div class="row">
   <div class="col-md-12 invbody-terms">
      Thank you for your business.
      <br><br>
      <?php if($quote->customer_note != ""): ?>
      <div class="notice">
         <h4><b>Customer Note</b></h4>
         <?php echo $quote->customer_note; ?>

      </div>
      <?php endif; ?>
      <?php if($quote->terms != ""): ?>
         <div class="notice">
            <h4><b>Terms & Conditions</b></h4>
            <?php echo $quote->terms; ?>

         </div>
      <?php endif; ?>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/quotes/preview.blade.php ENDPATH**/ ?>