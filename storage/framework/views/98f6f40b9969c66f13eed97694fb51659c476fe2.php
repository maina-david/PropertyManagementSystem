<div class="row">
   <div class="col-md-12">
      <a href="#create-task" class="btn btn-pink mt-2" data-toggle="modal"><i class="fal fa-tasks"></i> Add Tasks</a>
   </div>
</div>
<div class="row mt-2">
   <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-4">
         <div class="widget-list-item mb-1">
            <div class="widget-list-media">
               <?php if($task->status == 'Completed'): ?>
                  <img src="<?php echo asset('assets/img/complete.png'); ?>" alt="" class="rounded lazy">
               <?php else: ?>
                  <?php if($task->priority == 'High'): ?>
                     <img src="<?php echo asset('assets/img/urgent.png'); ?>" alt="" class="rounded lazy">
                  <?php elseif($task->priority == 'Normal'): ?>
                     <img src="<?php echo asset('assets/img/medium.png'); ?>" alt="" class="rounded lazy">
                  <?php else: ?>
                     <img src="<?php echo asset('assets/img/deafult.png'); ?>" alt="" class="rounded lazy">
                  <?php endif; ?>
               <?php endif; ?>
            </div>
            <div class="widget-list-content">
               <h4 class="widget-list-title mb-1 mt-1">  <?php echo $task->task; ?> </h4>
               <p class="widget-list-desc font-bold">Priority :<span class="font-weight-bold"><?php echo $task->priority; ?></span> | Status : <span class="font-weight-bold"><?php echo $task->status; ?></span> |  Assigned To :<span class="text-primary"><?php if(Hr::check_employee($task->assigned_to) == 1): ?> <?php echo Hr::employee($task->assigned_to)->names; ?> <?php endif; ?> </span> | Due Date : <b><?php echo date('d F Y', strtotime($task->date)); ?></b>
               </p>
               <a href="#" class="float-right ml-2 badge badge-danger delete"><i class="fas fa-trash"></i> Delete</a>
               <a href="#update-task-<?php echo $task->id; ?>" class="float-right ml-2 badge badge-primary" data-toggle="modal"><i class="fas fa-pen-square"></i> Edit</a>
            </div>
         </div>
      </div>
      <div class="modal fade" id="update-task-<?php echo $task->id; ?>" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-lg">
            <?php echo Form::model($task, ['route' => ['crm.leads.tasks.update', $task->id], 'method'=>'post', 'autocomplete'=>'off']); ?>

               <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add Task</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <?php echo csrf_field(); ?>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Task', array('class'=>'control-label')); ?>

                           <?php echo Form::text('task', null, array('class' => 'form-control', 'placeholder' => '')); ?>

                           <input type="hidden" name="leadID" value="<?php echo $customerID; ?>" required>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Category', 'Category', array('class'=>'control-label')); ?>

                           <?php echo e(Form::select('category',[''=>'Choose Category','Call'=>'Call','Email'=>'Email','Follow_up' => 'Follow_up','Meeting' => 'Meeting','Milestone' => 'Milestone','Tweet' => 'Tweet','Other' => 'Other'], null, ['class' => 'form-control'])); ?>

                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Date (Due)', array('class'=>'control-label')); ?>

                           <?php echo Form::date('date', null, array('class' => 'form-control', 'placeholder' => '')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Time', 'Time', array('class'=>'control-label')); ?>

                           <?php echo Form::time('time', null, array('class' => 'form-control', 'placeholder' => '')); ?>

                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Assigned To', array('class'=>'control-label')); ?>

                           <?php echo Form::select('assigned_to', $employees, null, array('class' => 'form-control', 'placeholder' => '')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Time', 'Priority', array('class'=>'control-label')); ?>

                           <?php echo e(Form::select('priority',[''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, ['class' => 'form-control'])); ?>

                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('status', 'Status', array('class'=>'control-label')); ?>

                           <?php echo e(Form::select('status',[''=>'Choose status','Yet to Start'=>'Yet to Start','In Progress'=>'In Progress','Completed' => 'Completed'], null, ['class' => 'form-control'])); ?>

                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                     <?php echo e(Form::textarea('description', null, ['class' => 'form-control ckeditor'])); ?>

                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Task</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                  </center>
               </div>
            </div>
            <?php echo Form::close(); ?>

         </div>
      </div>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>   
  

<div class="modal fade" id="create-task" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg">
      <?php echo Form::open(array('route' => 'crm.leads.tasks.store','method' =>'post','autocomplete'=>'off')); ?>

         <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Task</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <?php echo csrf_field(); ?>
            <div class="row">
               <div class="col-sm-6">
						<div class="form-group form-group-default required">
							<?php echo Form::label('names', 'Task', array('class'=>'control-label text-danger')); ?>

							<?php echo Form::text('task', null, array('class' => 'form-control', 'placeholder' => 'Enter tasks')); ?>

                     <input type="hidden" name="leadID" value="<?php echo $customerID; ?>" required>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group form-group-default required">
							<?php echo Form::label('Category', 'Category', array('class'=>'control-label')); ?>

							<?php echo e(Form::select('category',[''=>'Choose Category','Call'=>'Call','Email'=>'Email','Follow_up' => 'Follow_up','Meeting' => 'Meeting','Milestone' => 'Milestone','Tweet' => 'Tweet','Other' => 'Other'], null, ['class' => 'form-control','required' => ''])); ?>

						</div>
					</div>
				</div>
            <div class="row">
               <div class="col-sm-6">
						<div class="form-group form-group-default required">
							<?php echo Form::label('names', 'Date (Due)', array('class'=>'control-label')); ?>

							<?php echo Form::date('date', null, array('class' => 'form-control', 'placeholder' => '')); ?>

						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group form-group-default">
							<?php echo Form::label('Time', 'Time', array('class'=>'control-label')); ?>

							<?php echo Form::time('time', null, array('class' => 'form-control', 'placeholder' => '')); ?>

						</div>
					</div>
				</div>
            <div class="row">
               <div class="col-sm-6">
						<div class="form-group form-group-default required">
							<?php echo Form::label('names', 'Assigned To', array('class'=>'control-label')); ?>

							<?php echo Form::select('assigned_to', $employees, null, array('class' => 'form-control', 'placeholder' => '','required' => '')); ?>

						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group form-group-default required">
							<?php echo Form::label('Time', 'Priority', array('class'=>'control-label')); ?>

							<?php echo e(Form::select('priority',[''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, ['class' => 'form-control','required' => ''])); ?>

						</div>
					</div>
				</div>
            <div class="row">
               <div class="col-sm-6">
						<div class="form-group form-group-default required">
							<?php echo Form::label('status', 'Status', array('class'=>'control-label')); ?>

							<?php echo e(Form::select('status',[''=>'Choose status','Yet to Start'=>'Yet to Start','In Progress'=>'In Progress','Completed' => 'Completed'], null, ['class' => 'form-control','required' => ''])); ?>

						</div>
					</div>
				</div>
            <div class="form-group required">
               <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

               <?php echo e(Form::textarea('description', null, ['class' => 'form-control ckeditor','required' => ''])); ?>

            </div>
         </div>
         <div class="modal-footer">
            <center>
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Task</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
            </center>
         </div>
      </div>
      <?php echo Form::close(); ?>

   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/leads/tasks/index.blade.php ENDPATH**/ ?>