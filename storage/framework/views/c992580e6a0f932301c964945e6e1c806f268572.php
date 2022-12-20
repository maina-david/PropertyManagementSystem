<div class="row">
   <div class="col-md-12 mb-3">
      <a href="javascript;" data-toggle="modal" data-target="#call-log" class="btn btn-pink btn-sm float-right"><i class="fas fa-phone-plus"></i> Add call log</a>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <ul class="media-list media-list-with-divider">
               <?php $__currentLoopData = $calllogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="media media-sm">
                     <a class="media-left" href="javascript:;">
                        <?php if(Wingu::user($call->created_by)->employeeID != ""): ?>)
                           <?php if(Hr::check_employee(ingu::user($call->created_by)->employeeID) == 1): ?>
                              <?php if(Hr::employee(Wingu::user($call->created_by)->employeeID)->image != ""): ?>
                                 <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/hr/employee/images/'.Hr::employee(Wingu::user($call->created_by)->employeeID)->image); ?>" alt="" class="media-object rounded-corner">
                              <?php endif; ?>
                           <?php endif; ?>
                        <?php else: ?>
                           <?php if(Wingu::check_user($call->created_by) == 1): ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo Wingu::user($call->created_by)->name; ?>&rounded=true&size=32" alt="">
                           <?php else: ?> 
                              <img src="https://ui-avatars.com/api/?name=No User&rounded=true&size=32" alt="">
                           <?php endif; ?>
                        <?php endif; ?> 
                     </a>
                     <div class="media-body">
                        <h5 class="media-heading"><?php echo $call->subject; ?></h5>
                        <p>
                           <b>Contact person :</b> <span class="text-primary"><?php echo $call->contact_person; ?></span> | <b>Phone Number :</b><span class="text-primary">+<?php echo Wingu::country($call->phone_code)->phonecode; ?><?php echo $call->phone_number; ?></span> | <b>Call Type :</b> <span class="text-primary"><?php echo $call->call_type; ?></span> | <b>Duration :</b> <span class="text-primary"><?php echo $call->hours; ?></span> hours, <span class="text-primary"><?php echo $call->minutes; ?></span> minutes, <span class="text-primary"><?php echo $call->seconds; ?></span> seconds
                        </p>
                        <?php echo $call->note; ?>

                        <p class="mt-2">
                           Call by • <b>by</b> <a href="#"><?php if(Wingu::check_user($call->created_by) == 1): ?><?php echo Wingu::user($call->created_by)->name; ?><?php else: ?> Unknown User <?php endif; ?></a> • <b>at</b> <a href="#"><?php echo date('F d, Y', strtotime($call->created_at)); ?> @ <?php echo date('g:i a', strtotime($call->created_at)); ?></a>
                           <a href="<?php echo route('crm.deals.calllog.delete', $call->id); ?>" class="btn btn-sm btn-danger float-right delete"><i class="fas fa-trash"></i></a>
                           <a href="#" data-toggle="modal" data-target="#call-log-<?php echo $call->id; ?>" class="btn btn-sm btn-default float-right mr-2"><i class="fas fa-edit"></i></a>
                        </p>
                     </div>
                  </li>
                  <hr>
                  <div class="modal fade" id="call-log-<?php echo $call->id; ?>">
                     <div class="modal-dialog modal-lg">
                        <?php echo Form::model($call, ['route' => ['crm.deals.calllog.update', $call->id], 'method'=>'post']); ?>

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
                                          <?php echo Form::label('Subject', 'Subject', array('class'=>'control-label')); ?>

                                          <?php echo Form::text('subject', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter call subject')); ?>

                                          <input type="hidden" name="dealID" value="<?php echo $deal->dealID; ?>" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group form-group-default required">
                                          <?php echo Form::label('Phone code', 'Country code', array('class'=>'control-label')); ?>

                                          <?php echo Form::select('phone_code', $phoneCode, null, array('class' => 'form-control', 'required' => '')); ?>

                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <div class="form-group form-group-default required">
                                          <?php echo Form::label('Phone number', 'Phone Number', array('class'=>'control-label')); ?>

                                          <?php echo Form::number('phone_number', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter phone number')); ?>

                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default">
                                          <?php echo Form::label('Call Type', 'Call Type', array('class'=>'control-label')); ?>

                                          <?php echo Form::select('call_type', ['' => 'Choose call type','Inbound' => 'Inbound','Outbound' => 'Outbound'], null, array('class' => 'form-control', 'required' => '')); ?>

                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default required">
                                          <?php echo Form::label('Contact Person', 'Contact Person', array('class'=>'control-label')); ?>

                                          <?php echo Form::text('contact_person', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter contact person')); ?>

                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group form-group-default required">
                                          <?php echo Form::label('Hour', 'Hour', array('class'=>'control-label')); ?>

                                          <?php echo Form::number('hours', null, array('class' => 'form-control', 'min' => '0', 'max' => '24', 'required' => '','placeholder' => 'Enter Hours')); ?>

                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group form-group-default required">
                                          <?php echo Form::label('Minutes', 'Minutes', array('class'=>'control-label')); ?>

                                          <?php echo Form::number('minutes', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '','placeholder' => 'Enter minutes')); ?>

                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group form-group-default required">
                                          <?php echo Form::label('Seconds', 'Seconds', array('class'=>'control-label')); ?>

                                          <?php echo Form::number('seconds', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '','placeholder' => 'Enter seconds')); ?>

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
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit</button>
                                 <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                              </div>
                           </div>
                        <?php echo Form::close(); ?>

                     </div>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="call-log">
   <div class="modal-dialog modal-lg">
      <form action="<?php echo route('crm.deals.calllog.store',$deal->dealID); ?>" method="post">
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
                        <?php echo Form::label('Subject', 'Subject', array('class'=>'control-label')); ?>

                        <?php echo Form::text('subject', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter call subject')); ?>

                        <input type="hidden" name="dealID" value="<?php echo $deal->dealID; ?>" required>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Phone code', 'Country code', array('class'=>'control-label')); ?>

                        <?php echo Form::select('phone_code', $phoneCode, null, array('class' => 'form-control', 'required' => '')); ?>

                     </div>
                  </div>
                  <div class="col-md-8">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Phone number', 'Phone Number', array('class'=>'control-label')); ?>

                        <?php echo Form::text('phone_number', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter phone number')); ?>

                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <?php echo Form::label('Call Type', 'Call Type', array('class'=>'control-label')); ?>

                        <?php echo Form::select('call_type', ['' => 'Choose call type','Inbound' => 'Inbound','Outbound' => 'Outbound'], null, array('class' => 'form-control', 'required' => '')); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Contact Person', 'Contact Person', array('class'=>'control-label')); ?>

                        <?php echo Form::text('contact_person', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter contact person')); ?>

                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Hour', 'Hour', array('class'=>'control-label')); ?>

                        <?php echo Form::number('hours', null, array('class' => 'form-control', 'min' => '0', 'max' => '24', 'required' => '','placeholder' => 'Enter Hours')); ?>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Minutes', 'Minutes', array('class'=>'control-label')); ?>

      						<?php echo Form::number('minutes', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '','placeholder' => 'Enter minutes')); ?>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Seconds', 'Seconds', array('class'=>'control-label')); ?>

      						<?php echo Form::number('seconds', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '','placeholder' => 'Enter seconds')); ?>

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
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add call log</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
            </div>
         </div>
      </form>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/deals/deal/call_log.blade.php ENDPATH**/ ?>