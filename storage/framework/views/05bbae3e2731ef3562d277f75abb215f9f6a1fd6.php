<?php $__env->startSection('title','Exit Details'); ?>

<?php $__env->startSection('stylesheet'); ?>
	<?php echo Html::style('resources/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css'); ?>

	<?php echo Html::style('resources/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css'); ?>

	<?php echo Html::style('resources/assets/plugins/datatables-responsive/css/datatables.responsive.css'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-menu'); ?>
	<?php echo $__env->make('Limitless.Human-resource.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="content "> 
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">					 
					<ul class="breadcrumb">
						<li><a href="#">Human Resource</a></li>
						<li><a href="#" class="active">Exit Details</a></li>
					</ul>
				</div>
			</div>
		</div> 
		<div class="container-fluid container-fixed-lg bg-white"> 
			<div class="panel panel-transparent">
				<div class="panel-heading">
					<div class="panel-title">Exit Details</div>
					<a class="btn btn-primary pull-right" href="<?php echo e(url('exit-details/create')); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Exit Details</a>
					<div class="pull-right">
						<div class="col-xs-12">
							<input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
						<div>
							<table class="table table-hover demo-table-search table-responsive-block dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
								<thead>
									<tr role="row">
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:10%">Image</th>
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:15%">Name</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 273px;">Gender</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 273px;">Interviewer</th>
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:13%">Separation date</th>										
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 300px;" style="width:15%">Notice Date</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;" style="width:15%">Date Added</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;" style="width:10%">Status</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 230px;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr role="row" class="odd">
										<td class="v-align-middle semi-bold sorting_1">
											<img width="60" height="60" alt="" class="img-circle FL" src="https://people.zoho.com/people/images/user.png">
										</td>
										<td class="v-align-middle semi-bold sorting_1"><p><?php echo $emp->first_name; ?> <?php echo $emp->middle_name; ?> <?php echo $emp->last_name; ?></p></td>
										<td class="v-align-middle"><p>Female</p></td>
										<td class="v-align-middle"><p>Ben Frank</p></td>
										<td class="v-align-middle"><p>21,March 2017</p></td>
										<td class="v-align-middle"><p>22,March 2017</p></td>
										<td class="v-align-middle"><p>24,March 2017</p></td>
										<td class="v-align-middle"><span class="label label-success">Pending</span></td>
										<td class="v-align-middle">
											<div class="btn-group dropdown-default"> 
												<a class="btn dropdown-toggle btn-complete" data-toggle="dropdown" href="#" style="width: 140px;" aria-expanded="false"> Choose Action 
													<span class="caret"></span> 
												</a>
												<ul class="dropdown-menu " style="width: 140px;">
													<li><a href="<?php echo e(url('employee/'.$emp->id.'/show')); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
													<li><a href="<?php echo e(url('exit-details/'.$emp->id.'/edit')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp; Edit</a></li>
													<li><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp; Delete</a></li>
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
		</div>
	</div>		
<br>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

	<script src="<?php echo e(url('/')); ?>/resources/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js" type="text/javascript"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo e(url('/')); ?>/resources/assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
	<script type="text/javascript" src="<?php echo e(url('/')); ?>/resources/assets/plugins/datatables-responsive/js/lodash.min.js"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/pages/js/pages.min.js"></script>
	<script src="<?php echo e(url('/')); ?>/resources/assets/js/datatables.js" type="text/javascript"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/ExitDetails/index.blade.php ENDPATH**/ ?>