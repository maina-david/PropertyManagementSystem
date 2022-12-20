<?php $__env->startSection('title','Language'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-menu'); ?>
	<?php echo $__env->make('Limitless.Settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="content sm-gutter"> 
		<div class="container-fluid padding-25 sm-padding-10"> 
			<?php echo $__env->make('partials._errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col-md-6 col-lg-6">
				<h3>Choose <?php echo e(trans('limitless.default_language')); ?></h3>	
				<?php echo e(Form::open(array('url' => 'setting/defaultLanguage', 'role' => 'form', 'class' => 'solsoForm'))); ?>	
				<div class="form-group">
					<select name="language" class="form-control required solsoSelect2">				
						<?php if(isset($cl->name)): ?>
							<option value="<?php echo e($cl->id); ?>" selected> <?php echo e($cl->name); ?> </option>
							<option value=""><?php echo e(trans('limitless.choose')); ?></option>
						<?php else: ?>
							<option value="" selected><?php echo e(trans('limitless.choose')); ?></option>
						<?php endif; ?>							
						<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($v->id); ?>"> <?php echo e($v->name); ?> </option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		
					</select>
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo e(trans('general.save')); ?></button>	
				<?php echo e(Form::close()); ?>	
			</div>
			<div class="col-md-6 col-lg-6">
				<div class="container-fluid container-fixed-lg bg-white"> 
					<div class="panel panel-transparent">
						<div class="panel-heading">
							<div class="panel-title">Edit <?php echo e(trans('general.language')); ?></div>							
						</div>
						<div class="panel-body">
							<?php echo $__env->make('partials._errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
								<div>
									<?php echo Form::model($edit, ['route' => ['language.update',$edit->id], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']); ?>

									<?php echo csrf_field(); ?>

										<div class="form-group form-group-default col-md-12">
											<?php echo Form::label('Language Name', 'name', array('class'=>'control-label')); ?>

											<?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Language Name', 'required' =>'' )); ?>

										</div><br><br>
										<div class="form-group form-group-default col-md-12">
											<?php echo Form::label('short', 'Language Code', array('class'=>'control-label')); ?>

											<?php echo Form::text('short', null, array('class' => 'form-control', 'placeholder' => 'Language Code', 'required' =>'' )); ?>

										</div><br><br>
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo e(trans('general.save')); ?> Language </button>	
									<?php echo e(Form::close()); ?>	
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>	
		</div> 
	</div>
	<?php echo $__env->make('Limitless.Models.Settings.Languages.add-language', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/language/edit.blade.php ENDPATH**/ ?>