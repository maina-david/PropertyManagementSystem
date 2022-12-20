<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
   <!--<![endif]-->
   <?php $__env->startSection('title','Login . Verify Your Email Address'); ?>
   <?php echo $__env->make('partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <style>	
      .signup {
         margin: 10%;
      }
      a {
         color: #ef5279;
         transition: color .1s ease-in-out;
      }

      @media(max-width: 854px){
         img{
            width:100%;
         }
      }
   </style>

   <body class="pace-top bg-white">
      <!-- begin #page-loader -->
      
      <!-- end #page-loader -->
      
      <!-- begin #page-container -->
      <div class="container">
         <div class="row justify-content-center mt-5">
            <div class="col-md-8 mt-5">
               <div class="card">
                  <div class="card-header"><?php echo e(__('Verify Your Email Address')); ?></div>

                  <div class="card-body">
                     <?php if(session('resent')): ?>
                        <div class="alert alert-success" role="alert">
                              <?php echo e(__('A fresh verification link has been sent to your email address.')); ?>

                        </div>
                     <?php endif; ?>
                     <form method="POST" action="<?php echo e(route('verification.resend')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo e(__('Before proceeding, please check your email for a verification link.')); ?>

                        <?php echo e(__('If you did not receive the email')); ?><br><br>
                        <button type="submit" class="btn btn-primary"><?php echo e(__('click here to request another')); ?></button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>

         <!-- end page container -->
      <?php echo $__env->make('partials._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   </body>
</html>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/auth/hold.blade.php ENDPATH**/ ?>