<ul class="nav">
   <li class="nav-profile">
      <a href="javascript:;" data-toggle="nav-profile">
         <div class="cover with-shadow"></div>
         <div class="image">
            <img src="https://ui-avatars.com/api/?name=<?php echo Auth::user()->name; ?>&rounded=true&size=70" alt="<?php echo Auth::user()->name; ?>">
         </div>
         <div class="info">
            <?php echo $module; ?>

         </div>
      </a>
   </li>
</ul>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/partials/_nav-profile.blade.php ENDPATH**/ ?>