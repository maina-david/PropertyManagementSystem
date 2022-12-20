<div class="col-md-12">
   <div class="row">
      <div class="col-md-4">
         <?php if($business->logo != ""): ?> 
            <img src="<?php echo asset('businesses/'.$business->businessID.'/documents/images/'.$business->logo); ?>" class="logo" alt="<?php echo $business->businessName; ?>" style="width:70%">
         <?php endif; ?>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
         <p>
            <strong><?php echo $property->management_name; ?></strong><br>
            <?php if($property->management_phonenumber != ""): ?>
               <b>Phone:</b> <?php echo $property->management_phonenumber; ?><br>
            <?php endif; ?>
            <?php if($property->management_email != ""): ?>
               <b>Email:</b> <?php echo $property->management_email; ?> <br>
            <?php endif; ?>
            <?php if($property->management_postaladdress != ""): ?>
               <b>Postal Address:</b> <?php echo $property->management_postaladdress; ?> 
            <?php endif; ?>
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
            <strong><?php echo $tenant->tenant_name; ?></strong>
            <span><br><?php if($tenant->bill_state != ""): ?><?php echo $tenant->bill_state; ?>,<?php endif; ?></span>
            <span><?php if($tenant->bill_city != ""): ?><?php echo $tenant->bill_city; ?>,<?php endif; ?></span>
            <span><?php if($tenant->bill_street != ""): ?><?php echo $tenant->bill_street; ?><br><?php endif; ?></span>
            <span>
               <?php if($tenant->bill_street != ""): ?>
                  <?php echo $tenant->bill_zip_code; ?><br>
               <?php endif; ?>
               <?php if($tenant->bill_country != ""): ?>
                  <?php echo Wingu::country($tenant->bill_country)->name; ?><br>
               <?php endif; ?>
            </span>
            <span><b>Email: </b><?php if($tenant->contact_email != ""): ?><?php echo $tenant->contact_email; ?><?php endif; ?></span>
         </address>
      </div>
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <table style="float:left">
            <tbody>
               <tr>
                  <th>Invoice Number</th>
                  <td>: <?php echo $invoice->invoice_prefix; ?><?php echo $invoice->invoice_number; ?></td>
               </tr>
               <tr>
                  <th>Status :</th>
                  <td>
                     <?php if($invoice->statusID == 1): ?>
                        <span style="color:green;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($invoice->name); ?></span>
                     <?php else: ?>
                     <span style="color:blue;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($invoice->name); ?></span>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>Issue Date</th>
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
                        <td><span class="text-right">: <?php echo $business->code; ?> <?php echo number_format($invoice->balance); ?> </span></td>
                     </tr>
                  <?php elseif($invoice->invoiceStatusID == 2): ?>
                     <tr>
                        <th>Amount Due </th>
                        <td><span class="text-right">: <?php echo $business->code; ?> <?php echo number_format($invoice->total); ?> </span></td>
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
            <?php if($invoice->taxvalue != ""): ?>  
               <th>Tax</th>
            <?php endif; ?>
            <th>Total</th>
         </tr>
      </thead>
      <tbody>
         <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="item-row">
               <td align="center"><?php echo e($count++); ?></td>
               <td class="description">
                  <?php echo e($product->item_name); ?>

               </td>
               <td><?php echo e($product->quantity); ?></td>
               <td>
                  <?php echo $business->code; ?> <?php echo e(number_format($product->price)); ?>

               </td>       
               <?php if($invoice->taxvalue != ""): ?>        
                  <td>
                     <?php echo e(number_format($product->taxrate)); ?>%
                  </td>
               <?php endif; ?>
               <td>
                  <?php echo $business->code; ?> <?php echo e(number_format($product->total_amount)); ?> 
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
                  <td><strong>: <?php echo $business->code; ?> <?php echo number_format($invoice->sub_total); ?> <strong></td>
               </tr>
               <?php if($invoice->taxvalue != ""): ?>  
                  <tr>
                     <th>Tax</th>
                     <td>
                        <strong>
                           : <?php echo $business->code; ?> <?php echo number_format($invoice->taxvalue); ?>  
                        </strong>
                     </td>
                  </tr>
               <?php endif; ?>
               <tr>
                  <th>Total Amount</th>
                  <td>
                     <strong>
                        : <?php echo $business->code; ?> <?php echo number_format($invoice->total); ?> 
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
                     <td><?php echo $payment->reference_number; ?></td>
                     <td>
                        <?php if($payment->payment_method != ""): ?>
                           <?php echo Finance::payment_method($payment->payment_method)->name; ?>

                        <?php endif; ?>
                     </td>
                     <td><?php echo date('M d, Y', strtotime($payment->payment_date)); ?></td>
                     <td><?php echo $business->code; ?> <?php echo number_format($payment->amount); ?> </td>
                     <td>
                        <?php echo $business->code; ?> <?php echo number_format($payment->balance); ?> 
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
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/invoice/property/preview.blade.php ENDPATH**/ ?>