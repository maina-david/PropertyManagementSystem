<?php $__env->startSection('title'); ?><?php echo $property->title; ?> | Billing | Edit Invoices <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="#">Billing</a></li>
         <li class="breadcrumb-item active"><a href="#">Edit</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | Billing | Edit Invoices</h1>
      
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-12">
                  <?php echo Form::model($invoice, ['route' => ['property.invoice.update',[$invoice->id,$propertyID]], 'method'=>'post']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="panel">
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="tenant" class="text-danger">Choose Tenant *</label>
                                    <select name="tenant" class="form-control multiselect" id="tenant" required>
                                       <option selected value="<?php echo e($invoice->tenantID); ?>"><?php echo $tenant->tenant_name; ?></option>
                                       <?php if($invoice->tenantID == ""): ?>
                                          <option value=""><b>Choose tenant</b></option>
                                       <?php endif; ?>
                                       <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tnt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($tnt->tenantID); ?>"><?php echo $tnt->tenant_name; ?></option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group">
                                    <label for="number">Invoice Number</label>
                                    <div class="input-group mb-2">
                                       <div class="input-group-prepend">
                                          <?php if($invoice->invoice_prefix != ""): ?>
                                             <div class="input-group-text"><?php echo e($invoice->invoice_prefix); ?></div>
                                          <?php else: ?> 
                                             <div class="input-group-text"><?php echo e($invoiceSetting->prefix); ?></div>
                                          <?php endif; ?>
                                       </div>
                                       <?php echo Form::text('invoice_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')); ?>

                                 </div>
                                 </div>                        
                              </div> 
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="date" class="text-danger">Issue Date *</label>
                                    <?php echo Form::date('invoice_date', null, array('class' => 'form-control', 'placeholder' => 'YYY-MM-DD','required' => '')); ?>

                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="end" class="text-danger">Due Date * </label>
                                    <?php echo Form::date('invoice_due', null, array('class' => 'form-control', 'placeholder' => 'YYY-MM-DD','required' => '')); ?>

                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <label for="" class="text-danger">Choose Category</label>
                                 <div class="form-group form-group-default">
                                    <select name="income_category" class="form-control multiselect"> 
                                       <option value="<?php echo $invoice->income_category; ?>"><?php echo Finance::original_income_category($invoice->income_category)->name; ?></option>
                                       <?php $__currentLoopData = $incomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo $income->id; ?>"><?php echo $income->name; ?></option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="end">Subject</label>
                                    <?php echo Form::text('invoice_title',null,['class'=>'form-control']); ?>

                                 </div>
                           </div>
                           <div class="col-md-3 col-lg-3">
                              <div class="form-group form-group-default required">
                                 <label for="end" class="text-danger">Unit #</label>
                                 <select name="leaseID" id="leases" class="form-control" required>
                                    <option value="<?php echo $invoice->leaseID; ?>"><?php echo $tenant->serial; ?></option>
                                 </select>
                              </div> 
                           </div>
                           </div>                  
                        </div>
                     </div>
                     <div class="panel panel-default mt-3">
                        <div class="panel-heading">
                           <h4 class="panel-title"><b>Invoice Items</b></h4>
                        </div>
                        <div class="panel-body">
                           <div class='row mt-3'>
                              <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                 <table class="table table-bordered table-striped" id="table">
                                    <thead>
                                       <tr>
                                          <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                                          <th width="35%">Item Name</th>
                                          <th width="13%">Quantity</th>
                                          <th width="13%">Price</th>
                                          <th width="13%">Tax</th>
                                          <th width="25%">Total</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <tr>
                                             <td><input class="case" type="checkbox"/></td>
                                             <td>
                                                <textarea type="text" name="product_name[]" class="form-control" id="itemName_1"><?php echo $product->item_name; ?></textarea>
                                             </td>
                                             <td>
                                                <input type="number" name="qty[]" id="quantity_1" value="<?php echo e($product->quantity); ?>" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                             </td>
                                             <td>
                                                <input type="number" name="price[]" id="price_1" value="<?php echo e($product->price); ?>" class="form-control onchange changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                             </td> 
                                             <td>
                                                <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                                   <?php if($product->taxrate == 0 || $product->taxrate == ""): ?>
                                                      <option value="0">Choose tax rate</option>
                                                   <?php else: ?> 
                                                      <option value="<?php echo $product->taxrate; ?>"><?php echo $product->taxrate; ?>%</option>
                                                   <?php endif; ?>
                                                   <option value="0">No Tax</option>
                                                   <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                          </tr>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                       
                                       <tr>
                                          <td colspan="2" class="col-md-12 col-lg-8"></td>
                                          <td colspan="2" style="width:20%">
                                             <h4 class="pull-right top10">Sub Total</h4>
                                          </td>
                                          <td colspan="3">
                                             <h4 class="text-center">
                                                <input readonly type="number" value="<?php echo $invoice->sub_total; ?>" class="form-control" id="subTotal" step="0.01">
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
                                                <input readonly type="number" class="form-control" value="<?php echo $invoice->taxvalue; ?>" id="taxvalue" step="0.01">
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
                                                <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="<?php echo $invoice->total; ?>" placeholder="Total" step="0.01">
                                             </h4>
                                          </td>
                                       </tr>
                                    </tfoot>
                                 </table>
                              </div>
                           </div>
                           <div class='row mb-3'>
                              <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                                 <button class="btn btn-danger delete" type="button">- Delete</button>
                                 <button class="btn btn-primary addmore" type="button">+ Add More</button>
                              </div>
                           </div>
                           <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                        </div>
                     </div>
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4 class="panel-title">Invoice Note | Terms & conditions</h4>
                        </div>
                        <div class="panel-body">
                           <div class='row mt-3'>
                              <div class="col-md-6 mt-3">
                                 <label for="">Customer Notes</label>
                                 <textarea name="customer_note" class="form-control my-editor" rows="8" cols="80"><?php echo $invoice->customer_note; ?></textarea>
                              </div>
                              <div class="col-md-6 mt-3">
                                 <label for="">Terms & Conditions</label>
                                 <textarea name="terms" class="form-control my-editor" rows="8" cols="80"><?php echo $invoice->terms; ?></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                        <div class='form-group text-center'>
                           <center>
                              <button type="submit"class="btn btn-success btn-lg submit"><i class="fas fa-save"></i> Update Invoice </button>
                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                           </center>
                        </div>
                     </div>
                  <?php echo e(Form::close()); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app.property.partials._invoice', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('script2'); ?>
   <script type="text/javascript">
      $('#tenant').on('change',function(e){
         console.log(e);
         var tenant =  e.target.value;
         var propertyID =  "<?php echo e($propertyID); ?>";
         var url = "<?php echo e(url('/')); ?>";

         //ajax 
         $.get(url+'/property-management/property/'+propertyID+'/invoices/'+tenant+'/leases', function(data){
            //success data
            $('#leases').empty();
            $.each(data, function(leases, lease){
               $('#leases').append('<option value="'+ lease.leaseID +'">'+lease.serial+'</option>');
            });
         });
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/invoices/edit.blade.php ENDPATH**/ ?>