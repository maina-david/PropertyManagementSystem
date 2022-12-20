<?php $__env->startSection('title','Add New Credit note'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.creditnote.index'); ?>">Credit note</a></li>
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-credit-card"></i> Create Credit note</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>      
      <?php echo e(Form::open(array('route' => 'finance.creditnote.store'))); ?>

         <?php echo csrf_field(); ?>
         <div class='row'>
            <div class="col-md-6 col-lg-6">
               <div class="form-group form-group-default">
                  <label for="Customer" class="text-danger">Customer *</label>
                  <select name="customer" class="form-control multiselect" id="client_select" required>
                     <option value="" selected>Choose Customer</option>
                     <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cli->id); ?>"> <?php echo $cli->customer_name; ?></option>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
               </div>
            </div> 
            <div class="col-md-6 col-lg-6">
               <div class="form-group">
                  <label for="number">Credit Note Number</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre"><?php echo e(Finance::creditnote()->prefix); ?></span>
                     <input type="text" name="creditnote_number" class="form-control required no-line" autocomplete="off" value="<?php echo e(Finance::creditnote()->number + 1); ?>" readonly>
                  </div>
                  <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Title</label>
                  <?php echo Form::text('title', null ,['class' => 'form-control','placeholder' => 'Enter title']); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Reference number #</label>
                  <?php echo Form::text('reference_number', null ,['class' => 'form-control','placeholder' => 'Enter Reference Number']); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="date" class="text-danger">Credit Note Date *</label>
                  <input type="date" name="creditnote_date" class="form-control required" autocomplete="off" required>
               </div>
            </div>
         </div>
         <div class="panel panel-default mt-3">
            <div class="panel-heading">
               <h4 class="panel-title">Credit Note Items</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                     <table class="table table-bordered table-striped" id="lpoItem">
                        <thead>
                           <tr>
                              <th width="40%">Item Name</th>
                              <th>Price</th>
                              <th>Quantity</th>
                              <th>Total</th>
                              <th width="1%"></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr class="clone-item">
                              <td>
                                 <select name="productID[]" class="form-control dublicateSelect2 onchange solsoCloneSelect2" id="itemName_1" data-init-plugin='select2' required>
                                    <option value="">Choose Producrs</option>
                                    <?php $__currentLoopData = $Itemproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                       
                                       <option value="<?php echo e($prod->productID); ?>"> 
                                          <?php echo e(substr($prod->product_name, 0, 100)); ?> <?php echo e(strlen($prod->product_name) > 100 ? '...' : ''); ?> 
                                          <?php if($prod->track_inventory == 'Yes'): ?>
                                             <?php if($prod->type == 'product' && $prod->current_stock <= 0 ): ?>***** OUT OF STOCK ***** <?php endif; ?>
                                          <?php endif; ?>
                                       </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $Itemservice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                       
                                       <option value="<?php echo e($service->productID); ?>"> 
                                          <?php echo e(substr($service->product_name, 0, 100)); ?> <?php echo e(strlen($service->product_name) > 100 ? '...' : ''); ?> 
                                       </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select> 
                              </td>                                 
                              <td> 
                                 <input type="number" name="qty[]" id="quantity_1" class="form-control changesNo quanyityChange" required>
                              </td>
                              <td>
                                 <input type="number" name="price[]" id="price_1" class="form-control changesNo" autocomplete="off" step="0.01" required>
                              </td>
                              <td class="none">
                                 <input type="number"  id="discount_1" class="form-control discount changesNo" autocomplete="off" step="0.01" >
                              </td>
                              <td class="none">
                                 <select  class="form-control changesNo onchange" id="tax_1" autocomplete="off">                                    
                                    
                                 </select>
                                 <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" autocomplete="off" step="0.01" readonly>
                              </td>
                              <td>
                                 <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" placeholder="Main Amount" step="0.01" readonly>
                                 <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" placeholder="Total Amount" step="0.01" readonly>
                                 <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" placeholder="Total Sum" step="0.01" readonly>
                              </td>
                              <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                           <table class="table table-bordered table-striped">
                              <tr>
                                 <td>Sub Total</td>
                                 <td>
                                    <input readonly value="0" type="number" class="form-control" id="subTotal"  onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </td>
                              </tr>
                              <tr>
                                 <td>Total Amount</td>
                                 <td>
                                    <input readonly value="0" type="number" class="form-control" id="InvoicetotalAmount" placeholder="Total" step="0.01">
                                 </td>
                              </tr>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div class='row mb-3'>
                  <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                     <a class="btn btn-primary" id="addRows" href="javascript:;"><i class="fal fa-plus-circle"></i> Add More</a>
                  </div>
               </div>
            </div>
         </div>
         <div class='row mt-3'>
            <div class="col-md-6 mt-3">
               <label for="">Customer Notes</label>
               <textarea name="customer_note" class="form-control ckeditor" rows="8" cols="80"><?php echo Finance::creditnote()->default_customer_notes; ?></textarea>
            </div>
            <div class="col-md-6 mt-3">
               <label for="">Terms & Conditions</label>
               <textarea name="terms" class="form-control ckeditor" rows="8" cols="80"><?php echo Finance::creditnote()->default_terms_conditions; ?></textarea>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
               <div class='form-group text-center'>
                  <center>
                     <button type="submit"class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Create Credit note </button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                  </center>
               </div>
            </div>
         </div>
      <?php echo e(Form::close()); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app.finance.partials._lpo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/creditnote/create.blade.php ENDPATH**/ ?>