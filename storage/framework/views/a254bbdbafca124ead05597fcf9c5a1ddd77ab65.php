<?php $__env->startSection('title'); ?>
<?php echo $salesorder->prefix; ?><?php echo $salesorder->salesorder_number; ?> | Sales Order | <?php echo $client->customer_name; ?> | 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-10">
				<div class="invoice">
					<!-- begin invoice-company -->
					<div class="invoice-company text-inverse f-w-600">
						<span class="col-md-12">
							
							<?php if (app('laratrust')->isAbleTo('update-invoice')) : ?>
								<a href="<?php echo route('finance.salesorders.edit', $salesorder->salesorderID); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-edit"></i> Edit
								</a>
							<?php endif; // app('laratrust')->permission ?>
							<?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
								<a href="<?php echo route('finance.salesorders.pdf', $salesorder->salesorderID); ?>" target="_blank" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
								</a>
							<?php endif; // app('laratrust')->permission ?>
							<?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
								<a href="<?php echo route('finance.salesorders.print', $salesorder->salesorderID); ?>" target="_blank" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
								</a>
							<?php endif; // app('laratrust')->permission ?>
							<a href="#" class="btn btn-default btn-sm m-b-10 p-l-5" data-toggle="modal" data-target="#attach-files"><i class="fal fa-paperclip"></i> Attach Files</a>
							<?php if($salesorder->statusID != 44): ?>
								<a href="<?php echo route('finance.salesorders.status.change',[$salesorder->salesorderID,44]); ?>" class="btn btn-success btn-sm m-b-10 p-l-5"><i class="fal fa-check-circle"></i> Mark as confirmed</a>
							<?php endif; ?>
							<?php if($salesorder->statusID == 44): ?>
								<?php if($salesorder->invoiceID == ""): ?>
									<a href="<?php echo route('finance.salesorders.convert',$salesorder->salesorderID); ?>" class="btn btn-warning btn-sm m-b-10 p-l-5 delete"><i class="fal fa-exchange-alt"></i> Convert to invoice</a>
								<?php endif; ?>
							<?php endif; ?>
							<?php if($salesorder->invoiceID != ""): ?>
								<a href="<?php echo route('finance.invoice.show', $salesorder->invoiceID); ?>" class="btn btn-pink btn-sm m-b-10 p-l-5" target="_blank"><i class="fal fa-file-invoice-dollar"></i> view invoice</a>
							<?php endif; ?>
							<a href="<?php echo route('finance.salesorders.delete', $salesorder->salesorderID); ?>" class="btn btn-danger btn-sm m-b-10 p-l-5 delete"><i class="fal fa-trash"></i> Delete</a>
						</span>
					</div>
					<hr>
					<div class="invoice-content">
						<?php echo $__env->make('templates.'.$template.'.salesorder.preview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
					
					<!-- begin invoice-footer -->
					<div class="invoice-footer">
						<p class="text-center m-b-5 f-w-600">
							THANK YOU FOR YOUR BUSINESS
						</p>
						<p class="text-center">
							<?php if($salesorder->website != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> <?php echo $salesorder->website; ?></span>
							<?php endif; ?>
							<?php if($salesorder->primary_phonenumber != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> <?php echo $salesorder->primary_phonenumber; ?></span>
							<?php endif; ?>
							<?php if($salesorder->primary_email != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> <?php echo $salesorder->primary_email; ?></span>
							<?php endif; ?>
						</p>
					</div>
					<!-- end invoice-footer -->
				</div>
         </div>
      </div>
	</div>

	
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="<?php echo route('finance.salesorders.attachment.files'); ?>" class="dropzone" id="my-awesome-dropzone" method="post">
						<?php echo csrf_field(); ?>
						<input type="hidden" value="<?php echo $salesorder->salesorderID; ?>" name="salesorderID">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th></th>
									<th width="10%">Name</th>
									<th>Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo $filec++; ?></td>
										<td>
											<?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
												<center><img src="<?php echo asset('businesses/'.$salesorder->business_code.'/finance/salesorders/'.$file->file_name); ?>" alt="" style="width:30px;height:30px"></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'pdf') !== FALSE): ?>
												<center><i class="fal fa-file-pdf fa-4x"></i></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'octet-stream') !== FALSE): ?>
												<center><i class="fal fa-file-alt fa-4x"></i></center>
											<?php endif; ?>
										</td>
										<td width="10%"><?php echo $file->file_name; ?></td>
										<td><?php echo $file->file_mime; ?></td>
										<td>
											<a href="<?php echo route('finance.salesorders.attachment.delete',$file->id); ?>" class="btn btn-danger delete"><i class="fal fa-trash"></i> Delete</a>
										</td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
					</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
		function change_status() {
			var url = '<?php echo url('/'); ?>';
			var status = document.getElementById("status").value;
			var file = document.getElementById("fileID").value;
			$.get(url+'/finance/salesorders/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/salesorders/show.blade.php ENDPATH**/ ?>