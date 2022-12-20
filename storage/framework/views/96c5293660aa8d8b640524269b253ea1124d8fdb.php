<?php $__env->startSection('title','Settings | Income Categories'); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings | Income Categories</h1>
      <div class="row">
         <?php echo $__env->make('app.property.settings._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <a class="btn btn-danger float-right" href="#add-category" class="btn btn-pink mb-3" data-toggle="modal"><i class="fal fa-plus-circle"></i> Add Category</a>
                     </div>
                     <div class="col-md-12">
                        <div class="card">
                           <div class="card-body">
                              <table id="example5" class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th width="1%">#</th>
                                       <th>Title</th>
                                       <th>Description</th>
                                       <th width="20%">Action</th>
                                    </tr>
                                 </thead>
                                 <tfoot>
                                    <tr>
                                       <th width="1%">#</th>
                                       <th>Title</th>
                                       <th>Description</th>
                                       <th width="20%">Action</th>
                                    </tr>
                                 </tfoot>
                                 <tbody>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <tr>
                                          <td><?php echo $count++; ?></td>
                                          <td><?php echo $category->name; ?></td>
                                          <td><?php echo $category->description; ?></td>
                                          <td>
                                             <a href="javascript:;" class="btn btn-sm btn-primary edit-income" id="<?php echo $category->id; ?>"><i class="fas fa-edit"></i> Edit</a>
                                             <a href="<?php echo route('property.income.category.delete', $category->id); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                                          </td>
                                       </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" id="add-category">
         <div class="modal-dialog">
            <form action="<?php echo route('property.income.category.store'); ?>" method="POST">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title">Add Category</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                     <?php echo csrf_field(); ?>
                     <div class="form-group">
                        <label for="" class="text-danger">Name *</label>
                        <input type="text" class="form-control" name="name" required>
                     </div>
                     <div class="form-group">
                        <label for="">Descriptions</label>
                        <textarea type="text" class="form-control" name="description" cols="5" rows="5"></textarea>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Add Category</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                  </div>
               </div>
            </form>
         </div>
      </div>

      <!-- #edit modal-dialog -->
      <div class="modal fade" id="edit-income" tabindex="-1" role="dialog">
         <div class="modal-dialog">
            <?php echo Form::open(array('route' => 'property.income.category.update','method' =>'post','autocomplete'=>'off')); ?>

            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Edit Category</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <?php echo csrf_field(); ?>

                  <div class="form-group">
                     <label for="">Name</label>
                     <?php echo Form::text('name', null, array('class' => 'form-control','id' =>'name', 'required' => '')); ?>

                     <input type="hidden" name="incomeID" id="incomeID">
                  </div>
                  <div class="form-group">
                     <label for="">Descriptions</label>
                     <?php echo Form::textarea('description', null, array('class' => 'form-control','id' => 'description')); ?>

                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Update Category</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
               </div>
            </div>
            <?php echo Form::close(); ?>

         </div>
      </div>
      <!-- #modal-without-animation -->
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script>
      $(document).on('click', '.edit-income', function(){

         var id = $(this).attr('id');
			var url = "<?php echo url('/'); ?>";
         $('#edit-income').html();
         $.ajax({
            url: url+"/property-management/income/category/"+id+"/edit",
            dataType:"json",
            success:function(html){
               $('#name').val(html.data.name);
					$('#description').val(html.data.description);
					$('#incomeID').val(id);
               $('#edit-income').modal('show');
            }
         })
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/settings/income/index.blade.php ENDPATH**/ ?>