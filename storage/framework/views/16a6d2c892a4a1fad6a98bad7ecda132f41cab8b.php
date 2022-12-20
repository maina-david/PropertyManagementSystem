<?php $__env->startSection('title','Payroll settings'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Payroll</li>
         <li class="breadcrumb-item active">Payroll settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-cog"></i> Payroll settings </h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.hr.payroll.settings._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('hrm.payroll.settings.approval')); ?>" href="<?php echo route('hrm.payroll.settings.approval'); ?>">
                           Approver setting
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('hrm.payroll.settings.deduction')); ?>" href="<?php echo route('hrm.payroll.settings.deduction'); ?>">
                           Deductions
                        </a>
                     </li>
                     
                  </ul>
               </div>
               <div class="card-block">
                  <div class="row">
                     <div class="col-md-12">
                        <a href="#add-type" data-toggle="modal" class="btn btn-pink mb-2 float-right"> Add deduction</a>
                     </div>
                  </div>
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="5%">#</th>
                           <th class="text-nowrap">Name</th>
                           <th class="text-nowrap">Description</th>
                           <th class="text-nowrap" width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo $deduction->title; ?></td>
                              <td><?php echo $deduction->description; ?></td>
                              <td>
                                 
                                 <a href="<?php echo route('hrm.payroll.settings.deduction.delete',$deduction->id); ?>" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
                  <div class="modal fade" id="add-type" tabindex="-1" role="dialog">
                     <div class="modal-dialog modal-lg">
                        <?php echo Form::open(array('route' => 'hrm.payroll.settings.deduction.store','method' =>'post','autocomplete'=>'off')); ?>

                           <div class="modal-content">
                              <div class="modal-header">
                                 <h4 class="modal-title">Add deduction</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                 <?php echo csrf_field(); ?>
                                 <div class="form-group form-group-default required">
                                    <?php echo Form::label('names', 'Deduction name', array('class'=>'control-label')); ?>

                                    <?php echo Form::text('title', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter Name')); ?>

                                 </div>
                                 <div class="form-group">
                                    <?php echo Form::label('names', 'Description', array('class'=>'control-label')); ?>

                                    <?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor', 'required' => '')); ?>

                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add deduction</button>
                                 <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                              </div>
                           </div>
                        <?php echo Form::close(); ?>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script>
      $(document).on('click', '.edit-deduction', function(){
         var id = $(this).attr('id');
         var url = "<?php echo url('/'); ?>"
         $('#deduction_edit_form').html();
         $.ajax({
            url:url+"/hrm/payroll/settings/deduction/"+id+"/edit",
            dataType:"json",
            success:function(html){
               $('#title').val(html.data.name);
					$('#description').val(html.data.priority);
					$('#deductionID').val(id);
               $('#deduction_edit_form').modal('show');
            }
         })
      });
   </script>
	<script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/settings/deductions.blade.php ENDPATH**/ ?>