<?php $__env->startSection('title','Lead Settings'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Crm</a></li>
         <li class="breadcrumb-item"><a href="#">Leads</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Lead Settings</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
			<?php echo $__env->make('app.crm.settings._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col-md-9">
				<div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('crm.leads.status')); ?>" href="<?php echo route('crm.leads.status'); ?>"><i class="fas fa-sort-numeric-up"></i> Lead Status</a>
                     </li>
							<li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('crm.leads.sources')); ?>" href="<?php echo route('crm.leads.sources'); ?>"><i class="fas fa-sun"></i> Lead Source</a>
                     </li>
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
							<?php if(Request::is('crm/lead/status')): ?>
                        <?php echo $__env->make('app.crm.settings.leads.status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php endif; ?>
                     <?php if(Request::is('crm/lead/sources')): ?>
                        <?php echo $__env->make('app.crm.settings.leads.source', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php endif; ?>
                  </div>
               </div>
            </div>
			</div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/settings/leads/settings.blade.php ENDPATH**/ ?>