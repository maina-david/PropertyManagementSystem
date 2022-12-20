<?php $__env->startSection('title','Sent SMS'); ?>


<?php $__env->startSection('sidebar'); ?>
  <?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <div class="float-right">
      <a href="#send-single" data-toggle="modal" class="btn btn-pink"><i class="fas fa-paper-plane"></i> Send Single SMS</a>
      
   </div>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fas fa-sms"></i> Sent SMS</h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">Sent SMS</h4>
      </div>
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered">
            <thead>
               <tr role="row">
                  <th width="1%">#</th>
                  <th>Date</th>
                  <th>To</th>
                  <th>FROM</th>
                  <th>Message</th>
                  <th>Status</th>
                  <th>Mode</th>
               </tr>
            </thead>
            <tfoot>
               <th width="1%">#</th>
               <th>Date</th>
               <th>Sent To</th>
               <th>Sent FROM</th>
               <th>Message</th>
               <th>Status</th>
               <th>Sending mode</th>
            </tfoot>
            <tbody>
               <?php $__currentLoopData = $smses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo $count++; ?></td>
                     <td><?php echo date('jS F, Y', strtotime($sms->created_at)); ?></td>
                     <td><?php echo $sms->sms_to; ?></td>
                     <td><?php echo $sms->sms_from; ?></td>
                     <td><?php echo $sms->message; ?></td>
                     <td><span class="btn btn-sm <?php echo $sms->name; ?>"><?php echo $sms->name; ?></span></td>
                     <td><?php echo $sms->sent_mode; ?></td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>
   
   <div class="modal fade" id="send-single" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
      <?php echo Form::open(array('route' => 'crm.sms.send.single','method' =>'post','autocomplete'=>'off')); ?>

         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> Send SMS</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label class="control-label" for="from">Choose Your Channel </label>
                  <?php echo Form::select('channel', $channel, null, ['class'=>'form-control','required' =>'','id' => 'channel']); ?>

               </div>
               
               <div class="form-group">
                  <label class="control-label" for="sms_to">To </label>
                  <?php echo Form::text('to',null, ['class'=>'form-control','required'=>'']); ?>

                  <span class="help-block"><a  href="#">| Or Choose from contact</a> </span>
               </div>
               <div class="form-group">
                  <label class="control-label" for="message">SMS </label>
                  <?php echo Form::textarea('message',null, ['class'=>'form-control','required'=>'','size' => '4x6','maxlength' => '255']); ?>

                  <p class="help-block" id="sms-counter">
                  Remaining: <span class="remaining">160</span> | Length: <span class="length">0</span> | Messages: <span class="messages">0</span>
                  </p>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Send</button>
            </div>
         </div>
      <?php echo Form::close(); ?>

      </div>
   </div>
   
   <div class="modal fade" id="send-bulk" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
      <?php echo Form::open(array('route' => 'crm.sms.send.bulk','method' =>'post','autocomplete'=>'off')); ?>

         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> Send Bulk</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label class="control-label" for="from">From </label>
                  <input type="text" name="from" id="from" class="form-control " value="winguPlus">
               </div>

               <div class="form-group">
                  <label class="control-label" for="sms_to">To </label>

                  <div class="col-lg-6">

                  <select multiple="multiple" id="my-select" name="contacts[]">
                  <option value="0743232435">Wadongo - 0743232435</option>
                  </select>

                  <span class="help-block">
                  <a href="#" id="ib_select_all">Select all</a> |
                  <a href="#" id="ib_de_select_all">De select all</a>
                  </span>

                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label" for="message">SMS </label>
                  <textarea class="form-control" name="message" id="message" rows="4"></textarea>
                  <p class="help-block" id="sms-counter">
                  Remaining: <span class="remaining">160</span> | Length: <span class="length">0</span> | Messages: <span class="messages">0</span>
                  </p>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Send</button>
            </div>
         </div>
      <?php echo Form::close(); ?>

      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/sms/sent.blade.php ENDPATH**/ ?>