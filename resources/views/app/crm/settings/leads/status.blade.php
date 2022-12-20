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
								@foreach($statuses as $status)
									<tr>
										<td>{!! $count++ !!}</td>
										<td>{!! $status->name !!}</td>
										<td>{!! $status->description !!}</td>
										<td>
											<a href="#update-status-{!! $status->id !!}" class="btn btn-primary" data-toggle="modal"><i class="far fa-edit"></i></a>
											<a href="{!! route('crm.leads.status.delete', $status->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
									<div class="modal fade" id="update-status-{!! $status->id !!}">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Update Status</h4>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													{!! Form::model($status, ['route' => ['crm.leads.status.update',$status->id], 'method'=>'post']) !!}
														@csrf
														<div class="form-group form-group-default required">
															{!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
															{!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter status Name','required' => '')) !!}
														</div>
														<div class="form-group">
															{!! Form::label('description', 'Description', array('class'=>'control-label')) !!}
															{!! Form::textarea('description', null, array('class' => 'form-control', 'size' => '10x10')) !!}
														</div>
														<div class="form-group mt-4">
															<center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Status</button></center>
														</div>
													{!! Form::close() !!}
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		{{-- create status --}}
		<div class="modal fade" id="create-status">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add Status</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						{!! Form::open(array('route' => 'crm.leads.status.store')) !!}
							@csrf
							<div class="form-group form-group-default required">
								{!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
								{!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter status Name','required' => '')) !!}
							</div>
							<div class="form-group">
								{!! Form::label('description', 'Description', array('class'=>'control-label')) !!}
								{!! Form::textarea('description', null, array('class' => 'form-control', 'size' => '10x10')) !!}
							</div>
							<div class="form-group mt-4">
								<center>
									<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Status</button>
									<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
								</center>
							</div>
						{!! Form::close() !!}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
