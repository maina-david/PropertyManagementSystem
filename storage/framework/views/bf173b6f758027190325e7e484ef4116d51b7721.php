<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Credit Notes <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
			<li class="breadcrumb-item"><a href="j<?php echo route('property.creditnote.index',$property->id); ?>">Credit Notes</a></li>
			<li class="breadcrumb-item active"><a href="<?php echo route('property.creditnote.index',$property->id); ?>">Index</a></li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | Credit Notes </h1>
	   <div class="row">
	      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	      <div class="col-md-12">
	         <?php echo Form::model($settings, ['route' => ['property.creditnote.settings.update',$settings->id], 'method'=>'post']); ?>

	            <div class="panel panel-default">
	               <div class="panel-heading">
	                  Credit Note Settings
	               </div>
	               <div class="panel-body">
	                  <div class="row row-space-10 m-b-20">
	                     <div class="col-md-4">
	                        <div class="form-group form-group-default required">
	                           <?php echo Form::label('Invoice number', 'Credit Note number', array('class'=>'control-label text-danger')); ?>

	                           <?php echo Form::number('number', null, array('class' => 'form-control', 'placeholder' => 'Enter Invoice number', 'required' => '')); ?>

	                           <input type="hidden" name="propertyID" value="<?php echo $property->id; ?>">
	                        </div>
	                     </div>
	                     <div class="col-md-4">
	                        <div class="form-group form-group-default required ">
	                           <?php echo Form::label('Invoice prefix', 'Credit Note prefix', array('class'=>'control-label text-danger')); ?>

	                           <?php echo Form::text('prefix', null, array('class' => 'form-control', 'placeholder' => 'Enter invoice prefix')); ?>

	                        </div>
	                     </div>
	                     <div class="col-md-12">
	                        <div class="form-group">
	                           <h4 for="">Default Terms & Conditions</h4>
	                           <?php echo Form::textarea('default_terms_conditions', null, array('class' => 'form-control my-editor')); ?>

	                        </div>
	                     </div>
	                     <div class="col-md-12">
	                        <div class="form-group">
	                           <h4 for="">Default Credit Note Footer</h4>
	                           <?php echo Form::textarea('default_footer', null, array('class' => 'form-control my-editor')); ?>

	                        </div>
	                     </div>
	                     <div class="col-md-12">
	                        <div class="form-group">
	                           <h4 for="">Customer Notes</h4>
	                           <?php echo Form::textarea('default_customer_notes', null, array('class' => 'form-control my-editor')); ?>

	                        </div>
	                     </div>
	                     <div class="col-md-12">
	                        <div class="form-group">
	                           <center>
	                              <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
	                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
	                           </center>
	                        </div>
	                     </div>
	                  </div>
	               </div>
	            </div>
	         <?php echo Form::close(); ?>

	      </div>
	   </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/creditnote/settings.blade.php ENDPATH**/ ?>