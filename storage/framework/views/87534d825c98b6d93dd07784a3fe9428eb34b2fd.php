<?php $__env->startSection('title'); ?><?php echo ucfirst($section); ?> <?php echo e(trans('general.section')); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesheet'); ?>
	
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('backend.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;"><?php echo e(trans('general.settings')); ?></a></li>
			<li class="breadcrumb-item"><a href="javascript:;"><?php echo e(trans('settings.language')); ?></a></li>
			<li class="breadcrumb-item active"><?php echo e(trans('general.translate')); ?> <?php echo e(trans('settings.language')); ?></li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fas fa-language"></i> <?php echo e(trans('general.translate')); ?> <?php echo e(trans('settings.language')); ?>.</h1>
		<?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="col-md-12 col-lg-12">
			<h4><?php echo e(trans('settings.language')); ?> : <?php echo e($language->name); ?></h4>
			<h4><?php echo e(trans('general.section')); ?>  : <span class="uppercase"><?php echo ucfirst($section); ?></span></h4>
		</div>		
		<!-- begin row -->
		<div class="row">
			<!-- begin col-8 -->
			<div class="col-lg-8">
				<!-- begin panel -->
				<div class="panel panel-inverse">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title"><?php echo e(trans('settings.language')); ?></h4>
					</div>
					<button class="btn btn-info pull-right mt-2 mb-2 mr-2" data-target="#addlanguage" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo e(trans('general.add')); ?> <?php echo e(trans('settings.language')); ?></button>
					<?php echo e(Form::open(array('route' => 'language.translate', 'method'=>'POST', 'role' => 'form'))); ?>

					<input type="hidden" name="section" value="<?php echo $section; ?>">
						<table id="category-form" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo e(trans('general.original')); ?></th>
									<th><?php echo e(trans('general.translate')); ?></th>
								</tr>
							</thead>									
							<tbody>
								<?php $__currentLoopData = $original; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>											
								<tr>
									<td width="50%">
										<p><b><?php echo e($v['original']); ?></b></p>
									</td>												
									<td>
										<input type="text" name="words[<?php echo e($k); ?>]" class="form-control required" value="<?php echo e(isset($translated[$k]) ? $translated[$k] : $v['translated']); ?>">
									</td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>	
							<tfoot>
								<tr>
									<td colspan="2">
										<input type="hidden" name="languageID" value="<?php echo e($language->id); ?>" required="">
										<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?php echo e(trans('general.save')); ?></button>
									</td>
								</tr>
							</tfoot>		
						</table>	
					<?php echo e(Form::close()); ?>

				</div>
				<!-- end panel -->
			</div>
			<!-- end col-8 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">					
				<h4 class="m-t-0 m-b-15"><b><?php echo e(trans('general.choose')); ?> <?php echo e(trans('general.translate')); ?> <?php echo e(trans('general.section')); ?></b></h4>
				<?php echo e(Form::open(array('route' => 'language.translate.section', 'method' => 'post'))); ?>	
					<input type="hidden" name="languageID" value="<?php echo e($language->id); ?>" required="">
					<div class="form-group">
						<select name="section" class="form-control required solsoSelect2">				
							<option value="<?php echo $section; ?>"><?php echo $section; ?></option>
							<?php $__currentLoopData = $sects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo $sect->directory; ?>"><?php echo $sect->name; ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
					<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> <?php echo e(trans('general.save')); ?></button>	
				<?php echo e(Form::close()); ?>	
			</div>
			<!-- end col-4 -->
		</div>
	</div> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script type="text/javascript">
		$(document).ready(function() {
	    	$('#category-form').DataTable( {
	         dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [ [1000000,10], [1000000,10, "All"] ],
	         buttons: [
					{extend: 'copy',className: 'btn-sm'},
					{extend: 'csv',title: 'Finance Contact list', className: 'btn-sm'},
					{extend: 'pdf', title: 'Finance Contact list', className: 'btn-sm'},
					{extend: 'print',className: 'btn-sm'}
            ]
		    } );
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/language/show.blade.php ENDPATH**/ ?>