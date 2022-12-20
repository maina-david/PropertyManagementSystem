<?php $__env->startSection('title'); ?> Plans <?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?><?php echo route('home.page'); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      td+td{
         text-align: center;
      }
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div class="section-container head-section bg-white">
      <!-- BEGIN container -->
      <div class="container text-center mb-5">
         <center><h2><i class="fal fa-sim-card fa-5x"></i></h2></center>
         <h2 class="mt-5 head-title">Safaricom Lipa na Mpesa.</h2>
      </div>
      <!-- END container -->
   </div>
   <div class="section-container" style="min-height: 300px">
      <div class="container">
         <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
               <?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <div class="card mb-4">
                  <div class="card-header"><b>Lipa na Mpesa Instruction</b></div>
                  <div class="card-body">
                     <ul>
                        <li>Go to M-PESA on your phone</li>
                        <li>Select Pay Bill option</li>
                        <li>Enter Business number <strong>522522</strong></li>
                        <li>Enter Account number <strong>1239891571</strong></li>
                        <li>Enter the Amount <strong>ksh <?php echo number_format(Limitless::get_plan($id)->price); ?></strong></li>
                        <li>Enter your M-PESA PIN and Send</li>
                        <li>You will receive a confirmation SMS from <strong>M-PESA</strong></li>
                     </ul>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header"><b>STK Push</b></div>
                  <div class="card-body">
                     <form action="<?php echo url('/'); ?>/api/underground/v1/limitlessERP/stk/push" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                           <label for="">Enter Your Phone number</label>
                           <?php echo Form::number('phone_number',null,['class'=>'form-control','placeholder' => 'e.x 2547000000','required'=>'']); ?>

                           <input type="hidden" name="amount" value="<?php echo Limitless::get_plan($id)->price; ?>" required>
                        </div>
                        <div class="form-group">
                           <button class="btn btn-primary">Submit</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="col-md-2"></div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/wingu/hold/safaricom.blade.php ENDPATH**/ ?>