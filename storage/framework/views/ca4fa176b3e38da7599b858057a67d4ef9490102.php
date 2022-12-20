<?php $__env->startSection('title'); ?> <?php echo $role->name; ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li class="breadcrumb-item"><a href="javascript:;"><?php echo trans('general.settings'); ?></a></li>
            <li class="breadcrumb-item"><a href="javascript:;"><?php echo trans('settings.roles'); ?></a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header"><?php echo trans('general.view'); ?> <?php echo trans('settings.roles'); ?>  <?php echo trans('settings.permissions'); ?> <a class="btn btn-info " href="<?php echo url('/settings/roles/'.$role->id.'/edit'); ?>"><i class="fa fa-edit" aria-hidden="true"></i> Edit this Role</a></h1>        
        <div class="panel panel-inverse" data-sortable-id="ui-widget-1">         
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo trans('general.add'); ?> <?php echo trans('settings.roles'); ?></h4>
            </div>
            <div class="row">   
                <div class="panel-body background-white">
                    <div class="content">
                        <h2 class="title">Permissions:</h1>
                        <ul>
                            <?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($r->display_name); ?> <em class="m-l-15">(<?php echo e($r->description); ?>)</em></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/roles/show.blade.php ENDPATH**/ ?>