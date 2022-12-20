<a href="" class="btn btn-pink mt-3 mb-3" data-toggle="modal" data-target="#call-log"><i class="fal fa-phone-plus"></i> Add Call log</a>
<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <div class="card">
      <div class="card-header"><?php echo $log->subject; ?></div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-1">
               <?php if(Wingu::check_user($log->created_by) == 1): ?>
                  <img src="https://ui-avatars.com/api/?name=<?php echo Wingu::user($log->created_by)->name; ?>&rounded=true&size=32" alt="">
               <?php else: ?> 
                  <img src="https://ui-avatars.com/api/?name=No User&rounded=true&size=32" alt="">
               <?php endif; ?>
            </div>
            <div class="col-md-11">
               <p>
                  <b>Contact person : </b><span class="text-pink"><?php echo $log->contact_person; ?></span><br>
                  <b>Phone Number : </b><span class="text-pink"><?php echo $log->phone_number; ?></span><br>
                  <b>Call Type : </b><span class="text-pink"><?php echo $log->call_type; ?></span><b> Duration : </b><span class="text-pink"><?php echo $log->hours; ?></span> hours, <span class="text-pink"><?php echo $log->minutes; ?></span> minutes, <span class="text-pink"><?php echo $log->seconds; ?></span> seconds
               </p>
               <?php echo $log->note; ?>

            </div>
         </div>
      </div>
      <div class="card-footer text-muted">
         <div class="row">
            <div class="col-md-8">
               Added <b>by</b> <a href="#"><?php if(Wingu::check_user($log->created_by) == 1): ?><?php echo Wingu::user($log->created_by)->name; ?><?php else: ?> Unknown User <?php endif; ?></a> • <b>at</b> <a href="#"><?php echo date('F d, Y', strtotime($log->created_at)); ?> @ <?php echo date('g:i a', strtotime($log->created_at)); ?></a>     
            </div>
            <div class="col-md-4">
               <a href="<?php echo route('crm.customer.calllog.delete', $log->id); ?>" class="btn btn-sm btn-danger float-right delete"><i class="fas fa-trash"></i> Delete</a>
               <a href="#" data-toggle="modal" data-target="#call-log-<?php echo $log->id; ?>" class="btn btn-sm float-right mr-2 btn-primary"><i class="fas fa-edit"></i> Edit</i></a>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="call-log-<?php echo $log->id; ?>">
      <div class="modal-dialog modal-lg">
         <?php echo Form::model($log, ['route' => ['crm.customer.calllog.update', $log->id], 'method'=>'post']); ?>

            <?php echo csrf_field(); ?>
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title"> Update Call Log</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Subject', 'Subject', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('subject', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Subject')); ?>

                           <input type="hidden" name="customerID" value="<?php echo $customerID; ?>" required>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Phone number', 'Phone Number', array('class'=>'control-label')); ?>

                           <?php echo Form::number('phone_number', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter number')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Contact Person', 'Contact Person', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('contact_person', null, array('class' => 'form-control', 'required' => '', 'placeholder'=>'Enter contacted person')); ?>

                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Hour', 'Hour', array('class'=>'control-label')); ?>

                           <?php echo Form::number('hours', null, array('class' => 'form-control', 'min' => '0', 'max' => '24')); ?>

                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Minutes', 'Minutes', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::number('minutes', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '', 'placeholder' => 'Enter number')); ?>

                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Seconds', 'Seconds', array('class'=>'control-label')); ?>

                           <?php echo Form::number('seconds', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '' , 'placeholder' => 'Enter number')); ?>

                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Call Type', 'Call Type', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::select('call_type', ['' => 'Choose call type','Inbound' => 'Inbound','Outbound' => 'Outbound'], null, array('class' => 'form-control', 'required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('status', 'Status', array('class'=>'control-label')); ?>

                           <?php echo Form::select('statusID', $status, null, array('class' => 'form-control')); ?>

                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Note</label>
                          <?php echo Form::textarea('note', null, array('class' => 'form-control ckeditor', 'required' => '')); ?>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Call log</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                  </center>
               </div>
            </div>
         <?php echo Form::close(); ?>

      </div>
   </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="modal fade" id="call-log">
   <div class="modal-dialog modal-lg">
      <form action="<?php echo route('crm.leads.calllog.store'); ?>" method="post">
         <?php echo csrf_field(); ?>
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> New Call Log</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Subject', 'Subject', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::text('subject', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Subject')); ?>

                        <input type="hidden" name="customerID" value="<?php echo $customerID; ?>" required>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Phone number', 'Phone Number', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::number('phone_number', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter phone number')); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Contact Person', 'Contact Person', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::text('contact_person', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter name')); ?>

                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <?php echo Form::label('Hour', 'Hour', array('class'=>'control-label')); ?>

                        <?php echo Form::number('hours', null, array('class' => 'form-control', 'min' => '0', 'max' => '24', 'placeholder' => 'Enter number')); ?>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Minutes', 'Minutes', array('class'=>'control-label text-danger')); ?>

      						<?php echo Form::number('minutes', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '', 'placeholder' => 'Enter number')); ?>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Seconds', 'Seconds', array('class'=>'control-label text-danger')); ?>

      						<?php echo Form::number('seconds', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '', 'placeholder' => 'Enter number')); ?>

                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Call Type', 'Call Type', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::select('call_type', ['' => 'Choose call type','Inbound' => 'Inbound','Outbound' => 'Outbound'], null, array('class' => 'form-control', 'required' => '')); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <?php echo Form::label('status', 'Status', array('class'=>'control-label')); ?>

      						<?php echo Form::select('statusID', $status, null, array('class' => 'form-control')); ?>

                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                       <label for="">Note</label>
                       <?php echo Form::textarea('note', null, array('class' => 'form-control ckeditor', 'required' => '')); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
               </center>
            </div>
         </div>
      </form>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/leads/calllog/index.blade.php ENDPATH**/ ?>