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
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Update Article</h1>
      <!-- end page-header -->
      <?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <?php echo Form::model($edit, ['route' => ['cms.knowledgebase.update', $edit->id], 'method'=>'post', 'autocomplete'=>'off','class' => 'row']); ?>

         <?php echo csrf_field(); ?>
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('name', 'Title', array('class'=>'control-label')); ?>

                        <?php echo Form::text('name', null, array('class' => 'form-control','required' => '')); ?>

                     </div>
                     <div class="form-group">
                        <div class="checkbox checkbox-primary">
                           <input type="checkbox" name="status" value="disabled" <?php if($edit->status == 'disabled'): ?> checked <?php endif; ?>>
                           <label for="disabled">Disabled</label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('title', 'Groups', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('groupID', $groups, null, ['class' => 'form-control multiselect','required' => ''])); ?>

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
         <div class="panel panel-inverse">
            <div class="panel-body">
               <div class="panel-body">
                  <div class="form-group">
                     <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                     <?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor')); ?>

                  </div>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Article</button></center>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php echo Form::close(); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo url('/'); ?>/public/backend/plugins/ckeditor/4/full/ckeditor.js"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/cms/knowledgebase/edit.blade.php ENDPATH**/ ?>