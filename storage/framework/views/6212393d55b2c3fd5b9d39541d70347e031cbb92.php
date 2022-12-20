<div>
   <div class="col-md-12 mt-3">
      <div class="row">
         <div class="col-md-3">
            <div class="form-group">
               <label for="">Tenant Name</label>
               <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Tenant Name">
            </div>
         </div>
         
         <div class="col-md-3">
            <div class="form-group">
               <label for="">Per Page</label>
               <select wire:model="perPage" class="form-control">                  
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="75">75</option>
                  <option value="100">100</option>
               </select>
            </div>
         </div>
         <div class="col-md-12 mt-2">   
            <div class="panel">
               <div class="panel-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Tenant</th>
                           <th width="8%">Invoice</th>
                           <th>Amount</th>
                           <th>Paid</th>
                           <th>Balance</th>
                           <th>Date</th>
                           <th width="8%">Status</th>
                           <th width="13%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr role="row" class="odd"> 
                              <td><?php echo e($crt+1); ?></td> 
                              <td>
                                 <a class="text-danger" href="<?php echo route('property.tenants.show',[$propertyID,$v->tenantID]); ?>" target="_blank"><?php echo $v->tenant_name; ?></a>
                                 <?php if($v->unitID != ""): ?>
                                    <?php if(Property::check_property_unit($propertyID,$v->unitID) == 1): ?>
                                       <br>
                                       <span class="font-bold badge badge-primary"><?php echo Property::property_unit($propertyID,$v->unitID)->serial; ?></span>
                                    <?php endif; ?>
                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php echo e($v->invoice_prefix); ?><?php echo e($v->invoice_number); ?>

                              </td>
                              <td><?php echo $property->code; ?><?php echo number_format($v->total); ?></td>
                              <td><?php echo $property->code; ?><?php echo number_format($v->paid); ?></td>
                              <td class="v-align-middle">                       
                                 <?php if( $v->statusID == 1 ): ?>
                                    <span class="label label-success">Paid</span>
                                 <?php else: ?>
                                    <?php echo $property->code; ?> <?php echo e(number_format(round($v->total - $v->paid))); ?> 
                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php echo date('M j, Y',strtotime($v->invoice_date)); ?> - <br>
                                 <?php echo date('M j, Y',strtotime($v->invoice_due)); ?>

                              </td>
                              <td><span class="label <?php echo $v->statusName; ?>"><?php echo e($v->statusName); ?></span></td>
                              <td>
                                 <a href="<?php echo route('property.invoice.show',[$propertyID,$v->invoiceID]); ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                 <a href="<?php echo route('property.invoice.edit',[$propertyID,$v->invoiceID]); ?>" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                 <a href="<?php echo route('property.invoice.delete',[$propertyID,$v->invoiceID]); ?>" class="btn btn-danger btn-sm delete"><i class="far fa-trash"></i></a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
                  <?php echo $invoices->links(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/livewire/property/accounting/invoices/index.blade.php ENDPATH**/ ?>