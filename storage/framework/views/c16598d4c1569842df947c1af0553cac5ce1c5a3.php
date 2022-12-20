<div class="row">
   <div class="col-md-12">
      <a href="#add-type" data-toggle="modal" class="btn btn-pink mb-2 float-right"><i class="fas fa-calendar"></i> Add Leave Type</a>
   </div>
</div>
<table id="data-table-default" class="table table-striped table-bordered">
   <thead>
      <tr>
         <th width="5%"></th>
         <th class="text-nowrap">Type</th>
         <th class="text-nowrap" width="12%">Action</th>
      </tr>
   </thead>
   <tbody>
      <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $type->name; ?></td>
            <td><a href="<?php echo route('hrm.leave.settings.type.delete',$type->id); ?>" class="btn btn-danger delete">Delete</a></td>
         </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </tbody>
</table>

<div class="modal fade" id="add-type" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <?php echo Form::open(array('route' => 'hrm.leave.settings.type.store','method' =>'post','autocomplete'=>'off')); ?>

         <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Type</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <?php echo csrf_field(); ?>
            <div class="form-group form-group-default required">
               <?php echo Form::label('names', 'Leave Type Name', array('class'=>'control-label')); ?>

               <?php echo Form::text('name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter Name')); ?>

            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Type</button>
            <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
         </div>
      </div>
      <?php echo Form::close(); ?>

   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/leave/settings/type.blade.php ENDPATH**/ ?>