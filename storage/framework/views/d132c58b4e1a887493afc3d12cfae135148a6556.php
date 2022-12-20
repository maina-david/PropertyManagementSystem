<?php $__env->startSection('title','Knowledge base articles'); ?>
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
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">All Articles</h1>
      <!-- end page-header -->
      <?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>Title</th>
                              <th>Groups</th>
                              <th width="10">Status</th>
                              <th width="20">Publish date</th>
                              <th width="21%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td><?php echo $count++; ?></td>
                                 <td><?php echo $article->name; ?></td>
                                 <td>
                                    
                                 </td>
                                 <td>
                                    <?php if($article->status == 'disabled'): ?>
                                       <span class="badge badge-danger"><?php echo $article->status; ?></span>
                                    <?php else: ?>
                                       <span class="badge badge-success">Active</span>
                                    <?php endif; ?>
                                 </td>
                                 <td><?php echo date('F d, Y', strtotime($article->created_at)); ?></td>
                                 <td>
                                    <a href="<?php echo e(route('cms.knowledgebase.edit', $article->id)); ?>" class="btn btn-primary"><i class="far fa-edit"></i> Edit</a>
                                    <a href="<?php echo e(route('cms.knowledgebase.show', $article->id)); ?>" class="btn btn-pink"><i class="fas fa-eye"></i> Show</a>
                                    <a href="<?php echo route('cms.knowledgebase.delete', $article->id); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/cms/knowledgebase/index.blade.php ENDPATH**/ ?>