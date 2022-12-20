<?php $__currentLoopData = $aFolder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oFolder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <?php
      $aMessage = $oFolder->messages()->all()->get();   
   ?>
   <?php $__currentLoopData = $aMessage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oMessage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php echo $oMessage->getSubject(); ?>

   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/mail/inbox.blade.php ENDPATH**/ ?>