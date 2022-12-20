<div class="row">
   <div class="col-md-12">
      <?php if (app('laratrust')->isAbleTo('create-expensecategory')) : ?>
         <a href="#" class="btn btn-pink btn-sm m-b-10 p-l-5 offset-md-10 float-right" title="Add Category" data-toggle="modal" data-target="#category">
            <i class="fal fa-plus-circle"></i> Add Category 
         </a>
      <?php endif; // app('laratrust')->permission ?>
   </div>
</div>
<table id="data-table-default" class="table table-striped table-bordered">
   <thead>
      <tr>
         <th width="1%">#</th>
         <th>Name</th>
         <th>Description</th>
         <th width="20%"><center>Action</center></th>
      </tr>
   </thead>
   <tbody>
      <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $cat->category_name; ?></td>
            <td><?php echo $cat->category_description; ?></td>
            <td>
               <?php if (app('laratrust')->isAbleTo('update-expensecategory')) : ?>
                  <a href="#" data-toggle="modal" data-target="#edit-category-<?php echo $cat->id; ?>" class="btn btn-pink btn-sm"><i class="far fa-edit"></i> Edit</a>
               <?php endif; // app('laratrust')->permission ?>
               <?php if (app('laratrust')->isAbleTo('create-expensecategory')) : ?>
                  <a href="<?php echo e(route('finance.expense.category.destroy', $cat->id)); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i>&nbsp;&nbsp; Delete</a>
               <?php endif; // app('laratrust')->permission ?>
            </td>
         </tr>      
         <div class="modal fade" id="edit-category-<?php echo $cat->id; ?>">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title">Edit Category</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <?php echo Form::model($cat, ['route' => ['finance.expense.category.update',$cat->id], 'method'=>'post']); ?>

                  <?php echo csrf_field(); ?>
                     <div class="modal-body">
                        <div class="form-group form-group-default required ">
                           <?php echo Form::label('Category Name', 'Category Name', array('class'=>'control-label')); ?>

                           <?php echo Form::text('category_name', null, array('class' => 'form-control', 'placeholder' => 'Category Name', 'required' =>'' )); ?>

                        </div>
                        <div class="form-group">
                           <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                           <?php echo Form::textarea('category_description', null, array('class' => 'form-control', 'size' => '6x10', 'placeholder' => 'Description')); ?>

                        </div>
                     </div>
                     <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-pink submit">Update Category</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>      
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </tbody>
</table>

<?php echo Form::open(array('route' => 'finance.expense.category.store','enctype'=>'multipart/form-data','data-parsley-validate' => '', 'method'=>'post' )); ?>

   <?php echo csrf_field(); ?>
   <div class="modal fade" id="category">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add Expense Category</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <div class="form-group form-group-default required ">
                  <?php echo Form::label('Category Name', 'Category Name', array('class'=>'control-label')); ?>

                  <?php echo Form::text('category_name', null, array('class' => 'form-control', 'placeholder' => 'Category Name', 'required' =>'' )); ?>

               </div>
               <div class="form-group">
                  <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                  <?php echo Form::textarea('category_description', null, array('class' => 'form-control', 'size' => '6x10', 'placeholder' => 'Description')); ?>

               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-success submit">Submit Information</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="20%">
            </div>
         </div>
      </div>
   </div>
<?php echo Form::close(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/expense/category/category.blade.php ENDPATH**/ ?>