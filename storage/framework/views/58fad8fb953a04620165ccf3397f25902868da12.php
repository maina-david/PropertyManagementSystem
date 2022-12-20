<?php $__env->startSection('title','Invoice Settings'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content"> 
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Invoice</li>
         <li class="breadcrumb-item active">General</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-tools"></i>  Invoice Settings</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('finance.settings.invoice')); ?>" href="<?php echo route('finance.settings.invoice'); ?>"><i class="fas fa-sort-numeric-up"></i> Generated Numbers</a>
                     </li>
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isResource('defaults')); ?>" href="<?php echo route('finance.settings.invoice.defaults',$settings->id); ?>">
                           <i class="fas fa-file-invoice-dollar"></i> Defaults
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isResource('workflow')); ?>" href="<?php echo route('finance.settings.invoice.workflow',$settings->id); ?>">
                           <i class="fas fa-toolbox"></i> Workflow Settings
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isResource('payments')); ?>" href="<?php echo route('finance.settings.invoice.payments',$settings->id); ?>">
                           <i class="fas fa-sliders-h"></i> Payments Settings
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isResource('tabs')); ?>" href="<?php echo route('finance.settings.invoice.tabs',$settings->id); ?>">
                           <i class="fas fa-table"></i> Invoice Tabs
                        </a>
                     </li>
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
                     <?php if(Request::is('finance/settings/invoice')): ?>
                        <div class="">
                           <?php echo Form::model($settings, ['route' => ['finance.settings.invoice.generated.update',$settings->id], 'method'=>'post',]); ?>

                              <?php echo csrf_field(); ?>

                              <div class="form-group">
                                 <label for="">Invoice Number</label>
                                 <?php echo Form::number('number', null, array('class' => 'form-control', 'value' => '000')); ?>

                              </div>
                              <div class="form-group">
                                 <label for="">Invoice Prefix</label>
                                 <?php echo Form::text('prefix', null, array('class' => 'form-control')); ?>

                              </div>
                              <p class="font-weight-bold"><i class="fas fa-info-circle text-primary"></i> Specify a prefix to dynamically set the invoice number. The invoice number will have 2 extra zeros i.e 002.</p>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           <?php echo Form::close(); ?>

                        </div>
                     <?php endif; ?>
                     <?php if(Request::is('finance/settings/invoice/'.$settings->id.'/defaults')): ?>
                        <div class="">
                           <?php echo Form::model($settings, ['route' => ['finance.settings.invoice.defaults.update',$settings->id], 'method'=>'post',]); ?>

                              <?php echo csrf_field(); ?>

                              <div class="form-group">
                                 <h4 for="">Default Terms & Conditions</h4>
                                 <?php echo Form::textarea('default_terms_conditions', null, array('class' => 'form-control ckeditor')); ?>

                              </div>
                              <div class="form-group">
                                 <h4 for="">Default Invoice Footer</h4>
                                 <?php echo Form::textarea('default_invoice_footer', null, array('class' => 'form-control ckeditor')); ?>

                              </div>
                              <div class="form-group">
                                 <h4 for="">Customer Notes</h4>
                                 <?php echo Form::textarea('default_customer_notes', null, array('class' => 'form-control ckeditor')); ?>

                              </div>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           <?php echo Form::close(); ?>

                        </div>
                     <?php endif; ?>
                     <?php if(Request::is('finance/settings/invoice/'.$settings->id.'/workflow')): ?>
                        <div class="">
                           <?php echo Form::model($settings, ['route' => ['finance.settings.invoice.workflow.update',$settings->id], 'method'=>'post',]); ?>

                              <?php echo csrf_field(); ?>

                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="editing_of_Sent" class="custom-control-input" id="customCheckSent"  <?php if($settings->editing_of_Sent == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="custom-control-label" for="customCheckSent">Allow editing of Sent Invoice?<label>
                              </div><br>
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="automatically_email_recurring" class="custom-control-input" id="customCheckAuto"  <?php if($settings->automatically_email_recurring == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="custom-control-label" for="customCheckAuto">Enable Auto Email<label>
                              </div>
                              <p>Automatically email recurring invoices when they are created.</p>
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="auto_archive" class="custom-control-input" id="customCheckArchive"  <?php if($settings->auto_archive == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="custom-control-label" for="customCheckArchive">Enable Auto Archive<label>
                              </div>
                              <p>Automatically archive invoices when they are paid.</p>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           <?php echo Form::close(); ?>

                        </div>
                     <?php endif; ?>
                     <?php if(Request::is('finance/settings/invoice/'.$settings->id.'/payments')): ?>
                        <div class="">
                           <?php echo Form::model($settings, ['route' => ['finance.settings.invoice.payments.update',$settings->id], 'method'=>'post',]); ?>

                              <?php echo csrf_field(); ?>

                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="notify_on_payment" class="custom-control-input" id="customChecknotified"  <?php if($settings->notify_on_payment == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="custom-control-label" for="customChecknotified">Get notified when customers pay online<label>
                              </div><br>
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="automate_thank_you_note" class="custom-control-input" id="customCheckreceipt"  <?php if($settings->automate_thank_you_note == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="custom-control-label" for="customCheckreceipt">Do you want to include the payment receipt along with the Thank You Note?<label>
                              </div><br>
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="auto_thank_you_payment_received" class="custom-control-input" id="customCheckthank"  <?php if($settings->auto_thank_you_payment_received == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="custom-control-label" for="customCheckthank">Automate thank you note to customer on receipt of online payment.<label>
                              </div>
                              <div class="form-group mt-5">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i>  Update Information</button>
                                    <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           <?php echo Form::close(); ?>

                        </div>
                     <?php endif; ?>
                     <?php if(Request::is('finance/settings/invoice/'.$settings->id.'/tabs')): ?>
                        <div class="">
                           <?php echo Form::model($settings, ['route' => ['finance.settings.invoice.tabs.update',$settings->id], 'method'=>'post',]); ?>

                              <?php echo csrf_field(); ?>

                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" name="show_discount_tab" id="customCheckDiscounttab" value="Yes" <?php if($settings->show_discount_tab == 'Yes'): ?> Checked <?php endif; ?>>
                                 <label class="custom-control-label" for="customCheckDiscounttab">Show Discount tab on invoice</label>
                              </div>
                              <br>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="show_tax_tab" class="custom-control-input" id="customCheckTaxtab"  <?php if($settings->show_tax_tab == 'Yes'): ?> Checked <?php endif; ?>/>
                                 <label class="custom-control-label" for="customCheckTaxtab">Show Tax tab on invoice<label>
                              </div>
                              <div class="form-group mt-5">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
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
   <script src="<?php echo asset('/assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/invoices/settings/index.blade.php ENDPATH**/ ?>