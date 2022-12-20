<?php if(count($errors) > 0): ?>
	<div class="alert alert-danger no-border">
		<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
		<span class="text-semibold">Errors!</span><br>
		<ul>
			<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li><?php echo e($error); ?></li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
   </div>
<?php endif; ?>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/partials/_messages.blade.php ENDPATH**/ ?>