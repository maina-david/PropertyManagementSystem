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
			<div class="col-md-12 col-lg-12">
				<h1><i class="fa fa-plus"></i> <?php echo e(trans('limitless.translate_language')); ?></h1>
				<h3><b>Language :</b> <?php echo $name; ?></h3>
			</div>		
			
			<div class="col-md-12 col-lg-12">
				<div class="panel panel-transparent">
					<div class="panel-heading">
						<button class="btn btn-primary pull-right" data-target="#addlanguage" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add <?php echo e(trans('limitless.languages')); ?></button>
						
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">
						<?php echo e(Form::open(array('url' => 'translate/store', 'method'=>'POST', 'role' => 'form'))); ?>

						<div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
							<div>
								<table id="category-form" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th><?php echo e(trans('limitless.original_language')); ?></th>
											<th><?php echo e(trans('limitless.translate_language')); ?></th>
										</tr>
									</thead>									
									<tbody>
										<?php $__currentLoopData = $original; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>											
										<tr>
											<td width="50%">
												<p><b><?php echo e($v['original']); ?></b></p>
											</td>												
											<td>
												<input type="text" name="words[<?php echo e($k); ?>]" class="form-control required col-md-6" value="<?php echo e(isset($translated[$k]) ? $translated[$k] : $v['translated']); ?>" style="width:100%">
											</td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>	
									<tfoot>
										<tr>
											<td colspan="2">
												<input type="hidden" name="languageID" value="<?php echo e(Request::segment(2)); ?>" required="">
												<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?php echo e(trans('limitless.save')); ?></button>
											</td>
										</tr>
									</tfoot>									
								</table>
							</div>
						</div>
						<?php echo e(Form::close()); ?>

					</div>
				</div>
			</div>	
			
		</div> 
	</div>
	<?php echo $__env->make('Limitless.Models.Settings.Languages.add-language', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
		} );
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/language/translate.blade.php ENDPATH**/ ?>