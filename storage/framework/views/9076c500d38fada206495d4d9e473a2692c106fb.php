<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Estimate | <?php echo $details->prefix; ?><?php echo $details->number; ?></title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="<?php echo asset('assets/templates/bootstrap-3/style.css'); ?>" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style>
</head>
<body class="login-page" style="background: white">
   <div>
      <div class="row">
         <div class="col-xs-7">
            <h4><b>From:</b></h4>
            <strong><?php echo $details->businessName; ?></strong><br>
            <?php if($details->street != ""): ?>
               <?php echo $details->street; ?><br>
            <?php endif; ?>
            <?php if($details->city != ""): ?>
            <?php echo $details->city; ?>, 
            <?php endif; ?>
            <?php if($details->postal_address != "" ): ?>
            <?php echo $details->postal_address; ?> 
            <?php endif; ?>
            <?php if($details->postal_address != "" && $details->zip_code != "" ): ?>
               - <?php echo $details->zip_code; ?>

            <?php endif; ?><br>
            <b>Phone:</b> <?php echo $details->primary_phonenumber; ?><br>
            <b>Email:</b> <?php echo $details->primary_email; ?>

         </div>
         <div class="col-xs-4">
            <?php if($details->logo != ""): ?>
               <img src="<?php echo asset('businesses/'.$details->business_code.'/documents/images/'.$details->logo); ?>" class="logo" alt="<?php echo $details->name; ?>">
            <?php endif; ?>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-6">
            <h4><b>To:</b></h4>
            <address>
               <strong><?php echo $client->customer_name; ?></strong><br>
               <span>
                  <?php if($client->bill_attention != ""): ?>
                     <strong>ATTN :</strong><?php echo $client->bill_attention; ?>

                  <?php endif; ?>
               </span><br>
               <span><?php if($client->bill_state != ""): ?><?php echo $client->bill_state; ?>,<?php endif; ?></span>
               <span><?php if($client->bill_city != ""): ?><?php echo $client->bill_city; ?>,<?php endif; ?></span>
               <span><?php if($client->bill_street != ""): ?><?php echo $client->bill_street; ?><?php endif; ?></span><br>
               <span>
                  <?php if($client->bill_street != ""): ?>
                     <?php echo $client->bill_zip_code; ?><br>
                  <?php endif; ?>
                  <?php if($client->bill_country != ""): ?>
                     <?php echo Wingu::country($client->bill_country)->name; ?>

                  <?php endif; ?>
               </span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <td colspan="2" align="center"><b>ESTIMATE</b></td>
                  </tr>
                  <tr>
                     <th>Estimate # :</th>
                     <td class="text-right"><b><?php echo $details->prefix; ?><?php echo $details->number; ?></b></td>
                  </tr>
                  <?php if($details->reference_number != ""): ?>
                     <tr>
                        <th>Reference # :</th>
                        <td class="text-right text-uppercase"><b><?php echo $details->reference_number; ?></b></td>
                     </tr>
                  <?php endif; ?>
                  <tr>
                     <th>Status :</th>
                     <td class="text-right">
                        <?php if($details->statusID == 1): ?>
                           <p style="color:green;font-style: normal;font-weight: bolder;"><?php echo ucfirst($details->name); ?></p>
                        <?php else: ?>
                        <p style="color:blue;font-style: normal;font-weight: bolder;"><?php echo ucfirst($details->name); ?></p>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <tr>
                     <th>Date Create :</th>
                     <td class="text-right"><?php echo date('F j, Y',strtotime($details->estimate_date)); ?></td>
                  </tr>
                  <tr>
                     <th>Due Date :</th>
                     <td class="text-right"><?php echo date('F j, Y',strtotime($details->estimate_due)); ?></td>
                  </tr>
               </tbody>
            </table>
            <div style="margin-bottom: 0px">&nbsp;</div>
            <table style="width: 100%; margin-bottom: 20px">
               <tbody>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><div> Amount </div></th>
                     <td style="padding: 5px" class="text-right"><strong> <?php echo number_format($details->total); ?> <?php echo $details->code; ?> </strong></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="40%">Items</th>
               <th>Qty</th>
               <th>Price</th>
               <th>Amount</th>
                        
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
                     <?php echo e(number_format($product->selling_price)); ?> <?php echo $details->code; ?>

                  </td>
                  <td>
                     <span class="price">
                        <?php echo number_format($product->quantity * $product->selling_price) ?> <?php echo $details->code; ?>

                     </span>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
      <div class="row">
         <div class="col-xs-6"></div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><div>SUB TOTAL :</div></th>
                     <td style="padding: 5px" class="text-right"><strong><?php echo number_format($details->sub_total); ?> <?php echo $details->code; ?><strong></td>
                  </tr>
                  <?php if($details->show_discount_tab == 'Yes'): ?>
                     <?php if($details->discount != ""): ?>
                        <tr class="well" style="padding: 5px">
                           <th style="padding: 5px"><strong>Discount </strong></th>
                           <?php if($details->discount_type == 'amount'): ?>
                              <td style="padding: 5px" class="text-right">
                                 <strong>
                                    <?php echo $details->discount  ?> <?php echo $details->code; ?>

                                 </strong>
                              </td>
                           <?php else: ?> 
                              <td style="padding: 5px" class="text-right">
                                 <strong>
                                    <?php echo $details->sub_total * ($details->discount / 100)  ?> <?php echo $details->code; ?>

                                 </strong>
                              </td>
                           <?php endif; ?>
                        </tr>
                     <?php else: ?> 
                        <tr class="well" style="padding: 5px">
                           <th style="padding: 5px"><strong>Discount </strong></th>
                           <td style="padding: 5px" class="text-right">
                              <strong>
                                 0.00
                              </strong>
                           </td>
                        </tr>
                     <?php endif; ?>
                  <?php endif; ?>
                  <?php if($details->show_tax_tab == 'Yes'): ?>
                     <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><strong>Tax - <?php echo $details->tax; ?>%</strong></th>
                        <td style="padding: 5px" class="text-right">
                           <strong>
                              <?php echo $taxed; ?>  <?php echo $details->code; ?>

                           </strong>
                        </td>
                     </tr>
                  <?php endif; ?>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL :</strong></th>
                     <td style="padding: 5px" class="text-right"><strong><?php echo number_format($details->total); ?> <?php echo $details->code; ?></strong></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-8 invbody-terms">
            <h4>Thank you for your business.</h4>
            <br><br>
            <?php if($details->customer_note != ""): ?>
               <div class="notice">
                  <h4>Customer note</h4>
                  <?php echo $details->customer_note; ?>

               </div>
            <?php endif; ?>
            <?php if($details->terms != ""): ?>
               <div class="notice">
                  <h4>Terms & Conditions</h4>
                  <?php echo $details->terms; ?>

               </div>
            <?php endif; ?>
         </div>
      </div>
   </div>

</body>
</html><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/estimate.blade.php ENDPATH**/ ?>