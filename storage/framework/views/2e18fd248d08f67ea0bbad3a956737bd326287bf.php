<?php $__env->startSection('title','Purchase Orders'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <?php if(Finance::lpo_count() != Wingu::plan()->lpos && Finance::lpo_count() < Wingu::plan()->lpos): ?>
            <?php if (app('laratrust')->isAbleTo('create-lpo')) : ?>
               <a href="<?php echo route('finance.lpo.create'); ?>" class="btn btn-pink"><i class="fas fa-plus"></i> New Purchase Orders</a>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-contract"></i> Purchase Orders</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Number</th>
                     <th>Supplier</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Number</th>
                     <th>Supplier</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Issue Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $lpos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr role="row" class="odd">
                        <td><?php echo e($crt+1); ?></td>
                        <td>
                           <?php echo $v->lpo_title; ?>

                        </td>
                        <td>
                           <b><?php echo $v->prefix; ?><?php echo $v->lpo_number; ?></b>
                        </td>
                        <td>
                           <?php echo $v->supplierName; ?>

                        </td>
                        <td class="text-uppercase font-weight-bold">
                           <?php echo $v->reference_number; ?>

                        </td>
                        <td><?php echo $v->symbol; ?><?php echo number_format($v->main_amount); ?></td>
                        <td><span class="badge <?php echo $v->statusName; ?>"><?php echo ucfirst($v->statusName); ?></span></td>
                        <td>
                           <?php echo date('F j, Y',strtotime($v->lpo_date)); ?>

                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <?php if (app('laratrust')->isAbleTo('read-lpo')) : ?>
                                    <li><a href="<?php echo e(route('finance.lpo.show', $v->lpoID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('update-lpo')) : ?>
                                    <li><a href="<?php echo route('finance.lpo.edit', $v->lpoID); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('delete-lpo')) : ?>
                                    <li><a href="<?php echo route('finance.lpo.delete', $v->lpoID); ?>" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/purchaseorders/index.blade.php ENDPATH**/ ?>