<?php $__env->startSection('title','Update articles'); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('backend.cms.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Cms</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('cms.knowledgebase.index'); ?>">Knowledge base</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('cms.knowledgebase.index'); ?>"> Articles</a></li>
         <li class="breadcrumb-item active">Detail</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">View</h1>
      <!-- end page-header -->
      <?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-9">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <h3><?php echo $article->name; ?></h3>
                  <?php echo $article->description; ?>

               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="panel panel-inverse">
               <div class="panel-body">

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/cms/knowledgebase/show.blade.php ENDPATH**/ ?>