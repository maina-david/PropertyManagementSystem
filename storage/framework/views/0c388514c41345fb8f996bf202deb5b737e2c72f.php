<?php $__env->startSection('title'); ?><?php if($client->company_name != ""): ?><?php echo $client->company_name; ?> <?php else: ?> <?php echo $client->client_name; ?> <?php endif; ?> | information <?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		
		<div class="row">
			<div class="col-md-3">
				<div class="card-box text-center">
               <?php if($client->image == ""): ?>
                  <img alt="<?php echo $client->names; ?>" src="<?php echo "https://www.gravatar.com/avatar/". md5(strtolower(trim($client->contact_email))) . "?s=200&d=wavatar"; ?>" class="img-circle" width="80" height="80">
               <?php else: ?>
                  <img width="150" height="150" alt="" class="img-circle" src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/clients/'.$client->contact_email .'/images/'.$client->image); ?>">
               <?php endif; ?>
					<h4 class="mb-1 mt-2"><?php if($client->company_name != ""): ?><?php echo $client->company_name; ?> <?php else: ?> <?php echo $client->client_name; ?> <?php endif; ?></h4>
					<p class="text-muted"><i class="fas fa-at"></i> <?php echo $client->contact_email; ?><br><i class="fas fa-phone"></i> <?php echo $client->primary_phone_number; ?></p>
					<a href="<?php echo e(route('finance.contact.edit', $client->cid)); ?>" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fas fa-user-edit"></i> Edit</a>
					<a href="#" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fas fa-envelope-open-text"></i> Send Email</a>
					<a href="<?php echo route('finance.contact.delete', $client->cid); ?>" class="btn btn-danger btn-xs waves-effect mb-2 waves-light"><i class="fas fa-trash"></i> Delete</a>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fas fa-file-invoice-dollar"></i> Billing Address</h4>
					</div>
					<div class="panel-body">
						<p><b>Billing Information</b></p>
						<p><?php echo $client->bill_attention; ?><br>
							<?php if($client->bill_country != ""): ?>
							<?php echo Wingu::country($client->bill_country)->name; ?><br>
							<?php endif; ?>
							<?php echo $client->bill_city; ?><br>
							<?php echo $client->bill_street; ?><br>
							<?php echo $client->bill_state; ?><br>
							<?php echo $client->bill_address; ?> - <?php echo $client->bill_zip_code; ?><br>
							<?php echo $client->bill_fax; ?></b>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fas fa-truck"></i> Shipping Address</h4>
					</div>
					<div class="panel-body">
						<p><b>Shipping Information</b></p>
						<p><?php echo $client->ship_attention; ?><br>
							<?php if($client->ship_country != ""): ?>
							<?php echo Settings::country($client->ship_country)->name; ?><br>
							<?php endif; ?>
							<?php echo $client->ship_city; ?><br>
							<?php echo $client->ship_street; ?><br>
							<?php echo $client->ship_state; ?><br>
							<?php echo $client->ship_address; ?> - <?php echo $client->ship_zip_code; ?><br>
							<?php echo $client->ship_fax; ?></b>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fas fa-info-circle"></i> Other Information</h4>
					</div>
					<div class="panel-body">
						<p>Currency Code <span class="float-right text-primary"> <?php if($client->currency != ""): ?> <?php echo Finance::currency($client->currency)->currency_name; ?> - <?php echo Finance::currency($client->currency)->symbol; ?> <?php endif; ?></span></p>
						<p>Portal Status <span class="float-right text-primary"><?php if($client->portal != ""): ?> Portal Set <?php else: ?> Not Set <?php endif; ?></span></p>
						<p>Portal Language <span class="float-right text-primary"><?php if($client->language != ""): ?> <?php echo Wingu::Language($client->language)->name; ?> <?php endif; ?> </span></p>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row mb-3">
					<div class="col-md-6"></div>
					<div class="col-md-6">
						<a href="<?php echo e(route('finance.contact.edit', $client->cid)); ?>" class="btn btn-default"><i class="fas fa-user-edit"></i> Edit</a>
						<a href="#" class="btn btn-default"><i class="fas fa-paperclip"></i> Attach Files</a>
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"> New Transaction </button>
							<ul class="dropdown-menu pull-right">
								<li><a href="<?php echo route('finance.contact.invoices', $clientID); ?>">Invoice</a></li>
								<li><a href="">Customer Payment</a> </li>
								<li><a href="">Estimate</a> </li>
								<li><a href="">Recurring Invoice  </a> </li>
								<li><a href="">Credit Note</a> </li>
								<li><a href="">Expense</a> </li>
								<li><a href="">Recurring Expense</a> </li>
								<li class="divider"></li>
								<li> <a href="">Project</a> </li>
							</ul>
						</div>
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-default dropdown-toggle pull-right"> More </button>
							<ul class="dropdown-menu">
								<li><a href="#">Associate Templates</a></li>
								<li><a href="">Stop all Reminders</a></li>
								<li><a href="">Email Contact</a></li>
								<li class="divider"></li>
								<li><a href="">Configure Client Portal</a></li>
								<li><a href="">Clone</a></li>
								<li><a href="">Merge Contacts</a></li>
								<li class="divider"></li>
								<li><a href="">Mark as Inactive</a></li>
								<li><a href="">Delete</a></li>
							</ul>
						</div>
					</div>
				</div>
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- begin nav -->
				<?php echo $__env->make('app.finance.contacts.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- end nav -->

				<!-- main client page -->
				<?php if(Request::is('finance/contact/'.$clientID.'/show')): ?>
					<div class="contact-dashboard">
						<div class="row">
							<!-- begin col-3 -->
							<div class="col-lg-4 col-md-6">
								<div class="widget widget-stats bg-gradient-teal">
									<div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i></div>
									<div class="stats-content">
										<div class="stats-title">Unused Credits</div>
										<div class="stats-number">ksh 42,900</div>
										<div class="stats-progress progress">
											<div class="progress-bar" style="width: 100%;"></div>
										</div>
										<div class="stats-desc">view</div>
									</div>
								</div>
							</div>
							<!-- end col-3 -->
							<!-- begin col-3 -->
							<div class="col-lg-4 col-md-6">
								<div class="widget widget-stats bg-gradient-blue">
									<div class="stats-icon stats-icon-lg"><i class="fas fa-file-invoice-dollar fa-fw"></i></div>
									<div class="stats-content">
										<div class="stats-title">Outstanding Receivables</div>
										<div class="stats-number">ksh 180,200</div>
										<div class="stats-progress progress">
											<div class="progress-bar" style="width: 100%;"></div>
										</div>
										<div class="stats-desc">view</div>
									</div>
								</div>
							</div>
							<!-- end col-3 -->
							<!-- begin col-3 -->
							<div class="col-lg-4 col-md-6">
								<div class="widget widget-stats bg-gradient-purple">
									<div class="stats-icon stats-icon-lg"><i class="fas fa-hammer fa-fw"></i></div>
									<div class="stats-content">
										<div class="stats-title">Projects</div>
										<div class="stats-number">38,900</div>
										<div class="stats-progress progress">
											<div class="progress-bar" style="width: 100%;"></div>
										</div>
										<div class="stats-desc">view</div>
									</div>
								</div>
							</div>
							<!-- end col-3 -->
						</div>
						<!-- end row -->
						<div class="row">
							<!-- begin col-8 -->
							<div class="col-lg-12">
								<div class="widget-chart with-sidebar inverse-mode">
									<div class="widget-chart-content bg-black">
										<h4 class="chart-title">
											Income and Expense
										</h4>
										<div id="visitors-line-chart" class="widget-chart-full-width nvd3-inverse-mode" style="height: 260px;"></div>
									</div>
									<div class="widget-chart-sidebar bg-black-darker">
										<div class="chart-number">
											ksh 1,225,729
											<small>Total Income</small>
										</div>
										<div id="visitors-donut-chart" class="nvd3-inverse-mode p-t-10" style="height: 180px"></div>
										<ul class="chart-legend f-s-11">
											<li><i class="fa fa-circle fa-fw text-primary f-s-9 m-r-5 t-minus-1"></i> 34.0% <span>Income</span></li>
											<li><i class="fa fa-circle fa-fw text-success f-s-9 m-r-5 t-minus-1"></i> 56.0% <span>Expense</span></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- end col-8 -->
						</div>
					</div>
				<?php endif; ?>

				<!-- comments -->
				<?php if(Request::is('finance/contact/'.$clientID.'/comments')): ?>
					<?php echo $__env->make('app.finance.contacts.comments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- invoice -->
				<?php if(Request::is('finance/contact/'.$clientID.'/invoices')): ?>
					<?php echo $__env->make('app.finance.contacts.invoices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/suppliers/view.blade.php ENDPATH**/ ?>