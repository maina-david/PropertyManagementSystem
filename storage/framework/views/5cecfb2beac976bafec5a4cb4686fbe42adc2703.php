<div class="row">
   <div class="col-md-12">
      <table class="table table-bordered">
         <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td>
                  <small class="text-primary"><?php echo $event->name; ?> Date</small>
                  <p><b><?php echo date('M jS, Y', strtotime($event->action_date)); ?></b></p>
               </td>
               <td>
                  <h3><?php echo $event->name; ?></h3>
               </td>
               <td>
                  <small class="text-primary">Assigned to</small>
                  <p>
                     <?php if($event->allocated_to != ""): ?>
                        <b><?php echo Hr::employee($event->allocated_to)->names; ?></b>
                     <?php endif; ?>
                  </p>
               </td>
               <td>
                  <small class="text-primary">Due date</small>
                  <p>
                     <?php if($event->due_action_date == ""): ?>
                        <b>No due date</b>
                     <?php else: ?> 
                        <b><?php echo date('M jS, Y', strtotime($event->due_action_date)); ?></b>
                     <?php endif; ?>
                  </p>
               </td>
               <td width="20%">
                  <small class="text-primary">Note</small>
                  <?php echo $event->note; ?>

               </td>
               <td width="12%">
                  <?php if($event->status == 38): ?>                  
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".checkout<?php echo $event->eventID; ?>">Edit</a>
                  <?php endif; ?>
                  <?php if($event->status == 39): ?>
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".lease<?php echo $event->eventID; ?>">Edit</a>
                  <?php endif; ?>
                  <?php if($event->status == 43): ?>
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".checkin<?php echo $event->eventID; ?>">Edit</a>
                  <?php endif; ?>
                  <a href="<?php echo route('assets.event.delete',$event->eventID); ?>" class="btn btn-sm btn-danger delete">Delete</a>
               </td>
            </tr>

            
            <div class="modal fade checkout<?php echo $event->eventID; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <?php echo Form::model($event, ['route' => ['assets.event.checkout.update',$event->eventID], 'method'=>'post','id'=>'checkoutForm', 'autocomplete' => 'off']); ?>

                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Update Check out</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Check-out Date</label>
                                    <?php echo Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']); ?>

                                    <input type="hidden" name="status" value="38">
                                    <input type="hidden" name="assetID" value="<?php echo $details->id; ?>">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Due Date</label>
                                    <?php echo Form::text('due_action_date',null,['class' => 'form-control datepicker', 'placeholder' => 'choose date']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Check-out to</label>
                                    <?php echo Form::select('check_out_to',['' => 'Choose','Person' => 'Person','Branch' => 'Branch','Location' => 'Site / Location'],null,['class' => 'form-control', 'required' => '', 'id'=>'checkoutto']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Branch</label>
                                    <?php echo Form::select('branch',$branches,null,['class' => 'form-control']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Person</label>
                                    <?php echo Form::select('allocated_to',$employees,null,['class' => 'form-control']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Site / Location </label>
                                    <?php echo Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Department </label>
                                    <?php echo Form::select('department',$departments,null,['class' => 'form-control']); ?>

                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                                 </div>
                              </div>
                           </div>       
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitCheckoutForm">Update information</button>
                              <img src="<?php echo asset('/assets/img/btn-loader.gif'); ?>" class="checkout-load none" width="15%">
                           </center>
                        </div>
                     <?php echo Form::close(); ?>

                  </div>
               </div>
            </div>

            
            <div class="modal fade lease<?php echo $event->eventID; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <?php echo Form::model($event, ['route' => ['assets.event.lease.update',$event->eventID], 'method'=>'post','id'=>'leaseForm', 'autocomplete' => 'off']); ?>

                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Lease</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Lease Begins</label>
                                    <?php echo Form::date('action_date',null,['class' => 'form-control', 'required' => '']); ?>

                                    <input type="hidden" name="status" value="39">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Lease Expires</label>
                                    <?php echo Form::date('due_action_date',null,['class' => 'form-control', 'required' => '']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Leasing Customer </label>
                                    <?php echo Form::select('allocated_to',$customers,null,['class' => 'form-control', 'required' => '']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Send Email</label>
                                    <?php echo Form::select('send_email',['No' => 'No','Yes' => 'Yes'],null,['class' => 'form-control','id'=>'lease_email']); ?>

                                 </div>
                              </div>                  
                              <div class="col-md-6" id="leaseEmail" style="display: none">
                                 <div class="form-group form-group-default required">
                                    <label for="">Email</label>
                                    <?php echo Form::email('email',null,['class' => 'form-control', 'placeholder' => 'Enter email']); ?>

                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                                 </div>
                              </div>
                           </div>       
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitLeaseForm">Update Lease</button>
                              <img src="<?php echo url('/'); ?>/public/backend/img/btn-loader.gif" class="lease-load none" width="15%">
                           </center>
                        </div>
                     <?php echo Form::close(); ?>

                  </div>
               </div>
            </div>

            
            <div class="modal fade checkin<?php echo $event->eventID; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <?php echo Form::model($event, ['route' => ['assets.event.checkin.update',$event->eventID], 'method'=>'post','id'=>'leaseForm', 'autocomplete' => 'off']); ?>

                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Check in</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Return Date </label>
                                    <?php echo Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']); ?>

                                    <input type="hidden" name="status" value="43">
                                    <input type="hidden" name="assetID" value="<?php echo $details->id; ?>">
                                 </div>
                              </div>                 
                              <div class="col-md-6" id="checkoutLocation">
                                 <div class="form-group form-group-default required">
                                    <label for="">Site / Location </label>
                                    <?php echo Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']); ?>

                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    <?php echo Form::textarea('note',null,['class' => 'form-control ckeditor']); ?>

                                 </div>
                              </div>
                           </div>       
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitCheckinForm">update Information</button>
                              <img src="<?php echo url('/'); ?>/public/backend/img/btn-loader.gif" class="checkin-load none" width="15%">
                           </center>
                        </div>
                     <?php echo Form::close(); ?>

                  </div>
               </div>
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </table>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/assets/events/index.blade.php ENDPATH**/ ?>