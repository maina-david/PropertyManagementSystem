<?php $__env->startSection('title','Purchase order Settings'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Purchase order</li>
         <li class="breadcrumb-item active">General</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i>  Purchase Order Settings</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('finance.settings.lpo')); ?>" href="<?php echo route('finance.settings.lpo'); ?>"><i class="fas fa-sort-numeric-up"></i> Generated Numbers</a>
                     </li>
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isResource('defaults')); ?>" href="<?php echo route('finance.settings.lpo.defaults',$settings->id); ?>">
                           <i class="fas fa-file-invoice-dollar"></i> Defaults
                        </a>
                     </li>
                     
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
                     <?php if(Request::is('finance/settings/lpo')): ?>
                        <div class="">
                           <?php echo Form::model($settings, ['route' => ['finance.settings.lpo.generated.update',$settings->id], 'method'=>'post',]); ?>

                              <?php echo csrf_field(); ?>

                              <div class="form-group">
                                 <label for="">Purchase Order Number</label>
                                 <?php echo Form::number('number', null, array('class' => 'form-control', 'value' => '000')); ?>

                              </div>
                              <div class="form-group">
                                 <label for="">Purchase Order Prefix</label>
                                 <?php echo Form::text('prefix', null, array('class' => 'form-control')); ?>

                              </div>
                              <p class="font-weight-bold"><i class="fas fa-info-circle text-primary"></i> Specify a prefix to dynamically set the Purchase order number</p>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                                 </center>
                              </div>
                           <?php echo Form::close(); ?>

                        </div>
                     <?php endif; ?>
                     <?php if(Request::is('finance/settings/lpo/'.$settings->id.'/defaults')): ?>
                        <div class="">
                           <?php echo Form::model($settings, ['route' => ['finance.settings.lpo.defaults.update',$settings->id], 'method'=>'post',]); ?>

                              <?php echo csrf_field(); ?>

                              <div class="form-group">
                                 <h4 for="">Default Terms & Conditions</h4>
                                 <?php echo Form::textarea('default_terms_conditions', null, array('class' => 'form-control ckeditor')); ?>

                              </div>
                              <div class="form-group">
                                 <h4 for="">Default Purchase order Footer</h4>
                                 <?php echo Form::textarea('default_footer', null, array('class' => 'form-control ckeditor')); ?>

                              </div>
                              <div class="form-group">
                                 <h4 for="">Customer Notes</h4>
                                 <?php echo Form::textarea('default_customer_notes', null, array('class' => 'form-control ckeditor')); ?>

                              </div>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                                 </center>
                              </div>
                           <?php echo Form::close(); ?>

                        </div>
                     <?php endif; ?>
                     <?php if(Request::is('finance/settings/lpo/'.$settings->id.'/tabs')): ?>
                        <div class="">
                           <?php echo Form::model($settings, ['route' => ['finance.settings.lpo.tabs.update',$settings->id], 'method'=>'post',]); ?>

                              <?php echo csrf_field(); ?>

                              <div class="form-check">
                                 <input type="checkbox" value="Yes" name="show_discount_tab" class="form-check-input" id="defaultCheckbox" <?php if($settings->show_discount_tab == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="form-check-label" for="defaultCheckbox">Show Discount tab on Purchase order<label>
                              </div><br>
                              <div class="form-check">
                                 <input type="checkbox" value="Yes" name="show_tax_tab" class="form-check-input" id="defaultCheckbox" <?php if($settings->show_tax_tab == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="form-check-label" for="defaultCheckbox">Show Tax tab on Purchase order<label>
                              </div>
                              <div class="form-group mt-5">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                                 </center>
                              </div>
                           <?php echo Form::close(); ?>

                        </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/purchaseorders/settings/index.blade.php ENDPATH**/ ?>