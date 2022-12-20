<?php $__env->startSection('title','Income Category'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Income</li>
         <li class="breadcrumb-item active">Category</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-tools"></i> Income Category</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('finance.income.category')); ?>" href="<?php echo route('finance.income.category'); ?>"><i class="fas fa-money-bill-alt"></i> Category</a>
                     </li>
                  </ul>
               </div>
               <div class="card-block">
                  <div class="p-0 m-0">
                     <div class="row mb-3">
                        <div class="col-md-12">
                           <?php if (app('laratrust')->isAbleTo('create-incomecategory')) : ?>
                              <a class="btn btn-pink float-right" href="#add-category" class="btn btn-pink mb-3" data-toggle="modal"><i class="fas fa-plus"></i> Add Category</a>
                           <?php endif; // app('laratrust')->permission ?>
                        </div>
                     </div>
                     <table id="data-table-default" class="table table-striped table-bordered table-hover">
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
                                    <?php if (app('laratrust')->isAbleTo('update-incomecategory')) : ?>
                                       <a href="javascript:;" class="btn btn-sm btn-primary edit-income" id="<?php echo $category->id; ?>"><i class="fas fa-edit"></i> Edit</a>
                                    <?php endif; // app('laratrust')->permission ?>
                                    <?php if (app('laratrust')->isAbleTo('delete-incomecategory')) : ?>
                                       <a href="<?php echo route('finance.income.category.delete', $category->id); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                                    <?php endif; // app('laratrust')->permission ?>
                                 </td>
                              </tr>
                              <!-- #modal-dialog -->
                              
                              <!-- #modal-without-animation -->
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="add-category">
      <div class="modal-dialog">
         <form action="<?php echo route('finance.income.category.store'); ?>" method="POST">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add Category</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <?php echo csrf_field(); ?>
                  <div class="form-group">
                     <label for="">Name</label>
                     <input type="text" class="form-control" name="name" required>
                  </div>
                  <div class="form-group">
                     <label for="">Descriptions</label>
                     <textarea type="text" class="form-control" name="description" cols="5" rows="5"></textarea>
                  </div>         
               </div>
               <div class="modal-footer">
                  <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
                  <button type="submit" class="btn btn-primary submit">Submit</button>
                  <img src="<?php echo asset('assets/backend/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
               </div>
            </div>
         </form>
      </div>
   </div>

   <!-- #edit modal-dialog -->
   <div class="modal fade" id="edit-income" tabindex="-1" role="dialog">
      <div class="modal-dialog">   
         <?php echo Form::open(array('route' => 'finance.income.category.update','method' =>'post','autocomplete'=>'off')); ?>                                
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
               <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
               <button type="submit" class="btn btn-primary submit"><i class="fas fa-save"></i> Update Category</button>
               <img src="<?php echo asset('assets/backend/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
            </div>            
         </div>   
         <?php echo Form::close(); ?>                                
      </div>
   </div>
   <!-- #modal-without-animation -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script>
      $(document).on('click', '.edit-income', function(){
         
         var id = $(this).attr('id');
			var url = "<?php echo url('/'); ?>";
         $('#edit-income').html();
         $.ajax({
            url: url+"/finance/income/category/"+id+"/edit",
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/income/index.blade.php ENDPATH**/ ?>