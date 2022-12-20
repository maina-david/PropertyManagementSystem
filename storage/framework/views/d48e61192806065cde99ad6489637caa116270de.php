<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <link rel="stylesheet" href="<?php echo asset('assets/css/dashboard.css'); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div class="main">
      <div class="row mt-5">
         <div class="col-md-12 mb-5">
            <h1 class="text-center"><b>What would you like to manage ?</b></h1>
         </div>

         <!--- finance -->
         <?php if(Wingu::check_business_modules(1) == 1): ?>
            <?php if (app('laratrust')->isAbleTo('access-finance')) : ?>
               <?php if(Wingu::check_modules(1) == 1): ?>
                  <?php if(Wingu::modules(1)->status == 15): ?>
                     <div class="col-md-3 mb-3">
                        <div class="green-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 <?php
                                    $moduleInfo = Wingu::get_account_module_details(1);
                                 ?>
                                 <?php if($moduleInfo->version == 35): ?>
                                    <?php
                                       $today = date('Y-m-d');
                                       $timeLeft = Helper::date_difference($moduleInfo->end_date,$today);
                                    ?>
                                    <?php if($timeLeft > 0): ?>
                                       <center><span class="text-danger"><b>Free Trial <?php echo $timeLeft; ?> days left</b></span></center>
                                    <?php endif; ?>
                                 <?php endif; ?>
                                 <h2 class=""><?php echo Wingu::modules(1)->name; ?></h2>
                                 <p class="font-bold text-success"><?php echo Wingu::modules(1)->caption; ?></p>
                                 <div class="mb-2"><?php echo Wingu::modules(1)->icon; ?></div>
                                 <p class="small"><?php echo Wingu::modules(1)->introduction; ?></p>
                                 <a href="<?php echo route('finance.index'); ?>" class="btn btn-success btn-sm">
                                    <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php endif; ?>
               <?php endif; ?>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>

         <!--- human resource -->
         <?php if(Wingu::check_business_modules(2) == 1): ?>
            <?php if (app('laratrust')->isAbleTo('access-humanresource')) : ?>
               <?php if(Wingu::check_modules(2) == 1): ?>
                  <?php if(Wingu::modules(2)->status == 15): ?>
                     <div class="col-md-3 mb-3">
                        <div class="blue-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 <?php
                                    $moduleInfo = Wingu::get_account_module_details(2);
                                 ?>
                                 <?php if($moduleInfo->version == 35): ?>
                                    <?php
                                       $today = date('Y-m-d');
                                       $timeLeft = Helper::date_difference($moduleInfo->end_date,$today);
                                    ?>
                                    <?php if($timeLeft > 0): ?>
                                       <center><span class="text-danger"><b>Free Trial <?php echo $timeLeft; ?> days left</b></span></center>
                                    <?php endif; ?>
                                 <?php endif; ?>
                                 <h2 class=""><?php echo Wingu::modules(2)->name; ?></h2>
                                 <p class="font-bold text-info"><?php echo Wingu::modules(2)->caption; ?></p>
                                 <div class="mb-2"><?php echo Wingu::modules(2)->icon; ?></div>
                                 <p class="small"><?php echo Wingu::modules(2)->introduction; ?></p>
                                 <?php
                                    $property = Wingu::get_account_module_details(2);
                                 ?>
                                 <?php if($property->module_status == 15 && $property->payment_status == 1): ?>
                                    <a href="<?php echo route('hrm.dashboard'); ?>" class="btn btn btn-info btn-sm text-white">
                                       <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                                    </a>
                                 <?php else: ?>
                                    <a href="<?php echo route('settings.applications.billing',$property->id); ?>" class="btn btn-sm btn-pink">
                                       <i class="fal fa-usd-circle"></i> Make Payment
                                    </a>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php endif; ?>
               <?php endif; ?>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>

         <!-- crm -->
         <?php if(Wingu::check_business_modules(13) == 1): ?>
            <?php if (app('laratrust')->isAbleTo('crm-access')) : ?>
               <?php if(Wingu::check_modules(13) == 1): ?>
                  <?php if(Wingu::modules(13)->status == 15): ?>
                     <div class="col-md-3 mb-3">
                        <div class="black-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 <?php
                                    $moduleInfo = Wingu::get_account_module_details(13);
                                 ?>
                                 <?php if($moduleInfo->version == 35): ?>
                                    <?php
                                       $today = date('Y-m-d');
                                       $timeLeft = Helper::date_difference($moduleInfo->end_date,$today);
                                    ?>
                                    <?php if($timeLeft > 0): ?>
                                       <center><span class="text-danger"><b>Free Trial <?php echo $timeLeft; ?> days left</b></span></center>
                                    <?php endif; ?>
                                 <?php endif; ?>
                                 <h2 class="m-b-xs"><?php echo Wingu::modules(13)->name; ?></h2>
                                 <p class="font-bold"><?php echo Wingu::modules(13)->caption; ?></p>
                                 <div class="mb-2">
                                    <?php echo Wingu::modules(13)->icon; ?>

                                 </div>
                                 <p class="small"><?php echo Wingu::modules(13)->introduction; ?></p>
                                 <?php
                                    $property = Wingu::get_account_module_details(13);
                                 ?>
                                 <?php if($property->module_status == 15 && $property->payment_status == 1): ?>
                                    <a href="<?php echo route('crm.dashboard'); ?>" class="btn btn btn-black btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                                 <?php else: ?>
                                    <a href="<?php echo route('settings.applications.billing',$property->id); ?>" class="btn btn-sm btn-pink">
                                       <i class="fal fa-usd-circle"></i> Make Payment
                                    </a>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php endif; ?>
               <?php endif; ?>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>

         <!--- property management -->
         <?php if(Wingu::check_business_modules(15) == 1): ?>
            
               <?php if(Wingu::check_modules(15) == 1): ?>
                  <?php if(Wingu::modules(15)->status == 15): ?>
                  <?php
                     $property = Wingu::get_account_module_details(15);
                  ?>
                     <div class="col-md-3 mb-3">
                        <div class="gray-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 <?php if($property->version == 35): ?>
                                    <?php
                                       $today = date('Y-m-d');
                                       $timeLeft = Helper::date_difference($property->end_date,$today);
                                    ?>
                                    <?php if($timeLeft > 0): ?>
                                       <center><span class="text-danger"><b>Free Trial <?php echo $timeLeft; ?> days left</b></span></center>
                                    <?php endif; ?>
                                 <?php endif; ?>
                                 <h2 class="m-b-xs"><?php echo Wingu::modules(15)->name; ?></h2>
                                 <p class="font-bold text-gray"><?php echo Wingu::modules(15)->caption; ?></p>
                                 <div class="mb-2"><?php echo Wingu::modules(15)->icon; ?></div>
                                 <p class="small"><?php echo Wingu::modules(15)->introduction; ?></p>
                                 <?php if($property->module_status == 15 && $property->payment_status == 1): ?>
                                    <a href="<?php echo route('dashboard.property'); ?>" class="btn btn-gray btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                                 <?php else: ?>
                                    <a href="<?php echo route('settings.applications.billing',$property->id); ?>" class="btn btn-sm btn-pink">
                                       <i class="fal fa-usd-circle"></i> Make Payment
                                    </a>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php endif; ?>
               <?php endif; ?>
            
         <?php endif; ?>

         <!--- settings -->
         <?php if (app('laratrust')->hasRole('admin')) : ?>
            <div class="col-md-3">
               <div class="yellow-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="m-b-xs">Settings</h2>
                        <p class="font-bold text-yellow">All Configurations</p>
                        <div class="mb-2">
                           <i class="fal fa-tools fa-5x"></i>
                        </div>
                        <p class="small">
                           User roles,user management,payment integration,Telephony integration,business profile
                        </p>
                        <a href="<?php echo route('settings.index'); ?>" class="btn btn-yellow btn-sm">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; // app('laratrust')->hasRole ?>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/dashboard/dashboard.blade.php ENDPATH**/ ?>