<?php $__env->startSection('title'); ?>
	Details |
	<?php if($client->contact_type == 'Individual'): ?> 
		<?php echo $client->salutation; ?> <?php echo $client->customer_name; ?>

	<?php else: ?> 
		<?php echo $client->customer_name; ?>

	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="card-box text-center">
               <?php if($client->image != ""): ?>
						<img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$client->customer_code.'/images/'.$client->image); ?>" alt="" style="width:90px;height:90px" class="rounded-circle">
					<?php else: ?>
						<img src="https://ui-avatars.com/api/?name=<?php echo $client->customer_name; ?>&rounded=true&size=90" alt="">
					<?php endif; ?>
					<h4 class="mb-1 mt-2">
						<?php if($client->contact_type == 'Individual'): ?> 
							<?php echo $client->salutation; ?> <?php echo $client->customer_name; ?>

						<?php else: ?> 
							<?php echo $client->customer_name; ?>

						<?php endif; ?>
					</h4>  
					<p class="text-muted"><i class="fas fa-at"></i> <?php echo $client->email; ?><br><i class="fas fa-phone"></i> <?php echo $client->primary_phone_number; ?></p>
					<a href="<?php echo e(route('crm.customers.edit', $client->cid)); ?>" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fal fa-edit"></i> Edit</a>
					<?php if(Wingu::business()->plan != 1): ?>
						<a href="<?php echo route('crm.customer.mail',$customerID); ?>" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fal fa-paper-plane"></i> Send Email</a>
					<?php endif; ?>
					<a href="<?php echo route('crm.customers.delete', $client->cid); ?>" class="btn btn-danger btn-xs waves-effect mb-2 waves-light delete"><i class="fas fa-trash"></i> Delete</a>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-file-invoice-dollar"></i> Billing Information</h4>
					</div>
					<div class="panel-body">
						<p><?php echo $client->bill_attention; ?><br>
							<?php if($client->bill_country != ""): ?>
							<?php echo Wingu::country($client->bill_country)->name; ?><br>
							<?php endif; ?>
							<?php echo $client->bill_city; ?><br>
							<?php echo $client->bill_street; ?><br>
							<?php echo $client->bill_state; ?><br>
							<?php echo $client->bill_address; ?><br>
							<?php echo $client->bill_zip_code; ?><br>
							<?php echo $client->bill_fax; ?></br>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-shipping-fast"></i> Shipping Information</h4>
					</div>
					<div class="panel-body">
						<p><?php echo $client->ship_attention; ?><br>
							<?php if($client->ship_country != ""): ?>
							<?php echo Wingu::country($client->ship_country)->name; ?><br>
							<?php endif; ?>
							<?php echo $client->ship_city; ?><br>
							<?php echo $client->ship_street; ?><br>
							<?php echo $client->ship_state; ?><br>
							<?php echo $client->ship_address; ?> <br>
							<?php echo $client->ship_zip_code; ?><br>
							<?php echo $client->ship_fax; ?></br>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-users-medical"></i> Contact Persons</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="row">
										<div class="col-md-3">
											<img src="https://ui-avatars.com/api/?name=<?php echo $contact->names; ?>&rounded=true&size=50" alt="">
										</div>
										<div class="col-md-9">
											<p>
												<b>Name :</b> <span class="text-pink"><?php echo $contact->names; ?></span><br>
												<b>Phone number :</b> <span class="text-pink"><?php echo $contact->phone_number; ?></span><br>
												<b>Email :</b> <span class="text-pink"><?php echo $contact->contact_email; ?></span><br>
												<b>Designation :</b> <span class="text-pink"><?php echo $contact->designation; ?></span><br>
											</p>
										</div>
										<div class="col-md-12">
											<hr>
										</div>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>								
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-md-9">
				<div class="row mb-3">
					<div class="col-md-12">
                  <div class="float-right">
							<a href="<?php echo e(route('crm.customers.edit', $client->cid)); ?>" class="btn btn-white"><i class="fas fa-edit"></i> Edit</a>
							<?php if(Wingu::business()->plan != 1): ?>
								<a href="<?php echo e(route('crm.customer.send', $client->cid)); ?>" class="btn btn-white"><i class="fal fa-paper-plane"></i> Send Mail</a>
							<?php endif; ?>
   						<div class="btn-group">
   							<button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> New Transaction </button>
   							<ul class="dropdown-menu pull-right">
   								<li><a href="<?php echo route('finance.invoice.product.create'); ?>">Invoice</a></li>
   								<li><a href="<?php echo route('finance.payments.create'); ?>">Payment</a> </li>
   								<li><a href="<?php echo route('finance.quotes.create'); ?>">Quotes</a> </li>
   								<li><a href="<?php echo route('finance.creditnote.create'); ?>">Credit Note</a> </li>
   								<li class="divider"></li>
   								<li> <a href="">Project</a> </li>
   							</ul>
   						</div>
   						<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-white dropdown-toggle pull-right"> More </button>
								<ul class="dropdown-menu">
									<?php if(Wingu::business()->plan != 1): ?>
										<li><a href="<?php echo route('crm.customer.sms',$customerID); ?>"><i class="fal fa-sms"></i> SMS</a></li>
										<li><a href="<?php echo route('crm.customer.mail',$customerID); ?>"><i class="fal fa-paper-plane"></i> Mail</a></li>
										<li class="divider"></li>
									<?php endif; ?>
									<li><a href="<?php echo route('crm.customer.notes',$customerID); ?>"><i class="fal fa-sticky-note"></i> Notes</a></li>
									<li><a href="<?php echo route('crm.customer.events',$customerID); ?>"><i class="fal fa-calendar-alt"></i> Meeting</a></li>
									<li><a href="<?php echo route('crm.customer.calllog',$customerID); ?>"><i class="fal fa-phone-office"></i> Call log</a></li>
									<li class="divider"></li>									
									<li><a href="<?php echo route('crm.customers.delete', $client->cid); ?>"><i class="fas fa-trash"></i> Delete</a></li>
								</ul>
							</div>
							<?php if(Wingu::business()->plan != 1): ?>
								<a href="<?php echo route('crm.customer.documents',$customerID); ?>" class="btn btn-white"><i class="fal fa-folder"></i> Documents</a>
							<?php endif; ?>
                  </div>
					</div>
				</div>
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- begin nav -->
				<?php echo $__env->make('app.crm.customers._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- end nav -->

				<!-- main client page -->
				<?php if(Request::is('crm/customer/'.$customerID.'/show')): ?>
					<?php echo $__env->make('app.crm.customers.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>					
				<?php endif; ?>

				<!-- comments -->
				<?php if(Request::is('crm/customer/'.$customerID.'/comments')): ?>
					<?php echo $__env->make('app.crm.customers.comments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- invoice -->
				<?php if(Request::is('crm/customer/'.$customerID.'/invoices')): ?>
					<?php echo $__env->make('app.crm.customers.invoices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- estimates -->
				<?php if(Request::is('crm/customer/'.$customerID.'/quotes')): ?>
					<?php echo $__env->make('app.crm.customers.quotes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- creditnote -->
				<?php if(Request::is('crm/customer/'.$customerID.'/creditnotes')): ?>
					<?php echo $__env->make('app.crm.customers.creditnotes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- projects -->
				<?php if(Request::is('crm/customer/'.$customerID.'/projects')): ?>
					<?php echo $__env->make('app.crm.customers.projects', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- statement -->
				<?php if(Request::is('crm/customer/'.$customerID.'/statement')): ?>
					<?php echo $__env->make('app.crm.customers.statement', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- statement mail -->
				<?php if(Request::is('crm/customer/'.$customerID.'/statement/mail')): ?>
					<?php echo $__env->make('app.crm.customers.statementMail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- subscription -->
				<?php if(Request::is('crm/customer/'.$customerID.'/subscriptions')): ?>
					<?php echo $__env->make('app.crm.customers.subscriptions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- contacts -->
				<?php if(Request::is('crm/customer/'.$customerID.'/contacts')): ?>
					<?php echo $__env->make('app.crm.customers.contacts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- mails -->
				<?php if(Request::is('crm/customer/'.$customerID.'/mail')): ?>
					<?php echo $__env->make('app.crm.customers.mail.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- send -->
				<?php if(Request::is('crm/customer/'.$customerID.'/send')): ?>
					<?php echo $__env->make('app.crm.customers.mail.mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- documents -->
				<?php if(Request::is('crm/customer/'.$customerID.'/documents')): ?>
					<?php echo $__env->make('app.crm.customers.documents', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- sms -->
				<?php if(Request::is('crm/customer/'.$customerID.'/sms')): ?>
					<?php echo $__env->make('app.crm.customers.sms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- notes -->
				<?php if(Request::is('crm/customer/'.$customerID.'/notes')): ?>
					<?php echo $__env->make('app.crm.customers.notes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- events -->
				<?php if(Request::is('crm/customer/'.$customerID.'/events')): ?>
					<?php echo $__env->make('app.crm.customers.events', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- events -->
				<?php if(Request::is('crm/customer/'.$customerID.'/calllogs')): ?>
					<?php echo $__env->make('app.crm.customers.calllogs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/customers/view.blade.php ENDPATH**/ ?>