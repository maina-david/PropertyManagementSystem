<div>
   <div class="col-md-12">
      <div class="row">
         <div class="col-md-12 mt-2 mb-2">
            <a href="#" data-toggle="modal" data-target="#bulk" class="btn btn-primary"><i class="fal fa-plus-circle"></i> Bulk utility billing</a>
            
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Tenant Name">
            </div>
         </div> 
         <div class="col-md-4">
            <div class="form-group">
               <select wire:model="utility" class="form-control">
                  <option value="">Choose Utility</option>
                  <?php $__currentLoopData = $utilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $utility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <option value="<?php echo $utility->id; ?>"><?php echo $utility->name; ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <select wire:model="perPage" class="form-control">                  
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="75">75</option>
                  <option value="100">100</option>
               </select>
            </div>
         </div>
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">                  
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Tenant</th>
                           <th>Utility</th>
                           <th>Prev</th>
                           <th>Curr</th>
                           <th>Cons</th>
                           <th>price</th>
                           <th>Amount</th>
                           <th>Paid</th>
                           <th>Balance</th>
                           <th>Status</th>
                           <th>Period</th>
                           <th width="12%">Action</th>
                        </tr>
                     </thead> 
                     <tbody>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input type="hidden" name="invoiceID" value="<?php echo $invoice->invoiceID; ?>">
                           <?php echo csrf_field(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td>
                                 <?php echo $invoice->tenant_name; ?><br>
                                 <span class="badge badge-warning"><?php echo $invoice->utility_No; ?></span>
                              </td>
                              <td><?php echo $invoice->item_name; ?></td>
                              <td>
                                 <?php if($invoice->current_units == "" || $invoice->current_units == 0): ?>
                                    <?php echo $invoice->last_reading; ?>

                                 <?php else: ?> 
                                    <?php echo $invoice->previous_units; ?>

                                 <?php endif; ?>
                              </td>
                              <td><?php echo $invoice->current_units; ?></td>
                              <td><?php echo $invoice->quantity; ?></td>
                              <td><?php echo $invoice->unitPrice; ?></td>  
                              <td><?php echo $invoice->code; ?> <?php echo number_format($invoice->total_amount); ?></td>
                              <td> 
                                 <?php echo $invoice->code; ?><?php echo number_format($invoice->paid); ?>  
                              </td>  
                              <td> 
                                 <?php if($invoice->statusID == 1 ): ?>
                                    <span class="label label-success">Paid</span>
                                 <?php else: ?>
                                    <?php echo $invoice->code; ?> <?php echo e(number_format(round($invoice->invoice_total - $invoice->paid))); ?> 
                                 <?php endif; ?>      
                              </td>  
                              <td> 
                                 <span class="label <?php echo $invoice->status_name; ?>"><?php echo e($invoice->status_name); ?></span>  
                              </td>  
                              <td>
                                 <b><?php echo date('d M, y', strtotime($invoice->invoice_date)); ?> - <br><?php echo date('d M, y', strtotime($invoice->invoice_due)); ?></b>   
                              </td>
                              <td>
                                 <a href="<?php echo route('property.utility.billing.show',[$propertyID,$invoice->invoiceID]); ?>" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                                 <?php if($invoice->status_name == 'unpaid' ): ?>
                                    <?php if($invoice->current_units == "" || $invoice->current_units == 0): ?>
                                       <a href="#" title="Add Current reading and calculate" data-toggle="modal" data-target="#editUtility<?php echo $invoice->invoiceID; ?>" class="btn btn-sm btn-success"><i class="fad fa-calculator-alt"></i></a>
                                    <?php else: ?> 
                                       <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editUtility<?php echo $invoice->invoiceID; ?>"><i class="fas fa-edit"></i></a>
                                    <?php endif; ?>
                                 <?php endif; ?>
                                 <a href="<?php echo route('property.utility.billing.delete',[$propertyID,$invoice->invoiceID]); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                              </td>
                           </tr>
                           <!-- Modal -->
                           <div class="modal fade" id="editUtility<?php echo $invoice->invoiceID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                 <?php if($invoice->current_units == "" || $invoice->current_units == 0): ?>
                                    <form action="<?php echo route('property.calculate.utility.consumption',[$propertyID,$invoice->invoiceProductID]); ?>" method="post" autocomplete="off">
                                 <?php else: ?> 
                                    <form action="<?php echo route('property.update.utility.consumption',[$propertyID,$invoice->invoiceProductID]); ?>" method="POST">
                                 <?php endif; ?>
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <?php if($invoice->current_units == "" || $invoice->current_units == 0): ?>
                                             <h5 class="modal-title" id="exampleModalLongTitle">Calculate Utility Bill</h5>
                                          <?php else: ?> 
                                             <h5 class="modal-title" id="exampleModalLongTitle">Update Utility Bill</h5>
                                          <?php endif; ?>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">                                       
                                          <div class="form-group">
                                             <label for="">Current Consumption</label>
                                             <input type="number" class="form-control" name="current" step="0.01" min="<?php echo $invoice->previous_units; ?>" value="<?php echo $invoice->current_units; ?>" required>
                                             <input type="hidden" class="form-control" name="invoiceID" value="<?php echo $invoice->invoiceID; ?>" required>
                                          </div>
                                          <div class="form-group">
                                             <label for="">Current Price</label>
                                             <input type="number" class="form-control" step="0.01" name="price" value="<?php echo $invoice->unitPrice; ?>" required>
                                          </div>
                                          
                                          
                                       </div>
                                       <div class="modal-footer">         
                                          <?php if($invoice->current_units == "" || $invoice->current_units == 0): ?>                              
                                             <button type="submit" class="btn btn-success submit">Calculating Utility Billing</button>
                                          <?php else: ?> 
                                             <button type="submit" class="btn btn-warning submit">Update Utility Billing</button>
                                          <?php endif; ?>
                                          <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
                  <?php echo $invoices->links(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <div class="modal fade" id="bulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Billing Details</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="<?php echo route('property.prepare.utility.billing',$propertyID); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Issue Date</label>
                           <?php echo Form::date('issue_date',null,['class'=>'form-control','required'=>'']); ?>

                        </div>
                     </div> 
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Due Date</label>
                           <?php echo Form::date('due_date',null,['class'=>'form-control','required'=>'']); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Utility</label>
                           <select name="utility" class="form-control" required>
                              <option value="">Choose Utility</option>
                              <?php $__currentLoopData = $utilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $utility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $utility->id; ?>"><?php echo $utility->name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Customer Note</label>
                           <?php echo Form::textarea('customer_note',null,['class'=>'form-control','size' => '9 x 9']); ?>

                        </div>
                     </div>  
                     <div class="col-md-12">
                        <button class="btn btn-success float-right submit" type="submit"><i class="fas fa-save"></i> Save and process billing</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load float-right none" alt="Loader" width="25%">
                     </div>                 
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div> 
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/livewire/property/utility/index.blade.php ENDPATH**/ ?>