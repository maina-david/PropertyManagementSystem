<div class="row">
   <div class="col-md-12 mb-2">
      <a href="<?php echo route('assets.maintenances.create',$details->id); ?>" class="btn btn-pink pull-right"><i class="fas fa-plus-circle"></i> Add Maintenance</a>
   </div>
   <div class="col-md-12">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead id="assetMaintenancesTable-sticky-header" style="">
            <tr>
               <th width="1%">#</th>
               <th>Maintenance Type</th>
               <th>Title</th>
               <th>Start Date</th>
               <th>Completion Date</th>
               <th>Warranty</th>
               <th>Cost</th>
               <th>Supplier</th>
               <th width="8%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $maintenances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maintenance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo $maintenance->maintenance_type; ?></td>
                  <td><?php echo $maintenance->title; ?></td>
                  <td>
                     <?php if($maintenance->start_date): ?>
                        <?php echo date('M jS, Y', strtotime($maintenance->start_date)); ?> @ <?php echo date('h:i:s A', strtotime($maintenance->start_date)); ?>

                     <?php endif; ?>
                  </td>
                  <td>
                     <?php if($maintenance->completion_date): ?>
                        <?php echo date('M jS, Y', strtotime($maintenance->completion_date)); ?> @ <?php echo date('h:i:s A', strtotime($maintenance->completion_date)); ?>

                     <?php endif; ?>
                  </td>
                  <td><?php echo $maintenance->warranty_improvement; ?></td>
                  <td><?php echo number_format($maintenance->cost); ?></td>
                  <td>
                     <?php if($maintenance->supplierID != ""): ?>
                        <?php if(Finance::check_supplier($maintenance->supplierID) == 1): ?>
                           <b><?php echo Finance::supplier($maintenance->supplierID)->supplierName; ?></b>
                        <?php endif; ?>
                     <?php endif; ?>
                  </td>
                  <td>
                     <a href="<?php echo route('assets.maintenances.edit',[$details->id,$maintenance->id]); ?>" class="btn btn-primary btn-sm"><i class="fal fa-edit"></i></a>
                     <a href="" class="btn btn-sm btn-danger delete"><i class="fal fa-trash"></i></a>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div> <!-- row --><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/assets/maintenances.blade.php ENDPATH**/ ?>