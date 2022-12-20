<?php $__env->startSection('title','New Proposal'); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('backend.cms.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Cms</a></li>
         <li class="breadcrumb-item"><a href="#">Proposal</a></li>
         <li class="breadcrumb-item active">New</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">New Proposal</h1>
      <!-- end page-header -->
      <?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <?php echo Form::open(array('route' => 'cms.knowledgebase.store','class' => 'row')); ?>

         <?php echo csrf_field(); ?>
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('name', 'Title', array('class'=>'control-label')); ?>

                        <?php echo Form::text('title', null, array('class' => 'form-control','required' => '')); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('name', 'Proposal type', array('class'=>'control-label')); ?>

                        <?php echo Form::select('proposal_type', ['' => 'choose proposal type','edocument' => 'Make e-document','upload-proposal' => 'upload proposal'], null, array('class' => 'form-control','required' => '','id' => 'type')); ?>

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default">
                        <?php echo Form::label('title', 'proposal Category', array('class'=>'control-label')); ?>

                        <?php echo Form::text('proposal_category', null, array('class' => 'form-control','placeholder' => 'e.g Marketing proposal')); ?>

                     </div>
                     <div class="form-group form-group-default" id="upload-proposal" style="display:none">
                        <?php echo Form::label('title', 'Upload Proposal', array('class'=>'control-label')); ?>

                        <?php echo Form::file('upload', null, array('class' => 'form-control')); ?>

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
               </div>
            </div>
         </div>
         <div class="panel-body">
            <div class="form-group">
               <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Proposal</button></center>
            </div>
         </div>
      <?php echo Form::close(); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      $(document).ready(function() {
         $('#type').on('change', function() {
            if (this.value == 'upload-proposal') {
               $('#upload-proposal').show();
            } else { 
               $('#upload-proposal').hide();
            }
         });
      });
   </script>
   <script src="<?php echo url('/'); ?>/public/backend/plugins/ckeditor/4/full/ckeditor.js"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/cms/proposal/create.blade.php ENDPATH**/ ?>