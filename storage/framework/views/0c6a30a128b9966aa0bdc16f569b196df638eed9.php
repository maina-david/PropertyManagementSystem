<?php $__env->startSection('title','Create Post'); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Social Media Marketing</a></li>
         <li class="breadcrumb-item active">Create Post</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullhorn"></i> Create Post</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
      <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Create Post</h4>
            </div>
            <div class="panel-body"> 
               <form action="<?php echo route('crm.social.post.store'); ?>" method="post" enctype="multipart/form-data">
                  <?php echo csrf_field(); ?>
                  <div class="form-group"> 
                     <label for="">Account</label>
                     <?php echo Form::select('account[]',$accounts,null,['class'=>'form-control multiselect']); ?>

                  </div>
                  <div class="form-group">
                     <label for="">Post</label>
                     <?php echo Form::textarea('post', null,['class' => 'form-control','required' => '']); ?>

                  </div>
                  <hr>
                  <div class="form-group">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="postlink">
                        <label class="custom-control-label" for="postlink">Add Link to the post</label>
                     </div>
                  </div>
                  <div class="form-group" id="link" style="display: none">
                     <label for="">Link</label>
                     <?php echo Form::text('link',null,['class' => 'form-control','placeholder' => 'e.x https://winguplus.com/']); ?>

                  </div>
                  <div class="form-group" id="linkDetails" style="display: none">
                     <label for="">Link Description</label>
                     <?php echo Form::textarea('link_description', null,['class' => 'form-control','size' => '3x4', 'placeholder' => 'start typing....','maxlength' => '180']); ?>

                  </div>
                  <hr>
                  <div class="form-group">
                     <label for="">Add Media</label><br>
                     <input type="file" name="media[]" id="files" accept="audio/*,video/*,image/*" multiple>
                  </div>
                  <hr>
                  <div class="form-group" id="Schedule-post-view">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="Schedule-post">
                        <label class="custom-control-label"  for="Schedule-post"> Schedule Post</label>
                     </div>
                  </div>
                  <div id="Schedule" style="display: none">
                     <div class="form-group">
                        <label for="">Schedule for a Specific Date</label>
                        <input type="text" name="scheduled_upload_date_time" id="" class="form-control datetimepicker" placeholder="choose date and time">
                     </div>
                     <div class="form-group">
                        <label for="">Repeat this Post</label>
                        <select name="repeat_period" id="repeat_period" class="form-control">
                           <option value="">Choose</option>
                           <option value="Monthly">Monthly</option>
                           <option value="Weekly">Weekly</option>
                        </select>
                     </div>
                     <div class="form-group" id="weekly" style="display: none">
                        <select name="repeat_day_date" class="form-control">
                           <option value="Moday">Moday</option>
                           <option value="Tuesday">Tuesday</option>
                           <option value="Wednesday">Wednesday</option>
                           <option value="Thursday">Thursday</option>
                           <option value="Friday">Friday</option>
                           <option value="Saturday">Saturday</option>
                           <option value="Sunday">Sunday</option>
                        </select>
                     </div>
                     <div class="form-group" id="monthly" style="display: none">
                        <select name="repeat_day_date"  class="form-control">
                           <?php for($x = 1; $x <= 31; $x++): ?> {
                              <option value="<?php echo $x ?>"><?php echo $x ?></option>
                           <?php endfor; ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="">Repeat Until</label>
                        <input type="text" name="post_date" id="" class="form-control datetimepicker" placeholder="choose date and time">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="47" name="publish">
                        <label class="custom-control-label" for="Publish"> Publish Know</label>
                     </div>
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save post</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </form>
            </div>
         </div>
      </div>
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
      $('#repeat_period').on('change', function() {
			if (this.value == 'Weekly') {
				$('#weekly').show();
			} else {
				$('#weekly').hide();
			}

			if(this.value == 'Monthly') {
				$('#monthly').show();
			} else {
				$('#monthly').hide();
			}
		});
   </script> 
   <script type="text/javascript">
      $('#postlink').click(function(){
         this.checked?$('#link').show(1000):$('#linkDetails').hide(1000); //time for show
         this.checked?$('#linkDetails').show(1000):$('#linkDetails').hide(1000);
      });
   </script>
   <script type="text/javascript">
      $('#Schedule-post').click(function(){
         this.checked?$('#Schedule').show(1000):$('#Schedule-post-view').hide(1000);
      });
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/social/post/create.blade.php ENDPATH**/ ?>