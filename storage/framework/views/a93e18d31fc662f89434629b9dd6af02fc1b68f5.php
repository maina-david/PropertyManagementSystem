<?php $__env->startSection('title','Assets'); ?>

<?php $__env->startSection('stylesheets'); ?>
	<?php echo Html::style('resources/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css'); ?>

	<?php echo Html::style('resources/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css'); ?>

	<?php echo Html::style('resources/assets/plugins/datatables-responsive/css/datatables.responsive.css'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-menu'); ?>
	<?php echo $__env->make('Modules.Human-resource.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="content "> 
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">					 
					<ul class="breadcrumb">
						<li><a href="#">Human Resource</a></li>
						<li><a href="#" class="active">Assets</a></li>
					</ul>
				</div>
			</div>
		</div> 
		<div class="container-fluid container-fixed-lg bg-white"> 
			<div class="panel panel-transparent">
				<div class="panel-heading">
					<div class="panel-title">Assets</div>
					<a class="btn btn-primary pull-right" data-target="#addasset" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Record</a>
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
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:3%">#</th>
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:10%">Employee</th>
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:15%">Given date</th>
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:13%">Type of asset</th>
										<th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Title: activate to sort column descending" aria-sort="ascending" style="width:13%">Asset ID</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 273px;">Asset details</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 300px;" style="width:15%">Return date</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 173px;" style="width:10%">Status</th>
										<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 230px;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr role="row" class="odd">
										<td>1</td>
										<td class="v-align-middle semi-bold sorting_1">
											<p><?php echo $emp->first_name; ?> <?php echo $emp->middle_name; ?> <?php echo $emp->last_name; ?></p>
										</td>
										<td class="v-align-middle semi-bold sorting_1"><p>12,March 2017</p></td>
										<td class="v-align-middle semi-bold sorting_1"><p>Payed Leave</p></td>
										<td class="v-align-middle"><p>55</p></td>
										<td class="v-align-middle"><p>12,March 2017</p></td>
										<td class="v-align-middle"><p>12,March 2017</p></td>
										<td class="v-align-middle"><span class="label label-success">Pending</span></td>
										<td class="v-align-middle">
											<div class="btn-group dropdown-default"> 
												<a class="btn dropdown-toggle btn-complete" data-toggle="dropdown" href="#" style="width: 140px;" aria-expanded="false"> Choose Action 
													<span class="caret"></span> 
												</a>
												<ul class="dropdown-menu " style="width: 140px;">
													
													<li><a data-target="#editassets" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp; Edit</a></li>
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
	<?php echo $__env->make('Modules.Models.Assets.add-assets', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
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
<?php echo $__env->make('layouts.main-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/Assets/index.blade.php ENDPATH**/ ?>