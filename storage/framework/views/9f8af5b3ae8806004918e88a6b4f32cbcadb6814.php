<?php $__env->startSection('title','Product Inventory'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
      <li class="breadcrumb-item"><a href="javascript:;">Products</a></li>
      <li class="breadcrumb-item active">Product Inventory</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-inventory"></i> Product Inventory | <?php echo $product->product_name; ?></h1>
   <!-- end page-header -->
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row">
      <?php echo $__env->make('app.finance.partials._shop_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-9">
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="col-md-12 mt-3">
                  <?php echo Form::model($product, ['route' => ['finance.inventory.settings.update',$productID], 'class' => 'row', 'method'=>'post','enctype'=>'multipart/form-data']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="col-md-6">
                        <h5>Track inventory for this product</h5>
                        <p>Would you like winguplus to track inventory movement for this product?</p>
                        <?php if(Wingu::business()->plan != 1): ?>
                           <div class="form-group required">
                              <?php echo Form::select('track_inventory',[''=>'Choose','Yes' => 'Yes','No' => 'No'],null,['class' => 'form-control multiselect']); ?>

                           </div>
                        <?php endif; ?>
                     </div>
                     
                     <div class="col-md-12">
                        <button type="submit" class="btn btn-success float-left"><i class="fas fa-save"></i> Update</button>
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
         <?php if($product->track_inventory == "Yes"): ?>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title mb-1">Inventory 
                     
                  </h4>
               </div>
               <div class="panel-body">
                  <div class="col-md-12 mt-3">
                     <div class="row">                     
                        <div class="col-md-12">
                           <table class="table table-striped">
                              <thead>
                                 <th width="25%">Out Let</th>
                                 <th>Available stock</th>
                                 <th>Reorder point</th>
                                 <th>Reorder Qty</th>
                                 <th>Expiration Date</th>
                                 <th width="13%"></th>
                              </thead>
                              <tbody>
                                 <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <form action="<?php echo route('finance.inventory.update',[$inventory->id,$productID]); ?>" method="POST" >
                                       <?php echo csrf_field(); ?>
                                       <tr>
                                          <td>
                                             <?php if($inventory->default_inventory == 'Yes'): ?>
                                                <?php echo $mainBranch->branch_name; ?>

                                             <?php else: ?> 
                                                <?php if(Hr::check_branch($inventory->branch_id) == 1): ?>
                                                   <?php echo Hr::branch($inventory->branch_id)->branch_name; ?>

                                                <?php endif; ?>
                                             <?php endif; ?>
                                          </td>
                                          <td><input type="text" class="form-control" name="current_stock" value="<?php echo $inventory->current_stock; ?>"></td>
                                          <td><input type="text" class="form-control" name="reorder_point" value="<?php echo $inventory->reorder_point; ?>"> </td>
                                          <td><input type="text" class="form-control" name="reorder_qty" value="<?php echo $inventory->reorder_qty; ?>"> </td>
                                          <td><input type="date" class="form-control" name="expiration_date" value="<?php echo $inventory->expiration_date; ?>"> </td>
                                          <td>
                                             <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                             <?php if($inventory->default_inventory != 'Yes'): ?>
                                                <?php if(Hr::check_branch($inventory->branch_id) == 1): ?>
                                                   <a href="<?php echo route('finance.inventory.outlet.link.delete',[$productID,$inventory->branch_id]); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                                                <?php endif; ?>
                                             <?php endif; ?>
                                          </td>
                                       </tr>
                                    </form>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div> 
         <?php endif; ?>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Outlet </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="<?php echo route('finance.inventory.outlet.link'); ?>" method="post" enctype="multipart/form-data">
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label for="">Choose Outlet</label>
                  <select name="outlets[]" id="" class="form-control" multiple required style="width:100%">
                     <?php $__currentLoopData = $outlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($mainBranch->id != $outlet->id): ?>
                           <option value="<?php echo $outlet->id; ?>"><?php echo $outlet->branch_name; ?></option>
                        <?php endif; ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <input type="hidden" name="productID" value="<?php echo $productID; ?>" required>
               </div>
               <div class="form-group">
                  <center><button class="btn btn-success btn-sm">Add Outlets</button></center>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/inventory.blade.php ENDPATH**/ ?>