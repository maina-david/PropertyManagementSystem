<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-body">
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
            </div>
            <div class="row">
               <div class="col-md-12 mb-1">
                  <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th width="5%">Image</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Phone number</th>                       
                           <th>Lease</th>
                           <th>Dates</th>
                           <th width="9%">Action</th>
                        </tr>
                     </thead> 
                     <tbody>
                        <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td>
                                 <?php if($tenant->image == ""): ?>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo $tenant->tenant_name; ?>&rounded=true&size=40" alt="<?php echo $tenant->tenant_name; ?>"/>
                                 <?php else: ?>
                                    <img width="40" height="40" alt="" class="img-circle" src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/property/tenant/'.$tenant->tenant_code); ?>/images/<?php echo $tenant->image; ?>">
                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php echo $tenant->tenant_name; ?> 
                              </td>
                              <td><?php echo $tenant->contact_email; ?></td>
                              <td><?php echo $tenant->primary_phone_number; ?></td>
                              <td><?php echo Property::count_lease($tenant->id); ?></td>
                              <td>
                                 <b>Registered :</b> <?php echo date('M jS, Y', strtotime($tenant->created_at)); ?>

                              </td>
                              <td>
                                 
                                 <a href="<?php echo route('tenants.edit',$tenant->id); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                 <a href="<?php echo route('tenants.delete',$tenant->tenant_code); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
                  <?php echo $tenants->links(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/livewire/property/tenants/index.blade.php ENDPATH**/ ?>