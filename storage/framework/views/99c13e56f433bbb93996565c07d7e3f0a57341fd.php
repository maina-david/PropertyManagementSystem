<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Credit Note | <?php echo $details->prefix; ?><?php echo $details->number; ?></title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="<?php echo url('/'); ?>/resources/views/templates/bootstrap-3/style.css" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style>
</head>
<body class="login-page" style="background: white">
   <div>
      <div class="row">        
         <div class="col-xs-4">
            <?php if($business->logo != ""): ?>
               <img src="<?php echo url('/'); ?>/storage/files/business/<?php echo $business->business_code; ?>/documents/images/<?php echo $details->logo; ?>" class="logo" alt="<?php echo $details->businessName; ?>">
            <?php endif; ?>
         </div>
         <div class="col-xs-2"></div>
         <div class="col-xs-6">
            <strong><?php echo $details->businessName; ?></strong>
            <?php if($details->street != ""): ?>
            <br><?php echo $details->street; ?>

            <?php endif; ?>
            <?php if($details->city != ""): ?>
            <br><?php echo $details->city; ?>,
            <?php endif; ?>
            <?php if($details->postal_address != "" ): ?>
            <br><?php echo $details->postal_address; ?>

            <?php endif; ?>
            <?php if($details->postal_address != "" && $details->zip_code != "" ): ?>
                 <?php echo $details->zip_code; ?>

            <?php endif; ?>
            <?php if($details->primary_phonenumber != "" ): ?>         
            <br><b>Phone:</b> <?php echo $details->primary_phonenumber; ?>

            <?php endif; ?>
            <?php if($details->primary_email != "" ): ?>  
            <br><b>Email:</b> <?php echo $details->primary_email; ?>

            <?php endif; ?>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 mt-3 mb-3" style="border: 1px solid #ccc!important;font-family: inherit !important">
            <h3 style="text-align: center;font-family: inherit !important">Credit Note</h3>
         </div>               
      </div>
      <br>
      <div class="row">
         <div class="col-xs-6">
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
                     <?php echo Limitless::country($client->bill_country)->name; ?><br>
                  <?php endif; ?>
               </span>
               <span><b>Email: </b><?php if($client->email != ""): ?><?php echo $client->email; ?><?php endif; ?></span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <th>Credit Note Number</th>
                     <td class="text-right"><b><?php echo $details->prefix; ?><?php echo $details->number; ?></b></td>
                  </tr>
                  <tr>
                     <th>Status</th>
                     <td class="text-right">
                        <?php if($details->statusID == 1): ?>
                           <p style="color:green;font-style: normal;font-weight: bolder;"><?php echo ucfirst($details->name); ?></p>
                        <?php else: ?>
                        <p style="color:blue;font-style: normal;font-weight: bolder;"><?php echo ucfirst($details->name); ?></p>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <tr>
                     <th>Issue Date</th>
                     <td class="text-right"><?php echo date('F j, Y',strtotime($details->creditnote_date)); ?></td>
                  </tr>
               </tbody>
            </table>
         </div><br>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="30%">Item</th>
               <th>Quantity</th>
               <th>Price</th>
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
                     <?php echo e(number_format($product->price)); ?> <?php echo $details->code; ?>

                  </td>
                  <td>
                     <?php echo e(number_format($product->price * $product->quantity)); ?> <?php echo $details->code; ?>

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
                     <th style="padding: 5px"><div>Sub Total </div></th>
                     <td style="padding: 5px" class="text-right"><strong>: <?php echo number_format($details->sub_total); ?> <?php echo $details->code; ?><strong></td>
                  </tr>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL </strong></th>
                     <td style="padding: 5px" class="text-right">
                        <strong>
                           : <?php echo number_format($details->total); ?> <?php echo $details->code; ?>

                        </strong>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-12 invbody-terms">
            Thank you for your business.
            <br><br>
            <?php if($details->customer_note != ""): ?>
               <div class="notice">
                  <h4><b>Customer Note</b></h4>
                  <?php echo $details->customer_note; ?>

               </div>
            <?php endif; ?>
            <?php if($details->terms != ""): ?>
               <div class="notice">
                  <h4><b>Terms & Conditions</b></h4>
                  <?php echo $details->terms; ?>

               </div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/bootstrap-3/creditnote/property/creditnote.blade.php ENDPATH**/ ?>