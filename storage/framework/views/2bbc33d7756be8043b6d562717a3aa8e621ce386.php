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
         <li class="breadcrumb-item active">View Post</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-bullhorn"></i> View Post</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Post</h4>
               </div>
               <div class="panel-body"> 
                  <h4><?php echo $post->title; ?></h4>
                  <p><?php echo $post->post; ?></p>
                  <div class="row">
                     <div class="col-md-6"></div>
                     <div class="col-md-3"> </div>
                     <div class="col-md-3">
                        <a href="<?php echo route('crm.publications.post.publish',[$post->id,$channel->channelID]); ?>" class="pull-right btn btn-pink">Publish post to <?php echo Crm::medium($channel->mediumID)->name; ?></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Statistics</h4>
            </div>
            <div class="panel-body"> 
               
            </div>
         </div>
      </div>
   </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/social/post/show.blade.php ENDPATH**/ ?>