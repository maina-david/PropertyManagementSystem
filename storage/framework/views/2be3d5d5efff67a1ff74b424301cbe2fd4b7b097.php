<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <title><?php echo Documents::settings('Estimates')->code; ?><?php echo $edit->number; ?></title>
      <link rel="stylesheet" href="<?php echo url('/'); ?>/resources/views/templates/invoices/temp01/style.css" media="all" />
   </head>
   <body>
      <div class="invoice-box">
         <table cellpadding="0" cellspacing="0">
            <tr class="top">
               <td colspan="2">                  
                  <tr>
                     <td>
                        <img src="https://www.sparksuite.com/images/logo.png" class="logo">
                     </td> 
                     <?php if($edit->document_type == 'Estimate'): ?>
                        <td>
                           <h1>ESTIMATE</h1>
                           #: <?php echo Documents::settings('Estimates')->code; ?><?php echo $edit->number; ?><br>
                           Estimate Date: <?php echo date('F j, Y',strtotime($edit->start_date)); ?><br>
                           Reference# : <?php echo $edit->lpo_number; ?>

                        </td>
                     <?php endif; ?>
                     <?php if($edit->document_type == 'Invoice'): ?>
                        <td>
                           <h1>Invoice</h1>
                           #: <?php echo Documents::settings('Estimates')->code; ?><?php echo $edit->number; ?><br>
                           Created: January 1, 2015<br>
                           Due: February 1, 2015
                        </td>
                     <?php endif; ?>
                  </tr>
               </td>
            </tr>
            <tr class="information">
               <td colspan="2">
                  <tr>
                     <td>
                        <p>
                           <?php if(Limitless::check_for_setting('company name','profile') == 1): ?>
                              <strong><?php echo Limitless::get_specific_setting('company name','profile'); ?></strong>	 
                           <?php endif; ?>	
                           <?php if(Limitless::check_for_setting('location','profile') == 1): ?>									
                              <br><?php echo Limitless::get_specific_setting('location','profile'); ?>

                           <?php endif; ?>
                           <?php if(Limitless::check_for_setting('town','profile') == 1): ?>	
                              <br><?php echo Limitless::get_specific_setting('town','profile'); ?>

                           <?php endif; ?>, 
                           <?php if(Limitless::check_for_setting('city','profile') == 1): ?>
                              <?php echo Limitless::get_specific_setting('city','profile'); ?>, 
                           <?php endif; ?>
                           <?php if(Limitless::check_for_setting('country','profile') == 1): ?>
                              <?php echo Limitless::get_specific_setting('country','profile'); ?>

                           <?php endif; ?>
                           <?php if(Limitless::check_for_setting('postal address','profile') == 1): ?>
                              <br><?php echo Limitless::get_specific_setting('postal address','profile'); ?>

                           <?php endif; ?>
                        </p>
                     </td>
                     <td>
                        <p>
                           <strong><?php if($client->company_name != ""): ?><?php echo $client->company_name; ?><?php else: ?><?php echo $client->client_name; ?><?php endif; ?></strong><br>
                           <strong>ATTN :</strong> <?php echo $client->bill_attention; ?>

                           <br><?php echo $client->bill_state; ?>, <?php echo $client->bill_city; ?>, <?php echo $client->bill_street; ?><br>
                           <?php echo $client->bill_zip_code; ?>, <?php echo Limitless::country($client->bill_country)->name; ?>

                        </p>
                     </td>
                  </tr>
               </td>
            </tr>
            <tr class="">
               <td>#</td>
               <td>Items</td>
               <td>Qty</td>
               <td>Price</td>
               <td>Amount</td>
            </tr>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr class="item">
                  <td><?php echo $count++; ?></td>										
                  <td>
                     <?php if($product->product_id != 0 ): ?>
                        <strong><?php echo Finance::product($product->product_id)->product_name; ?></strong>
                        <small><?php echo $product->short_description; ?></small>
                     <?php else: ?> 
                        <strong><?php echo $product->product_name; ?></strong>
                     <?php endif; ?>
                  </td>
                  <td><?php echo $product->quantity; ?></td>
                  <td>
                     <?php echo number_format($product->price); ?>.00 <?php echo Finance::currency($edit->currency_id)->code; ?>

                  </td>
                  <td><?php echo number_format($product->price); ?>.00 <?php echo Finance::currency($edit->currency_id)->code; ?> </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr class="total">
               <td></td>
               <td><strong>Sub Total :</strong> <?php echo number_format($edit->amount); ?>.00 <?php echo Finance::currency($edit->currency_id)->code; ?></td>
            </tr>
            <tr class="total">
               <td></td>
               <td>
                  <strong>Tax - <?php echo $edit->tax; ?>% :</strong> <?php echo number_format($taxed); ?> <?php echo Finance::currency($edit->currency_id)->code; ?>

               </td>
            </tr>
            <tr class="total">
               <td></td>
               <td>
                  <strong>Discount :</strong> <?php echo number_format($edit->discount); ?> <?php echo Finance::currency($edit->currency_id)->code; ?>

               </td>
            </tr>
            <tr class="total">
               <td></td>
               <td><strong>TOTAL :</strong> <?php echo number_format($edit->total_amount); ?>.00 <?php echo Finance::currency($edit->currency_id)->code; ?></td>
            </tr>
         </table>
      </div>
   </body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/templates/temp01/theme.blade.php ENDPATH**/ ?>