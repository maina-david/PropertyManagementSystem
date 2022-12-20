<?php $__env->startSection('title','All Credit notes'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <?php if(Finance::count_creditnote() != Wingu::plan()->credit_note && Finance::count_creditnote() < Wingu::plan()->credit_note): ?>
            <?php if (app('laratrust')->isAbleTo('create-creditnote')) : ?>
               <a href="<?php echo route('finance.creditnote.create'); ?>" class="btn btn-pink"><i class="fas fa-plus"></i> New  Credit note</a>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>
         
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> All  Credit notes</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Client</th>
                     <th>Reference #</th>
                     <th>Amount</th>
                     <th>Balance</th>
                     <th>Status</th>
                     <th>Credit note date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Client</th>
                     <th>Reference #</th>
                     <th>Amount</th>
                     <th>Balance</th>
                     <th>Status</th>
                     <th>Credit note date</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $creditnotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr role="row" class="odd">
                        <td><?php echo e($crt+1); ?></td>
                        <td>
                           <b><?php echo $v->prefix; ?><?php echo $v->creditnote_number; ?></b>
                        </td>
                        <td>
                           <?php echo $v->customer_name; ?>

                        </td>
                        <td class="text-uppercase font-weight-bold">
                           <?php echo $v->reference_number; ?>

                        </td>
                        <td><?php echo $v->symbol; ?><?php echo number_format($v->total,2); ?> </td>
                        <td><?php echo $v->symbol; ?><?php echo number_format($v->balance,2); ?> </td>
                        <td>
                           <span class="badge <?php echo $v->statusName; ?>">
                              <?php echo ucfirst($v->statusName); ?>

                           </span>
                        </td> 
                        <td>
                           <?php echo date('F j, Y',strtotime($v->creditnote_date)); ?>

                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <?php if (app('laratrust')->isAbleTo('read-creditnote')) : ?>
                                    <li><a href="<?php echo e(route('finance.creditnote.show', $v->creditnoteID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('update-creditnote')) : ?>
                                    <?php if($v->paymentID == ""): ?>
                                       <li><a href="<?php echo route('finance.creditnote.edit', $v->creditnoteID); ?>"><i class="fas fa-edit"></i> Edit</a></li>
                                    <?php endif; ?>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('delete-creditnote')) : ?>
                                    <li><a href="<?php echo route('finance.creditnote.delete', $v->creditnoteID); ?>" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
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

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/creditnote/index.blade.php ENDPATH**/ ?>