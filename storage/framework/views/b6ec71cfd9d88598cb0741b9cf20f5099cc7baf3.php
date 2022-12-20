<div class="row">
   <div class="col-md-4">
      <?php if($salesorder->logo != ""): ?>
         <img src="<?php echo url('/'); ?>/public/businesses/<?php echo $salesorder->business_code; ?>/documents/images/<?php echo $salesorder->logo; ?>" class="logo" alt="<?php echo $salesorder->businessName; ?>" style="width:70%">
      <?php endif; ?>
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong><?php echo $salesorder->businessName; ?></strong>
         <?php if($salesorder->street != ""): ?>
         <br><?php echo $salesorder->street; ?><br>
         <?php endif; ?>
         <?php if($salesorder->city != ""): ?>
         <?php echo $salesorder->city; ?>,
         <?php endif; ?>
         <?php if($salesorder->postal_address != "" ): ?>
         <?php echo $salesorder->postal_address; ?>

         <?php endif; ?>
         <?php if($salesorder->postal_address != "" && $salesorder->zip_code != "" ): ?>
            - <?php echo $salesorder->zip_code; ?>

         <?php endif; ?>
         <br>
         <b>Phone:</b> <?php echo $salesorder->primary_phonenumber; ?><br>
         <b>Email:</b> <?php echo $salesorder->primary_email; ?>

      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Sales Order</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong><?php echo $client->customer_name; ?></strong>
         <span><br><?php if($client->bill_state != ""): ?><?php echo $client->bill_state; ?>,<?php endif; ?></span>
         <span><?php if($client->bill_city != ""): ?><?php echo $client->bill_city; ?>,<?php endif; ?></span>
         <span><?php if($client->bill_street != ""): ?><?php echo $client->bill_street; ?><br><?php endif; ?></span>
         <span>
            <?php if($client->bill_street != ""): ?>
               <?php echo $client->bill_zip_code; ?><br>
            <?php endif; ?>
            <?php if($client->bill_country != ""): ?>
               <?php echo Wingu::country($client->bill_country)->name; ?><br>
            <?php endif; ?>
         </span>
         <span><b>Email: </b><?php if($client->email != ""): ?><?php echo $client->email; ?><?php endif; ?></span>
      </address>
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>Sales Order#</b></th>
               <td>: <?php echo $salesorder->prefix; ?><?php echo $salesorder->number; ?></td>
            </tr>
            <?php if($salesorder->reference_number != ""): ?>
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: <?php echo $salesorder->reference_number; ?></td>
               </tr>
            <?php endif; ?>
            <tr>
               <th><b>Status</b></th>
               <td>
                  <?php if($salesorder->statusID == 1): ?>
                     <span style="color:green;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($salesorder->name); ?></span>
                  <?php else: ?>
                  <span style="color:blue;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($salesorder->name); ?></span>
                  <?php endif; ?>
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: <?php echo date('F j, Y',strtotime($salesorder->salesorder_date)); ?></td>
            </tr>
            <tr>
               <th>Due Date</th>
               <td>: <?php echo date('F j, Y',strtotime($salesorder->salesorder_due_date)); ?></td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<table class="table table-striped table-bordered mt-3">
   <thead>
      <tr>
         <th width="1%">#</th>
         <th width="30%">Item</th>
         <th>Quantity</th>
         <th>Price</th>
         <?php if($salesorder->show_discount_tab == 'Yes'): ?>
            <?php if($salesorder->discount != ""): ?>
               <th>Discount(<?php echo $salesorder->symbol; ?>)</th>
            <?php endif; ?>
         <?php endif; ?>
         <?php if($salesorder->taxconfig != 'Exclusive'): ?> 
            <?php if($salesorder->show_tax_tab == 'Yes'): ?>
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
               <?php echo $salesorder->code; ?> <?php echo e(number_format($product->selling_price)); ?> 
            </td>
            <?php if($salesorder->show_discount_tab == 'Yes'): ?>
               <?php if($salesorder->discount != ""): ?>
                  <td>
                     <?php echo number_format($product->discount); ?> <?php echo $salesorder->code; ?>

                  </td>
               <?php endif; ?>
            <?php endif; ?>
            <?php if($salesorder->taxconfig != 'Exclusive'): ?> 
               <?php if($salesorder->show_tax_tab == 'Yes'): ?>
                  <td>
                     <?php echo e(number_format($product->taxrate)); ?>%
                  </td>
               <?php endif; ?>
            <?php endif; ?>
            <td>
               <?php echo $salesorder->code; ?> <?php echo e(number_format($product->total_amount)); ?>

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
               <td><strong><?php echo $salesorder->code; ?> <?php echo number_format($salesorder->main_amount); ?><strong></td>
            </tr>
            <?php if($salesorder->show_discount_tab == 'Yes'): ?>
               <?php if($salesorder->discount != ""): ?>
                  <tr>
                     <th>Discount</th>
                     <td><strong>: <?php echo $salesorder->code; ?> <?php echo number_format($salesorder->discount); ?><strong></td>
                  </tr>
               <?php endif; ?>
            <?php endif; ?>
            <tr>
               <th>Sub Total</th>
               <td><strong>: <?php echo $salesorder->code; ?> <?php echo number_format($salesorder->sub_total); ?><strong></td>
            </tr>
            <?php if($salesorder->taxconfig != 'Exclusive'): ?> 
               <?php if($salesorder->show_tax_tab == 'Yes'): ?>
                  <tr>
                     <th><strong>Tax</strong></th>
                     <td>
                        <strong>
                           : <?php echo $salesorder->code; ?> <?php echo number_format($salesorder->taxvalue); ?>  
                        </strong>
                     </td>
                  </tr>
               <?php endif; ?>
            <?php endif; ?>
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : <?php echo $salesorder->code; ?> <?php echo number_format($salesorder->total); ?>

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
      <?php if($salesorder->customer_note != ""): ?>
      <div class="notice">
         <h4><b>Customer Note</b></h4>
         <?php echo $salesorder->customer_note; ?>

      </div>
      <?php endif; ?>
      <?php if($salesorder->terms_conditions != ""): ?>
         <div class="notice">
            <h4><b>Terms & Conditions</b></h4>
            <?php echo $salesorder->terms_conditions; ?>

         </div>
      <?php endif; ?>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/salesorder/preview.blade.php ENDPATH**/ ?>