<div class="card mt-3">
   <div class="card-header"><i class="fal fa-tasks"></i> Projects</div>
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="13%">Project</th>
               <th>Date started</th>
               <th>End date</th>
               <th>Progress</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th width="13%">Project</th>
               <th>Date started</th>
               <th>End date</th>
               <th>Progress</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr role="row" class="odd">
                  <td><?php echo e($crt+1); ?></td>
                  <td><?php echo $v->project_name; ?></td>
                  <td><?php echo date('F jS, Y', strtotime($v->start_date)); ?></td>
                  <td><?php echo date('F jS, Y', strtotime($v->end_date)); ?></td>
                  <td><?php echo $v->progress; ?></td>
                  <td><span class="badge <?php echo Wingu::status($v->statusID)->name; ?>"><?php echo Wingu::status($v->statusID)->name; ?></span></td>
                  <td><a href="<?php echo route('project.show',$v->id); ?>" class="btn btn-sm btn-pink" target="_blank"><i class="fas fa-eye"></i> view</td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/customers/projects.blade.php ENDPATH**/ ?>