<div class="row">
   <div class="col-md-4">
      <?php if($lpo->logo != ""): ?>
         <img src="<?php echo asset('businesses/'.$lpo->business_code.'/documents/images/'.$lpo->logo); ?>" class="logo" alt="<?php echo $lpo->businessName; ?>" style="width:70%">
      <?php endif; ?>
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong><?php echo $lpo->businessName; ?></strong>
         <?php if($lpo->street != ""): ?>
         <br><?php echo $lpo->street; ?><br>
         <?php endif; ?>
         <?php if($lpo->city != ""): ?>
         <?php echo $lpo->city; ?>,
         <?php endif; ?>
         <?php if($lpo->postal_address != "" ): ?> 
         <?php echo $lpo->postal_address; ?>

         <?php endif; ?>
         <?php if($lpo->postal_address != "" && $lpo->zip_code != "" ): ?>
            - <?php echo $lpo->zip_code; ?>

         <?php endif; ?>
         <br>
         <b>Phone:</b> <?php echo $lpo->primary_phonenumber; ?><br>
         <b>Email:</b> <?php echo $lpo->primary_email; ?>

      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Purchase Order</h3>
   </div>               
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong><?php echo $supplier->supplierName; ?></strong>
         <span><?php if($supplier->bill_state != ""): ?><br><?php echo $supplier->bill_state; ?>,<?php endif; ?></span>
         <span><?php if($supplier->bill_city != ""): ?><br><?php echo $supplier->bill_city; ?>,<?php endif; ?></span>
         <span><?php if($supplier->bill_street != ""): ?><br><?php echo $supplier->bill_street; ?><br><?php endif; ?></span>
         <span>
            <?php if($supplier->bill_street != ""): ?>
               <?php echo $supplier->bill_zip_code; ?><br>
            <?php endif; ?>
            <?php if($supplier->bill_country != ""): ?>
               <?php echo Wingu::country($supplier->bill_country)->name; ?><br>
            <?php endif; ?>
         </span>
         <span><b>Email: </b><?php if($supplier->email != ""): ?><?php echo $supplier->email; ?><?php endif; ?></span>
      </address> 
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>purchaseorders #</b></th>
               <td>: <?php echo $lpo->prefix; ?><?php echo $lpo->number; ?></td>
            </tr>
            <?php if($lpo->reference_number != ""): ?>
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: <?php echo $lpo->reference_number; ?></td>
               </tr>
            <?php endif; ?>
            <tr>
               <th><b>Status</b></th>
               <td>
                  <?php if($lpo->statusID == 1): ?>
                     <span style="color:green;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($lpo->name); ?></span>
                  <?php else: ?>
                  <span style="color:blue;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($lpo->name); ?></span>
                  <?php endif; ?>
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: <?php echo date('F j, Y',strtotime($lpo->lpo_date)); ?></td>
            </tr>
            <tr>
               <th>Expected Delivery Date</th>
               <td>: <?php echo date('F j, Y',strtotime($lpo->lpo_due)); ?></td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="30%">Item</th>
               <th>Quantity</th>
               <th>Price</th>
               
                     <th>Discount</th>
                  
                     <th>Tax</th>
                  
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
                     <?php echo e(number_format($product->selling_price)); ?> <?php echo $lpo->code; ?>

                  </td>
                  
                        <td>
                           <?php echo number_format($product->discount); ?> <?php echo $lpo->code; ?>

                        </td>
                     
                        <td>
                           <?php echo e(number_format($product->taxrate)); ?>%
                        </td>
                     
                  <td>
                     <?php echo e(number_format($product->total_amount)); ?> <?php echo $lpo->code; ?>

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
               <th>Sub Total</th>
               <td><strong>: <?php echo $lpo->code; ?> <?php echo number_format($lpo->sub_total); ?> <strong></td>
            </tr>
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : <?php echo $lpo->code; ?> <?php echo number_format($lpo->total); ?> 
                  </strong>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="col-md-12 invbody-terms">
      <?php if($lpo->customer_note != ""): ?>
         <div class="notice">
            <h4><b>Supplier Note</b></h4>
            <?php echo $lpo->customer_note; ?>

         </div>
      <?php endif; ?>
      <?php if($lpo->terms != ""): ?>
         <div class="notice">
               <h4><b>Terms & Conditions</b></h4>
               <?php echo $lpo->terms; ?>

         </div>
      <?php endif; ?>
      <br><br>
      Thank you for your business.
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/lpo/preview.blade.php ENDPATH**/ ?>