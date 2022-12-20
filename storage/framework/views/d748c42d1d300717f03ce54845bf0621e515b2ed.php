<?php $__env->startSection('title','ContactList'); ?>

<?php $__env->startSection('stylesheets'); ?>
	
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-menu'); ?>
	<?php echo $__env->make('app.crm.partials._main_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="normalheader ">
        <div class="hpanel">
            <div class="panel-body">
                <a class="small-header-action" href="">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>
                <div id="hbreadcrumb" class="pull-right m-t-lg">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                        <li>
                            <span>Contacts</span>
                        </li>
                        <li class="active">
                            <span>Contact List</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Contacts
                </h2>
                <small>Quick way to view all your clients and how much they owe the company</small>
            </div>
        </div>
    </div>
	<div class="content"> 
        <div class="row p-b-20">                
            <a href="<?php echo e(url('crm/leads/create')); ?>" class="btn btn-info pull-right m-r-20"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Leads</a>            
        </div>
		<div class="row">
            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cnt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3">
                    <div class="hpanel <?php if($cnt->contact_type == 'Individual'): ?> hgreen <?php elseif($cnt->contact_type == 'Organization'): ?> hred <?php else: ?> hblue <?php endif; ?> contact-panel">
                        <div class="panel-body">
                            <?php if($cnt->contact_type == 'Individual'): ?>
                                <span class="label label-success pull-right"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Individual</span>
                            <?php elseif($cnt->contact_type == 'Organization'): ?>
                                <span class="label label-info pull-right"><i class="fa fa-building-o" aria-hidden="true"></i> Organization</span>
                            <?php else: ?>

                            <?php endif; ?>  
                            <?php if($cnt->client_type == 'Lead'): ?>
                                <span class="label label-warning pull-right"><i class="fa fa-bullseye" aria-hidden="true"></i> Leads </span> 
                            <?php endif; ?>                          
                            <img alt="logo" class="img-circle m-b" src="<?php echo e(asset('resources/assets/images/profile_avatar.png')); ?>">
                            <h3><a href="<?php echo e(url('crm/contact/'.$cnt->id.'/view')); ?>">
                            <?php if($cnt->company_name == ""): ?>
                                <?php echo $cnt->first_name; ?> <?php echo $cnt->last_name; ?>

                            <?php elseif($cnt->first_name == ""): ?>
                                <?php echo $cnt->company_name; ?>

                            <?php endif; ?>.</a></h3>
                            <div class="text-muted font-bold m-b-xs"><?php echo $cnt->contact_email; ?></div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.
                            </p>
                        </div>
                        <div class="panel-footer contact-footer">
                            <div class="row">
                                <div class="col-md-6 border-right"> 
                                    <a href="<?php echo e(url('crm/contact/'.$cnt->id.'/view')); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="<?php echo e(url('crm/Contact/'.$cnt->id.'/edit')); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="<?php echo e(url('crm/Contact/'.$cnt->id.'/delete')); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
	</div>	

    <contact-quick-edit></contact-quick-edit>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/customers/leads.blade.php ENDPATH**/ ?>