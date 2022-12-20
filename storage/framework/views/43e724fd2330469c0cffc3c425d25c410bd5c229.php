<?php $__env->startSection('title','Update Category'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.category'); ?>">Item Category</a></li>
         <li class="breadcrumb-item active">Update Item Category</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-sitemap"></i> Update Product Category </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
            <div class="col-md-6">
               <div class="panel panel-inverse">
                  <div class="panel-body">
                     <div class="panel-body">
                        <table id="data-table-default" class="table table-striped table-bordered">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th width="20%">Name</th>
                                 <th width="20%">Parent</th>
                                 <th width="13%">Items</th>
                                 <th class="text-center" width="15.5%">Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $cat->name; ?></td>
                                    <td class="font-weight-bold">
                                       <?php if($cat->parentID != ""): ?>
                                          <?php echo Finance::product_category($cat->parentID)->name; ?>

                                       <?php endif; ?>
                                    </td>
                                    <td><?php echo Finance::products_by_category_count($cat->id); ?></td>
                                    <td>
                                       <?php if (app('laratrust')->isAbleTo('update-productcategory')) : ?>
                                          <a href="<?php echo e(route('finance.product.category.edit', $cat->id)); ?>" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                       <?php endif; // app('laratrust')->permission ?>
                                       <?php if (app('laratrust')->isAbleTo('delete-productcategory')) : ?>
                                          <a href="<?php echo route('finance.product.category.destroy', $cat->id); ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                       <?php endif; // app('laratrust')->permission ?>
                                    </td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Update Category</h4>
                  </div>
                  <div class="panel-body">
                     <div class="panel-body">
                        <?php echo Form::model($category, ['route' => ['finance.product.category.update',$category->id], 'method'=>'post','enctype'=>'multipart/form-data','data-parsley-validate' => '']); ?>

                           <?php echo csrf_field(); ?>
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('name', 'Name', array('class'=>'control-label')); ?>

                              <?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Category Name','required' => '')); ?>

                           </div>
                           <div class="form-group">
                              <?php echo Form::label('title', 'Parent Category', array('class'=>'control-label')); ?>

                              <select name="parent" class="form-control multiselect">
                                 <?php if($category->parent == 0): ?>
                                    <option value="">Choose parent category if any</option>
                                 <?php else: ?>
                                    <option value="<?php echo $category->parent; ?>">
                                       <?php echo App\Models\finance\products\category::where('id',$category->parent)->where('businessID',Auth::user()->businessID)->first()->name; ?>

                                    </option>
                                 <?php endif; ?>
                                 <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $paro->id; ?>"><?php echo $paro->name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                           <div class="form-group mt-4">
                              <center>
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Category</button>
                                 <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                              </center>
                           </div>
                        <?php echo Form::close(); ?>

                     </div>
                  </div>
               </div>
            </div>
         </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/category/edit.blade.php ENDPATH**/ ?>