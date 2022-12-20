<?php $__env->startSection('title','Update Quotes'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.quotes.index'); ?>">Quotes</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Update Quotes</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php echo Form::model($quote, ['route' => ['finance.quotes.update',$quote->id], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']); ?>

            <?php echo csrf_field(); ?>
            <div class="load-animate">
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="customer" class="text-danger">Customer</label>
                        <select name="customer" class="form-control multiselect" required>
									<option selected value="<?php echo e($quote->customerID); ?>"><?php echo $customer->customer_name; ?></option>
                           <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($cli->id); ?>"><?php echo $cli->customer_name; ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php echo $errors->first('client', '<p class="error">:messages</p>');?>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="number">Quote Number</label>
                        <div class="input-group">
                           <span class="input-group-addon solso-pre"><?php echo e(Finance::quote()->prefix); ?></span>
                           <?php echo Form::text('quote_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')); ?>

                        </div>
                        <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="number" class="">Reference # </label>
                        <div class="input-group">
                           <input type="text" name="reference_number" class="form-control" value="<?php echo e($quote->reference_number); ?>" >
                        </div>
                        <?php echo $errors->first('reference_number', '<p class="error">:messages</p>');?>
                     </div>
                  </div>
               </div>
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="date" class="text-danger">Date Create</label>
                        <?php echo Form::text('quote_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Date Create','required' => '')); ?>

                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end" class="text-danger">Expiry Date * </label>
                        <?php echo Form::text('quote_due', null, array('class' => 'form-control datepicker-rs', 'placeholder' => 'Expiry Date','required' => '')); ?>

                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end">Amounts are</label>
                        <?php echo Form::select('taxconfig',['Inclusive' => 'Tax Inclusive','Exclusive' => 'Tax Exclusive'],null,['class' => 'form-control', 'id' => 'taxconfig' ]); ?>

                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group-default">
                        <label for="">Subject</label>
                        <?php echo Form::text('subject',null, ['class' => 'form-control', 'placeholder' => 'Enter quote subject']); ?>

                     </div>
                  </div>
               </div>
               <div class="row mt-3 mb-3">
                  <div class="col-md-12">
                     <?php echo Form::textarea('description',null,['class' => 'form-control ckeditor']); ?>

                  </div>
               </div>
               <div class="panel panel-default mt-4">
                  <div class="panel-heading">
                     <h4 class="panel-title">Quote Items</h4>
                  </div>
                  <div class="panel-body">
                     <div class='row mt-3'>
                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                           <table class="table table-bordered table-striped" id="invoiceItems">
                              <thead>
                                 <tr>
                                    <th width="35%">Item Name</th>
                                    <th width="13%">Quantity</th>
                                    <th width="13%">Price</th>
                                    <th width="13%">Discount(<?php echo $quote->symbol; ?>)</th>
                                    <th width="13%">Tax</th>
                                    <th width="25%">Total</th>
                                    <th></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $__currentLoopData = $quoteproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="clone-item">
                                       <td>
                                          <select name="productID[]" class="form-control dublicateSelect2 onchange solsoCloneSelect2" id="itemName_1" data-init-plugin='select2' required>
                                             <option value="<?php echo e($product->productID); ?>">
                                                <?php if(Finance::check_product($product->productID) == 1): ?>
                                                   <?php echo Finance::product($product->productID)->product_name; ?>

                                                <?php else: ?>
                                                   <i>Unknown Product</i>
                                                <?php endif; ?>
                                             </option>
                                             <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($prod->id); ?>"> <?php echo $prod->product_name; ?> </option>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </select>
                                          <?php echo $errors->first('currency', '<p class="error">:messages</p>');?>
                                       </td>
                                       <td>
                                          <input type="number" name="qty[]" id="quantity_1" value="<?php echo e($product->quantity); ?>" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                       </td>
                                       <td>
                                          <input type="number" name="price[]" id="price_1" value="<?php echo e($product->price); ?>" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                       </td>
                                       <td>
                                          <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" value="<?php echo e($product->discount); ?>" autocomplete="off" step="0.01">
                                       </td>
                                       <td>
                                          <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                             <?php if($product->taxrate == 0 || $product->taxrate == ""): ?>
                                                <option value="0">Choose tax rate</option>
                                             <?php else: ?> 
                                                <option value="<?php echo $product->taxrate; ?>"><?php echo $product->taxrate; ?>%</option>
                                             <?php endif; ?>
                                             <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($tx->rate); ?>"> <?php echo e($tx->name); ?>-<?php echo e($tx->rate); ?>%</option>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </select>
                                          <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" value="<?php echo $product->taxvalue; ?>" autocomplete="off" step="0.01" readonly>
                                       </td>
                                       <td>
                                          <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" value="<?php echo $product->quantity * $product->price; ?>" placeholder="Main Amount" step="0.01" readonly>
                                          <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" value="<?php echo $product->sub_total; ?>" placeholder="Total Amount" step="0.01" readonly>
                                          <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" value="<?php echo $product->total_amount; ?>"  placeholder="Total Sum" step="0.01" readonly>
                                       </td>
                                       <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <td colspan="2" class="col-md-12 col-lg-8"></td>
                                    <td colspan="2" style="width:20%">
                                       <h4 class="pull-right top10">Amount</h4>
                                    </td>
                                    <td colspan="3">
                                       <h4 class="text-center">
                                          <input readonly value="<?php echo $quote->main_amount; ?>" type="number" class="form-control" id="mainAmountF" step="0.01">
                                       </h4>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="2" class="col-md-12 col-lg-8"></td>
                                    <td colspan="2" style="width:20%">
                                       <h4 class="pull-right top10">Discount</h4>
                                    </td>
                                    <td colspan="3">
                                       <h4 class="text-center">                                    
                                          <input readonly type="number" value="<?php echo $quote->discount; ?>" class="form-control" id="discountTotal" step="0.01">
                                       </h4>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="2" class="col-md-12 col-lg-8"></td>
                                    <td colspan="2" style="width:20%">
                                       <h4 class="pull-right top10">Sub Total</h4>
                                    </td>
                                    <td colspan="3">
                                       <h4 class="text-center">
                                          <input readonly type="number" value="<?php echo $quote->sub_total; ?>" class="form-control" id="subTotal" step="0.01">
                                       </h4>
                                    </td>
                                 </tr>
                                 <tr id="taxfield">
                                    <td colspan="2" class="col-md-12 col-lg-8"></td>
                                    <td colspan="2" style="width:20%">
                                       <h4 class="pull-right top10">Tax</h4>
                                    </td>
                                    <td colspan="3">
                                       <h4 class="text-center">
                                          <input readonly type="number" class="form-control" value="<?php echo $quote->taxvalue; ?>" id="taxvalue" step="0.01">
                                       </h4>
                                    </td>
                                 </tr>
                                 <tr class="table-default">
                                    <td colspan="2" class="col-md-12 col-lg-8"></td>
                                    <td colspan="2" style="width:20%">
                                       <h4 class="pull-right top10">Total Amount</h4>
                                    </td>
                                    <td colspan="3">
                                       <h4 class="text-center">
                                          <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="<?php echo $quote->total; ?>" placeholder="Total" step="0.01">
                                       </h4>
                                    </td>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                     </div>
                     <div class='row mb-3'>
                        <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                           <a class="btn btn-primary" id="addRows" href="javascript:;"><i class="fal fa-plus-circle"></i> Add More</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class='row'>
                <div class="col-md-6 mt-3">
                    <label for="">Customer Notes</label>
                    <textarea name="customer_note" class="form-control ckeditor" rows="8" cols="80"><?php echo $quote->customer_note; ?></textarea>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="">Terms & Conditions</label>
                    <textarea name="terms" class="form-control ckeditor" rows="8" cols="80"><?php echo $quote->terms; ?></textarea>
                    <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                </div>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                     <div class='form-group text-center'>
                        <center>
                           <button type="submit" class="btn btn-pink btn-lg submitQuote"><i class="fas fa-save"></i> Update Quote </button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submitQuoteLoad none" alt="" width="15%">
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         <?php echo e(Form::close()); ?>

         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app.finance.partials._invoice', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('script2'); ?>
   <script type="text/javascript">
      $(document).ready(function(){
         $('.submitQuote').on('submit', function(){
            $(".submitQuote").hide();
            $(".submitQuoteLoad").show();
         });//submit
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/quotes/edit.blade.php ENDPATH**/ ?>