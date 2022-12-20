<?php $__env->startSection('title','Edit Deals'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('crm.dashboard'); ?>">CRM</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('crm.deals.create'); ?>">Deals</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-bullseye"></i> Edit deals</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Edit deal</h4>
               </div>
               <div class="panel-body">
                  <?php echo Form::model($edit, ['route' => ['crm.deals.update', $edit->id], 'method'=>'post', 'autocomplete' => 'off']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Title</label>
                        <?php echo Form::text('title',null,['class' => 'form-control', 'required' => '', 'placeholder' => 'Enter title']); ?>

                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Deal Value</label>
                              <?php echo Form::number('value',null,['class' => 'form-control', 'step' => '0.01', 'placeholder' => 'Enter deal value']); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Expected close date</label>
                              <?php echo Form::text('close_date',null,['class' => 'form-control datepicker', 'placeholder' => 'Choose date']); ?>

                           </div>
                        </div> 
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Pipeline</label> 
                              <?php echo Form::select('pipeline',$pipelines,null,['class' => 'form-control multiselect','id'=>'pipeline']); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Pipeline Stage</label>
                              <select name="stage" id="stages" class="form-control multiselect">
                                 <?php if(Crm::check_pipeline_stage($edit->stage) == 1): ?>
                                    <option value="<?php echo $edit->stage; ?>" selected><?php echo Crm::pipeline_stage($edit->stage)->title; ?></option>
                                 <?php endif; ?>
                                 <?php if($edit->pipeline != ""): ?>
                                    <?php $__currentLoopData = Crm::all_pipeline_stages($edit->pipeline); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if($stage->id != $edit->stage): ?>
                                          <option value="<?php echo $stage->id; ?>"><?php echo $stage->title; ?></option>
                                       <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Sales owner</label>
                              <?php echo Form::select('owner',$employees,null,['class' => 'form-control multiselect']); ?>

                           </div>
                        </div> 
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">
                                 Related Customer 
                                 <span class="pull-right" data-toggle="tooltip" data-placement="top" title="This list includes leads, You can link deals to leads">
                                    <i class="fas fa-info-circle"></i>
                                 </span>
                              </label>
                              <?php echo Form::select('contact',$customers,null,['class' => 'form-control multiselect']); ?>

                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Description</label>
                              <?php echo Form::textarea('description',null,['class' => 'form-control ckeditor']); ?>

                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update deal</button>
			               <img src="<?php echo asset('/assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </div>
                 <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
         <div class="col-md-4">

         </div>
      </div>     
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      $('#pipeline').on('change',function(e){         
         console.log(e);
         var pipeline =  e.target.value;
         var url = "<?php echo e(url('/')); ?>"
         //ajax
         $.get(url+'/crm/deals/'+pipeline+'/stages', function(data){
            //success data
            //
            $('#stages').empty();
            $.each(data, function(stages, stage){
               $('#stages').append('<option value="'+ stage.id +'">'+stage.title+'</option>');
            });
         });
      });
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/deals/deal/edit.blade.php ENDPATH**/ ?>