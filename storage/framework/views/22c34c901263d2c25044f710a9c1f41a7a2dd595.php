<?php $__env->startSection('title','Edit Post'); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Social Media Marketing</a></li>
         <li class="breadcrumb-item active">Edit Post</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-bullhorn"></i> Edit Post</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
      <div class="row mb-3">
         <div class="col-md-12">
            <h4>
               Channels : 
               <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo route('crm.publications.post.channel',[$edit->id,$ch->id]); ?>" class="btn btn-sm btn-info"><?php echo $ch->channel_name; ?></a>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </h4>
         </div>
      </div>

      <?php echo Form::model($edit, ['route' => ['crm.publications.update',$edit->id], 'method'=>'post','class' => 'row']); ?>

         <?php echo csrf_field(); ?>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Edit Post</h4>
               </div>
               <div class="panel-body"> 
                  <div class="form-grou[">
                     <label for="">Post Title</label>
                     <?php echo Form::text('title', null,['class' => 'form-control','required' => '']); ?>

                  </div>
                  <div class="form-group"> 
                     <label for="">Account</label>
                     <select name="account" class="form-control" id="account"  required> 
                        <?php if($edit->accountID != ""): ?>
                           <option value="<?php echo $currentAccounts->accountID; ?>"><?php echo $currentAccounts->customer_name; ?></option>
                        <?php else: ?>
                           <option value="">Choose account</option> 
                        <?php endif; ?>
                        <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $account->accountID; ?>"><?php echo $account->customer_name; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="">Select Channels</label>
                     <select class="form-control multiselect" id="channel" name="channel[]" multiple required="">
                        <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $channel->id; ?>" selected><?php echo $channel->channel_name; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="">Post</label>
                     <?php echo Form::textarea('post', null,['class' => 'form-control','required' => '']); ?>

                  </div>
                  <hr>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Edit Post</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="postlink" <?php if($edit->link != ""): ?> checked <?php endif; ?>>
                        <label class="custom-control-label" for="postlink">Add Link to the post</label>
                     </div>
                  </div>
                  <?php if($edit->link != ""): ?>
                     <div class="form-group" id="link">
                        <label for="">Link</label>
                        <?php echo Form::text('link',null,['class' => 'form-control','placeholder' => 'e.x https://winguplus.com/']); ?>

                     </div>
                     <div class="form-group" id="linkDetails">
                        <label for="">Link Description</label>
                        <?php echo Form::textarea('link_description', null,['class' => 'form-control','size' => '3x4', 'placeholder' => 'start typing....','maxlength' => '180']); ?>

                     </div>
                     <hr>
                  <?php endif; ?>
                  <div class="form-group">
                     <label for="">Add Images</label><br>
                     <input type="file" name="media[]" id="files" accept="audio/*,video/*,image/*" multiple>
                  </div>
                  <div class="form-group">
                     <label for="">When to post Specific day and time Open</label>
                     <?php echo Form::text('upload_time',null,['class' => 'form-control datetimepicker', 'placeholder' => 'choose date and time' ]); ?>

                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update post</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>
         </div>
      <?php echo Form::close(); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      $('#account').on('change',function(e){
         console.log(e);
         var account =  e.target.value;
         var url = "<?php echo e(url('/')); ?>"
         //ajax
         $.get(url+'/crm/marketing/retrive/channel/'+account, function(data){
            //success data
            //
            //$('#channel').empty();
            $.each(data, function(channel, info){
               $('#channel').append('<option value="'+ info.id +'">'+info.channel_name+'</option>');
            });
         });
      });
   </script> 
   <script type="text/javascript">
      $('#postlink').click(function(){
         this.checked?$('#link').show(1000):$('#linkDetails').hide(1000); //time for show
         this.checked?$('#linkDetails').show(1000):$('#linkDetails').hide(1000);
      });
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/social/post/edit.blade.php ENDPATH**/ ?>