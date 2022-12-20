<?php $__env->startSection('title','Language'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('backend.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<!-- begin #content -->
   <div id="content" class="content">		
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;"><?php echo e(trans('general.settings')); ?></a></li>
         <li class="breadcrumb-item"><a href="javascript:;"><?php echo e(trans('settings.language')); ?></a></li>
         <li class="breadcrumb-item active"><?php echo e(trans('general.all')); ?> <?php echo e(trans('settings.language')); ?></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><?php echo e(trans('general.all')); ?> <?php echo e(trans('settings.language')); ?></h1>
	
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
					<table id="category-form" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo e(trans('settings.language')); ?></th>
								<th><?php echo e(trans('settings.short_name')); ?></th>
								<th colspan="3"><center><?php echo e(trans('general.action')); ?></center></th>
							</tr>
						</thead>
						<tbody>
							<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td class="v-align-middle semi-bold sorting_1">
										<?php echo e($crt+1); ?>

									</td>
									<td class="v-align-middle semi-bold sorting_1">
										<?php echo e($v->name); ?>

									</td>
									<td class="v-align-middle semi-bold sorting_1" style="width:100%">
										<?php echo e($v->short); ?>

									</td>
									<td class="v-align-middle semi-bold sorting_1">		
										<a class="btn solso-email btn-info" href="<?php echo e(route('language.show',[$v->id,'general'])); ?>">  
											<i class="fa fa-book"></i> <?php echo e(trans('general.translate')); ?>

										</a>
									</td>	
									<td class="v-align-middle semi-bold sorting_1">							
										<a class="btn btn-primary" href="<?php echo e(url('settings/language/' . $v->id . '/edit')); ?>">
											<i class="fa fa-edit"></i> <?php echo e(trans('general.edit')); ?>

										</a>
									</td>	
									<td class="v-align-middle semi-bold sorting_1">							
										<button class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="<?php echo e(url('settings/language/' . $v->id)); ?>">
											<i class="fa fa-trash"></i> <?php echo e(trans('general.delete')); ?>

										</button>		
									</td>
								</tr>					
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>				
						</tbody>
					</table>	
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-8 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">					
				<h4 class="m-t-0 m-b-15"><b><?php echo e(trans('general.choose')); ?> <?php echo e(trans('settings.language')); ?></b></h4>
				<?php echo e(Form::open(array('route' => 'language.defaultLanguage', 'method' => 'post'))); ?>	
					<div class="form-group">
						<select name="language" class="form-control required solsoSelect2">				
							<?php if(isset($cl->name)): ?>
								<option value="<?php echo e($cl->id); ?>" selected> <?php echo e($cl->name); ?> </option>
								<option value=""><?php echo e(trans('general.choose')); ?></option>
							<?php else: ?>
								<option value="" selected><?php echo e(trans('general.choose')); ?></option>
							<?php endif; ?>							
							<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v->id); ?>"> <?php echo e($v->name); ?> </option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		
						</select>
					</div>
					<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> <?php echo e(trans('general.save')); ?> <?php echo e(trans('settings.language')); ?></button>	
				<?php echo e(Form::close()); ?>	
			</div>
			<!-- end col-4 -->
		</div>
		<!-- end row -->
	</div>
	<div class="modal fade stick-up" id="addlanguage" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
					<h5>Add Language</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<?php echo e(Form::open(array('url' => 'language/store', 'role' => 'form', 'class' => 'solsoForm'))); ?>		
							<div class="col-md-12 col-lg-12">
								<div class="form-group">
									<label for="name"><?php echo e(trans('limitless.name')); ?></label>
									<input type="text" name="name" class="form-control required" autocomplete="off" required="">
								</div>		
							</div>
							<div class="clearfix"></div>						
							<div class="col-md-12 col-lg-12">
								<div class="form-group">
									<label for="short_name"><?php echo e(trans('limitless.short_name')); ?></label>
									<input type="text" name="short_name" class="form-control required" autocomplete="off" required="">
								</div>		
							</div>
							<div class="clearfix"></div>						
							<div class="form-group col-md-12">
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?php echo e(trans('limitless.save')); ?></button>	
							</div>						
						<?php echo e(Form::close()); ?>	               
					</div>		
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="solsoDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"><?php echo e(trans('limitless.delete_dialog')); ?></h4>
				</div>
				<div class="modal-body">
						<p><?php echo e(trans('limitless.procedure_is_irreversible')); ?></p>
						<p><?php echo e(trans('limitless.want_to_proceed')); ?><p>
				</div>
				<div class="modal-footer">				
					<?php echo Form::open(['route' => ['language.destroy', 1],'method'=>'DELETE']); ?>

						<?php echo e(Form::hidden('_method', 'DELETE')); ?>

						<button type="button" class="btn btn-info" data-dismiss="modal"><?php echo e(trans('limitless.no')); ?></button>
						<button type="submit" class="btn btn-danger pull-right"><?php echo e(trans('limitless.yes')); ?></button>						
					<?php echo e(Form::close()); ?>		
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script type="text/javascript">
		$(document).ready(function() {
	    	$('#category-form').DataTable();
		} );
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/language/index.blade.php ENDPATH**/ ?>