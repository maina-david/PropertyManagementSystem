<?php $__env->startSection('title','Digital Marketing Accounts'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Digital Marketing</a></li>
         <li class="breadcrumb-item">Accounts</li>
         <li class="breadcrumb-item active">Channels</li>
      </ol>
      <!-- end breadcrumb --> 
      <!-- begin page-header -->
      <h1 class="page-header">Channels</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-7">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Account Channels</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Medium</th>
                        <th>Channel</th>
                        <th>Date Added</th>
                        <th width="26%">Action</th>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo $channel->name; ?></td>
                              <td><?php echo $channel->channel_name; ?></td>
                              <td><?php echo date('d F, Y', strtotime($channel->channel_date)); ?></td>
                              <td>
                                 <a href="<?php echo route('crm.channel.edit',[$channel->accountID,$channel->channelID]); ?>" class="btn btn-pink"><i class="fas fa-edit"></i> Edit</a>
                                 <a href="<?php echo route('crm.channel.delete',$channel->channelID); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-5">
            <div class="panel panel-default">
               <div class="panel-heading">
                  Add channel to account
               </div>
               <div class="panel-body">
                  <form action="<?php echo route('crm.channel.store'); ?>" method="post">
                     <?php echo csrf_field(); ?>
                     <input type="hidden" name="accountID" value="<?php echo $accountID; ?>" required>  
                     <div class="form-group form-group-default">
                        <label for="">Medium</label>
                        <?php echo Form::select('medium',$mediums,null,['class'=>'form-control multiselect']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Channel name</label>
                        <?php echo Form::text('channel_name',null,['class'=>'form-control','placeholder' => 'Enter channel name']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Client ID</label>
                        <?php echo Form::text('client_id',null,['class'=>'form-control','placeholder' => 'Enter Client ID']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Client secret</label>
                        <?php echo Form::text('client_secret',null,['class'=>'form-control','placeholder' => 'Enter Client secret']); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Redirect</label>
                        <?php echo Form::text('redirect',null,['class'=>'form-control','placeholder' => 'Enter redirect URL']); ?>

                     </div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save Channel</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/social/channels/index.blade.php ENDPATH**/ ?>