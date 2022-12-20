<div class="row">
   <div class="col-md-4">
      <?php if($invoice->logo != ""): ?>
         <img src="<?php echo asset('businesses/'.$invoice->business_code.'/documents/images/'.$invoice->logo); ?>" class="logo" alt="<?php echo $invoice->businessName; ?>" style="width:70%">
      <?php endif; ?>
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong><?php echo $invoice->businessName; ?></strong>
         <?php if($invoice->street != ""): ?>
         <br><?php echo $invoice->street; ?><br>
         <?php endif; ?>
         <?php if($invoice->city != ""): ?>
         <?php echo $invoice->city; ?>,
         <?php endif; ?>
         <?php if($invoice->postal_address != "" ): ?>
         <?php echo $invoice->postal_address; ?>

         <?php endif; ?>
         <?php if($invoice->postal_address != "" && $invoice->zip_code != "" ): ?>
            - <?php echo $invoice->zip_code; ?>

         <?php endif; ?>
         <br>
         <b>Phone:</b> <?php echo $invoice->primary_phonenumber; ?><br>
         <b>Email:</b> <?php echo $invoice->primary_email; ?>

      </p>
   </div>   
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Invoice</h3>
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
               <th><b>Invoice Number</b></th>
               <td>: <?php echo $invoice->prefix; ?><?php echo $invoice->number; ?></td>
            </tr>
            <?php if($invoice->reference_number != ""): ?>
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: <?php echo $invoice->reference_number; ?></td>
               </tr>
            <?php endif; ?>
            <tr>
               <th><b>Status</b></th>
               <td>
                  <?php if($invoice->statusID == 1): ?>
                     <span style="color:green;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($invoice->name); ?></span>
                  <?php else: ?>
                  <span style="color:blue;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($invoice->name); ?></span>
                  <?php endif; ?>
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: <?php echo date('F j, Y',strtotime($invoice->invoice_date)); ?></td>
            </tr>
            <tr>
               <th>Due Date</th>
               <td>: <?php echo date('F j, Y',strtotime($invoice->invoice_due)); ?></td>
            </tr>
            <?php if($invoice->invoiceStatusID != 1): ?>
               <?php if($invoice->invoiceStatusID == 3): ?>
                  <tr>
                     <th>Balance</th>
                     <td><span class="text-right">: <?php echo $invoice->symbol; ?><?php echo number_format($invoice->balance,2); ?> </span></td>
                  </tr>
               <?php elseif($invoice->invoiceStatusID == 2): ?>
                  <tr>
                     <th>Amount Due </th>
                     <td><span class="text-right">: <?php echo $invoice->symbol; ?><?php echo number_format($invoice->total,2); ?> </span></td>
                  </tr>
               <?php endif; ?>
            <?php endif; ?>
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
         <?php if($invoice->show_discount_tab == 'Yes'): ?>
            <?php if($invoice->discount != ""): ?>
               <th>Discount(<?php echo $invoice->symbol; ?>)</th>
            <?php endif; ?>
         <?php endif; ?>
         <?php if($invoice->taxconfig != 'Exclusive'): ?> 
            <?php if($invoice->show_tax_tab == 'Yes'): ?>
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
               <?php echo $invoice->symbol; ?><?php echo e(number_format($product->selling_price,2)); ?> 
            </td>
            <?php if($invoice->show_discount_tab == 'Yes'): ?>
               <?php if($invoice->discount != ""): ?>
                  <td>
                     <?php echo $invoice->symbol; ?><?php echo number_format($product->discount,2); ?> 
                  </td>
               <?php endif; ?>
            <?php endif; ?>
            <?php if($invoice->taxconfig != 'Exclusive'): ?> 
               <?php if($invoice->show_tax_tab == 'Yes'): ?>
                  <td>
                     <?php echo e(number_format($product->taxrate)); ?>%
                  </td>
               <?php endif; ?>
            <?php endif; ?>
            <td>
               <?php echo $invoice->symbol; ?><?php echo e(number_format($product->total_amount,2)); ?> 
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
               <td><strong><?php echo $invoice->symbol; ?><?php echo number_format($invoice->main_amount,2); ?><strong></td>
            </tr>
            <?php if($invoice->show_discount_tab == 'Yes'): ?>
               <?php if($invoice->discount != ""): ?>
                  <tr>
                     <th>Discount</th>
                     <td><strong>: <?php echo $invoice->symbol; ?><?php echo number_format($invoice->discount,2); ?><strong></td>
                  </tr>
               <?php endif; ?>
            <?php endif; ?>
            <tr>
               <th>Sub Total</th>
               <td><strong>: <?php echo $invoice->symbol; ?><?php echo number_format($invoice->sub_total,2); ?><strong></td>
            </tr>
            <?php if($invoice->taxconfig != 'Exclusive'): ?> 
               <?php if($invoice->show_tax_tab == 'Yes'): ?>
                  <tr>
                     <th><strong>Tax</strong></th>
                     <td>
                        <strong>
                           : <?php echo $invoice->symbol; ?><?php echo number_format($invoice->taxvalue,2); ?>  
                        </strong>
                     </td>
                  </tr>
               <?php endif; ?>
            <?php endif; ?>
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : <?php echo $invoice->symbol; ?><?php echo number_format($invoice->total,2); ?> 
                  </strong>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="col-md-12">
      <h4>Transactions</h4>
      <table class="table table-striped table-bordered">
         <tr>
            <th width="20%">Transaction #</th>
            <th>Mode of payment</th>
            <th>Date paid</th>
            <th>Amount paid</th>
            <th>Balance</th>
         </tr> 
         <tbody> 
            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td>
                     <?php echo $payment->reference_number; ?>

                     <?php if($payment->credited == 'yes'): ?> 
                        Credited
                     <?php endif; ?>
                  </td>
                  <td>
                     <?php if($payment->payment_method != ""): ?>
                        <?php if(Finance::check_default_payment_method($payment->payment_method) == 1): ?>
                           <?php echo Finance::default_payment_method($payment->payment_method)->name; ?>

                        <?php else: ?> 
                           <?php if(Finance::check_payment_method($payment->payment_method) == 1): ?>
                              <?php echo Finance::payment_method($payment->payment_method)->name; ?>

                           <?php endif; ?>
                        <?php endif; ?>
                     <?php endif; ?>
                     <?php if($payment->credited == 'yes'): ?> 
                        Credited
                     <?php endif; ?>
                  </td>
                  <td><?php echo date('M d, Y', strtotime($payment->payment_date)); ?></td>
                  <td><?php echo $invoice->symbol; ?><?php echo number_format($payment->amount,2); ?> </td> 
                  <td>
                     <?php if($payment->balance < 0): ?>

                     <?php else: ?>
                        <?php echo $invoice->symbol; ?><?php echo number_format($payment->balance,2); ?> 
                     <?php endif; ?>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="col-md-12 invbody-terms">
      Thank you for your business.
      <br><br>
      <?php if($invoice->customer_note != ""): ?>
      <div class="notice">
         <h4><b>Customer Note</b></h4>
         <?php echo $invoice->customer_note; ?>

      </div>
      <?php endif; ?>
      <?php if($invoice->terms != ""): ?>
         <div class="notice">
            <h4><b>Terms & Conditions</b></h4>
            <?php echo $invoice->terms; ?>

         </div>
      <?php endif; ?>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/invoice/preview.blade.php ENDPATH**/ ?>