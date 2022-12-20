<?php $__env->startSection('title','Pipeline'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('crm.dashboard'); ?>">CRM</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('crm.pipeline.index'); ?>">Pipeline</a></li>
         <li class="breadcrumb-item"><a href="#">Stage</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-stream"></i> <?php echo $pipeline->title; ?></h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Pipeline Stages</div>
               <div class="card-body">
                  <table class="table table-striped mb-0" id="formTable" data-sortable>
                     <thead>
                        <tr>
                           <th width="1%"></th>
                           <th width="1%">#</th>
                           <th>Title</th>
                           <th width="24%">Action</th>
                        </tr>
                     </thead>
                     <tbody id="sortThis">
                        <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr data-index="<?php echo e($stage->id); ?>" data-position="<?php echo e($stage->position); ?>">
                              <td><i class="fas fa-grip-vertical"></i></td>
                              <td><?php echo e($count++); ?></td>
                              <td><?php echo e($stage->title); ?></td>
                              <td>
                                 <a href="<?php echo route('crm.pipeline.stage.edit',$stage->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                                 <a href="<?php echo route('crm.pipeline.stage.delete',$stage->id); ?>" class="btn btn-danger btn-sm">Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Add Stage</div>
               <div class="card-body">
                  <form action="<?php echo route('crm.pipeline.stage.store'); ?>" method="POST">
                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default">
                        <label for="">Title</label>
                        <?php echo Form::text('title',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter stage title']); ?>

                        <input type="hidden" name="pipelineID" value="<?php echo $pipeline->id; ?>" required>
                     </div>
                     <div class="form-group">
                        <label for="">Description</label>
                        <?php echo Form::textarea('description',null,['class'=>'form-control','size'=>'8x8','placeholder'=>'Enter stage description']); ?>

                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add stage</button>
			               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
   $(document).ready(function () {
   $('#formTable #sortThis').sortable({
      update: function (event, ui) {
            $(this).children().each(function (index) {
               if ($(this).attr('data-position') != (index+1)) {
                  $(this).attr('data-position', (index+1)).addClass('updated');
               }
            });
            saveNewPositions();
         }
      });
   });
</script>
<script type="text/javascript">
   function saveNewPositions() {
      var positions = [];
      $('.updated').each(function () {
         positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
         $(this).removeClass('updated');
      });
      
      $.ajax({
         url: '<?php echo e(route('stage_position_update')); ?>',
         method: 'PUT',
         dataType: 'text',
         data: {
         updated: 1,
         positions: positions,
         _token: '<?php echo e(csrf_token()); ?>'
         }, success: function (response) {
         console.log(response);
         },error: function (data, textStatus, errorThrown) {
         console.log(data);
         },
      });
   }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/deals/pipelines/pipeline/show.blade.php ENDPATH**/ ?>