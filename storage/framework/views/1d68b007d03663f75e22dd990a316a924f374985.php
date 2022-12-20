<?php if (app('laratrust')->isAbleTo('create-payments')) : ?>
   <div class="row mb-3">
      <div class="col-md-12">
         <a class="btn btn-pink float-right" href="#add-mode" class="btn btn-pink mb-3" data-toggle="modal"><i class="fas fa-plus"></i> Add Payment Modes</a>
      </div>
   </div>
<?php endif; // app('laratrust')->permission ?>
<table id="data-table-default" class="table table-striped table-bordered table-hover">
   <thead>
      <tr>
         <th width="1%">#</th>
         <th>Title</th>
         <th>Description</th>
         <th width="20%">Action</th>
      </tr>
   </thead>
   <tfoot>
      <tr>
         <th width="1%">#</th>
         <th>Title</th>
         <th>Description</th>
         <th width="20%">Action</th>
      </tr>
   </tfoot>
   <tbody>
      <?php $__currentLoopData = $defaults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $default): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $default->name; ?></td>
            <td><?php echo $default->description; ?></td>
            <td>
               <a href="" class="btn btn-sm btn-default btn-block">Default</a>
            </td>
         </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $account->name; ?></td>
            <td><?php echo $account->description; ?></td>
            <td>
               <?php if (app('laratrust')->isAbleTo('update-payments')) : ?>
                  <a href="#modal-dialog<?php echo $account->id; ?>" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fas fa-edit"></i> Edit</a>
               <?php endif; // app('laratrust')->permission ?>
               <?php if (app('laratrust')->isAbleTo('delete-payments')) : ?>
                  <a href="<?php echo route('finance.payment.mode.delete', $account->id); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
               <?php endif; // app('laratrust')->permission ?>
            </td>
         </tr>
         <!-- #modal-dialog -->
         <div class="modal fade" id="modal-dialog<?php echo $account->id; ?>">
            <div class="modal-dialog">
               <?php echo Form::model($account, ['route' => ['finance.payment.mode.update',$account->id], 'method'=>'post',]); ?>

                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title">Update Payment Mode</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
                        <?php echo csrf_field(); ?>

                        <div class="form-group">
                           <label for="">Mode Name</label>
                           <?php echo Form::text('name', null, array('class' => 'form-control', 'required' => '')); ?>

                        </div>
                        <div class="form-group">
                           <label for="">Descriptions</label>
                           <?php echo Form::textarea('description', null, array('class' => 'form-control')); ?>

                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </div>
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
         <!-- #modal-without-animation -->
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </tbody>
</table>
<?php echo Form::open(array('route' => 'finance.payment.mode.store','enctype'=>'multipart/form-data','method'=>'post' )); ?>

   <?php echo csrf_field(); ?>
   <div class="modal fade" id="add-mode">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add payment mode</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <div class="form-group form-group-default required ">
                  <?php echo Form::label('Mode name', 'Mode name', array('class'=>'control-label')); ?>

                  <?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Mode Name', 'required' =>'' )); ?>

               </div>
               <div class="form-group">
                  <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                  <?php echo Form::textarea('description', null, array('class' => 'form-control', 'size' => '6x10', 'placeholder' => 'Description')); ?>

               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Information</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
            </div>
         </div>
      </div>
   </div>
<?php echo Form::close(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/payments/settings/list.blade.php ENDPATH**/ ?>