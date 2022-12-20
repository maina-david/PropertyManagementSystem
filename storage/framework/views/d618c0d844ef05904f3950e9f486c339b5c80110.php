<?php $__env->startSection('title','Update Invoice'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.invoice.index'); ?>">Invoice</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-file-invoice"></i> Update Invoice</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="panel panel-inverse">
			<div class="panel-body">
         <?php echo Form::model($invoice, ['route' => ['finance.invoice.random.update',$invoice->id], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

            <?php echo csrf_field(); ?>
            <div class="load-animate">
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="client" class="text-danger">Choose Clients *</label>
                        <select name="client" class="form-control default-select2" required>
                           <?php if(Finance::client($invoice->client_id)->company_name != ""): ?>
                              <option selected value="<?php echo e($invoice->client_id); ?>"><?php echo Finance::client($invoice->client_id)->company_name; ?></option>
                           <?php else: ?>
                              <option selected value="<?php echo e($invoice->client_id); ?>"><?php echo Finance::client($invoice->client_id)->client_name; ?></option>
                           <?php endif; ?>
                           <option value=""><b>Choose Client</b></option>
                           <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($cli->id); ?>">
                                 <?php if($cli->company_name != ""): ?>
                                    <?php echo $cli->company_name; ?>

                                 <?php elseif($cli->client_name != ""): ?>
                                    <?php echo $cli->client_name; ?>

                                 <?php endif; ?>
                              </option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="number">Invoice Number</label>
                        <div class="input-group">
                           <span class="input-group-addon solso-pre"><?php echo e(Finance::invoice_settings()->prefix); ?></span>
                           <?php echo Form::text('invoice_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')); ?>

                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="number" class="">LPO # </label>
                        <div class="input-group">
                           <input type="text" name="lpo_number" class="form-control" value="<?php echo e($invoice->lpo_number); ?>" >
                        </div>
                     </div>
                  </div>
               </div>
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="currency" class="text-danger">Choose Currency *</label>
                        <select name="currency" class="form-control default-select2" required>
                           <option selected value="<?php echo e($invoice->currencyID); ?>">
                              <?php echo Finance::currency($invoice->currencyID)->code; ?>

                           </option>
                           <option value="">Choose Currency</option>
                           <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($c->id); ?>"><b><?php echo $c->currency_name; ?></b> - <?php echo e($c->code); ?> </option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="date" class="text-danger">Date Create *</label>
                        <?php echo Form::text('invoice_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Date Create','required' => '')); ?>

                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="end" class="text-danger">Expiry Date * </label>
                        <?php echo Form::text('invoice_due', null, array('class' => 'form-control datepicker-rs', 'placeholder' => 'Expiry Date','required' => '')); ?>

                     </div>
                  </div>
               </div>
               <div class='row mt-3'>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                              <th width="38%">Item Name</th>
                              <th width="15%">Price</th>
                              <th width="15%">Quantity</th>
                              <th width="15%">Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr id="tr_1">
                                 <td><input class="case" type="checkbox"/></td>
                                 <td>
                                    <textarea type="text" name="product_name[]" id="itemName_1" class="form-control"><?php echo $product->product_name; ?></textarea>
                                 </td>
                                 <td>
                                    <input type="number" name="price[]" id="price_1" value="<?php echo e($product->total_amount); ?>" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </td>
                                 <td>
                                    <input type="number" name="qty[]" id="quantity_1" value="<?php echo e($product->quantity); ?>" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </td>
                                 <td>
                                    <input type="number" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="<?php echo $product->total_amount * $product->quantity ?>">
                                 </td>
                              </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                           <?php if(Finance::estimate()->show_discount_tab == 'Yes'): ?>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Discount</h4>
                              </td>
                              <td colspan="2">
                                 <h4 class="text-center">
                                    <select name="discount_type" class="form-control mb-2" id="type">
                                       <?php if($invoice->discount_type != ""): ?>
                                          <option value="<?php echo $invoice->discount_type; ?>"><?php echo $invoice->discount_type; ?></option>
                                       <?php endif; ?>
                                       <option value="">Choose discount type</option>
                                       <option value="amount">Amount</option>
                                       <option value="percentage">Percentage (%)</option>
                                    </select>
                                    <input name="discount" class="form-control" id="discount" value="<?php echo $invoice->discount; ?>">
                                 </h4>
                              </td>
                           </tr>
                           <?php endif; ?>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Sub Total</h4>
                              </td>
                              <td colspan="2">
                                 <h4 class="text-center">
                                    <input readonly  value="<?php echo $invoice->sub_total; ?>" type="number" class="form-control" id="subTotal"  onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </h4>
                              </td>
                           </tr>
                           <?php if(Finance::estimate()->show_tax_tab == 'Yes'): ?>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Tax - <?php echo $invoice->tax; ?>%</h4>
                              </td>
                              <td colspan="2">
                                 <h4 class="text-center">
                                    <select name="tax" class="form-control required solsoEvent mb-2" id="tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required>
                                       <?php if($invoice->tax != ""): ?>
                                       <option value="<?php echo $invoice->tax; ?>"><?php echo $invoice->tax; ?>%</option>
                                       <?php endif; ?>
                                       <option value="0">Choose tax rate</option>
                                       <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($tx->rate); ?>"><?php echo e($tx->name); ?> - <?php echo e($tx->rate); ?>%</option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <input readonly value="<?php echo $invoice->sub_total * ($invoice->tax / 100) ?>" type="number" class="form-control"  id="taxAmount" placeholder="Tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </h4>
                              </td>
                           </tr>
                           <?php endif; ?>
                           <tr class="table-default">
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Total Amount</h4>
                              </td>
                              <td colspan="2">
                                 <h4 class="text-center">
                                    <input readonly value="<?php echo $invoice->total; ?>" type="number" class="form-control" name="data[Invoice][invoice_total]" id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
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
               <div class='row'>
						<div class="col-md-6 mt-3">
							<label for="">Customer Notes</label>
							<textarea name="customer_note" class="form-control ck4standard" rows="8" cols="80"><?php echo $invoice->customer_note; ?></textarea>
						</div>
						<div class="col-md-6 mt-3">
							<label for="">Terms & Condition</label>
							<textarea name="terms" class="form-control ck4standard" rows="8" cols="80"><?php echo $invoice->terms; ?></textarea>
						</div>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                     <div class='form-group text-center'>
                        <center>
                           <button type="submit"class="btn btn-primary btn-lg submit"><i class="fas fa-save"></i> Update Invoice </button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  </div>
               </div>
               <div class
            </div>
         <?php echo e(Form::close()); ?>

         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script>
	   //adds extra table rows
	   var i=$('table tr').length;

	   $(".addmore").on('click',function(){
	      addNewRow();
	   });

	   $(document).on('keypress', ".addNewRow", function(e){
	      var keyCode = e.which ? e.which : e.keyCode;
	      if(keyCode == 9 ) addNewRow();
	   });

	   var readonly = $('#readonly').val();

	   var addNewRow = function(id){
	      html = '<tr id="tr_'+i+'">';
	      html += '<td><input class="case" id="caseNo_'+i+'" type="checkbox"/></td>';
	      html += '<td><textarea type="text" name="product_name[]"  id="itemName_'+i+'" class="form-control" autocomplete="off" required></textarea></td>';
	      html += '<td><input '+readonly+' type="text" name="price[]" id="price_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required></td>';

	      html += '<td><input type="text" name="qty[]" id="quantity_'+i+'" class="form-control changesNo quanyityChange" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required>';
	      html += '</td>';
	      html += '<td><input type="text" id="total_'+i+'" class="form-control totalLinePrice addNewRow" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required></td>';
	      html += '</tr>';

	      if( typeof id !== "undefined"){
	         $('#tr_'+id).after(html);
	      }else{
	         $('table').append(html);
	      }

	      console.log(id);

	      $('#caseNo_'+i).focus();

	      i++;
	   }

	   //to check all checkboxes
	   $(document).on('change','#check_all',function(){
	      $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
	   });

	   //deletes the selected table rows
	   $(".delete").on('click', function() {
	      $('.case:checkbox:checked').parents("tr").remove();
	      $('#check_all').prop("checked", false);
	      calculateTotal();
	   });

	   $(document).on('click','.add_icon',function(){
	      var add_icon_id = $(this).attr('id');
	      var add_icon_arr = add_icon_id.split("_");
	      var icon_id = add_icon_arr[add_icon_arr.length-1];
	      addNewRow(icon_id);
	   });

	   //price change
	   $(document).on('keyup','.changesNo',function(){
	      id_arr = $(this).attr('id');
	      id = id_arr.split("_");

	      quantity = $('#quantity_'+id[1]).val();
	      price = $('#price_'+id[1]).val();
	      if( quantity!='' && price !='' ) $('#total_'+id[1]).val( (parseFloat(price)*parseFloat(quantity)).toFixed(2) );
	      calculateTotal();
	   });

	   $(document).on('change keyup blur','#tax',function(){
	      calculateTotal();
	   });

	   //total price calculation
	   function calculateTotal(){
	      subTotal = 0 ;
			total = 0;

	      $('.totalLinePrice').each(function(){
	         if($(this).val() != '' )subTotal += parseFloat( $(this).val() );

				discount = $('#discount').val();
				type = $('#type').val();

				if(discount != '' && type != ''){
					if(type == 'amount'){
						subTotal = subTotal - discount;
					}else if(type == 'percentage'){

						percentage = subTotal * (discount/100);

                 	subTotal = subTotal - percentage;
					}
				}else{

					subTotal = subTotal;
				}
	      });

	      $('#subTotal').val(subTotal.toFixed(2) );

	      tax = $('#tax').val();

	      if(tax != '' && typeof(tax) != "undefined" ){
	         taxAmount = subTotal * ( parseFloat(tax) /100 );
	         $('#taxAmount').val(taxAmount.toFixed(2));
	         total = subTotal + taxAmount;
	      }else{
	         $('#taxAmount').val(0);
	         total = subTotal;
	      }

	      $('#totalAftertax').val( total.toFixed(2) );

	      calculateAmountDue();
	   }

	   //It restrict the non-numbers
	   var specialKeys = new Array();
	   specialKeys.push(8,46); //Backspace
	   function IsNumeric(e) {
	      var keyCode = e.which ? e.which : e.keyCode;
	      if(keyCode == 9 )return true;
	      var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
	      return ret;
	   }
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/invoices/random/edit.blade.php ENDPATH**/ ?>