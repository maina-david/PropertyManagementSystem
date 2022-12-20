<?php $__env->startSection('title','Payment view receipt'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row">
      <div class="col-md-8">
         <div class="col-md-12">
            <a href="<?php echo route('finance.payments.mail',$details->invoicePaymentID); ?>"  class="btn btn-white btn-sm m-b-10 p-l-5"><i class="fal fa-envelope"></i> Email Recipt</a>
            <a href="<?php echo route('finance.payments.edit',$details->invoicePaymentID); ?>" class="btn btn-sm btn-white m-b-10 p-l-5">
               <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?php echo route('finance.payments.pdf',$details->invoicePaymentID); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fal fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
            </a>
            <a href="<?php echo route('finance.payments.print',$details->invoicePaymentID); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
               <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
            </a>
            
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="pcs-template-body">
                     <div style="padding-bottom:35px;border-bottom:1px solid #eee;width:100%;">
                        <table>
                           <tbody>
                           <tr>
                              <td style="vertical-align:top;padding-left:30px">
                                 <p>
                                    <span class="pcs-orgname"><b><?php echo $details->businessName; ?></b><br></span>
                                    <?php if( $details->street != ""): ?>
                                       <?php echo $details->street; ?><br>
                                    <?php endif; ?>
                                    <?php if( $details->city != ""): ?>
                                       <?php echo $details->city; ?>, <?php echo $details->postal_address; ?> - <?php echo $details->zip_code; ?><br>
                                    <?php endif; ?>
                                    <?php if($details->primary_phonenumber != ""): ?>
                                       Phone: <?php echo $details->primary_phonenumber; ?><br>
                                    <?php endif; ?>
                                    <?php if($details->primary_email != ""): ?>
                                       Email: <?php echo $details->primary_email; ?><br>
                                    <?php endif; ?>
                                 </p>
                              </td>
                           </tr>
                           </tbody>
                        </table>
                     </div>                  
                     <div style="padding:35px 0 50px;text-align:center">
                        <span style="border-bottom:1px solid #eee;font-size: 13pt; color: #333333;">PAYMENT RECEIPT</span>
                     </div>                       
                     <div style="width: 70%;float: left;">
                        <div style="width: 100%;padding: 11px 0;">
                           <div style="width:35%;float:left;" class="pcs-label">Payment Date</div>
                           <div style="width:65%;border-bottom:1px solid #eee;float:right;">
                              <b><?php echo date('jS F, Y', strtotime($details->payment_date)); ?></b>
                           </div>
                           <div style="clear:both;"></div>
                        </div>                  
                        <div style="width: 100%;padding: 10px 0;">
                           <div style="width:35%;float:left;" class="pcs-label">Reference Number</div>
                           <div style="width:65%;border-bottom:1px solid #eee;float:right;min-height:22px">
                              <b><?php echo $details->transactionID; ?></b>
                           </div>
                           <div style="clear:both;"></div>
                        </div>                  
                        <div style="width: 100%;padding: 11px 0;">
                           <div style="width:35%;float:left;" class="pcs-label">Payment Mode</div>
                           <div style="width:65%;border-bottom:1px solid #eee;float:right;">
                              <b>
                                 <?php if($details->payment_method != ""): ?>
                                    <?php if(Finance::check_default_payment_method($details->payment_method) == 1): ?>
                                       <?php echo Finance::default_payment_method($details->payment_method)->name; ?>

                                    <?php else: ?> 
                                       <?php if(Finance::check_payment_method($details->payment_method) == 1): ?>
                                          <?php echo Finance::payment_method($details->payment_method)->name; ?>

                                       <?php endif; ?>
                                    <?php endif; ?>
                                 <?php endif; ?>
                              </b>
                           </div>
                           <div style="clear:both;"></div>
                        </div>
                     </div>                  
                     <div style="text-align:center;color:#ffffff;float:right;background:#78ae54;width: 25%; padding: 34px 5px;">
                        <span> Amount Received</span><br>
                        <span  style="font-size: 16pt;color: #ffffff;">
                        <?php echo $details->code; ?> <?php echo number_format($details->amount); ?>

                        </span>
                     </div>
                     <div style="clear:both;"></div>
                     <div style="margin-top:50px">
                        <table style="width:100%">
                           <tbody>
                           <tr>
                              <td>
                                 <div>
                                    <p style="font-weight:600;color: #777777;">Bill To</p>
                                    <a href="#"><?php echo $details->customer_name; ?></a><br>
                                    <?php if($details->email != ""): ?>
                                       <?php echo $details->email; ?><br>
                                    <?php endif; ?>
                                    <?php if($details->primary_phone_number != ""): ?>
                                       <?php echo $details->primary_phone_number; ?>, <?php echo $details->bill_city; ?>, <?php echo $details->bill_zip_code; ?><br>
                                    <?php endif; ?>
                                    <?php if($details->bill_country != ""): ?>
                                       <?php echo Wingu::country($details->bill_country)->name; ?><br>
                                    <?php endif; ?>
                                 </div>
                              </td>
                              <td style="text-align: right;vertical-align:top">
                              </td>
                           </tr>
                           </tbody>
                        </table>
                     </div>
                     <hr>         
                     <div style="margin-top:50px;page-break-inside: avoid;">
                        <h4 class="pcs-payment-details-header" style="margin-bottom:18px;">Payment for</h4>
                        <table style="width:100%;table-layout:fixed;" class="pcs-itemtable" border="0" cellspacing="0" cellpadding="0">
                           <thead>
                              <tr style="height:40px;">                       
                                 <td style="padding:5px 10px 5px 10px;word-wrap: break-word;" class="pcs-itemtable-header">
                                 Invoice Number
                                 </td>
                                 <td style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                                    Invoice Date
                                 </td>
                                 <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                                    Invoice Amount
                                 </td>
                                 <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                                    Payment Amount
                                 </td>
                                 <td align="right" style="padding:5px 10px 5px 5px;word-wrap: break-word;" class="pcs-itemtable-header">
                                    Amount Due
                                 </td>                     
                              </tr>
                           </thead>
                           <tbody>
                              <tr style="border-top:1px solid #ededed">                       
                                 <td valign="top" style="padding: 10px 0px 10px 10px;word-wrap: break-word;" class="pcs-item-row">
                                    <span><a href="#"><?php echo $details->prefix; ?><?php echo $details->invoice_number; ?></a></span>
                                 </td>                       
                                 <td valign="top" style="padding: 10px 10px 5px 10px;word-wrap: break-word;" class="pcs-item-row">
                                    <?php echo date('jS F, Y', strtotime($details->invoice_date)); ?>

                                 </td>                       
                                 <td valign="top" style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;" class="pcs-item-row">
                                    <?php echo $details->code; ?> <?php echo number_format($details->total); ?>

                                 </td>
                                 <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                                    <?php echo $details->code; ?> <?php echo number_format($details->amount); ?>

                                 </td>
                                 <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                                    <?php echo $details->code; ?> <?php echo number_format($details->paymentBalance); ?>

                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/payments/show.blade.php ENDPATH**/ ?>