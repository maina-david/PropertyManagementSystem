<?php $__env->startSection('title'); ?>
	Credit note | <?php echo $show->prefix; ?><?php echo $show->creditnote_number; ?>

<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="row">
			<div class="col-md-4">
				<div class=""> 
					<?php if(Finance::count_creditnote() != Wingu::plan()->credit_note && Finance::count_creditnote() < Wingu::plan()->credit_note): ?>
						<?php if (app('laratrust')->isAbleTo('create-creditnote')) : ?>
							<a href="<?php echo route('finance.creditnote.create'); ?>" class="btn btn-pink pull-right"><i class="fas fa-plus"></i> New</a> 
						<?php endif; // app('laratrust')->permission ?>
					<?php endif; ?>
					
				</div> 
			</div>
			<div class="col-md-8">
				<div class="invoice">
					<!-- begin invoice-company -->
					<div class="invoice-company text-inverse f-w-600 mb-3">
						<span class="pull-right hidden-print">
							<?php if (app('laratrust')->isAbleTo('create-creditnote')) : ?>
								<a href="<?php echo route('finance.creditnote.mail', $show->creditnoteID); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-envelope"></i> Email Credit note
								</a>
							<?php endif; // app('laratrust')->permission ?>
							<?php if($show->paymentID == ""): ?>
								<a href="<?php echo route('finance.creditnote.edit', $show->creditnoteID); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fas fa-edit"></i> Edit
								</a>
							<?php endif; ?>
							<?php if (app('laratrust')->isAbleTo('read-creditnote')) : ?>
								<a href="<?php echo route('finance.creditnote.pdf', $show->creditnoteID); ?>" class="btn btn-sm btn-white m-b-10 p-l-5">
									<i class="fal fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
								</a>
								<a href="<?php echo route('finance.creditnote.print', $show->creditnoteID); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
									<i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
								</a>
							<?php endif; // app('laratrust')->permission ?>
							<?php if (app('laratrust')->isAbleTo('create-creditnote')) : ?>
								<?php if($checkOpenInvoices >= 1): ?>
									<a href="#" data-toggle="modal" data-target="#apply-to-invoice" class="btn btn-sm btn-white m-b-10 p-l-5">
										Apply To Invoice
									</a>
								<?php endif; ?>
							<?php endif; // app('laratrust')->permission ?>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									More
								</button>
								<ul class="dropdown-menu dropdown-menu-right">
									
									<?php if (app('laratrust')->isAbleTo('create-creditnote')) : ?>
									<li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
									<?php endif; // app('laratrust')->permission ?>
									
									
									<li class="divider"></li>
									
									<?php if (app('laratrust')->isAbleTo('delete-creditnote')) : ?>
									<li><a href="<?php echo route('finance.creditnote.delete',$show->creditnoteID); ?>" class="text-danger delete">Delete Credit note</a></li>
									<?php endif; // app('laratrust')->permission ?>
								</ul>
							</div>
						</span> 
							
						<?php echo $show->prefix; ?><?php echo $show->creditnote_number; ?>

					</div>
					<!-- end invoice-company -->
					<div class="invoice-content">
						<?php echo $__env->make('templates.'.$template.'.creditnote.preview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
					<!-- begin invoice-footer -->
					<div class="invoice-footer">
						<p class="text-center m-b-5 f-w-600">
							THANK YOU FOR YOUR BUSINESS
						</p>
						<p class="text-center">
							<?php if($show->business_website != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> <?php echo $show->business_website; ?></span>
							<?php endif; ?>
							<?php if($show->primary_phonenumber != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> <?php echo $show->primary_phonenumber; ?></span>
							<?php endif; ?>
							<?php if($show->primary_email  != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> <?php echo $show->primary_email; ?></span>
							<?php endif; ?>
						</p>
					</div>
					<!-- end invoice-footer -->
				</div>
			</div>
		</div>
	</div>

	<!-- attach files to Quotes -->
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="<?php echo route('finance.creditnote.attachment.files'); ?>" class="dropzone" id="my-awesome-dropzone" method="post">
						<?php echo csrf_field(); ?>
						<input type="hidden" value="<?php echo $show->creditnoteID; ?>" name="creditnoteID">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
						<table id="data-table-default" class="table table-striped table-bordered table-hover">
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
												<center><i class="fas fa-image fa-4x"></i></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'pdf') !== FALSE): ?>
												<center><i class="fas fa-file-pdf fa-4x"></i></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'octet-stream') !== FALSE): ?>
												<center><i class="fas fa-file-alt fa-4x"></i></center>
											<?php endif; ?>
										</td>
										<td width="10%"><?php echo $file->file_name; ?></td>
										<td><?php echo $file->file_mime; ?></td>
										
										<td>
											<a href="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/creditnote/'.$file->file_name); ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
											<a href="<?php echo route('finance.creditnote.attachment.delete',$file->id); ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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

	<?php if($checkOpenInvoices >= 1): ?>
		<!--- Apply To Invoice -->
		<div class="modal fade" id="apply-to-invoice">
			<div class="modal-dialog modal-lg">
				<form action="<?php echo route('finance.creditnote.apply.credit'); ?>" method="post" enctype="multipart/form-data">
					<?php echo csrf_field(); ?>
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Apply credits from <?php echo $show->prefix; ?><?php echo $show->creditnote_number; ?></h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<table class="table table-bordered table-striped">
								<tr>
									<th>Invoice#</th>
									<th>Date</th>
									<th>Amount</th>
									<th>Balance</th>
									<th width="20%">Amout to credit</th>
								</tr>
								<tbody>
									<?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($invoice->total != ""): ?>
											<tr>
												<td><?php echo $invoice->prefix; ?><?php echo $invoice->invoice_number; ?></td>
												<td><?php echo date('d F, Y', strtotime($invoice->invoice_date)); ?></td>
												<td>
													<?php echo $invoice->code; ?> <?php echo number_format($invoice->total); ?>

												</td>
												<td>
													<?php echo $invoice->code; ?> <?php echo number_format($invoice->total - $invoice->paid); ?>

												</td> 
												<td>
													<input type="number" class="form-control" name="credit[]" required min="0" max="<?php echo $invoice->total - $invoice->paid; ?>">
													<input type="hidden" class="form-control" name="invoiceID[]" value="<?php echo $invoice->invoID; ?>">
													<input type="hidden" class="form-control" name="creditnoteID[]" value="<?php echo $show->creditnoteID; ?>">
													<input type="hidden" class="form-control" name="clientID" value="<?php echo $show->customerID; ?>">
												</td>
											</tr>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-pink submit">Apply Credit</button>
							<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none float-right" alt="" width="15%">
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
		function change_status() {
			var url = '<?php echo url('/'); ?>';
			var status = document.getElementById("status").value;
			var file = document.getElementById("fileID").value;
			$.get(url+'/finance/creditnote/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/creditnote/show.blade.php ENDPATH**/ ?>