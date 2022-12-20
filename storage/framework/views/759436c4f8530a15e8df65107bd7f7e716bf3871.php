<div class="">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-inverse">
				<div class="panel-body">
					<div class="panel-body">
						<a href="#create-status" class="btn btn-sm btn-pink mb-3" data-toggle="modal">Add Lead Status</a>
						<table id="data-table-default" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th width="1%">#</th>
									<th>Name</th>
									<th>Description</th>
									<th width="13%">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $status->name; ?></td>
										<td><?php echo $status->description; ?></td>
										<td>
											<a href="#update-status-<?php echo $status->id; ?>" class="btn btn-primary" data-toggle="modal"><i class="far fa-edit"></i></a>
											<a href="<?php echo route('crm.leads.status.delete', $status->id); ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
									<div class="modal fade" id="update-status-<?php echo $status->id; ?>">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Update Status</h4>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<?php echo Form::model($status, ['route' => ['crm.leads.status.update',$status->id], 'method'=>'post']); ?>

														<?php echo csrf_field(); ?>
														<div class="form-group form-group-default required">
															<?php echo Form::label('name', 'Name', array('class'=>'control-label')); ?>

															<?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter status Name','required' => '')); ?>

														</div>
														<div class="form-group">
															<?php echo Form::label('description', 'Description', array('class'=>'control-label')); ?>

															<?php echo Form::textarea('description', null, array('class' => 'form-control', 'size' => '10x10')); ?>

														</div>
														<div class="form-group mt-4">
															<center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Status</button></center>
														</div>
													<?php echo Form::close(); ?>

												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="create-status">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add Status</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<?php echo Form::open(array('route' => 'crm.leads.status.store')); ?>

							<?php echo csrf_field(); ?>
							<div class="form-group form-group-default required">
								<?php echo Form::label('name', 'Name', array('class'=>'control-label')); ?>

								<?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter status Name','required' => '')); ?>

							</div>
							<div class="form-group">
								<?php echo Form::label('description', 'Description', array('class'=>'control-label')); ?>

								<?php echo Form::textarea('description', null, array('class' => 'form-control', 'size' => '10x10')); ?>

							</div>
							<div class="form-group mt-4">
								<center>
									<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Status</button>
									<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
								</center>
							</div>
						<?php echo Form::close(); ?>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/settings/leads/status.blade.php ENDPATH**/ ?>