<?php $__env->startSection('title','Expence List | winguPlus'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
	<div class="content">
		<?php if(Finance::count_expense() != Wingu::plan()->expenses && Finance::count_expense() < Wingu::plan()->expenses): ?>
         <?php if (app('laratrust')->isAbleTo('create-expense')) : ?>
				<div class="pull-right">
					<a href="<?php echo route('finance.expense.create'); ?>" class="btn btn-pink"><i class="fal fa-plus"></i> New Expense</a>
				</div>
			<?php endif; // app('laratrust')->permission ?>
		<?php endif; ?>
		<!-- end breadcrumb --> 
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-money-check-alt"></i> All Expenses</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="hpanel">
		   <div class="panel panel-default mt-3">
				<div class="panel-heading">
					<h4 class="panel-title">Expenses List</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="1%">#</th>
								<th width="10%">Date</th>
								<th>Expense Category</th>
								<th>Reference#</th>
								<th>Expense Title</th>
								<th>Status</th>
								<th>Amount</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th width="1%">#</th>
								<th width="10%">Date</th>
								<th>Expense Category</th>
								<th>Reference#</th>
								<th>Expense Title</th>
								<th>Status</th>
								<th>Amount</th>
								<th width="10%">Action</th>
							</tr>
						</tfoot>
						<tbody>
							<?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
								<tr >
									<td><?php echo $count++; ?></td>
									<td><?php echo date('M j, Y',strtotime($exp->date)); ?></td>
									<td><?php echo $exp->category_name; ?></td>
									<td><b><?php echo $exp->refrence_number; ?></b></td>
									<td><?php echo $exp->expense_name; ?></td>
									<td>
										<span class="badge <?php echo $exp->statusName; ?>">
											<?php echo $exp->statusName; ?>

										</span>
									</td>
									<td><b><?php echo $exp->code; ?> <?php echo number_format($exp->amount); ?></b></td>
									<td>
										<div class="btn-group">
											<button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
											<ul class="dropdown-menu">
												<?php if (app('laratrust')->isAbleTo('update-expense')) : ?>
												<li><a href="<?php echo e(route('finance.expense.edit', $exp->eid)); ?>"><i class="far fa-edit"></i> &nbsp;&nbsp; Edit</a></li>
												<?php endif; // app('laratrust')->permission ?>
												<?php if (app('laratrust')->isAbleTo('update-expense')) : ?>
												<li><a href="<?php echo route('finance.expense.destroy', $exp->eid); ?>" class="delete"><i class="fas fa-trash"></i> &nbsp;&nbsp; Delete</a></li>
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
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/expense/expense/index.blade.php ENDPATH**/ ?>