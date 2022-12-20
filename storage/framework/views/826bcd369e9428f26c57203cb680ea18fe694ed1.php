<?php $__env->startSection('title'); ?>
	Quotes | <?php echo $customer->customer_name; ?> 
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<a href="#"  class="btn <?php echo $quote->statusName; ?> mb-2"><i class="fal fa-bell"></i> <?php echo ucfirst($quote->statusName); ?></a>
		<?php if($quote->statusID == 13 && $quote->invoice_link != ""): ?>
		   <a href="#" class="btn pink float-right"><i class="fal fa-check-circle"></i> Converted to invoice</a>
		<?php endif; ?>
		<div class="panel">
			<div class="panel-body">
				<div class="invoice-company text-inverse f-w-600">
					<span class="pull-right hidden-print">
						<?php if (app('laratrust')->isAbleTo('create-quotes')) : ?>
							<a href="<?php echo route('finance.quotes.mail', $quote->quoteID); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
								<i class="fal fa-envelope"></i> Email Quote
							</a>
						<?php endif; // app('laratrust')->permission ?>
						<?php if($quote->statusID != 13): ?>
							<?php if (app('laratrust')->isAbleTo('update-quotes')) : ?>
								<a href="<?php echo route('finance.quotes.edit', $quote->quoteID); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-edit"></i> Edit
								</a>
							<?php endif; // app('laratrust')->permission ?>
						<?php endif; ?>
						<?php if (app('laratrust')->isAbleTo('create-quotes')) : ?>
							<a href="<?php echo route('finance.quotes.pdf', $quote->quoteID); ?>" class="btn btn-sm btn-white m-b-10 p-l-5">
								<i class="fal fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
							</a>
						<?php endif; // app('laratrust')->permission ?>
						<?php if (app('laratrust')->isAbleTo('create-quotes')) : ?>
							<a href="<?php echo route('finance.quotes.print', $quote->quoteID); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
								<i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
							</a>
						<?php endif; // app('laratrust')->permission ?>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								More
							</button>
							<ul class="dropdown-menu dropdown-menu-right">
								
								<li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
								<?php if (app('laratrust')->isAbleTo('create-quotes')) : ?>
								<?php if($quote->statusID != 10): ?>
									<li><a href="<?php echo route('finance.quotes.status.change',[$quote->quoteID,10]); ?>">Mark as Draft</a></li>
								<?php endif; ?>
								<?php if($quote->statusID != 11): ?>
								<li><a href="<?php echo route('finance.quotes.status.change',[$quote->quoteID,11]); ?>">Mark as Expired</a></li>
								<?php endif; ?>
								<?php if($quote->statusID != 12): ?>
								<li><a href="<?php echo route('finance.quotes.status.change',[$quote->quoteID,12]); ?>">Mark as Declined</a></li>
								<?php endif; ?>
								<?php if($quote->statusID != 13): ?>
								<li><a href="<?php echo route('finance.quotes.status.change',[$quote->quoteID,13]); ?>">Mark as Accepted</a></li>
								<?php endif; ?>
								<?php if($quote->statusID != 6): ?>
								<li><a href="<?php echo route('finance.quotes.status.change',[$quote->quoteID,6]); ?>">Mark as Sent</a></li>
								<?php endif; ?>
								<?php endif; // app('laratrust')->permission ?>
								<li class="divider"></li>
								
								<li><a href="<?php echo route('finance.quotes.delete',$quote->quoteID); ?>" class="text-danger delete">Delete Quotes</a></li>
							</ul>
						</div>
						<?php if($quote->statusID == 13): ?>
							<?php if (app('laratrust')->isAbleTo('create-quotes')) : ?>
								<?php if($quote->invoice_link == ""): ?>
									<a href="<?php echo route('finance.quotes.convert',$quote->quoteID); ?>" class="btn btn-success btn-sm m-b-10 p-l-5"><i class="fal fa-rocket"></i> Convert to Invoice</a>
								<?php endif; ?>
							<?php endif; // app('laratrust')->permission ?>
						<?php endif; ?>
					</span>
					<?php echo $customer->customer_name; ?>

				</div>
			</div>
		</div>
		<div class="invoice">
			<?php echo $__env->make('templates.'.$template.'.quotes.preview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>				
			<!-- end invoice-content -->
			<!-- begin invoice-footer -->
			<div class="invoice-footer">
				<p class="text-center m-b-5 f-w-600">
					THANK YOU FOR YOUR BUSINESS
				</p>
				<p class="text-center">
					<?php if($quote->website != ""): ?>
					<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> <?php echo $quote->website; ?></span>
					<?php endif; ?>
					<?php if($quote->primary_phonenumber != ""): ?>
						<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> <?php echo $quote->primary_phonenumber; ?></span>
					<?php endif; ?>
					<?php if($quote->primary_email != ""): ?>
						<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> <?php echo $quote->primary_email; ?></span>
					<?php endif; ?>
				</p>
			</div>
			<!-- end invoice-footer -->
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
					<form action="<?php echo route('finance.quotes.attachment.files'); ?>" class="dropzone" id="my-awesome-dropzone" method="post">
						<?php echo csrf_field(); ?>
						<input type="hidden" value="<?php echo $quote->quoteID; ?>" name="quoteID">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
							<table id="data-table-default" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="1%">#</th>
										<th></th>
										<th>Name</th>
										<th>Type</th>
										<th  width="15%">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo $filec++; ?></td>
											<td>
												<?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
													<center><i class="fal fa-image fa-4x"></i></center>
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
												<a href="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/quotes/'.$file->file_name); ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
												<a href="<?php echo route('finance.quotes.attachment.delete',$file->id); ?>" class="btn btn-danger btn-sm"><i class="fal fa-trash"></i></a>
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
			$.get(url+'/finance/quotes/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/quotes/show.blade.php ENDPATH**/ ?>