<div class="row">
   <!-- begin timeline -->
	<ul class="timeline">
		<li>
			<!-- begin timeline-icon -->
			<div class="timeline-icon">
				<a href="javascript:;">&nbsp;</a>
			</div>
			<!-- end timeline-icon -->
			<!-- begin timeline-body -->
			<div class="timeline-body">
				<form action="<?php echo route('finance.contact.comments.post'); ?>" method="post">
					<?php echo csrf_field(); ?>
					<input type="hidden" value="<?php echo $clientID; ?>" name="clientID">
					<div class="form-group mb-5 mt-4">
						<textarea name="comment" rows="8" cols="80" class="form-control"></textarea>
						(For Internal Use)
						<button type="submit" class="btn btn-success float-right mt-3">Add Comment</button>
					</div>
				</form>
			</div>
			<!-- begin timeline-body -->
		</li>
		<?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li>
				<!-- begin timeline-time -->
				<div class="timeline-time">
					<span class="date"><?php echo date('d F, Y', strtotime($comment->created_at)); ?></span>
					<span class="time"><?php echo date('h:i a', strtotime($comment->created_at)); ?></span>
				</div>
				<!-- end timeline-time -->
				<!-- begin timeline-icon -->
				<div class="timeline-icon">
					<a href="javascript:;">&nbsp;</a>
				</div>
				<!-- end timeline-icon -->
				<!-- begin timeline-body -->
				<div class="timeline-body">
					<div class="timeline-content">						
						<p><?php echo $comment->comment; ?></p>
					</div>
					<div class="timeline-footer">
						<a href="<?php echo route('finance.contact.comments.delete', $comment->id); ?>" class="m-r-15 text-inverse-lighter"><i class="fas fa-trash"></i> delete</a>
					</div>
				</div>
				<!-- end timeline-body -->
			</li>	
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
	</ul>
	<!-- end timeline -->
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/suppliers/comments.blade.php ENDPATH**/ ?>