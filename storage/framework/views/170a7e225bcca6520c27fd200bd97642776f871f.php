<?php $__env->startSection('title','Applications Billing'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('wingu.dashboard'); ?>">Settings</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('settings.business.index'); ?>"> Applications</a></li>
         <li class="breadcrumb-item active">Billing</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-usd-circle"></i> Applications Billing</h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="container">
         <div class="row justify-content-md-center">
            <div class="col-8">
               <div class="card">
                  <div class="card-body"> 
                     <h4>
                        <b>Application:</b> <?php echo $module->name; ?><br>
                        <?php if($location->countryName == 'Kenya'): ?>
                           <b>Price:</b> ksh<?php echo number_format($module->module_price * 100); ?><br>
                        <?php else: ?> 
                           <b>Price:</b> $<?php echo $module->module_price; ?><br>
                        <?php endif; ?>
                        <b>Duration:</b> <?php echo $durations; ?> 
                     </h4> 
                     <form action="https://payments.ipayafrica.com/v3/ke">
                        <input name="hsh" type="hidden" value="<?php echo Wingu::ipay($module->business_module_id); ?>">  
                        <input type="hidden" name="live" value="1" class="form-control">
                        <input type="hidden" name="oid" value="<?php echo $module->business_module_id; ?>" class="form-control">
                        <input type="hidden" name="inv" value="<?php echo Wingu::business()->businessID; ?>" class="form-control">
                        <input type="hidden" name="tel" value="0700000000" class="form-control">
                        <input type="hidden" name="eml" value="<?php echo Wingu::business()->primary_email; ?>" class="form-control">
                        <input type="hidden" name="vid" value="treeb" class="form-control">
                        <?php if($location->countryName == 'Kenya'): ?>
                           <input type="hidden" name="curr" value="KES" class="form-control">
                           <input type="hidden" name="ttl" value="<?php echo $module->module_price * 100; ?>" class="form-control">
                           <input type="hidden" name="mpesa" value="1" class="form-control">
                           <input type="hidden" name="p3" value="KES" class="form-control">
                        <?php else: ?> 
                           <input type="hidden" name="curr" value="USD" class="form-control">
                           <input type="hidden" name="ttl" value="<?php echo $module->module_price; ?>" class="form-control">
                           <input type="hidden" name="mpesa" value="0" class="form-control">
                           <input type="hidden" name="p3" value="USD" class="form-control">
                        <?php endif; ?>                        
                        <input type="hidden" name="p1" value="Webpayment" class="form-control">
                        <input type="hidden" name="p2" value="<?php echo Auth::user()->businessID; ?>" class="form-control">
                        
                        <input type="hidden" name="p4" value="" class="form-control">
                        <input type="hidden" name="cbk" value="<?php echo route('wingu.application.payment'); ?>" class="form-control">
                        <input type="hidden" name="cst" value="1" class="form-control">
                        <input type="hidden" name="crl" value="0" class="form-control">
                        <center>
                           <button class="btn btn-block btn-success submit" type="submit">Make Payment</button>
                        </center>
                     </form>
                  </div>
               </div>
            </div>
         </div>   
      </div>    
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/billing/payment.blade.php ENDPATH**/ ?>