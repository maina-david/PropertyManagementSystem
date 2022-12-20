<?php $__env->startSection('title','Stock Control'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
			<?php if(Finance::lpo_count() != Wingu::plan()->lpos && Finance::lpo_count() < Wingu::plan()->lpos): ?>
				<?php if (app('laratrust')->isAbleTo('create-stockcontrol')) : ?>
					<a href="<?php echo route('finance.product.stock.order'); ?>" class="btn btn-pink"> Order stock</a>
				<?php endif; // app('laratrust')->permission ?>
			<?php endif; ?>
         
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-boxes"></i> Stock Control  </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
		<div class="panel panel-default mt-4">
			<div class="panel-heading">
				<h4 class="panel-title">All Orders</h4>
			</div>
			<div class="panel-body">
				<table id="data-table-default" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th width="1%">#</th>
							<th>Number</th>
							<th>Supplier</th>
							<th>Reference #</th>
							<th>Items</th>
							<th>Total Cost</th>
							<th>Status</th>
							<th>Date Created</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th width="1%">#</th>
							<th>Number</th>
							<th>Supplier</th>
							<th>Reference #</th>
							<th>Items</th>
							<th>Total Cost</th>
							<th>Status</th>
							<th>Date Created</th>
							<th width="10%">Action</th>
						</tr>
					</tfoot>
					<tbody>
						<?php $__currentLoopData = $lpos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr role="row" class="odd">
								<td><?php echo e($crt+1); ?></td>
								<td>
									<b><?php echo $v->prefix; ?><?php echo $v->lpo_number; ?></b>
								</td>
								<td>
									<?php echo $v->supplierName; ?>

								</td>
								<td class="text-uppercase font-weight-bold">
									<?php echo $v->reference_number; ?>

								</td>
								<td><?php echo Finance::lpo_items($v->lpoID); ?></td>
								<td><?php echo $v->code; ?> <?php echo number_format($v->total); ?></td>
								<td><span class="badge <?php echo $v->statusName; ?>"><?php echo ucfirst($v->statusName); ?></span></td>
								<td>
									<?php echo date('F j, Y',strtotime($v->lpo_date)); ?>

								</td>
								<td>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
										<ul class="dropdown-menu">
											<?php if (app('laratrust')->isAbleTo('read-stockcontrol')) : ?>
												<li><a href="<?php echo e(route('finance.product.stock.order.show', $v->lpoID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
											<?php endif; // app('laratrust')->permission ?>
											<?php if (app('laratrust')->isAbleTo('update-stockcontrol')) : ?>
												<li><a href="<?php echo route('finance.product.stock.order.edit', $v->lpoID); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
											<?php endif; // app('laratrust')->permission ?>
											<?php if (app('laratrust')->isAbleTo('delete-stockcontrol')) : ?>
												<li><a href="<?php echo route('finance.lpo.delete', $v->lpoID); ?>"><i class="fas fa-trash-alt delete"></i>&nbsp;&nbsp; Delete</a></li>
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

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/stock/index.blade.php ENDPATH**/ ?>