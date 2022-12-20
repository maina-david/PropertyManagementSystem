<?php $__env->startSection('title'); ?>Business Profile  <?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('wingu.dashboard'); ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('settings.business.index'); ?>"> Business Profile</a></li>
      <li class="breadcrumb-item active">Business Profile Settings</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-business-time"></i> Business Profile</h1>
   <!-- begin row -->
   <div class="row">  
      <div class="col-lg-4 col-xl-4">
         <div class="card-box text-center">
            <?php if($business->logo == ""): ?>
               <img src="https://ui-avatars.com/api/?name=<?php echo $business->name; ?>&rounded=true&size=32" class="rounded-circle avatar-lg img-thumbnail" alt="<?php echo $business->name; ?>">
            <?php else: ?>
               <img src="<?php echo asset('businesses/'.$business->businessID .'/documents/images/'.$business->logo); ?>" class="avatar-lg img-thumbnail" alt="<?php echo $business->name; ?>">
            <?php endif; ?>
            <h4 class="mt-2 mb-2"><?php echo $business->name; ?></h4>
            <p class="text-muted">@ <?php echo $business->primary_email; ?></p>
            <a href="#" class="btn pink btn-xs waves-effect mb-2 waves-light">BusinessID : <?php echo $business->businessID; ?></a>
            <div class="text-left mt-3">
               <p class="text-muted mb-2 font-13">
                  <strong>Business Name :</strong> <span class="ml-2"><?php echo $business->name; ?></span>
               </p>
               <p class="text-muted mb-2 font-13">
                  <strong>Primary Phonenumber :</strong>
                  <span class="ml-2">
                     <?php if($business->country != "" ): ?>(+<?php echo Wingu::country($business->country)->phonecode; ?>)<?php endif; ?> <?php echo $business->primary_phonenumber; ?>

                  </span>
               </p>
               <p class="text-muted mb-2 font-13">
                  <strong>Primary Email :</strong>
                  <span class="ml-2 "><?php echo $business->primary_email; ?></span>
               </p>
               <p class="text-muted mb-1 font-13">
                  <strong>Location :</strong>
                  <span class="ml-2"><?php if($business->country != "" ): ?><?php echo Wingu::country($business->country)->name; ?><?php endif; ?></span>
               </p>
               <p class="text-muted mb-1 font-13">
                  <strong>Website :</strong> <?php echo $business->website; ?></span>
               </p>
            </div>
         </div>
         <!-- end card-box -->
         <div class="card-box">
            <h4 class="header-title mb-3">Staff Members</h4>
            <div class="inbox-widget slimscroll" style="max-height:410px;">
               <?php $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="inbox-item">
                     <div class="inbox-item-img">
                        <?php if($staff->avatar == ""): ?>
                           <img src="https://ui-avatars.com/api/?name=<?php echo $staff->name; ?>&rounded=true&size=70" class="rounded-circle" alt="">
                        <?php else: ?>
                           <img src="<?php echo asset('businesses/'.$business->businessID.'/staff/'.$staff->email.'/images/'.$staff->avatar); ?>" class="rounded-circle" alt="">
                        <?php endif; ?>
                     </div>
                     <p class="inbox-item-author"><?php echo $staff->name; ?></p>
                     <p class="inbox-item-text"><?php echo $staff->email; ?></p>
                     <p class="inbox-item-date">
                        
                     </p>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div> <!-- end card-box-->
         <!-- end card-box-->
      </div>
      <div class="col-lg-8 col-xl-8">
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="card-box">
            <ul class="nav nav-pills navtab-bg nav-justified">
               <li class="nav-item">
                  <a href="<?php echo route('settings.business.index'); ?>" class="nav-link <?php echo e(Nav::isRoute('settings.business.index')); ?>">
                     <i class="fas fa-hourglass-half"></i> Recent Activities
                  </a>
               </li>
               <li class="nav-item">
                  <a href="<?php echo route('settings.business.edit'); ?>" class="nav-link <?php echo e(Nav::isRoute('settings.business.edit')); ?>">
                     <i class="fas fa-business-time"></i> Business Profile
                  </a>
               </li>
            </ul>
            <div class="tab-content">
               <?php if(Request::is('settings/businessprofile') || Request::is('settings')): ?>
                  <div class="">
                     <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase mr-1"></i> Experience</h5>
                     <ul class="list-unstyled timeline-sm" style="overflow-y:scroll; overflow-x:hidden; height:700px;">
                        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <li class="timeline-sm-item">
                              <h5 class="mt-0 mb-1"><?php echo date('jS \of F, Y', strtotime($log->created_at)); ?> @ <?php echo date('h:i:s A', strtotime($log->created_at)); ?></h5>
                              <p class="font-weight-bold"><?php echo $log->section; ?> | <?php echo $log->type; ?></p>
                              <p class="mt-2"><?php echo $log->activity; ?></p>
                           </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </ul>
                  </div>
               <?php endif; ?>
               
               <!-- end tab-pane -->
               <?php if(Request::is('settings/businessprofile/edit')): ?>
                  <div class="">
                     <?php echo Form::model($business, ['route' => ['settings.business.update',$business->id], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

                        <?php echo csrf_field(); ?>
                        <div class="row mb-2">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label  class="text-danger">Business Name <span class="text-danger">*</span></label>
                                 <?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Business Name', 'required' =>'' )); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="lastname">Industry</label>
                                 <?php echo e(Form::select('industry', $industry, null, ['class' => 'form-control multiselect'])); ?>

                              </div>
                           </div> <!-- end col -->
                        </div>
                        <div class="row mb-2">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Logo <span class="text-danger">*</span></label><br>
                                 <input type="file" name="logo" accept="image/*" id="thumbnail"/>
                              </div>
                           </div>
                           <div class="col-md-8">
                              <div class="form-group">
                                 <p>This logo will appear on the documents (estimates, invoices, etc.) that are created.<br>
                                    <small>Preferred Image Size: 240px x 240px @ 72 DPI Maximum size of 1MB.</small>
                                 </p>
                                 <?php if($business->logo != ""): ?>
                                    <a href="<?php echo route('settings.business.delete.logo', Auth::user()->businessID); ?>" class="btn-link">Remove logo</a>
                                 <?php endif; ?>
                              </div>
                           </div> <!-- end col -->
                        </div>
                        <div class="row mb-2">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Company ID</label>
                                 <?php echo Form::text('businessID', null, array('class' => 'form-control', 'placeholder' => '', 'readonly' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Company Size</label>
                                 <?php echo Form::select('company_size', ['' => 'Choose size', '1' => '1 - 3', '2' => '4 - 10', '3' => '11 - 50', '4' => '51 - 100'], null, array('class' => 'form-control')); ?>

                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label  class="text-danger">Primary Phone number <span class="text-danger">*</span></label>
                                 <?php echo Form::text('primary_phonenumber', null, array('class' => 'form-control', 'placeholder' => 'Priamry Contacts','required'=>'')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Primary Email</label>
                                 <?php echo Form::text('primary_email', null, array('class' => 'form-control', 'placeholder' => 'email', 'readonly' => '')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Website</label>
                                 <?php echo Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')); ?>

                              </div>
                           </div>
                        </div>
                        <hr>
                        <!-- end row -->
                        <div class="row mb-2">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Street</label>
                                 <?php echo Form::text('street', null, array('class' => 'form-control', 'placeholder' => 'Street')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>City</label>
                                 <?php echo Form::text('city', null, array('class' => 'form-control', 'placeholder' => 'City')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>State / Province</label>
                                 <?php echo Form::text('state_province', null, array('class' => 'form-control', 'placeholder' => 'State / Province')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Postal Code</label>
                                 <?php echo Form::text('zip_code', null, array('class' => 'form-control', 'placeholder' => 'Postal Code')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Country</label>
                                 <?php echo e(Form::select('country', $country, null, ['class' => 'form-control multiselect'])); ?>

                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="text-danger">Default Currency <span class="text-danger">*</span></label>
                                 <select class="form-control multiselect" name="base_currency" required>
                                    <?php if($business->base_currency != ""): ?>
                                       <option value="<?php echo $business->base_currency; ?>"><?php echo Finance::currency($business->base_currency)->currency_name; ?> - <?php echo Finance::currency($business->base_currency)->code; ?></option>
                                    <?php else: ?>
                                       <option value="">Choose currency</option>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo $cur->id; ?>"><?php echo $cur->currency_name; ?> - <?php echo $cur->code; ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <!-- end row -->
                        <div class="text-right">
                           <button type="submit" class="btn pink waves-effect waves-light mt-2 submit"><i class="fas fa-save"></i> Update Profile</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                        </div>
                     <?php echo Form::close(); ?>

                  </div>
               <?php endif; ?>
               <!-- end settings content-->
            </div>
            <!-- end tab-content -->
         </div>
         <!-- end card-box-->
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/business/index.blade.php ENDPATH**/ ?>