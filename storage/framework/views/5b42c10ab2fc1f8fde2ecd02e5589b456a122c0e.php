
<div id="header" class="header navbar-default">
   <!-- begin navbar-header -->
   <div class="navbar-header">
      <a href="<?php echo route('wingu.dashboard'); ?>" class="navbar-brand">
         <img src="<?php echo asset('assets/img/logo-long.png'); ?>" alt="" style="width:80%">
      </a>
      <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
   </div>
   <!-- end navbar-header -->
   <!-- begin header-nav -->
   <ul class="navbar-nav navbar-right">
      
      

      
      <li>
         <?php if(Wingu::check_if_account_has_modules() == 0): ?>
            <a href="<?php echo route('application.setup'); ?>" class="">
               <span class="label" style="position: absolute;top: 15px;right: 5px;display: block;background: #f16490;line-height: 12px;font-weight: 600;color: #fff;padding: .3em .6em;border-radius: 1px;">Applications</span>
            </a>
         <?php else: ?>
            <a href="<?php echo route('application'); ?>" class="">
               <span class="label" style="position: absolute;top: 15px;right: 5px;display: block;background: #f16490;line-height: 12px;font-weight: 600;color: #fff;padding: .3em .6em;border-radius: 1px;">Applications</span>
            </a>
         <?php endif; ?>
      </li>

      <li class="dropdown">
         <a href="<?php echo route('wingu.dashboard'); ?>" class="dropdown-toggle f-s-14">
            <i class="fad fa-anchor"></i> Home
         </a>
         
      </li>
      <li class="dropdown">
         
         <ul class="dropdown-menu media-list dropdown-menu-right">
            
            
            
            
         </ul>
      </li>
      <li class="dropdown navbar-user">
         <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name=<?php echo Auth::user()->name; ?>&rounded=true&size=70" alt="<?php echo Auth::user()->name; ?>">
            <span class="d-none d-md-inline"><?php echo Auth::user()->name; ?></span> <b class="caret"></b>
         </a>
         <div class="dropdown-menu dropdown-menu-right">
            <a href="<?php echo route('settings.business.index'); ?>" class="dropdown-item">
               <i class="fal fa-building"></i>
               <b><?php echo Wingu::business()->name; ?></b>
            </a>

            <div class="dropdown-divider"></div>
            <a href="<?php echo route('settings.business.index'); ?>" class="dropdown-item"><i class="fal fa-user-circle"></i> Edit Profile</a>
            <a href="<?php echo route('settings.business.edit'); ?>" class="dropdown-item"><i class="fal fa-tools"></i> Setting</a>
            <a href="<?php echo route('settings.applications'); ?>" class="dropdown-item"><i class="fal fa-gem"></i> My Application</a>
            <div class="dropdown-divider"></div>
            <a href="<?php echo url('logout'); ?>" class="dropdown-item"><i class="fal fa-sign-out"></i> Log Out</a>
         </div>
      </li>
   </ul>
   <!-- end header navigation right -->
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/partials/_header.blade.php ENDPATH**/ ?>