<?php $__env->startSection('title','Branch Edit'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?> 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Organization</li>
         <li class="breadcrumb-item">Branches</li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-map-marked-alt"></i> Edit Branches</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header ">
                  Branch details
               </div>
               <div class="card-body">
                  <?php echo Form::model($edit, ['route' => ['hrm.branches.update',$edit->id], 'method'=>'post','class'=>'row']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Branch name</label>
                           <?php echo Form::text('branch_name',null,['class' => 'form-control','placeholder' => 'Enter branch name', 'required' => '' ]); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Country</label>
                           <?php echo Form::select('countryID',$country,null,['class' => 'form-control multiselect', 'required' => '']); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">City</label>
                           <?php echo Form::text('city',null,['class' => 'form-control','placeholder' => 'Enter city', 'required' => '']); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Branch Address</label>
                           <?php echo Form::text('address',null,['class' => 'form-control','placeholder' => 'Enter address']); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Branch phone number</label>
                           <?php echo Form::text('phone_number',null,['class' => 'form-control','placeholder' => 'Enter phone number']); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Branch email</label>
                           <?php echo Form::email('email',null,['class' => 'form-control','placeholder' => 'Enter email']); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="">Is this the main branch ?</label>
                           <?php echo Form::select('main_branch',['No' => 'No','Yes' => 'Yes'],null,['class' => 'form-control']); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <button type="submit" class="float-right btn btn-pink submit"><i class="fas fa-save"></i> update Branch</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none float-right" alt="" width="15%">
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo url('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/organization/branches/edit.blade.php ENDPATH**/ ?>