<div class="card">
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th>Number</th>
               <th>Reference Number</th>
               <th>Amount</th>
               <th>Status</th>
               <th>Date</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th>Number</th>
               <th>Reference Number</th>
               <th>Amount</th>
               <th>Status</th>
               <th>Date</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            <?php $__currentLoopData = $lpos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr role="row" class="odd">
                  <td><?php echo e($crt+1); ?></td>
                  <td>
                     <b><?php echo Finance::lpo()->prefix; ?>00<?php echo $v->lpo_number; ?></b>
                  </td>
                  </td>
                  <td class="text-uppercase font-weight-bold">
                     <?php echo $v->reference_number; ?>

                  </td>
                  <td><?php echo number_format($v->total); ?> <?php echo Finance::currency($v->currencyID)->symbol; ?></td>
                  <td><span class="badge <?php echo Wingu::status($v->statusID)->name; ?>"><?php echo ucfirst(Wingu::status($v->statusID)->name); ?></span></td>
                  <td>
                     <?php echo date('F j, Y',strtotime($v->created_at)); ?>

                  </td>
                  <td>
                     <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                        <ul class="dropdown-menu">
                           <li><a href="<?php echo e(route('finance.lpo.show', $v->id)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                           <li><a href="<?php echo route('finance.lpo.edit', $v->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           <li><a href="<?php echo route('finance.lpo.delete', $v->id); ?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                        </ul>
                     </div>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/customers/lpos.blade.php ENDPATH**/ ?>